<?php

class UT_hykwWPData_dir extends hykwEasyUT {

  public function test_get_themeDIR()
  {
    global $wp_dir;
    $themedir = sprintf('%s/wp-content/themes/', $wp_dir);
    $this->assertEquals($themedir . 'wptest.parent', hykwWPData_dir::get_themeDIR(hykwWPData_dir::DIR_PARENT));
    $this->assertEquals($themedir . 'wptest', hykwWPData_dir::get_themeDIR(hykwWPData_dir::DIR_CHILD));
  }

}
