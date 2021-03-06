<?php

/**
 * hykwWPData_tag タグ関係
 * 
 * @uses baseHykwWPData
 */

class hykwWPData_tag extends baseHykwWPData
{

  /**
   * iget_post_objects 投稿のタグオブジェクトを返す
   * 
   * ※hykwWPData_postの方で実装すべきだけど、クラスがfatになっちゃうのでこっちで実装している
   * 
   * キーの例
   <pre>
      [term_id] => 79
      [name] => css
      [slug] => css
      [term_group] => 0
      [term_taxonomy_id] => 79
      [taxonomy] => post_tag
      [description] => 
      [parent] => 0
      [count] => 7
      [filter] => raw
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
   * @param string $taxonomy 取得するタクソノミーの名前
   * @return array タグオブジェクト(配列に詰め替えしている) タグ未設定時はArray()、投稿以外はFALSE
   */
  public static function iget_post_objects($keys = FALSE, $taxonomy = 'post_tag')
  {
    if (!is_single())
      return FALSE;

    $postid = hykwWPData_post::iget_id();
    return self::get_post_objects($postid, $keys, $taxonomy);
  }

  /**
   * get_post_objects 指定IDの投稿のタグオブジェクトを返す
   * 
   * @param integer $postid 投稿ID
   * @param array $keys 取得するデータのキー(FALSEなら全て)
   * @param string $taxonomy 取得するタクソノミーの名前
   * @return array タグオブジェクト(配列に詰め替えしている) タグ未設定時はArray()
   */
  public static function get_post_objects($postid, $keys = FALSE, $taxonomy = 'post_tag')
  {
    $tags = get_the_terms($postid, $taxonomy);
    if ($tags == FALSE)
      return Array();

    $tags_parsed = array();
    foreach ($tags as $tag) {
      array_push($tags_parsed, $tag);
    }

    $ret = self::_trimOnlySpecifiedObjects($tags_parsed, $keys);
    return $ret;
  }

}

