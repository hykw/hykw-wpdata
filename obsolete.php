<?php

class hykwWPData
{
  ############################## サイト関係
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
    return get_site_url();
  }

  # URLを取得
  public static function get_url()
  {
    return sprintf('%s%s', get_site_url(), $_SERVER['REQUEST_URI']);
  }

  ############################## 汎用
  # echo しちゃう関数の結果を変数で受けとる
  public static function obget_echoFun($funcName, $args = false)
  {
    ob_start();

    if ($args == false)
      call_user_func($funcName);
    else {
      if (!is_array($args))
        $array_args = array($args);
      else
        $array_args = $args;

      call_user_func_array($funcName, $array_args);
    }

    $ret = ob_get_contents();
    ob_end_clean();

    return $ret;
  }

  public static function get_wp_head()
  {
    return self::obget_echoFun('wp_head');
  }
  public static function get_wp_footer()
  {
    return self::obget_echoFun('wp_footer');
  }


  ############################## 投稿関係
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
    return self::get_post_permalink();
  }

  # 投稿のステータスを取得
  public static function get_post_status($postid = '')
  {
    return get_post_status($postid);
  }
  public static function get_in_post_status()
  {
    return self::get_post_status();
  }

  # 投稿のpost_typeを取得
  public static function get_post_type($postid = '')
  {
    return get_post_type($postid);
  }
  public static function get_in_post_type()
  {
    return self::get_post_type();
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
  public static function get_post_titleByID($postid)
  {
    return get_the_title($postid);
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
  public static function get_in_post_content($isApplyFilter = TRUE)
  {
    /*
      自動整形機能を無効にしないと、apply_filters()のタイミングで
      勝手に整形(<br>や<p>が入る）されるので注意

      # 自動整形機能を無効化
      remove_filter( 'the_content', 'wpautop' );
      remove_filter( 'the_excerpt', 'wpautop' );
     */

    $contents = get_the_content();
    if ($isApplyFilter)
      return apply_filters('the_content', $contents);

    return $contents;
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

  # カスタムフィールドの取得
  public static function get_post_meta($postid, $key, $single = TRUE)
  {
    return get_post_meta($postid, $key, $single);
  }
  public static function get_in_post_meta($key, $single = TRUE)
  {
    $postid = self::get_in_post_id();
    return self::get_post_meta($postid, $key, $single);
  }


  ############################## カテゴリ関係
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
  # $isParentOnly: TRUEなら、parent='0'(親カテゴリ)のみを対象とする
  # $isObjectReturn: TRUEなら、オブジェクトで返す
  public static function get_post_categoryNames($postid = FALSE, $isFirstOnly = FALSE, $isParentOnly = FALSE, $isObjectReturn = FALSE)
  {
    if ($postid == FALSE)
      $cats = get_the_category();
    else
      $cats = get_the_category($postid);

    $ret = array();
    foreach ($cats as $cat) {
      if ($isParentOnly) {
        if ($cat->parent == 0) {
          if ($isObjectReturn)
            array_push($ret, $cat);
          else
            array_push($ret, $cat->name);
        }
      } else {
        if ($isObjectReturn)
          array_push($ret, $cat);
        else
          array_push($ret, $cat->name);
      }
    }

    if (count($ret) == 0)
      return '';

    # カテゴリ１つを想定したテーマの場合、最初のテーマ名を返す
    if ($isFirstOnly)
      return $ret[0];

    return $ret;
  }


  ### カテゴリ関係
  # 選択されたカテゴリ名を返す（選択されてない場合はFALSE)
  public static function get_category_name($catid = FALSE)
  {
    if ($catid == FALSE)
      $catid = self::get_category_id();

    if ($catid == FALSE)
      return FALSE;

    return get_cat_name($catid);
  }

  # 選択されたカテゴリのIDを返す（未選択時はFALSE)
  public static function get_category_id()
  {
    $catid = get_query_var('cat');
    if ($catid != '')
      return $catid;

    return FALSE;
  }

  # slugでカテゴリ名を取得
  public static function get_post_category_name_bySlug($slug)
  {
    $work = get_category_by_slug($slug);
    if (is_null($work))
      return '';
    else
      return $work->cat_name;
  }

  # カテゴリ名からカテゴリIDを返す。
  # カテゴリ名がarrayの場合、カテゴリIDもarrayで返る
  # 取得できない時はFALSEを返す
  public static function get_category_id_byName($catnames)
  {
    $ret = array();

    if (!is_array($catnames)) {
      $id = get_cat_ID($catnames);
      return ($id == 0) ? FALSE : $id;
    }

    foreach ($catnames as $catname) {
      $id = get_cat_ID($catname);
      if ($id == 0)
        $id = FALSE;

      array_push($ret, $id);
    }

    return $ret;
  }

  # カテゴリの説明を取得($catid未指定ならカレント）
  ### 勝手に <p>とかを付与されるので注意
  ### 不要なら、remove_filter()すること。
  ##### remove_filter('term_description','wpautop')
  public static function get_category_description($catid = '', $isStripChars = TRUE)
  {
    $desc = category_description($catid);

    if ($isStripChars)
      $desc = str_replace("\n", '', $desc);

    return $desc;
  }

  # 指定カテゴリIDの子カテゴリオブジェクトを返す（無指定なら全部）
  public static function get_category_objects($parent_catid = '')
  {
    if ($parent_catid == '')
      return get_categories();
    else
      return get_categories(array('child_of' => $parent_catid));
  }

  # 指定カテゴリIDのURLを返す
  public static function get_category_permalink($catid)
  {
    return get_category_link($catid);
  }

  ############################## タグ関係
  # タグオブジェクトを返す
  # エラー時はArray()を返す（FALSEを返すと、foreach()で回しづらい）
  public static function get_tags_byID($postid, $taxonomy = FALSE)
  {
    if ($taxonomy == FALSE)
      $taxonomy = 'post_tag';

    $ret = get_the_terms($postid, $taxonomy);
    return ($ret == FALSE) ? Array() : $ret;
  }

  public static function get_in_tags($taxonomy = FALSE)
  {
    $postid = self::get_in_post_id();
    return self::get_tags_byID($postid, $taxonomy);
  }


  ############################## 固定ページ関係
  private static function _get_PageObjValue_byPath($path, $key, $post_statuses = array('publish'))
  {
    $work = get_page_by_path($path);
    if ($work != NULL) {
      $bValid = FALSE;
      foreach ($post_statuses as $post_status) {
        if ($work->post_status == $post_status) {
          $bValid = TRUE;
          break;
        }
      }

      if ($bValid)
        return $work->$key;
    }

    return '';
  }

  # ページのIDを返す
  public static function get_in_page_id()
  {
    return get_the_ID();
  }
  # 指定URLのページのIDを返す
  public static function get_page_id_byPath($path)
  {
    return self::_get_PageObjValue_byPath($path, 'ID');
  }

  # 指定ID/現在のページのURLを返す
  public static function get_page_permalink($postid = '', $pruneDomain = TRUE)
  {
    if ($postid != '')
      return self::pruneQueryString(get_page_uri($postid));

    $url = self::pruneQueryString((is_ssl() ?'https://':'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    if ($pruneDomain == FALSE)
      return $url;
    $url = preg_replace(sprintf('/https?:\/\/%s(.*)$/', $_SERVER['SERVER_NAME']), '${1}', $url);
    return $url;        
  }
  public static function get_page_parent_permalink($postid = '', $pruneDomain = TRUE)
  {
    $url = self::get_page_permalink($postid, FALSE);
    if ($url == '')
      return FALSE;

    $urls = explode('/', $url);

    if ($pruneDomain)
      return sprintf('/%s', $urls[3]);

    $ret = array();
    for ($i = 0; $i <= 3; $i++) {
      array_push($ret, $urls[$i]);
    }

    return implode('/', $ret);
  }

  # 現在のページのURLを返す
  ### ※is_page()==TRUE以外の所で呼ぶと、mod_rewriteの関係で想定外のURLが返ってくるので注意
  public static function get_in_page_permalink($pruneDomain = TRUE)
  {
    $url = get_permalink();
    if ($pruneDomain == FALSE)
      return $url;

    $url = preg_replace(sprintf('/https?:\/\/%s(.*)$/', $_SERVER['SERVER_NAME']), '${1}', $url);
    return $url;        
  }

  # 親ページのURLを返す(親ページの場合、自分のURLを返す）
  # エラーなら FALSE
  public static function get_in_page_parent_permalink($pruneDomain = TRUE)
  {
    $url = self::get_in_page_permalink(FALSE);
    if ($url == '')
      return FALSE;

    $urls = explode('/', $url);

    if ($pruneDomain)
      return sprintf('/%s', $urls[3]);

    $ret = array();
    for ($i = 0; $i <= 3; $i++) {
      array_push($ret, $urls[$i]);
    }

    return implode('/', $ret);
  }

  # 指定URLのページのタイトルを取得する
  public static function get_page_title_byPath($path)
  {
    return self::_get_PageObjValue_byPath($path, 'post_title');
  }

  # 指定URLのページの子ページの指定項目(array)を取得
  #  エラー時はFALSEを返す
  #  それ以外は、カテゴリ数分の連想配列で返す
  #
  # $debug = TRUE にすると、WP_Post Object をまるごと返す
  # 
  /*
   e.g.
   $cats = self::get_page_children_byPath($parent_url,
      array(
          'post_title',
          'post_name',
      ));
   */
  public static function get_page_children_byPath($path, $keys, $args = FALSE, $debug=FALSE)
  {
    $pageid = self::get_page_id_byPath($path);

    if ($args == FALSE) {
      $args = array(
        'post_type' => 'page', 
        'posts_per_page' => -1,
        'order' => 'ASC',
        'orderby' => 'menu_order',
      );
    }   

    $wp_query = new WP_Query();

    $all_wp_pages = $wp_query->query($args);
    $objs = get_page_children($pageid, $all_wp_pages);
    if (is_null($objs)) {
      wp_reset_postdata();
      return FALSE;
    }

    if ($debug) {
      wp_reset_postdata();
      return $objs;
    }

    $ret = array();
    foreach ($objs as $obj) {
      $value = array();
      foreach ($keys as $key) {
        $value[$key] = $obj->$key;
      }

      array_push($ret, $value);
    }

    wp_reset_postdata();
    return $ret;
  }


  ############################## URL関係
  # style.cssのURLを返す
  public static function get_url_stylecss_parent($url = '', $ver = '')
  {
    $ret = get_template_directory_uri();
    if ($ret == '')
      return '';

    return self::_get_url_stylecss_concat($ret, $url, $ver);
  }
  public static function get_url_stylecss_child($url = '', $ver = '')
  {
    $ret = get_stylesheet_directory_uri();
    if ($ret == '')
      return '';

    return self::_get_url_stylecss_concat($ret, $url, $ver);
  }
  private static function _get_url_stylecss_concat($ret, $url, $ver)
  {
    $verstr = ($ver == '') ? '' : sprintf('?ver=%s', $ver);
    $ret = sprintf('%s%s%s', $ret, $url, $verstr);

    return $ret;
  }

  # URLから、?code=1234 みたいなパラメータを除去
  public static function pruneQueryString($url)
  {
    $url = preg_replace('/^([^?].*)\?.*$/', '$1', $url);
    return $url;
  }


  ############################## ディレクトリ関係
  # 親テーマのディレクトリを返す
  public static function get_dir_template_parent()
  {
    return get_template_directory();
  }

  # 子テーマのディレクトリを返す
  public static function get_dir_template_child()
  {
    return get_stylesheet_directory();
  }

  ### アカウント関係
  # 指定名称のアカウントIDを取得
  public static function get_user_id_byName($username)
  {
    return get_user_by('login', $username)->ID;
  }

}
