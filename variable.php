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

if($_SERVER['SCRIPT_NAME']=='//thechat/login.php'||$_SERVER['SCRIPT_NAME']=='//thechat/thechat.php'){}else{

  include('/var/www/html/thechat/setting/pdo.php');
  $myId = intval($_COOKIE['theChatYouID']);
  $my_profiles = $dbh->prepare("SELECT * FROM `managers` WHERE `status` = '1' AND `id` = :myid");
  $my_profiles->execute(
    [
      'myid' => $myId,
    ]
  );
  $myProf = $my_profiles->fetch(PDO::FETCH_ASSOC);
  $myName = $myProf['name'];

  $dbh=null;

}