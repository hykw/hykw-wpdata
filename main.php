<?php
/**
 * @package HYKW Wordpress Data plugin
 * @version 0.1
 */
/*
Plugin Name: HYKW Wordpress Data plugin
Plugin URI: https://github.com/hykw/hykw-wpdata
Description: Wordpress のデータを取得する関数をラッパーしたクラス
Author: hitoshi-hayakawa
Version: 0.1
*/

class hykwWPData
{
  ### ブログ関係

  # ブログの名称を取得
  public static function get_blog_name()
  {
    return get_bloginfo('name');
  }

  # ブログの説明を取得
  public static function get_blog_description()
  {
    return get_bloginfo('description');
  }
        
  
  ### 投稿関係
  # タイトルの取得
  public static function get_post_title($sep = '')
  {
    if ($sep != '')
      return wp_title($sep, false, 'right');
    else
      return wp_title($sep, false);
  }
  
  

}
