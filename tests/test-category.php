<?php

class UT_hykwWPData_category extends WP_UnitTestCase {
  private $postids;
  private $catids;

  public function setUp()
  {
    parent::setUp();

    switch_theme('wptest');

    $catid1 = $this->factory->term->create( array(
      'name' => 'cat1_parent',
      'taxonomy' => 'category',
      'description', 'desc - cat1',
      ));
    $catid1_1 = $this->factory->term->create_object( array(
      'name' => 'cat1_child1',
      'taxonomy' => 'category',
      'description' => 'desc - cat1_1',
      'parent' => $catid1,
      ));

    $this->catids = array(
      $catid1,
      $catid1_1,
    );


#    $cat_all = get_terms( "category", "fields=all&get=all"  );
#    print_r( $cat_all);


#     wp_set_post_terms($postid,)
    $postid = $this->factory->post->create( array(
      'post_type' => 'post',
      'post_title' => 'post title ob',
    ));


    $this->postids = array(
      $postid,
    );


    # http://codex.wordpress.org/Function_Reference/wp_set_post_terms


  }

  public function tearDown()
  {
    parent::tearDown();
  }

  public function test_bulk()
  {
  
  }


}
