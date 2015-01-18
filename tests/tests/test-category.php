<?php

class UT_hykwWPData_category extends hykwEasyUT {

  public function test_get_post_objects()
  {

    $postid = 4;
    $url = sprintf('/archives/%d?code=3', $postid);
    $this->go_to($url);

    $expects = array(
      array('name' => 'カテゴリ01'),
      array('name' => '子カテゴリー 01'),
      array('name' => '親カテゴリー'),
    );
    $this->assertEquals($expects, hykwWPData_category::iget_post_objects(array('name')));
    $this->assertEquals($expects, hykwWPData_category::get_post_objects($postid, array('name')));
    $this->assertEquals($expects, hykwWPData_category::iget_post_objects(array('name'), FALSE));
    $this->assertEquals($expects, hykwWPData_category::get_post_objects($postid, array('name'), FALSE));

    $expects = array(
      array('name' => 'カテゴリ01'),
      array('name' => '親カテゴリー'),
    );
    $this->assertEquals($expects, hykwWPData_category::iget_post_objects(array('name'), TRUE));
    $this->assertEquals($expects, hykwWPData_category::get_post_objects($postid, array('name'), TRUE));
  }

  public function test_bulk()
  {
    $url = '/archives/category/01';
    $urlAndCode = '/archives/category/01?code=3';
    $this->go_to($urlAndCode);
    $fqdnAndURL = sprintf('http://%s%s', WP_TESTS_DOMAIN, $url);
    $fqdnAndURLAndCode = sprintf('http://%s%s?code=3', WP_TESTS_DOMAIN, $url);
    $fqdnAndURL_4 = sprintf('http://%s%s/0101', WP_TESTS_DOMAIN, $url);

    ##### iget_id()
    $this->assertEquals(3, hykwWPData_category::iget_id());

    ##### *get_objects()
    $expects = array(
      'name' => 'カテゴリ01',
    );
    $this->assertEquals($expects, hykwWPData_category::iget_objects(array('name')));
    $this->assertEquals($expects, hykwWPData_category::get_objects(3, array('name')));
    $expects = array(
      'name' => 'カテゴリ01-1',
      'parent' => 3,
    );
    $this->assertEquals($expects, hykwWPData_category::get_objects(4, array('name', 'parent')));

    $this->assertEquals(array(), hykwWPData_category::get_objects(9999));

    ##### *get_childObjects()
    $expects = array(
      array('name' => 'カテゴリ01-1'),
      array('name' => 'カテゴリ01-2'),
    );
    $this->assertEquals($expects, hykwWPData_category::iget_childObjects(array('name')));
    $this->assertEquals($expects, hykwWPData_category::get_childObjects(3, array('name')));
    $this->assertEquals(array(), hykwWPData_category::get_childObjects(9999));

    $this->assertEquals($fqdnAndURL, hykwWPData_category::iget_permalink(FALSE));
    $this->assertEquals($fqdnAndURL, hykwWPData_category::get_permalink(3, FALSE));
    $this->assertEquals($fqdnAndURL_4, hykwWPData_category::get_permalink(4, FALSE));
    $this->assertEquals('', hykwWPData_category::get_permalink(9999));

    $this->assertEquals('/archives/category/01', hykwWPData_category::iget_permalink());
    $this->assertEquals('/archives/category/01', hykwWPData_category::iget_permalink(TRUE));
    $this->assertEquals('/archives/category/01', hykwWPData_category::get_permalink(3));
    $this->assertEquals('/archives/category/01', hykwWPData_category::get_permalink(3, TRUE));
    $this->assertEquals('/archives/category/01/0101', hykwWPData_category::get_permalink(4));
    $this->assertEquals('/archives/category/01/0101', hykwWPData_category::get_permalink(4, TRUE));

    $this->assertEquals($fqdnAndURLAndCode, hykwWPData_url::get_thisurl(TRUE));
    $this->assertEquals($fqdnAndURL, hykwWPData_url::get_thisurl(FALSE));
    $this->assertEquals($fqdnAndURL, hykwWPData_url::get_thisurl());
  }

}
