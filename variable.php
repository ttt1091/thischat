<?php
ini_set('display_errors', "On");

$rootPath = '/var/www/html/thechat/';
$rootWebPath = '/thechat/';
$uploadPath = '/var/www/html/thechat/upload/';

function makeRandStr($length) {
  $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
  $r_str = null;
  for ($i = 0; $i < $length; $i++) {
      $r_str .= $str[rand(0, count($str) - 1)];
  }
  return $r_str;
}
function h($str){
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

session_start();
session_regenerate_id();
if(isset($_GET['myid']))
{
  setcookie('theChatYouID', $_GET['myid'], time()+43200);
}