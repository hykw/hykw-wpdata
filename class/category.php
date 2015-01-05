<?php

/**
 * hykwWPData_category カテゴリ関係
 * 
 * @uses baseHykwWPData
 */

class hykwWPData_category extends baseHykwWPData
{
  /**
   * iget_post_objects 投稿のカテゴリオブジェクトを返す
   *
   * ※hykwWPData_postの方で実装すべきだけど、クラスがfatになっちゃうのでこっちで実装している
   *
   キーの例
   <pre>
            [term_id] => 3
            [name] => カテゴリ01
            [slug] => 01
            [term_group] => 0
            [term_taxonomy_id] => 3
            [taxonomy] => category
            [description] => カテゴリ01の説明
            [parent] => 0
            [count] => 2
            [object_id] => 4
            [filter] => raw
            [cat_ID] => 3
            [category_count] => 2
            [category_description] => カテゴリ01の説明
            [cat_name] => カテゴリ01
            [category_nicename] => 01
            [category_parent] => 0
    </pre>

    呼び出し例）
    <pre>
      $ret = self::iget_post_objects(array('term_id', 'name'));
        [
          ['term_id' => 3, 'name'=> '名前'],
          ['term_id' => 4, 'name'=> '名前'],
          ['term_id' => 5, 'name'=> '名前'],
        ]
    </pre>

   * 
   * @param array $keys 取得するデータのキー(FALSEなら全て)
   * @param boolean $isParentOnly TRUE:親カテゴリのみ取得対象とする, FALSE:全カテゴリ対象
   * @return array カテゴリオブジェクト(配列に詰め替えしている)、エラー時はFALSE
   */
  public static function iget_post_objects($keys = FALSE, $isParentOnly = FALSE)
  {
    if (!is_single())
      return FALSE;

    $postid = hykwWPData_post::iget_id();
    if ($postid == FALSE)
      return FALSE;

    return self::get_post_objects($postid, $keys, $isParentOnly);
  }


  /**
   * get_post_objects 指定IDの投稿のカテゴリオブジェクトを返す
   * 
   * @param integer $postid 投稿ID
   * @param array $keys 取得するデータのキー(FALSEなら全て)
   * @param boolean $isParentOnly TRUE:親カテゴリのみ取得対象とする, FALSE:全カテゴリ対象
   * @return array カテゴリオブジェクト(配列に詰め替えしている)
   */
  public static function get_post_objects($postid, $keys = FALSE, $isParentOnly = FALSE)
  {
    $cats = get_the_category($postid);

    $cats_parsed = array();
    if ($isParentOnly == FALSE)
      $cats_parsed = $cats;
    else {
      foreach ($cats as $cat) {
        if ($cat->parent === 0)
          array_push($cats_parsed, $cat);
      }
    }

    # 全部返しちゃってOK
    if ($keys == FALSE)
      return $cats_parsed;

    return self::_trimOnlySpecifiedObjects($cats_parsed, $keys);
  }

  /**
   * iget_id 選択されたカテゴリのIDを返す
   * 
   * @return integer カテゴリID（未選択ならFALSE）
   */
  public static function iget_id()
  {
    $catid = get_query_var('cat');
    if ($catid != '')
      return $catid;

    return FALSE;
  }

  /**
   * iget_objects 選択されたカテゴリのオブジェクトを返す
   * 
    呼び出し例）
    <pre>
      $ret = self::iget_objects(array('term_id', 'name', 'slug'));
        ['term_id' => 3, 'name'=> '名前', 'slug' => '0303']
    </pre>

   * @param array $keys 取得するデータのキー(FALSEなら全て)
   * @return array カテゴリオブジェクト(連想配列)、未選択ならFALSE
   */
  public static function iget_objects($keys = FALSE)
  {
    $catid = self::iget_id();
    if ($catid == FALSE)
      return FALSE;

    return self::get_objects($catid, $keys);
  }

  /**
   * get_objects 指定IDのカテゴリのオブジェクトを返す
   * 
   * @param integer $catid カテゴリID
   * @param array $keys 取得するデータのキー(FALSEなら全て)
   * @return array カテゴリオブジェクト(連想配列)
   */
  public static function get_objects($catid, $keys = FALSE)
  {
    $cats = array(get_category($catid));

    $ret = self::_trimOnlySpecifiedObjects($cats, $keys);
    return $ret[0];
  }

  /**
   * iget_childObjects 選択されたカテゴリの子オブジェクトを返す
   * 
   * ※カテゴリをセットした投稿が0の場合、カテゴリが取得されないので注意
   * 
   * @param array $keys 取得するデータのキー(FALSEなら全て)
   * @return array カテゴリオブジェクト(配列に詰め替えしている)、未選択ならFALSE
   */
  public static function iget_childObjects($keys = FALSE)
  {
    $catid = self::iget_id();
    if ($catid == FALSE)
      return FALSE;

    return self::get_childObjects($catid, $keys);
  }

  /**
   * get_childObjects 指定IDのカテゴリの子オブジェクトを返す
   * 
   * @param integer $parent_catid 親カテゴリID
   * @param array $keys 取得するデータのキー(FALSEなら全て)
   * @return array カテゴリオブジェクト(配列に詰め替えしている)
   */
  public static function get_childObjects($parent_catid, $keys = FALSE)
  {
    $cats = get_categories(array('child_of' => $parent_catid));
    $cats_parsed = array();
    foreach ($cats as $cat) {
      array_push($cats_parsed, $cat);
    }

    $ret = self::_trimOnlySpecifiedObjects($cats_parsed, $keys);
    return $ret;
  }

  /**
   * iget_permalink 選択されたカテゴリのパーマリンクを返す
   *
   実行例）
  <pre>
    self::iget_permalink(TRUE)    # /archives/category/01
    self::iget_permalink(FALSE)    # http://example.jp/archives/category/01
  </pre>

   * @param boolean $isStripDomain TRUE:ドメイン部分は返さない, FALSE:ドメイン部分も含む
   * @return string パーマリンク、未選択ならFALSE
   */
  public static function iget_permalink($isStripDomain = TRUE)
  {
    $catid = self::iget_id();
    if ($catid == FALSE)
      return FALSE;

    return self::get_permalink($catid, $isStripDomain);
  }

  /**
   * get_permalink 指定IDのカテゴリのパーマリンクを返す
   * 
   * @param integer $catid カテゴリID
   * @param boolean $isStripDomain TRUE:ドメイン部分は返さない, FALSE:ドメイン部分も含む
   * @return string パーマリンク(e.g. 'http://example.jp/archives/category/01')
   */
  public static function get_permalink($catid, $isStripDomain = TRUE)
  {
    $url = get_category_link($catid); 
    if ($isStripDomain == FALSE)
      return $url;

    return self::_pruneDomainFromURL($url);
  }

}

