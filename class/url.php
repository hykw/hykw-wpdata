<?php

/**
 * hykwWPData_url URL関係
 * 
 * @uses baseHykwWPData
 */
class hykwWPData_url extends baseHykwWPData
{
  const DIR_PARENT = 'parent';
  const DIR_CHILD = 'child';

  /**
   * get_themeURL テーマのディレクトリを返す
   * 
   * @param const $parentChild 親もしくは子
   * @param boolean $with_scheme: FALSEなら //example.com のように scheme 無し
   * @return string テーマのディレクトリまでのFQDNを返す(e.g. 'http://example.com/wp-content/themes/test')
   */
  public static function get_themeURL($parentChild, $with_scheme = TRUE)
  {
    $ret = '';
    switch($parentChild) {
    case self::DIR_PARENT:
      $ret = get_template_directory_uri();
      break;
    case self::DIR_CHILD:
      $ret = get_stylesheet_directory_uri();
      break;
    default:
      return '';
    }

    if ($with_scheme)
      return $ret;

    return preg_replace("/^https?:/", "", $ret);
  }

  /**
   * get_domainName サイトのドメイン名を返す
   * 
   * @return string ドメイン名(e.g. 'http://example.com')
   */
  public static function get_domainName()
  {
    return get_site_url();
  }

  /**
   * get_requestURL URLのパス部分を返す
   * 
   * 例）
   * <pre>
   *   $uri = self::get_requestURL();        /archives?code=1234
   *   $uri = self::get_requestURL(TRUE);    /archives?code=1234
   *   $uri = self::get_requestURL(FALSE);   /archives
   * </pre>
   * 
   * @param bool $isIncludesQueryString TRUE:QueryString付き, FALSE: QueryString無し
   * @return string URL
   */
  public static function get_requestURL($isIncludesQueryString = FALSE)
  {
    $uri = $_SERVER['REQUEST_URI'];
    if ($isIncludesQueryString)
      return $uri;

    $work = explode('?', $uri);
    return $work[0];
  }

  /**
   * get_thisurl URLを返す
   * 
   * 例）
   * <pre>
   *   $uri = self::get_thisurl();        http://example.jp/archives?code=1234
   *   $uri = self::get_thisurl(TRUE);    http://example.jp/archives?code=1234
   *   $uri = self::get_thisurl(FALSE);   http://example.jp/archives
   * </pre>
   * 
   * @param bool $isIncludesQueryString TRUE:QueryString付き, FALSE: QueryString無し
   * @return string URL
   */
  public static function get_thisurl($isIncludesQueryString = FALSE)
  {
    $fqdn = self::get_domainName();
    $path = self::get_requestURL($isIncludesQueryString);

    return $fqdn . $path;
  }

}

