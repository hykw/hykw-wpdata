<?php

class UT_hykwWPData_post extends hykwEasyUT {

  public function test_bulk()
  {
    $postid = 4;
    $url = sprintf('/archives/%d', $postid);
    $urlAndCode = sprintf('%s?code=3', $url);
    $this->go_to($urlAndCode);
    $fqdnAndPath = sprintf('http://%s%s', WP_TESTS_DOMAIN, $url);
    $fqdnAndPathAndCode = sprintf('http://%s%s?code=3', WP_TESTS_DOMAIN, $url);

    ##### iget_id()
    $this->assertEquals($postid, hykwWPData_post::iget_id());

    ##### iget_permalink()
    $this->assertEquals($url, hykwWPData_post::iget_permalink());
    $this->assertEquals($fqdnAndPath, hykwWPData_post::iget_permalink(FALSE));
    $this->assertEquals($url, hykwWPData_post::iget_permalink(TRUE));

    ##### get_permalink()
    $this->assertEquals($url, hykwWPData_post::get_permalink($postid));
    $this->assertEquals($fqdnAndPath, hykwWPData_post::get_permalink($postid, FALSE));
    $this->assertEquals($url, hykwWPData_post::get_permalink($postid, TRUE));

    $this->assertEquals('', hykwWPData_post::get_permalink(9999));

    ##### iget_status()
    $this->assertEquals('publish', hykwWPData_post::iget_status());
    $this->assertEquals('publish', hykwWPData_post::get_status($postid));

    ##### iget_type()
    $this->assertEquals('post', hykwWPData_post::iget_type());

    ##### get_type()
    $this->assertEquals('', hykwWPData_post::get_type(9999));
    $this->assertEquals('post', hykwWPData_post::get_type($postid));

    ##### iget_title()
    $this->assertEquals('投稿１', hykwWPData_post::iget_title());

    ##### get_title()
    $this->assertEquals('', hykwWPData_post::get_title(9999));
    $this->assertEquals('極端な例: ネスト化された混合リスト', hykwWPData_post::get_title(1000));

    ##### *get_thumbnail_url()
    $this->assertEquals(UT_THUMBNAIL_4, hykwWPData_post::iget_thumbnail_url());
    $this->assertEquals(UT_THUMBNAIL_4, hykwWPData_post::get_thumbnail_url($postid));

    ##### get_thumbnail_obj()
    $obj = hykwWPData_post::get_thumbnail_obj($postid);
    $this->assertEquals(UT_THUMBNAIL_4, $obj[0]);
    $this->assertEquals('', hykwWPData_post::get_thumbnail_obj(9999));

    ##### *get_content()
    $this->assertEquals("あああああ", hykwWPData_post::iget_content());
    $this->assertEquals('あああああ', hykwWPData_post::get_content($postid));
    $this->assertEquals('', hykwWPData_post::get_content(99999));

    ##### *get_excerpt()
    $this->assertEquals('抜粋欄の内容', hykwWPData_post::iget_excerpt(TRUE));
    $this->assertEquals('抜粋欄の内容', hykwWPData_post::iget_excerpt(FALSE));
    $this->assertEquals('抜粋欄の内容', hykwWPData_post::iget_excerpt());
    $this->assertEquals('抜粋欄の内容', hykwWPData_post::get_excerpt($postid, TRUE));
    $this->assertEquals('抜粋欄の内容', hykwWPData_post::get_excerpt($postid, FALSE));
    $this->assertEquals('抜粋欄の内容', hykwWPData_post::get_excerpt($postid));
    $this->assertEquals('本文：投稿2', hykwWPData_post::get_excerpt(6));
    $this->assertEquals('本文：投稿2', hykwWPData_post::get_excerpt(6, TRUE));
    $this->assertEquals('', hykwWPData_post::get_excerpt(6, FALSE));
    $this->assertEquals('', hykwWPData_post::get_excerpt(99999));

    ##### *get_postdate()
    $this->assertEquals('2014/12/28', hykwWPData_post::iget_postdate());
    $this->assertEquals('2014/12/28', hykwWPData_post::get_postdate($postid));
    $this->assertEquals('', hykwWPData_post::get_postdate(99999));

    ##### *get_postmeta()
    $this->assertEquals('111', hykwWPData_post::iget_postmeta('カスタム1'));
    $this->assertEquals('', hykwWPData_post::iget_postmeta('xxxxx'));
    $this->assertEquals('111', hykwWPData_post::get_postmeta(4, 'カスタム1'));
    $this->assertEquals('', hykwWPData_post::get_postmeta(9999, 'カスタム1'));
  }

  public function test_fail()
  {
    $this->go_to('/?code=3');

    $this->assertEquals(FALSE, hykwWPData_post::iget_id());
    $this->assertEquals(FALSE, hykwWPData_post::iget_permalink());
    $this->assertEquals(FALSE, hykwWPData_post::iget_status());
    $this->assertEquals(FALSE, hykwWPData_post::iget_type());
    $this->assertEquals(FALSE, hykwWPData_post::iget_title());
    $this->assertEquals(FALSE, hykwWPData_post::iget_thumbnail_url());
    $this->assertEquals(FALSE, hykwWPData_post::iget_thumbnail_url('full'));
    $this->assertEquals(FALSE, hykwWPData_post::iget_thumbnail_url('thumbnail'));
    $this->assertEquals(FALSE, hykwWPData_post::iget_content());
    $this->assertEquals(FALSE, hykwWPData_post::iget_excerpt());
    $this->assertEquals(FALSE, hykwWPData_post::iget_postdate());
    $this->assertEquals(FALSE, hykwWPData_post::iget_postmeta(FALSE));
  }

}
