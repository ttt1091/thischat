<?php include('/var/www/html/thechat/variable.php'); ?>
<?php include('/var/www/html/thechat/setting/pdo.php'); ?>
<?php
  if(isset($_POST['login'])){
    $loginId = $_POST['loginid'];
    $loginPass = $_POST['loginpass'];

    $loginSet = $dbh->prepare("SELECT * FROM `managers` WHERE `login` = :loginid AND `password` = :loginpass");
    $loginSet->execute(
      [
        ':loginid' => $loginId,
        ':loginpass' => $loginPass,
      ]
    );
    $loginSets = $loginSet->fetch(PDO::FETCH_ASSOC);

    $loginCheck = $dbh->prepare("SELECT count(id) AS `login_check` FROM `managers` WHERE `login` = :loginid AND `password` = :loginpass");
    $loginCheck->execute([
      ':loginid' => $loginId,
      ':loginpass' => $loginPass,
    ]);

    $loginChecks = $loginCheck->fetch(PDO::FETCH_ASSOC);
    if(!empty($loginChecks['login_check'])){
      setcookie('theChatYouID', $loginSets['id'], time()+43200);
      setcookie('key', $loginSets['user_key'], time()+43200);
      $now = date('Y-m-d H:i:s');
      $ip = $_SERVER["REMOTE_ADDR"];
      $ip = ip2long($ip);
      $set_read_time = $dbh->prepare("UPDATE `managers` SET `ip2long` = :ipkey, online = :onlinekey, lasted_dt = :now WHERE `managers`.`id` = :uid");
      $set_read_time->execute(
        [
          ':uid' => $loginSets['id'],
          ':ipkey' => $ip,
          ':onlinekey' => makeRandStr(13),
          ':now' => $now
        ]
      );

      $dbh->query("DELETE FROM `messages` WHERE `opened_dt` != '9999-12-31 23:59:59' AND (`sended_dt` < DATE_SUB(NOW(), INTERVAL 12 HOUR))");
      // Json File Touch
      $loop_manager = $dbh->prepare("SELECT * FROM `managers` WHERE `id` != :myid AND `status` = '1'");
      $loop_manager->execute([
        'myid' => $loginSets['id']
      ]);
      while ($lmv = $loop_manager->fetch(PDO::FETCH_ASSOC)) {
        $my2you4json = [];
        $you2my4json = [];

        $message4json = $dbh->prepare("SELECT
          `msg`.`id`,
          `msg`.`send`,
          `mng`.`name` AS `sendname`,
          `msg`.`receive`,
          `mng2`.`name` AS `receivename`,
          `msg`.`subject`,
          `msg`.`body`,
          `msg`.`files`,
          `msg`.`status`,
          `msg`.`mail_key`,
          `msg`.`opened_dt`,
          `msg`.`sended_dt`,
          `msg`.`changed_dt`,
          `msg`.`created_dt`
        FROM `messages` AS `msg` INNER JOIN `managers` AS `mng` ON `msg`.`send` = `mng`.`id` INNER JOIN `managers` AS `mng2` ON `msg`.`receive` = `mng2`.`id`
        WHERE
          `msg`.`status` = 1 AND
          (`msg`.`send` = :mid AND `msg`.`receive` = :myid) OR
          (`msg`.`send` = :myid AND `msg`.`receive` = :mid)");
        $message4json->execute(
          [
            'mid' => $lmv['id'],
            'myid' => $loginSets['id']
          ]
        );
        while ($m4j = $message4json->fetch(PDO::FETCH_ASSOC)) {
          $my2you4json[] = [
            "mail_id" => $m4j['id'],
            "send" => $m4j['send'],
            "sendname" => $m4j['sendname'],
            "receive" => $m4j['receive'],
            "receivename" => $m4j['receivename'],
            "subject" => $m4j['subject'],
            "body" => $m4j['body'],
            "files" => $m4j['files'],
            "status" => $m4j['status'],
            "mail_key" => $m4j['mail_key'],
            "opened_dt" => $m4j['opened_dt'],
            "sended_dt" => $m4j['sended_dt'],
            "changed_dt" => $m4j['changed_dt'],
            "created_dt" => $m4j['created_dt']
          ];
          $you2my4json[] = [
            "mail_id" => $m4j['id'],
            "send" => $m4j['send'],
            "sendname" => $m4j['sendname'],
            "receive" => $m4j['receive'],
            "receivename" => $m4j['receivename'],
            "receive" => $m4j['subject'],
            "body" => $m4j['body'],
            "files" => $m4j['files'],
            "status" => $m4j['status'],
            "mail_key" => $m4j['mail_key'],
            "opened_dt" => $m4j['opened_dt'],
            "sended_dt" => $m4j['sended_dt'],
            "changed_dt" => $m4j['changed_dt'],
            "created_dt" => $m4j['created_dt']
          ];
        }

        exec('mkdir /var/www/html/thechat/json/messages/users/'.strval($loginSets['id']));
        exec('mkdir /var/www/html/thechat/json/messages/users/'.strval($lmv['id']));
        exec('touch /var/www/html/thechat/json/messages/users/'.strval($loginSets['id']).'/message-'.strval($lmv['id']).'.json');
        exec('touch /var/www/html/thechat/json/messages/users/'.strval($lmv['id']).'/message-'.strval($loginSets['id']).'.json');
        file_put_contents('/var/www/html/thechat/json/messages/users/'.strval($loginSets['id']).'/message-'.strval($lmv['id']).'.json', json_encode($my2you4json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        file_put_contents('/var/www/html/thechat/json/messages/users/'.strval($lmv['id']).'/message-'.strval($loginSets['id']).'.json', json_encode($you2my4json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
      }
      header('Location: /thechat/');
    } else {
      header('Location: /thechat/login');
    }

    $dbh=null;
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN</title>
  <link rel="apple-touch-icon" sizes="180x180" href="static/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="static/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="static/favicon/favicon-16x16.png">
  <!-- <link rel="manifest" href="static/favicon/site.webmanifest"> -->
  <link rel="mask-icon" href="static/favicon/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#2b5797">
  <meta name="theme-color" content="#ffffff">
  <link href="static/css/bootstrap.min.css" rel="stylesheet">
  <link href="static/css/login.css" rel="stylesheet">
</head>
<body>
  <div class="container-fluid d-flex justify-content-center align-items-center login-wrap" style="">
    <div class="card login-form">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form action="" method="POST">
          <div class="mb-3">
            <label for="" class="form-label">ID</label>
            <input type="text" class="form-control" name="loginid" value="">
          </div>
          <div class="mb-3">
            <label for="" class="form-label">PASS</label>
            <input type="password" class="form-control" name="loginpass" value="">
          </div>
          <div class="mb-3 d-grid gap-2">
            <button type="submit" class="btn btn-original-blue" name="login" value="go">ログイン</button>
          </div>
        </form>
        <div class="mb-3 d-grid gap-2">
          <a href="/thechat/thechat">新規登録</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>