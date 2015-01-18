<?php

class UT_ihykwWPData_account extends hykwEasyUT {

  public function test_get_id()
  {
    $this->assertEquals(FALSE, hykwWPData_account::get_id(''));
    $this->assertEquals(FALSE, hykwWPData_account::get_id('xxx'));

    $this->assertEquals(1, hykwWPData_account::get_id(WP_USER_ACCOUNT));
  }

}
