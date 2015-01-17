<?php

class UT_hykwWPData_ob extends WP_UnitTestCase {
  public function setUp()
  {
    parent::setUp();

    switch_theme('wptest');
  }

  public function tearDown()
  {
    parent::tearDown();
  }

  public function test_header()
  {
    $expects_header = '<title>wptest</title>';
    $headers = explode("\n", hykwWPData_ob::get_wp_head());
    $this->assertEquals($expects_header, $headers[0]);
  }

  public function test_footer()
  {
    $expects_footer = "<script type='text/javascript'>";
    $footers = explode("\n", hykwWPData_ob::get_wp_footer());
    $this->assertEquals($expects_footer, $footers[1]);
  }

  public function test_ob()
  {
    $postid = $this->factory->post->create( array(
      'post_type' => 'post',
      'post_title' => 'post title ob',
    ));
    $url = sprintf('/archives/%d', $postid);
    $this->go_to($url);
    $this->assertEquals('post title ob', hykwWPData_ob::get_funcResult('the_title'));
  }

}
