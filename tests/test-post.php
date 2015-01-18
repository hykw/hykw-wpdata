<?php

class UT_hykwWPData_post extends WP_UnitTestCase {
  private $postids;
  private $catids;

  public function setUp()
  {
    parent::setUp();

    switch_theme('wptest');

    /*                 term_id
        catid1         2
          catid1_1     3
          catid1_2     4
        catid2         5
     */

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
    $catid1_2 = $this->factory->term->create_object( array(
      'name' => 'cat1_child2',
      'taxonomy' => 'category',
      'description' => 'desc - cat1_2',
      'parent' => $catid1,
      ));

    $catid2 = $this->factory->term->create( array(
      'name' => 'cat2',
      'taxonomy' => 'category',
      'description', 'desc - cat2',
      ));

    $this->catids = array(
      $catid1,
      $catid1_1,
      $catid1_2,
      $catid2,
    );

#    $cat_all = get_terms( "category", "fields=all&get=all"  );
#    print_r( $cat_all);

    /*              category          post_id
      postid1       catid1            3
        postid1_1   catid1_1          4
        postid1_2   catid1, catid1_2  5
      postid2       catid2            6
     */
    $postid1 = $this->factory->post->create( array(
      'post_type' => 'post',
      'post_title' => 'post title1',
    ));
    $postid1_1 = $this->factory->post->create_object( array(
      'post_type' => 'post',
      'post_title' => 'post title 11',
      'post_parent' => $postid1,
    ));
    $postid1_2 = $this->factory->post->create_object( array(
      'post_type' => 'post',
      'post_title' => 'post title 12',
      'post_parent' => $postid1,
    ));
    $postid2 = $this->factory->post->create( array(
      'post_type' => 'post',
      'post_title' => 'post title2',
    ));

     wp_set_post_terms($postid1, $this->catids[0]);
     wp_set_post_terms($postid1_1, $this->catids[1]);
     wp_set_post_terms($postid1_2, array($this->catids[0], $this->catids[2]));
     wp_set_post_terms($postid2, $this->catids[3]);

    $this->postids = array(
      $postid1,
      $postid1_1,
      $postid1_2,
      $postid2,
    );

  }

  public function tearDown()
  {
    parent::tearDown();
  }

  public function test_bulk()
  {
    $url = sprintf('/?p=%s', $this->postids[0]);
    $this->go_to($url);
    $fqdnAndPath = sprintf('http://%s%s', WP_TESTS_DOMAIN, $url);

    ##### iget_id()
    $this->assertEquals($this->postids[0], hykwWPData_post::iget_id());

    ##### iget_permalink()
    $this->assertEquals($url, hykwWPData_post::iget_permalink());
    $this->assertEquals($fqdnAndPath, hykwWPData_post::iget_permalink(FALSE));
    $this->assertEquals($url, hykwWPData_post::iget_permalink(TRUE));

    ##### get_permalink()
    $this->assertEquals($url, hykwWPData_post::get_permalink($this->postids[0]));
    $this->assertEquals($fqdnAndPath, hykwWPData_post::get_permalink($this->postids[0], FALSE));
    $this->assertEquals($url, hykwWPData_post::get_permalink($this->postids[0], TRUE));

    $this->assertEquals('', hykwWPData_post::get_permalink(9999));


  }


}
