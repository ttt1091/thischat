<?php include('/var/www/html/thechat/variable.php'); ?>
<?php include('/var/www/html/thechat/setting/pdo.php'); ?>
<?php

  $set_read_time = $dbh->prepare("UPDATE `managers` SET `online` = null WHERE `managers`.`id` = :uid");
  $set_read_time->execute(
    [
      ':uid' => $_COOKIE['theChatYouID']
    ]
  );

  setcookie('PHPSESSID', '', time()-30);
  setcookie('theChatYouID', '', time()-30);
  setcookie('key', '', time()-30);

  header('Location: /thechat/login');