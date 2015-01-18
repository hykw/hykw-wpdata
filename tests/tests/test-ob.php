<?php

class UT_hykwWPData_ob extends hykwEasyUT {

  public function test_header()
  {
    $expects_header = "<meta name='robots' content='noindex,follow' />";
    $headers = explode("\n", hykwWPData_ob::get_wp_head());
    $this->assertEquals($expects_header, $headers[0]);
  }

  public function test_footer()
  {
    $footers = hykwWPData_ob::get_wp_footer();
    $this->assertEquals('', $footers);
  }

  public function test_ob()
  {
    $this->go_to('/archives/4');
    $this->assertEquals('投稿１', hykwWPData_ob::get_funcResult('the_title'));
  }

}
