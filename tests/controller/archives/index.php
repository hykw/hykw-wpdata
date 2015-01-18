<?php

##################################################

function post()
{

  ### hykwWPData_post



  $this->assertEquals('p18', '/archives/4', hykwWPData_url::get_requestURL());
  $this->assertEquals('p19', '/archives/4?code=3', hykwWPData_url::get_requestURL(TRUE));




  $i=36;

  $i=40;
  $expects = array(
    array('name' => 'カテゴリ01'),
    array('name' => '子カテゴリー 01'),
    array('name' => '親カテゴリー'),
  );
  $this->assertEquals('p'.$i++, $expects, hykwWPData_category::iget_post_objects(array('name')));
  $this->assertEquals('p'.$i++, $expects, hykwWPData_category::get_post_objects(4, array('name')));
  $this->assertEquals('p'.$i++, $expects, hykwWPData_category::iget_post_objects(array('name'), FALSE));
  $this->assertEquals('p'.$i++, $expects, hykwWPData_category::get_post_objects(4, array('name'), FALSE));
  $expects = array(
    array('name' => 'カテゴリ01'),
    array('name' => '親カテゴリー'),
  );
  $this->assertEquals('p'.$i++, $expects, hykwWPData_category::iget_post_objects(array('name'), TRUE));
  $this->assertEquals('p'.$i++, $expects, hykwWPData_category::get_post_objects(4, array('name'), TRUE));



}


/*
 下記URLへのアクセスを想定 
  http://wptest.comedical.jp/archives/category/01?code=3
 */ 
function cat()
{
  $i = 1;
  $this->assertEquals('p'.$i++, 3, hykwWPData_category::iget_id());

  $expects = array(
    'name' => 'カテゴリ01',
  );
  $this->assertEquals('p'.$i++, $expects, hykwWPData_category::iget_objects(array('name')));
  $this->assertEquals('p'.$i++, $expects, hykwWPData_category::get_objects(3, array('name')));
  $expects = array(
    'name' => 'カテゴリ01-1',
    'parent' => 3,
  );
  $this->assertEquals('p'.$i++, $expects, hykwWPData_category::get_objects(4, array('name', 'parent')));
  $this->assertEquals('p'.$i++, array(), hykwWPData_category::get_objects(9999));


  $expects = array(
    array('name' => 'カテゴリ01-1'),
    array('name' => 'カテゴリ01-2'),
  );
  $this->assertEquals('p'.$i++, $expects, hykwWPData_category::iget_childObjects(array('name')));
  $this->assertEquals('p'.$i++, $expects, hykwWPData_category::get_childObjects(3, array('name')));
  $this->assertEquals('p'.$i++, array(), hykwWPData_category::get_childObjects(9999));

  $this->assertEquals('p'.$i++, 'http://wptest.comedical.jp/archives/category/01', hykwWPData_category::iget_permalink(FALSE));
  $this->assertEquals('p'.$i++, 'http://wptest.comedical.jp/archives/category/01', hykwWPData_category::get_permalink(3, FALSE));
  $this->assertEquals('p'.$i++, 'http://wptest.comedical.jp/archives/category/01/0101', hykwWPData_category::get_permalink(4, FALSE));
  $this->assertEquals('p'.$i++, '', hykwWPData_category::get_permalink(9999));

  $this->assertEquals('p'.$i++, '/archives/category/01', hykwWPData_category::iget_permalink());
  $this->assertEquals('p'.$i++, '/archives/category/01', hykwWPData_category::iget_permalink(TRUE));
  $this->assertEquals('p'.$i++, '/archives/category/01', hykwWPData_category::get_permalink(3));
  $this->assertEquals('p'.$i++, '/archives/category/01', hykwWPData_category::get_permalink(3, TRUE));
  $this->assertEquals('p'.$i++, '/archives/category/01/0101', hykwWPData_category::get_permalink(4));
  $this->assertEquals('p'.$i++, '/archives/category/01/0101', hykwWPData_category::get_permalink(4, TRUE));
  
  $i = 19;
  $this->assertEquals('p'.$i++, 'http://wptest.comedical.jp/archives/category/01?code=3', hykwWPData_url::get_thisurl(TRUE));
  $this->assertEquals('p'.$i++, 'http://wptest.comedical.jp/archives/category/01', hykwWPData_url::get_thisurl(FALSE));
  $this->assertEquals('p'.$i++, 'http://wptest.comedical.jp/archives/category/01', hykwWPData_url::get_thisurl());

}

