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
   *  hykwWPData_categoryとhykwWPData_tagから利用している
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
    $url = preg_replace(sprintf('/https?:\/\/%s(.*)$/', $_SERVER['SERVER_NAME']), '${1}', $url);
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
