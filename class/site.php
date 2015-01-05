<?php

/**
 * hykwWPData_site サイト情報関係
 * 
 * @uses baseHykwWPData
 */
class hykwWPData_site extends baseHykwWPData
{
  /**
   * get_Name サイト名を取得(設定 - 一般 - サイトのタイトルの値)
   * 
   * @return string サイト名(e.g. "ほげほげサイト")
   */
  public static function get_name()
  {
    return get_bloginfo('name');
  }

  /**
   * get_description サイトの説明を取得(設定 - 一般 - キャッチフレーズの値)
   * 
   * @return string キャッチフレーズ(e.g. "とても素敵なサイト")
   */
  public static function get_description()
  {
    return get_bloginfo('description');
  }
}


