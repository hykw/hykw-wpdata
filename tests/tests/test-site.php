<?php

class UT_hykwWPData_site extends hykwEasyUT {

  public function test_bulk()
  {
    $this->assertEquals('wptest', hykwWPData_site::get_name());
    $this->assertEquals('キャッチフレーズの値', hykwWPData_site::get_description());
  }

}
