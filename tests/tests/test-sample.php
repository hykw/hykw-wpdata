<?php

class test_post extends hykwEasyUT {

  public function test_id()
  {
    $this->go_to('/archives/4');

    $this->assertEquals(4, get_the_ID());
  }
}
