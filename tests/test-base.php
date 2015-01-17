<?php

class xxx extends WP_UnitTestCase {
  public function setUp()
  {
    parent::setUp();

#    switch_theme('mvctest');
  }

  public function tearDown()
  {
    parent::tearDown();
  }

  public function test_()
  {
    $this->assertEquals('a', hykwWPData_url::get_themeURL(hykwWPData_url::DIR_PARENT));

  }

}
