<?php include('/var/www/html/thechat/variable.php'); ?>
<?php include('/var/www/html/thechat/setting/pdo.php'); ?>
<?php include($rootPath.'parts/chat-setting.php'); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php include($rootPath.'parts/head.php'); ?>
</head>
<body style="padding-top:56px;">

<?php include($rootPath.'parts/topnav.php'); ?>




<div class="container-fluid">
  <div class="row">
    <div class="left-col">
<?php include($rootPath.'parts/left-col.php'); ?>
    </div><!-- //left-col-END -->

    <div class="col-md message-col">
<?php include($rootPath.'parts/chat-view.php'); ?>
    </div><!-- //message-col-END -->

    <div class="right-col">
      <?php include($rootPath.'parts/right-default.php'); ?>
      <div>
        <pre>
<?php
  $test_que = $dbh->prepare("SELECT * FROM `managers` WHERE `status` = '1' AND `id` = '1'");
  $test_que->execute();
  $ttt = $test_que->fetch(PDO::FETCH_ASSOC);
  $push = $ttt['push_requests'];
  $depush = json_decode( $push , true );
  var_dump($depush);
  echo count($depush)."<br>";
  echo $depush[0]["endpoint"]."<br>";
  echo $depush[0]["userAuthToken"]."<br>";
  echo $depush[0]["userPublicKey"]."<br>";
?>
        </pre>
      </div>
    </div><!-- //right-col-END -->
  </div><!-- //row-END -->

  <div class="close-mask" style="display: none;"></div>

</div><!-- //container-END -->


<?php $dbh = null; ?>
  

<?php include($rootPath.'parts/service-worker.php'); ?>
<?php include($rootPath.'parts/bottom-js.php'); ?>

</body>
</html>