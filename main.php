<?php
/**
 * @package HYKW Wordpress Data plugin
 */
/*
Plugin Name: HYKW Wordpress Data plugin
Plugin URI: https://github.com/hykw/hykw-wpdata
Description: WordPressの投稿データやカテゴリデータを、ある程度一貫性のある名前でアクセスできるプラグイン
Author: Hitoshi Hayakawa
Version: 1.0
 */

$files = glob(__DIR__.'/class/*');
foreach ($files as $file) {
  $ext = pathinfo($file, PATHINFO_EXTENSION);
  if ($ext == 'php')
    require_once($file);
}

/**
 * baseHykwWPData baseクラス
 * 
 */
class baseHykwWPData
{
  /**
   * _trimOnlySpecifiedObjects （内部用）指定キーのデータだけ返す
   * 
   * $catobjの例
   <pre>
  (
    [0] => WP_Post Object
        (
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
            [post_modified] => 2014-12-29 13:55:32
            [post_modified_gmt] => 2014-12-29 13:55:32
            [post_content_filtered] => 
            [post_parent] => 2119
            [guid] => http://wptest.comedical.jp/?page_id=10
            [menu_order] => 0
            [post_type] => page
            [post_mime_type] => 
            [comment_count] => 0
            [filter] => raw
        )
  )
   </pre>
   *
   * $keysの例
   <pre>
   Array
   (
       [0] => ID
       [1] => post_name
   )
   </pre>
   * 
   * @param array $catobj trimする元データ
   * @param array $keys 取得する（残す）キー
   * @return string
   */
  protected static function _trimOnlySpecifiedObjects($catobj, $keys)
  {
    if ($keys == FALSE)
      return $catobj;

    $ret = array();
    foreach ($catobj as $cat) {
      $record = array();
      foreach ($keys as $key) {
        $record[$key] = $cat->$key;
      }
      array_push($ret, $record);
    }
    return $ret;
  }

  /**
   * _pruneDomainFromURL （内部用）URLからドメイン部分を取り除く
   * 
   * @param string $url URL
   * @return string 変換後のURL
   */
  protected static function _pruneDomainFromURL($url)
  {
    # WP_UnitTestCase用
    if (!isset($_SERVER['SERVER_NAME'])) {
      if (defined('WP_TESTS_DOMAIN'))
        $servername = WP_TESTS_DOMAIN;
      else
        return $url;
    } else {
      $servername = $_SERVER['SERVER_NAME'];
    }

    $url = preg_replace(sprintf('/https?:\/\/%s(.*)$/', $servername), '${1}', $url);
    return $url;
  }

  /**
   * _pruneQueryString URLから ?code=1234 みたいなパラメータを除去
   * 
   * @param string $url URL
   * @return string 変換後のURL
   */
  protected static function _pruneQueryString($url)
  {
    $url = preg_replace('/^([^?].*)\?.*$/', '$1', $url);
    return $url;
  }


}

require_once('obsolete.php');
