<?php

$_tests_dir = sprintf('%s/ut/hykw-wpdata', getenv('HOME'));

require_once $_tests_dir . '/includes/functions.php';

function _manually_load_environment()
{
  require dirname( __FILE__ ) . '/../main.php';
}

tests_add_filter( 'muplugins_loaded', '_manually_load_environment'  );

require $_tests_dir . '/includes/bootstrap.php';

##################################################
function p($obj)
{
  print_r($obj);
  exit;
}
function v($obj)
{
  var_dump($obj);
  exit;
}
