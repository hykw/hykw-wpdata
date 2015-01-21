<?php

/**
 * hykwWPData_post 投稿関係
 * 
 * @uses baseHykwWPData
 */
class hykwWPData_post extends baseHykwWPData
{
  /**
   * iget_id 選択された投稿のIDを返す(i stands for in the loop)
   * 
   * @return integer 投稿ID(未選択時はFALSE）
   */
  public static function iget_id()
  {
    if (!is_single())
      return FALSE;

    return get_the_ID();
  }

  /**
   * iget_permalink 投稿のpermalinkを返す(loop版)
   *
   実行例）
  <pre>
    self::iget_permalink(TRUE)    # /archives/4
    self::iget_permalink(FALSE)    # http://example.jp/archives/4
  </pre>
   * 
   * @param boolean $isStripDomain TRUE:ドメイン部分は返さない, FALSE:ドメイン部分も含む
   * @return string permalink(取得できない時は ""、投稿以外はFALSE)
   */
  public static function iget_permalink($isStripDomain = TRUE)
  {
    $postid = self::iget_id();
    if ($postid == FALSE)
      return FALSE;

    return self::get_permalink($postid, $isStripDomain);
  }

  /**
   * get_permalink 指定IDの投稿のpermalinkを返す
   * 
   * @param integer $postid 投稿ID
   * @param boolean $isStripDomain TRUE:ドメイン部分は返さない, FALSE:ドメイン部分も含む
   * @return string permalink(取得できない時は "")
   */
  public static function get_permalink($postid, $isStripDomain = TRUE)
  {
    $url = get_permalink($postid);
    if ($isStripDomain == FALSE)
      return $url;

    return self::_pruneDomainFromURL($url);
  }

  /**
   * iget_status 投稿の状態を返す
   * 
   * @return string 状態('publish', 'draft', 'trash', etc... 取得できない時は "", 投稿以外はFALSE)
   */
  public static function iget_status()
  {
    $postid = self::iget_id();
    if ($postid == FALSE)
      return FALSE;

    return self::get_status($postid);
  }

  /**
   * get_status 指定IDの投稿の状態を返す
   * 
   * @param integer $postid 投稿ID
   * @return string 状態('publish', 'draft', 'trash', etc... 取得できない時は "")
   */
  public static function get_status($postid)
  {
    return get_post_status($postid);
  }

  /**
   * iget_type 投稿の種類を返す
   * 
   * @return string 種類（'post', 'page', etc..., 取得できない時は "", 投稿以外はFALSE)
   */
  public static function iget_type()
  {
    $postid = self::iget_id();
    if ($postid == FALSE)
      return FALSE;

    return self::get_type($postid);
  }

  /**
   * get_type 指定IDの投稿の種類を返す
   * 
   * @param integer $postid 投稿ID
   * @return string 種類（'post', 'page', etc..., 取得できない時は "")
   */
  public static function get_type($postid)
  {
    return get_post_type($postid);
  }

  /**
   * iget_title 投稿のタイトルを返す
   * @return string 投稿のタイトル（投稿以外はFALSE)
   */
  public static function iget_title()
  {
    if (!is_single())
      return FALSE;

    return trim(wp_title(' ', FALSE));
  }

  /**
   * get_title 指定IDの投稿のタイトルを返す
   * 
   * @param integer $postid 投稿ID
   * @return string 投稿のタイトル(取得失敗なら"")
   */
  public static function get_title($postid)
  {
    return get_the_title($postid);
  }


  /**
   * iget_thumbnail_url 投稿の添付画像のURLを返す
   * 
   * @param string $size 画像の大きさ
   * @return string 画像のURL(未設定なら""、投稿以外はFALSE)
   */
  public static function iget_thumbnail_url($size = 'thumbnail')
  {
    $postid = self::iget_id();
    if ($postid == FALSE)
      return FALSE;

    return self::get_thumbnail_url($postid, $size);
  }

  /**
   * get_thumbnail_url 指定IDの投稿の添付画像のURLを返す
   * 
   * @param integer $postid 投稿ID
   * @param string $size 画像の大きさ
   * @return string 画像のURL(未設定なら"")
   */
  public static function get_thumbnail_url($postid, $size = 'thumbnail')
  {
    $ret = self::get_thumbnail_obj($postid, $size);
    return ($ret == FALSE) ? '' : $ret[0];
  }

  /**
   * get_thumbnail_obj 指定IDの投稿の添付画像のオブジェクトを返す
   * 
   * @param integer $postid 投稿ID
   * @param string $size 画像の大きさ
   * @return array 画像のオブジェクト（画像じゃない場合は FALSE)
   */
  public static function get_thumbnail_obj($postid, $size = 'thumbnail')
  {
    $thum_id = get_post_thumbnail_id($postid);
    if (is_null($thum_id))   # サムネイル（アイキャッチ画像）は未設定
      return '';

    $image = wp_get_attachment_image_src($thum_id, $size);

    return $image;
  }

  /**
   * iget_content 投稿の本文を返す
   * 
   *   自動整形機能を無効にしないと、apply_filters()のタイミングで
   *   勝手に整形(&lt;br&gt;や&lt;p&gt;が入る）されるので注意
   *
     <pre>
    # 自動整形機能を無効化
      remove_filter( 'the_content', 'wpautop' );
      remove_filter( 'the_excerpt', 'wpautop' );
     </pre>
   * 
   * @param bool $isApplyFilter_content TRUE: apply_filters('the_content')を通す, FALSE: 通さない
   * @return string 投稿の本文、投稿以外はFALSE
   */
  public static function iget_content($isApplyFilter_content = TRUE)
  {
    $postid = self::iget_id();
    if ($postid == FALSE)
      return FALSE;

    return self::get_content($postid, $isApplyFilter_content);
  }

  /**
   * get_content 指定IDの投稿の本文を返す
   * 
   *   iget_content()と同様に、勝手に整形されないように注意
   * 
   * @param integer $postid 投稿ID
   * @param bool $isApplyFilter_content TRUE: apply_filters('the_content')を通す, FALSE: 通さない
   * @return string 投稿の本文
   */
  public static function get_content($postid, $isApplyFilter_content = TRUE)
  {
    $post = get_post($postid);
    if (is_null($post))  # IDに該当するページが無い
      return '';

    $contents = $post->post_content;
    if ($isApplyFilter_content)
      return apply_filters('the_content', $contents);

    return $contents;
  }


  /**
   * iget_excerpt 投稿の抜粋を返す
   * 
   * @param bool $isStripContentOnEmpty TRUE:抜粋が空の場合、本文から作成して返す, FALSE:空のまま返す
   * @return string 投稿の抜粋、投稿以外はFALSE
   */
  public static function iget_excerpt($isStripContentOnEmpty = TRUE)
  {
    $postid = self::iget_id();
    if ($postid == FALSE)
      return FALSE;

    return self::get_excerpt($postid, $isStripContentOnEmpty);
  }
  /**
   * get_excerpt 指定IDの投稿の抜粋を返す
   * 
   * @param integer $postid 投稿ID
   * @param bool $isStripContentOnEmpty TRUE:抜粋が空の場合、本文から作成して返す, FALSE:空のまま返す
   * @return string 投稿の抜粋
   */
  public static function get_excerpt($postid, $isStripContentOnEmpty = TRUE)
  {
    $post = get_post($postid);
    if (is_null($post))
      return '';

    if ($post->post_excerpt != '')
      return $post->post_excerpt;

    if ($isStripContentOnEmpty) {
      $content = strip_shortcodes($post->post_content);
      $content = apply_filters('the_content', $content);
      $excerpt = wp_trim_words($content);

      return $excerpt;
    }
  }

  /**
   * iget_postdate 投稿の投稿日(公開日)を返す
   * 
   * 投稿日なので、更新をしてもこの日付は変わらない。
   *<br />
   * 例）
   <pre> 
   $date = self::iget_postdate();    # '2014/12/28'
   </pre> 
   * 
   * @return string 投稿日、投稿以外はFALSE
   */
  public static function iget_postdate()
  {
    $postid = self::iget_id();
    if ($postid == FALSE)
      return FALSE;

    return self::get_postdate($postid);
  }

  /**
   * get_postdate 指定IDの投稿の投稿日(公開日)を返す
   * 
   * @param integer $postid 投稿ID
   * @return string 投稿日
   */
  public static function get_postdate($postid)
  {
    return get_post_time(get_option('date_format'), FALSE, $postid);
  }

  /**
   * iget_postmeta 投稿の指定キーのカスタムフィールドの値を返す
   * 
   * @param string $key カスタムフィールドの名前
   * @return string カスタムフィールドの値、投稿以外はFALSE、取得出来ない時は""
   */
  public static function iget_postmeta($key)
  {
    $postid = self::iget_id();
    if ($postid == FALSE)
      return FALSE;

    return self::get_postmeta($postid, $key);
  }

  /**
   * get_postmeta 指定IDの投稿の指定キーのカスタムフィールドの値を返す
   * 
   * @param integer $postid 投稿ID
   * @param string $key カスタムフィールドの名前
   * @return string カスタムフィールドの値(取得できない時は"")
   */
  public static function get_postmeta($postid, $key)
  {
    return get_post_meta($postid, $key, TRUE);
  }


}


