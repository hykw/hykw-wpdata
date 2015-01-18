<?php

class UT_hykwWPData_url extends hykwEasyUT {

  public function test_get_themeURL()
  {
    $work = explode('/', hykwWPData_url::get_themeURL(hykwWPData_url::DIR_PARENT));
    $dir_parent = $work[5];
    $work = explode('/', hykwWPData_url::get_themeURL(hykwWPData_url::DIR_CHILD));
    $dir_child = $work[5];

    $this->assertEquals('wptest.parent', $dir_parent);
    $this->assertEquals('wptest', $dir_child);
  }

  public function test_get_domainName()
  {
    $this->assertEquals('http://wptest.comedical.jp', hykwWPData_url::get_domainName());
  }

  public function test_get_requestURL()
  {
    $this->go_to('/');
    $this->assertEquals('/', hykwWPData_url::get_requestURL());
    $this->assertEquals('/', hykwWPData_url::get_requestURL(FALSE));

    $this->go_to('/?code=333');
    $this->assertEquals('/?code=333', hykwWPData_url::get_requestURL(TRUE));
    $this->assertEquals('/', hykwWPData_url::get_requestURL());
    $this->assertEquals('/', hykwWPData_url::get_requestURL(FALSE));

    $this->go_to('/archives/3');
    $this->assertEquals('/archives/3', hykwWPData_url::get_requestURL());
    $this->go_to('/archives/3?code=4');
    $this->assertEquals('/archives/3', hykwWPData_url::get_requestURL());
    $this->assertEquals('/archives/3', hykwWPData_url::get_requestURL(FALSE));
    $this->assertEquals('/archives/3?code=4', hykwWPData_url::get_requestURL(TRUE));
  }

  public function test_get_thisurl()
  {
    $this->go_to('/archives/2?code=3');
    $this->assertEquals(sprintf('http://%s/archives/2', WP_TESTS_DOMAIN), hykwWPData_url::get_thisurl());
    $this->assertEquals(sprintf('http://%s/archives/2', WP_TESTS_DOMAIN), hykwWPData_url::get_thisurl(FALSE));
    $this->assertEquals(sprintf('http://%s/archives/2?code=3', WP_TESTS_DOMAIN), hykwWPData_url::get_thisurl(TRUE));
  }

}
