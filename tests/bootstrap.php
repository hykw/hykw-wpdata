<?php

$_tests_dir = getenv('WP_PATH_UT');
require_once $_tests_dir . '/includes/functions.php';

function _manually_load_environment()
{
  require dirname( __FILE__ ) . '/../main.php';
}

tests_add_filter( 'muplugins_loaded', '_manually_load_environment'  );

require $_tests_dir . '/includes/bootstrap.php';

