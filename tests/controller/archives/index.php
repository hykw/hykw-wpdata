<?php

##################################################

function post()
{

  ### hykwWPData_post

  assert_equal('p4', 'publish', hykwWPData_post::iget_status());
  assert_equal('p5', 'publish', hykwWPData_post::get_status(4));
  assert_equal('p6', 'draft', hykwWPData_post::get_status(1164));
  assert_equal('p7', 'trash', hykwWPData_post::get_status(1));
  assert_equal('p8', '', hykwWPData_post::get_status(99999));

  assert_equal('p9', 'post', hykwWPData_post::iget_type());
  assert_equal('p10', 'post', hykwWPData_post::get_type(4));
  assert_equal('p11', '', hykwWPData_post::get_type(99999));
  assert_equal('p12', 'page', hykwWPData_post::get_type(1751));

  assert_equal('p13', '投稿１', hykwWPData_post::iget_title());
  assert_equal('p14', '投稿１', hykwWPData_post::get_title(4));
  assert_equal('p15', '極端な例: ネスト化された混合リスト', hykwWPData_post::get_title(1000));

  assert_equal('p16', 'http://wptest.comedical.jp/wp-content/uploads/2013/09/dsc20050604_133440_34211-150x150.jpg', hykwWPData_post::iget_thumbnail_url());
  assert_equal('p17', 'http://wptest.comedical.jp/wp-content/uploads/2013/09/dsc20050604_133440_34211-150x150.jpg', hykwWPData_post::get_thumbnail_url(4));

  assert_equal('p18', '/archives/4', hykwWPData_url::get_requestURL());
  assert_equal('p19', '/archives/4?code=3', hykwWPData_url::get_requestURL(TRUE));

  assert_equal('p20', "あああああ", hykwWPData_post::iget_content());
  assert_equal('p21', 'あああああ', hykwWPData_post::get_content(4));
  assert_equal('p22', '', hykwWPData_post::get_content(99999));

  assert_equal('p23', '抜粋欄の内容', hykwWPData_post::iget_excerpt(TRUE));
  assert_equal('p24', '抜粋欄の内容', hykwWPData_post::iget_excerpt(FALSE));
  assert_equal('p25', '抜粋欄の内容', hykwWPData_post::iget_excerpt());
  assert_equal('p26', '抜粋欄の内容', hykwWPData_post::get_excerpt(4, TRUE));
  assert_equal('p27', '抜粋欄の内容', hykwWPData_post::get_excerpt(4, FALSE));
  assert_equal('p28', '抜粋欄の内容', hykwWPData_post::get_excerpt(4));
  assert_equal('p29', '本文：投稿2', hykwWPData_post::get_excerpt(6));
  assert_equal('p30', '本文：投稿2', hykwWPData_post::get_excerpt(6, TRUE));
  assert_equal('p31', '', hykwWPData_post::get_excerpt(6, FALSE));
  assert_equal('p32', '', hykwWPData_post::get_excerpt(99999));

  $i = 33;
  assert_equal('p'.$i++, '2014/12/28', hykwWPData_post::iget_postdate());
  assert_equal('p'.$i++, '2014/12/28', hykwWPData_post::get_postdate(4));
  assert_equal('p'.$i++, '', hykwWPData_post::get_postdate(99999));

  $i=36;
  assert_equal('p'.$i++, '111', hykwWPData_post::iget_postmeta('カスタム1'));
  assert_equal('p'.$i++, '', hykwWPData_post::iget_postmeta('xxxxx'));
  assert_equal('p'.$i++, '111', hykwWPData_post::get_postmeta(4, 'カスタム1'));
  assert_equal('p'.$i++, '', hykwWPData_post::get_postmeta(9999, 'カスタム1'));

  $i=40;
  $expects = array(
    array('name' => 'カテゴリ01'),
    array('name' => '子カテゴリー 01'),
    array('name' => '親カテゴリー'),
  );
  assert_equal('p'.$i++, $expects, hykwWPData_category::iget_post_objects(array('name')));
  assert_equal('p'.$i++, $expects, hykwWPData_category::get_post_objects(4, array('name')));
  assert_equal('p'.$i++, $expects, hykwWPData_category::iget_post_objects(array('name'), FALSE));
  assert_equal('p'.$i++, $expects, hykwWPData_category::get_post_objects(4, array('name'), FALSE));
  $expects = array(
    array('name' => 'カテゴリ01'),
    array('name' => '親カテゴリー'),
  );
  assert_equal('p'.$i++, $expects, hykwWPData_category::iget_post_objects(array('name'), TRUE));
  assert_equal('p'.$i++, $expects, hykwWPData_category::get_post_objects(4, array('name'), TRUE));

  $i = 46;
  assert_equal('p'.$i++, Array(), hykwWPData_tag::iget_post_objects(array('name')));

  $expects = array(
    array('name' => 'css'),
    array('name' => 'html'),
    array('name' => 'タイトル'),
  );
  assert_equal('p'.$i++, $expects, hykwWPData_tag::get_post_objects(1173, array('name')));





}


/*
 下記URLへのアクセスを想定 
  http://wptest.comedical.jp/archives/category/01?code=3
 */ 
function cat()
{
  $i = 1;
  assert_equal('p'.$i++, 3, hykwWPData_category::iget_id());

  $expects = array(
    'name' => 'カテゴリ01',
  );
  assert_equal('p'.$i++, $expects, hykwWPData_category::iget_objects(array('name')));
  assert_equal('p'.$i++, $expects, hykwWPData_category::get_objects(3, array('name')));
  $expects = array(
    'name' => 'カテゴリ01-1',
    'parent' => 3,
  );
  assert_equal('p'.$i++, $expects, hykwWPData_category::get_objects(4, array('name', 'parent')));
  assert_equal('p'.$i++, array(), hykwWPData_category::get_objects(9999));


  $expects = array(
    array('name' => 'カテゴリ01-1'),
    array('name' => 'カテゴリ01-2'),
  );
  assert_equal('p'.$i++, $expects, hykwWPData_category::iget_childObjects(array('name')));
  assert_equal('p'.$i++, $expects, hykwWPData_category::get_childObjects(3, array('name')));
  assert_equal('p'.$i++, array(), hykwWPData_category::get_childObjects(9999));

  assert_equal('p'.$i++, 'http://wptest.comedical.jp/archives/category/01', hykwWPData_category::iget_permalink(FALSE));
  assert_equal('p'.$i++, 'http://wptest.comedical.jp/archives/category/01', hykwWPData_category::get_permalink(3, FALSE));
  assert_equal('p'.$i++, 'http://wptest.comedical.jp/archives/category/01/0101', hykwWPData_category::get_permalink(4, FALSE));
  assert_equal('p'.$i++, '', hykwWPData_category::get_permalink(9999));

  assert_equal('p'.$i++, '/archives/category/01', hykwWPData_category::iget_permalink());
  assert_equal('p'.$i++, '/archives/category/01', hykwWPData_category::iget_permalink(TRUE));
  assert_equal('p'.$i++, '/archives/category/01', hykwWPData_category::get_permalink(3));
  assert_equal('p'.$i++, '/archives/category/01', hykwWPData_category::get_permalink(3, TRUE));
  assert_equal('p'.$i++, '/archives/category/01/0101', hykwWPData_category::get_permalink(4));
  assert_equal('p'.$i++, '/archives/category/01/0101', hykwWPData_category::get_permalink(4, TRUE));
  
  $i = 19;
  assert_equal('p'.$i++, 'http://wptest.comedical.jp/archives/category/01?code=3', hykwWPData_url::get_thisurl(TRUE));
  assert_equal('p'.$i++, 'http://wptest.comedical.jp/archives/category/01', hykwWPData_url::get_thisurl(FALSE));
  assert_equal('p'.$i++, 'http://wptest.comedical.jp/archives/category/01', hykwWPData_url::get_thisurl());

}

