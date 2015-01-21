<?php

class UT_hykwWPData_page extends hykwEasyUT {

  public function test_bulk()
  {
    $url = '/parent/static1';
    $urlAndCode = '/parent/static1?code=3';
    $pageid = 10;

    $this->go_to($urlAndCode);
    $fqdnAndPath = sprintf('http://%s%s', WP_TESTS_DOMAIN, $url);
    $fqdnAndPathAndCode = sprintf('http://%s%s?code=3', WP_TESTS_DOMAIN, $url);

    ##### iget_id()
    $this->assertEquals($pageid, hykwWPData_page::iget_id());

    ##### *get_parent_id()
    $this->assertEquals(2119, hykwWPData_page::iget_parent_id());
    $this->assertEquals(2119, hykwWPData_page::get_parent_id($pageid));
    $this->assertEquals(FALSE, hykwWPData_page::get_parent_id(1751));
    $this->assertEquals(FALSE, hykwWPData_page::get_parent_id(99999));

    ##### *get_objects()
    $expects = array(
      'ID'=> $pageid,
      'post_name' => 'static1',
    );
    $this->assertEquals($expects, hykwWPData_page::iget_objects(array('ID', 'post_name')));
    $this->assertEquals($expects, hykwWPData_page::get_objects('/parent/static1', FALSE, array('ID', 'post_name')));
    $this->assertEquals($expects, hykwWPData_page::get_objects(FALSE, $pageid, array('ID', 'post_name')));
    $this->assertEquals(FALSE, hykwWPData_page::get_objects(FALSE, FALSE));
    $this->assertEquals(FALSE, hykwWPData_page::get_objects('/xxxxxxxxx', FALSE));

    ##### *get_object()
    $this->assertEquals($pageid, hykwWPData_page::iget_object('ID'));
    $this->assertEquals($pageid, hykwWPData_page::get_object('ID', FALSE, $pageid));

    ##### *get_permalink()
    $this->assertEquals($fqdnAndPath, hykwWPData_page::iget_permalink(FALSE));
    $this->assertEquals('/parent/static1', hykwWPData_page::iget_permalink(TRUE));
    $this->assertEquals('/parent/static1', hykwWPData_page::iget_permalink());

    $this->assertEquals($fqdnAndPath, hykwWPData_page::get_permalink($pageid, FALSE));
    $this->assertEquals('/parent/static1', hykwWPData_page::get_permalink($pageid, TRUE));
    $this->assertEquals('/parent/static1', hykwWPData_page::get_permalink($pageid));

    ##### *get_title()
    $this->assertEquals('固定ページ１', hykwWPData_page::iget_title());
    $this->assertEquals('このサイトについて', hykwWPData_page::get_title(FALSE, 1752));
    $this->assertEquals('このサイトについて', hykwWPData_page::get_title('/about', FALSE));
    $this->assertEquals('このサイトについて', hykwWPData_page::get_title('/about'));

    ##### *get_contents()
    $expects = array("あああああ", "いいいいい", '');
    $this->assertEquals($expects, explode("\r\n", hykwWPData_page::iget_contents()));
    $this->assertEquals($expects, explode("\r\n", hykwWPData_page::get_contents(FALSE, $pageid)));

    ##### *get_date()
    $this->assertEquals('2014/12/28', hykwWPData_page::iget_date());
    $this->assertEquals('2014/12/28', hykwWPData_page::get_date($pageid));

  }

  public function test_get_child_ids()
  {
    $url = '/parent?code=3';
    $this->go_to($url);

    $this->assertEquals('親固定ページ1', hykwWPData_page::iget_title());
    $this->assertEquals(2119, hykwWPData_page::iget_id());
    $this->assertEquals(array(10, 2121), hykwWPData_page::iget_children_ids());
    $this->assertEquals(array(10,2121), hykwWPData_page::get_children_ids(2119));

    $this->assertEquals(FALSE, hykwWPData_page::get_children_ids(9999));
    $this->assertEquals(FALSE, hykwWPData_page::get_children_ids(1751));
  }

  public function test_fail()
  {
    $this->go_to('/?code=3');

    $this->assertEquals(FALSE, hykwWPData_page::iget_id());
    $this->assertEquals(FALSE, hykwWPData_page::iget_parent_id());
    $this->assertEquals(FALSE, hykwWPData_page::iget_children_ids());
    $this->assertEquals(FALSE, hykwWPData_page::iget_permalink());
    $this->assertEquals(FALSE, hykwWPData_page::iget_objects());
    $this->assertEquals(FALSE, hykwWPData_page::iget_title());
  }

  public function test_get_pagemeta()
  {
    $url = '/sample-page-2';
    $this->go_to($url);

    $this->assertEquals('', hykwWPData_page::iget_pagemeta('xxxxx'));
    $this->assertEquals('', hykwWPData_page::get_pagemeta(1751, 'xxxxx'));

    $this->assertEquals('12345', hykwWPData_page::iget_pagemeta('固定ページのカスタムフィールド'));
    $this->assertEquals('12345', hykwWPData_page::get_pagemeta(1751, '固定ページのカスタムフィールド'));

  }


}

