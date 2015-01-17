<?php

class UT_hykwWPData_site extends WP_UnitTestCase {
  public function setUp()
  {
    parent::setUp();

    switch_theme('wptest');
  }

  public function tearDown()
  {
    parent::tearDown();
  }

  public function test_bulk()
  {
    $this->assertEquals('wptest', hykwWPData_site::get_name());
    $this->assertEquals('Just another WordPress site', hykwWPData_site::get_description());
  }

}
