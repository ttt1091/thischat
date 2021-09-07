<?php

$rootPath = '/var/www/html/thechat/';
$rootWebPath = '/thechat/';

function makeRandStr($length) {
  $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
  $r_str = null;
  for ($i = 0; $i < $length; $i++) {
      $r_str .= $str[rand(0, count($str) - 1)];
  }
  return $r_str;
}