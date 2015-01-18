<?php

##################################################


assert_equal('p', FALSE, hykwWPData_category::iget_id());


######
$i = 1;
assert_equal('c'.$i++, FALSE, hykwWPData_category::iget_id());
assert_equal('c'.$i++, FALSE, hykwWPData_category::iget_objects());
assert_equal('c'.$i++, FALSE, hykwWPData_category::iget_childObjects());
assert_equal('c'.$i++, FALSE, hykwWPData_category::iget_permalink());
assert_equal('c'.$i++, FALSE, hykwWPData_category::iget_post_objects());

$i = 1;
assert_equal('pp'.$i++, FALSE, hykwWPData_page::iget_id());
assert_equal('pp'.$i++, FALSE, hykwWPData_page::iget_parent_id());
assert_equal('pp'.$i++, FALSE, hykwWPData_page::iget_children_ids());
assert_equal('pp'.$i++, FALSE, hykwWPData_page::iget_permalink());
assert_equal('pp'.$i++, FALSE, hykwWPData_page::iget_objects());
assert_equal('pp'.$i++, FALSE, hykwWPData_page::iget_title());

$i = 1;
assert_equal('post'.$i++, FALSE, hykwWPData_post::iget_id());
assert_equal('post'.$i++, FALSE, hykwWPData_post::iget_permalink());
assert_equal('post'.$i++, FALSE, hykwWPData_post::iget_status());
assert_equal('post'.$i++, FALSE, hykwWPData_post::iget_type());
assert_equal('post'.$i++, FALSE, hykwWPData_post::iget_title());
assert_equal('post'.$i++, FALSE, hykwWPData_post::iget_thumbnail_url());
assert_equal('post'.$i++, FALSE, hykwWPData_post::iget_thumbnail_url('full'));
assert_equal('post'.$i++, FALSE, hykwWPData_post::iget_thumbnail_url('thumbnail'));
assert_equal('post'.$i++, FALSE, hykwWPData_post::iget_content());
assert_equal('post'.$i++, FALSE, hykwWPData_post::iget_excerpt());
assert_equal('post'.$i++, FALSE, hykwWPData_post::iget_postdate());
assert_equal('post'.$i++, FALSE, hykwWPData_post::iget_postmeta(FALSE));

