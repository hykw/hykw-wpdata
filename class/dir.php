<?php

/**
 * hykwWPData_dir ディレクトリ関係
 * 
 * @uses baseHykwWPData
 */
class hykwWPData_dir extends baseHykwWPData
{
  const DIR_PARENT = 'parent';
  const DIR_CHILD = 'child';

  /**
   * get_themeDIR テーマのディレクトリを返す
   * 
   * @param const $parentChild 親もしくは子
   * @return string テーマのディレクトリ(e.g. '/var/www/example.jp/wp-content/themes/sample.theme')
   */
  public static function get_themeDIR($parentChild)
  {
    switch($parentChild)
    {
    case self::DIR_PARENT:
      return get_template_directory();
    case self::DIR_CHILD:
      return get_stylesheet_directory();
    }
    return '';
  }

}
