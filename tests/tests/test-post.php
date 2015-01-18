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

    /*              category          post_id       サムネイル画像あり
      postid1       catid1            3             y
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
      'post_excerpt' => 'excerpt11',
      'post_content' => 'content11',
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
    $postid3 = $this->factory->post->create( array(
      'post_type' => 'post',
      'post_status' => 'draft',
    ));
    $postid4 = $this->factory->post->create( array(
      'post_type' => 'post',
      'post_status' => 'pending',
    ));

    # カテゴリ追加
     wp_set_post_terms($postid1, $this->catids[0]);
     wp_set_post_terms($postid1_1, $this->catids[1]);
     wp_set_post_terms($postid1_2, array($this->catids[0], $this->catids[2]));
     wp_set_post_terms($postid2, $this->catids[3]);

     # サムネイル画像追加
#     $thumbnaiid1 = 0;
#     set_post_thumbnail($postid1, $thumbnaiid1);

    $this->postids = array(
      $postid1,
      $postid1_1,
      $postid1_2,
      $postid2,
      $postid3,
      $postid4,
    );

     remove_filter( 'the_content', 'wpautop'  );
     remove_filter( 'the_excerpt', 'wpautop'  );

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

    ##### iget_status()
    $this->assertEquals('publish', hykwWPData_post::iget_status());

    ##### iget_type()
    $this->assertEquals('post', hykwWPData_post::iget_type());

    ##### get_type()
    $this->assertEquals('', hykwWPData_post::get_type(9999));
    $this->assertEquals('post', hykwWPData_post::get_type($this->postids[0]));

    ##### iget_title()
    $this->assertEquals('post title1wptest', hykwWPData_post::iget_title());

    ##### get_title()
    $this->assertEquals('', hykwWPData_post::get_title(9999));
    $this->assertEquals('post title 12', hykwWPData_post::get_title($this->postids[2]));

    ##### iget_content()
    $this->assertEquals('Post content 1', hykwWPData_post::iget_content());
    $this->assertEquals('Post content 1', hykwWPData_post::iget_content(FALSE));
    $this->assertEquals('Post content 1', hykwWPData_post::iget_content(TRUE));

    ##### get_content()
    $this->assertEquals('Post content 1', hykwWPData_post::get_content($this->postids[0]));
    $this->assertEquals('Post content 1', hykwWPData_post::get_content($this->postids[0], FALSE));
    $this->assertEquals('Post content 1', hykwWPData_post::get_content($this->postids[0], TRUE));

  }

  public function test_get_status()
  {
    $url = sprintf('/?p=%s', $this->postids[4]);
    $this->go_to($url);

    ##### get_status()
    $this->assertEquals('draft', hykwWPData_post::get_status($this->postids[4]));
    $this->assertEquals('pending', hykwWPData_post::get_status($this->postids[5]));
    $this->assertFalse(hykwWPData_post::get_status(9999));
  }

  public function test_get_thumnbnail_url()
  {
    ### FIXME
    $this->assertEquals('', hykwWPData_post::iget_thumbnail_url());
    $this->assertEquals('', hykwWPData_post::get_thumbnail_url(9999));
    $this->assertEquals('', hykwWPData_post::get_thumbnail_obj(9999));
  }

  public function test_get_excerpt()
  {
    $url = sprintf('/?p=%s', $this->postids[1]);
    $this->go_to($url);

#    $this->assertEquals('exceprt11', hykwWPData_post::iget_excerpt());
#    $this->assertEquals('exceprt11', hykwWPData_post::iget_excerpt(TRUE));
    $this->assertEquals('exceprt11', hykwWPData_post::iget_excerpt(FALSE));

  
  }


}
