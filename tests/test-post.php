<?php

class post extends WP_UnitTestCase {

  private $foo;

  public function setUp()
  {
    parent::setUp();

      $postid = $this->factory->post->create( array(
            'post_type' => 'post',
              )  );
      $this->foo = $postid;
    
  }

    public function test_foo()
    {   
      $postid = $this->foo;

      $title = hykwWPData_post::get_title($postid);
      $this->assertEquals('post title', $title);

/*
#        $this->go_to( '/hoge/' );
        $this->go_to( '/' );
        $this->assertQueryTrue( 'is_home' ); // is_singular()なら合格

        $this->assertTrue(FALSE);
 */
    }   

    public function test_foo2()
    {   
      $postid = $this->foo;

      $title = hykwWPData_post::get_title($postid);
      $this->assertEquals('post title', $title);
    }
}

