<?php include('/var/www/html/thechat/variable.php'); ?>
<?php include('/var/www/html/thechat/setting/pdo.php'); ?>

<?php

ini_set( 'display_errors', 1 );
//////////////////////////////////////////
//  JobSterSettings
//////////////////////////////////////////
$now = date('Y/m/d');

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<?php include($rootPath.'parts/head.php'); ?>
<link rel="apple-touch-icon" href="static/favicon/apple-touch-icon.png">
<meta name="apple-mobile-web-app-title" content="theChat">
</head>
<body style="padding-top:56px;">

<?php include($rootPath.'parts/topnav.php'); ?>




<div class="container-fluid">
  <div class="row" style="flex-wrap: nowrap!important;">
    <div class="left-col">
      <?php include($rootPath.'jobster/parts/left-menu.php'); ?>
    </div><!-- //left-col-END -->

    <div class="col-md message-col" style="overflow-x: hidden;">

<div class="jobster-wrap">

<div>
  <h2>シフト登録</h2>
  <div>
    <div>
      <div>2021/09/01</div>
    </div>
  </div>
</div>

</div>

    </div><!-- //message-col-END -->

    <div class="right-col">
      <?php include($rootPath.'parts/right-default.php'); ?>
    </div><!-- //right-col-END -->
  </div><!-- //row-END -->

  <div class="close-mask" style="display: none;"></div>

</div><!-- //container-END -->


<?php $dbh = null; ?>
  

<?php include($rootPath.'parts/service-worker.php'); ?>
<?php include($rootPath.'parts/bottom-js.php'); ?>

</body>
</html>