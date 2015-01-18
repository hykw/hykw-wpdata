<?php

##################################################
echo <<<EOL
<pre>

EOL;

/*
  下記URLへのアクセスを想定

  http://wptest.comedical.jp/parent/static1?code=3
 */

$url = hykwWPData_url::get_requestURL(FALSE);
if ($url == '/parent/static1') {

  $i = 1;
  assert_equal('p'.$i++, 10, hykwWPData_page::iget_id());


  $expects = array(
    'ID'=> 10,
    'post_name' => 'static1',
  );
  assert_equal('p'.$i++, $expects, hykwWPData_page::iget_objects(array('ID', 'post_name')));
  assert_equal('p'.$i++, $expects, hykwWPData_page::get_objects('/parent/static1', FALSE, array('ID', 'post_name')));

  assert_equal('p'.$i++, 10, hykwWPData_page::iget_object('ID'));
  assert_equal('p'.$i++, 10, hykwWPData_page::get_object('ID', FALSE, 10));



  assert_equal('p'.$i++, $expects, hykwWPData_page::get_objects(FALSE, 10, array('ID', 'post_name')));
  assert_equal('p'.$i++, FALSE, hykwWPData_page::get_objects(FALSE, FALSE));
  assert_equal('p'.$i++, FALSE, hykwWPData_page::get_objects('/xxxxxxxxx', FALSE));

  assert_equal('p'.$i++, 'http://wptest.comedical.jp/parent/static1', hykwWPData_page::iget_permalink(FALSE));
  assert_equal('p'.$i++, '/parent/static1', hykwWPData_page::iget_permalink(TRUE));
  assert_equal('p'.$i++, '/parent/static1', hykwWPData_page::iget_permalink());

  assert_equal('p'.$i++, 'http://wptest.comedical.jp/parent/static1', hykwWPData_page::get_permalink(10, FALSE));
  assert_equal('p'.$i++, '/parent/static1', hykwWPData_page::get_permalink(10, TRUE));
  assert_equal('p'.$i++, '/parent/static1', hykwWPData_page::get_permalink(10));

  $i = 13;
  assert_equal('p'.$i++, 2119, hykwWPData_page::iget_parent_id());
  assert_equal('p'.$i++, 2119, hykwWPData_page::get_parent_id(10));
  assert_equal('p'.$i++, FALSE, hykwWPData_page::get_parent_id(1751));
  assert_equal('p'.$i++, FALSE, hykwWPData_page::get_parent_id(99999));

  assert_equal('p'.$i++, '固定ページ１', hykwWPData_page::iget_title());
  assert_equal('p'.$i++, 'このサイトについて', hykwWPData_page::get_title(FALSE, 1752));
  assert_equal('p'.$i++, 'このサイトについて', hykwWPData_page::get_title('/about', FALSE));
  assert_equal('p'.$i++, 'このサイトについて', hykwWPData_page::get_title('/about'));

  $expects = array("あああああ", "いいいいい", '');
  assert_equal('p'.$i++, $expects, explode("\r\n", hykwWPData_page::iget_contents()));
  assert_equal('p'.$i++, $expects, explode("\r\n", hykwWPData_page::get_contents(FALSE, 10)));

  assert_equal('p'.$i++, '2014/12/28', hykwWPData_page::iget_date());
  assert_equal('p'.$i++, '2014/12/28', hykwWPData_page::get_date(10));

} else {
  /*
  下記URLへのアクセスを想定

  http://wptest.comedical.jp/parent?code=3
 */
  $i = 1;
  assert_equal('p'.$i++, '親固定ページ1', hykwWPData_page::iget_title());
  assert_equal('p'.$i++, 2119, hykwWPData_page::iget_id());
  assert_equal('p'.$i++, array(10,2121), hykwWPData_page::iget_children_ids());
  assert_equal('p'.$i++, array(10,2121), hykwWPData_page::get_children_ids(2119));
  assert_equal('p'.$i++, FALSE, hykwWPData_page::get_children_ids(9999));
  assert_equal('p'.$i++, FALSE, hykwWPData_page::get_children_ids(1751));



}
