<?php

class UT_hykwWPData_tag extends hykwEasyUT {

  public function test_get_post_objects()
  {
    $this->go_to('/');
    $this->assertFalse(hykwWPData_tag::iget_post_objects());

    $this->go_to('/archives/4?code=3');
    $this->assertEquals(Array(), hykwWPData_tag::iget_post_objects(array('name')));

    $expects = array(
      array('name' => 'css'),
      array('name' => 'html'),
      array('name' => 'タイトル'),
    );
    $this->assertEquals($expects, hykwWPData_tag::get_post_objects(1173, array('name')));
  }

}
