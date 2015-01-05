<?php

/**
 * hykwWPData_page 固定ページ関係
 * 
 * @uses baseHykwWPData
 */

class hykwWPData_page extends baseHykwWPData
{
  /**
   * iget_id 選択されたページのIDを返す
   * 
   * @return string ページID、未選択時はFALSE
   */
  public static function iget_id()
  {
    if (!is_page())
      return FALSE;

    return get_the_ID();
  }

  /**
   * iget_parent_id 選択されたページの親のIDを返す
   * 
   * @return string 親ページID(未選択時はFALSE)
   */
  public static function iget_parent_id()
  {
    $pageid = self::iget_id();
    if ($pageid == FALSE)
      return FALSE;

    return self::get_parent_id($pageid);
  }

  /**
   * get_parent_id 指定IDのページの親のIDを返す
   * 
   * @param integer $pageid_child 子ページのID
   * @return string 親ページID(親ページが無い場合はFALSE)
   */
  public static function get_parent_id($pageid_child)
  {
    $parent_id = self::get_objects(FALSE, $pageid_child, array('post_parent'));
    if ($parent_id == FALSE)
      return FALSE;

    return $parent_id['post_parent'];
  }

  /**
   * iget_children_ids 選択中の固定ページの子のIDを返す
   * 
   * @return array 子のID（未選択ならFALSE)
   */
  public static function iget_children_ids()
  {
    $pageid = self::iget_id();
    if ($pageid == FALSE)
      return FALSE;

    return self::get_children_ids($pageid);
  }

  /**
   * get_children_ids 指定IDの固定ページの子のIDを返す
   * 
   * @param integer $pageid 親ページのID
   * @return array 子のID、子が無ければFALSE
   */
  public static function get_children_ids($pageid)
  {
    $args = array(
      'post_type' => 'page', 
      'posts_per_page' => -1,
      'order' => 'ASC',
      'orderby' => 'menu_order',
    );

    $wp_query = new WP_Query();

    $pages = $wp_query->query($args);
    $objs = get_page_children($pageid, $pages);
    if (is_null($objs)) {
      wp_reset_postdata();
      return FALSE;
    }

    $ret = array();
    foreach ($objs as $obj) {
      array_push($ret, $obj->ID);
    }

    wp_reset_postdata();
    return $ret;
  }

  /**
   * iget_objects 選択中の固定ページのオブジェクトを返す
   * 
   * キーの例
   <pre>
    [ID] => 10
    [post_author] => 1
    [post_date] => 2014-12-28 11:00:04
    [post_date_gmt] => 2014-12-28 11:00:04
    [post_content] => あああああ
    [post_title] => 固定ページ１
    [post_excerpt] => 
    [post_status] => publish
    [comment_status] => open
    [ping_status] => open
    [post_password] => 
    [post_name] => static1
    [to_ping] => 
    [pinged] => 
    [post_modified] => 2014-12-29 12:42:38
    [post_modified_gmt] => 2014-12-29 12:42:38
    [post_content_filtered] => 
    [post_parent] => 0
    [guid] => http://example.jp/?page_id=10
    [menu_order] => 0
    [post_type] => page
    [post_mime_type] => 
    [comment_count] => 0
    [filter] => raw
   </pre>

    呼び出し例）
    <pre>
      $ret = self::iget_objects(array('ID', 'post_name'));
         => ['ID' => 10, 'post_name'=> 'static1']
   </pre>
   * 
   * @return array ページオブジェクト（取得失敗（不正なURL?）時、あるいは固定ページじゃない時ははFALSE）
   */

  public static function iget_objects($keys = FALSE)
  {
    if (!is_page())
      return FALSE;

    $url = hykwWPData_url::get_requestURL(FALSE);
    return self::get_objects($url, FALSE, $keys);
  }

  /**
   * get_objects 指定URL/IDの固定ページのオブジェクトを返す
   * 
   * @param string $url 取得する固定ページのURL(idで指定する時はFALSE)
   * @param string $pageid 取得する固定ページのID(URLで指定する時はFALSE)
   * @param array $keys 取得するデータのキー(FALSEなら全て)
   * @return array ページオブジェクト（取得失敗（不正なURL?）時はFALSE）
   */
  public static function get_objects($url = FALSE, $pageid = FALSE, $keys = FALSE)
  {
    if (  ($url == FALSE) && ($pageid == FALSE) )
      return FALSE;

    if ($pageid != FALSE) {
      $url = get_page_uri($pageid);
      if ($url == FALSE)
        return FALSE;
    }

    $page = get_page_by_path($url);
    if (is_null($page))
      return FALSE;

    $page_parsed = array($page);
    $ret = self::_trimOnlySpecifiedObjects($page_parsed, $keys);
    return $ret[0];
  }

  /**
   * iget_permalink 選択中の固定ページのURLを返す
   *
   実行例）
  <pre>
    self::iget_permalink(TRUE)     # /page1
    self::iget_permalink(FALSE)    # http://example.jp/page1
  </pre>
   * 
   * @param boolean $isStripDomain TRUE:ドメイン部分は返さない, FALSE:ドメイン部分も含む
   * @return string permalink(取得できない時は "")、固定ページじゃない時はFALSE
   */
  public static function iget_permalink($isStripDomain = TRUE)
  {
    if (!is_page())
      return FALSE;

    $url = hykwWPData_url::get_requestURL(FALSE);
    if ($isStripDomain)
      return $url;

    return sprintf('%s%s', hykwWPData_url::get_domainName(), $url);
  }

  /**
   * get_permalink 指定IDのページのpermalinkを返す
   * 
   * @param integer $pageid ページID
   * @param boolean $isStripDomain TRUE:ドメイン部分は返さない, FALSE:ドメイン部分も含む
   * @return string permalink(取得できない時は "")
   */
  public static function get_permalink($pageid, $isStripDomain = TRUE)
  {
    $url = get_page_uri($pageid);
    if ($isStripDomain)
      return '/' . $url;

    return sprintf('%s/%s', hykwWPData_url::get_domainName(), $url);
  }

  /**
   * iget_title 選択中のページのタイトルを返す
   * 
   * @return string タイトル（固定ページじゃない時はFALSE)
   */
  public static function iget_title()
  {

    if (!is_page())
      return FALSE;

    $url = hykwWPData_url::get_requestURL(FALSE);
    $ret = self::get_objects($url, FALSE, array('post_title'));
    return $ret['post_title'];
  }

  /**
   * get_title 指定URL/IDのタイトルを返す
   * 
   * @param string $url 取得する固定ページのURL(idで指定する時はFALSE)
   * @param string $pageid 取得する固定ページのID(URLで指定する時はFALSE)
   * @return string タイトル
   */
  public static function get_title($url = FALSE, $pageid = FALSE)
  {
    if (  ($url == FALSE) && ($pageid == FALSE) )
      return '';

    $ret = self::get_objects($url, $pageid, array('post_title'));
    return $ret['post_title'];
  }

}

