<?php

class UT_ihykwWPData_account extends WP_UnitTestCase {
  public function setUp()
  {
    parent::setUp();

    switch_theme('ut.child');
  }

  public function tearDown()
  {
    parent::tearDown();
  }

  public function test_get_id()
  {
    $this->assertEquals(FALSE, hykwWPData_account::get_id('xxx'));

    $role = 'administrator';
    $user = $this->factory->user->create_and_get( array(
      'role' => $role,
    ));
    $this->assertEquals($user->ID, hykwWPData_account::get_id($user->user_login));
  }

}
