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
  public function get_blog_name()
	{
		return get_bloginfo('name');
	}

	# ブログの説明を取得
	public function get_blog_desc()
	{
		return get_bloginfo('description');
	}
	
}

