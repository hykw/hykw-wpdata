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
  ### サイト関係
  # サイトの名称を取得
  public static function get_site_name()
  {
    return get_bloginfo('name');
  }

  # サイトの説明を取得
  public static function get_site_description()
  {
    return get_bloginfo('description');
  }

  # サイトのURLを取得
  public static function get_site_url()
  {
    return sprintf('%s%s', get_site_url(), $_SERVER['REQUEST_URI']);
  }
        
  
  ### 投稿関係
  # 投稿のIDを取得
  public static function get_in_post_id()
  {
    return get_the_ID();
  }

  # 投稿のパーマリンクを取得(ループ内で使う場合は $postid を指定しない）
  public static function get_post_permalink($postid = '')
  {
    $url = null;
    if ($postid == '')
      $url = get_permalink();

    $url =  get_permalink($postid);
    if ($url == FALSE) // $postidに該当するページが存在しない場合
      $url = '';

    return $url;
  }
  public static function get_in_post_permalink()
  {
    return hykwWPData::get_post_permalink();
  }


  # タイトルの取得
  public static function get_post_title($sep = '')
  {
    if ($sep != '')
      return wp_title($sep, FALSE, 'right');
    else
      return wp_title($sep, FALSE);
  }
  public static function get_in_post_title()
  {
    return get_the_title();
  }
  

  # サムネイルのURLを取得
  public static function get_post_thumbnail($postid, $size = 'full')
  {
    $thum_id = get_post_thumbnail_id($postid);
    if (is_null($thum_id))   # サムネイル（アイキャッチ画像）は未設定
      return '';
    
    $image = wp_get_attachment_image_src($thum_id, $size);

    return $image[0];
  }

  # 本文を取得
  public static function get_post_content($postid)
  {
    $post = get_post($postid);
    if (is_null($post))  # IDに該当するページが無い
      return '';

    return $post->post_content;
  }
  public static function get_in_post_content()
  {
    return get_the_content();
  }

  # 抜粋を取得
  public static function get_post_excerpt($postid)
  {
    $post = get_post($postid);
    if (is_null($post))
      return '';

    if ($post->excerpt != '')
      return $post->excerpt;

    $content = strip_shortcodes($post->post_content);
    $content = apply_filters('the_content', $content);
    $excerpt = wp_trim_words($content);

    return $excerpt;
  }
  public static function get_in_post_excerpt()
  {
    return get_the_excerpt();
  }

  # 投稿日の取得
  public static function get_post_time($postid)
  {
    return get_post_time(get_option('date_format'), FALSE, $postid);
  }
  public static function get_in_post_time()
  {
    return get_the_time(get_option('date_format'));
  }
  

  /*
# http://wpdocs.sourceforge.jp/%E3%83%86%E3%83%B3%E3%83%97%E3%83%AC%E3%83%BC%E3%83%88%E3%82%BF%E3%82%B0/get_the_category
  # カテゴリオブジェクトの配列を返す
  public static function get_post_categories($postid = null)
  {
    if (is_null($postid))
      return get_the_category();
    else
      return get_the_category($postid);
  }
  */

  # 投稿のカテゴリ名の取得(１つしか設定されてない場合、文字列で返す。複数の場合は配列)
  public static function get_post_categoryNames($postid = FALSE, $isFirstOnly = FALSE)
  {
    if ($postid == FALSE)
      $cats = get_the_category();
    else
      $cats = get_the_category($postid);

    switch (count($cats)) {
        case 0: 
          return '';
        case 1:
          return $cats[0]->name;
    }
    
    # カテゴリ１つを想定したテーマの場合、最初のテーマ名を返す
    if ($isFirstOnly)
      return $cats[0]->name;

    $ret = array();
    foreach ($cats as $cat) {
      array_push($ret, $cat->name);
    }

    return $ret;
  }


  ### カテゴリ関係
  # 選択されたカテゴリ名を返す（選択されてない場合はFALSE)
  public static function get_category_name()
  {
    $catid = get_query_var('cat');
    if ($catid != '')
      return get_cat_name($catid);

    return FALSE;
  }

  
  ### URL関係
  # style.cssのURLを返す
  public static function get_url_stylecss_parent($url = '', $ver = '')
  {
    $ret = get_template_directory_uri();
    if ($ret == '')
      return '';

    return hykwWPData::_get_url_stylecss_concat($ret, $url, $ver);
  }
  public static function get_url_stylecss_child($url = '', $ver = '')
  {
    $ret = get_stylesheet_directory_uri();
    if ($ret == '')
      return '';

    return hykwWPData::_get_url_stylecss_concat($ret, $url, $ver);
  }
  private static function _get_url_stylecss_concat($ret, $url, $ver)
  {
    $verstr = ($ver == '') ? '' : sprintf('?ver=%s', $ver);
    $ret = sprintf('%s%s%s', $ret, $url, $verstr);

    return $ret;
  }
}
