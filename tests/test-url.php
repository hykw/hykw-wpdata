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
    $this->assertEquals('ut.parent', hykwWPData_url::get_requestURL());
  
  }

}
