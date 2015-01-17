<?php

class UT_hykwWPData_url extends WP_UnitTestCase {
  public function setUp()
  {
    parent::setUp();

    switch_theme('ut.child');
  }

  public function tearDown()
  {
    parent::tearDown();
  }

  public function test_get_themeURL()
  {
    $work = explode('/', hykwWPData_url::get_themeURL(hykwWPData_url::DIR_PARENT));
    $dir_parent = $work[5];
    $work = explode('/', hykwWPData_url::get_themeURL(hykwWPData_url::DIR_CHILD));
    $dir_child = $work[5];

    $this->assertEquals('ut.parent', $dir_parent);
    $this->assertEquals('ut.child', $dir_child);
  }

  public function test_get_requestURL()
  {
    $this->go_to('/');
    $this->assertEquals('/', hykwWPData_url::get_requestURL());
    $this->assertEquals('/', hykwWPData_url::get_requestURL(FALSE));

    $this->go_to('/?code=333');
    $this->assertEquals('/?code=333', hykwWPData_url::get_requestURL(TRUE));
    $this->assertEquals('/', hykwWPData_url::get_requestURL());
    $this->assertEquals('/', hykwWPData_url::get_requestURL(FALSE));

    $this->go_to('/archives/3');
    $this->assertEquals('/archives/3', hykwWPData_url::get_requestURL());
    $this->go_to('/archives/3?code=4');
    $this->assertEquals('/archives/3', hykwWPData_url::get_requestURL());
    $this->assertEquals('/archives/3', hykwWPData_url::get_requestURL(FALSE));
    $this->assertEquals('/archives/3?code=4', hykwWPData_url::get_requestURL(TRUE));
  }

  public function test_get_thisurl()
  {
    $this->go_to('/archives/2?code=3');
    $this->assertEquals('http://ut.comedical.jp/archives/2', hykwWPData_url::get_thisurl());
    $this->assertEquals('http://ut.comedical.jp/archives/2', hykwWPData_url::get_thisurl(FALSE));
    $this->assertEquals('http://ut.comedical.jp/archives/2?code=3', hykwWPData_url::get_thisurl(TRUE));
  }

}
