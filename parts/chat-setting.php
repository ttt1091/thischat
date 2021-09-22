<?php
ini_set( 'display_errors', 1 );
//////////////////////////////////////////
//  一時設定
//////////////////////////////////////////



if(!isset($_COOKIE['theChatYouID'])){
  header('Location: /thechat/login');
}


if(isset($_POST['mode'])){
  if($_POST['mode']=='read'){
    $messageId = $_POST['messageId'];
    $now = date('Y/m/d H:i:s');
    $targetId = $_GET['target'];

    $set_read_time = $dbh->prepare("UPDATE `messages` SET `opened_dt` = :now WHERE `messages`.`id` = :messageid");
    $set_read_time->execute(
      [
        'now' => $now,
        'messageid' => $messageId
      ]
    );

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
                'mid' => $targetId,
                'myid' => $myId,
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

          exec('mkdir /var/www/html/thechat/json/messages/users/'.strval($myId));
          exec('mkdir /var/www/html/thechat/json/messages/users/'.strval($targetId));
          exec('touch /var/www/html/thechat/json/messages/users/'.strval($myId).'/message-'.strval($targetId).'.json');
          exec('touch /var/www/html/thechat/json/messages/users/'.strval($targetId).'/message-'.strval($myId).'.json');
          file_put_contents('/var/www/html/thechat/json/messages/users/'.strval($myId).'/message-'.strval($targetId).'.json', json_encode($my2you4json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
          file_put_contents('/var/www/html/thechat/json/messages/users/'.strval($targetId).'/message-'.strval($myId).'.json', json_encode($you2my4json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));


    header('Location: /thechat/?target='.$targetId.'&read=message'.$messageId);
    
  } elseif( $_POST['mode'] == 'send' ) {
    if(!empty($_POST['messageBody']||$_FILES['messageFile'])){
      $mailkey = makeRandStr(13);
      $target = $_POST['target'];
      $now = date('Y/m/d H:i:s');
      $myId = intval($_COOKIE['theChatYouID']);
      $messagebody = h($_POST['messageBody']);

      $tempfile = $_FILES['messageFile']['tmp_name'];
      @list($file_name,$file_type) = explode(".",@$_FILES['messageFile']['name']);
      $copy_file = date("Ymd-His") . "." . $file_type;
      $copy_other_file = $file_name."-".date("Ymd-His") . "." . $file_type;
      $updir = $rootPath.'upload/';
      $image_list = ["png","jpeg","jpg","gif"];
      str_replace($image_list, "", $file_type, $image_count);
      if($image_count !== 0){
        $filename = $updir.$copy_file;
      } else {
        $filename = $rootPath.'upload/' . $copy_other_file;
      }
      if (is_uploaded_file($tempfile)) {
        if ( move_uploaded_file($tempfile , $filename )) {
          if($image_count !== 0){
            $file = $copy_file;
          } else {
            $file = $copy_other_file;
          }
        } else {
          $file = '';
        }
      } else {
        $file = '';
      } 

      if(empty($_POST['subject'])){
        $subject = '';
      } else {
        $subject = h($_POST['subject']);
      }

      $insert_message = $dbh->prepare("INSERT INTO `messages` 
        (`send`, `receive`, `subject`, `body`, `files`, `mail_key`, `sended_dt`, `created_dt`) VALUES 
        (:sendid, :receiveid, :messagesubject, :body, :files, :mailkey, :sended, :created)
      ");
      $insert_message->execute(
        [
          'sendid' => $myId,
          'receiveid' => $target,
          'messagesubject' => $subject,
          'body' => $messagebody,
          'files' => $file,
          'mailkey' => $mailkey,
          'sended' => $now,
          'created' => $now
        ]
      );
      // exec('php sendPush.php');

      // 古いメッセージ(開封後12時間経過)の強制削除
      $dbh->query("DELETE FROM `messages` WHERE (`opened_dt` < DATE_SUB(NOW(), INTERVAL 12 HOUR))");

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
            'mid' => $target,
            'myid' => $myId,
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


      exec('mkdir /var/www/html/thechat/json/messages/users/'.strval($myId));
      exec('mkdir /var/www/html/thechat/json/messages/users/'.strval($target));
      exec('touch /var/www/html/thechat/json/messages/users/'.strval($myId).'/message-'.strval($target).'.json');
      exec('touch /var/www/html/thechat/json/messages/users/'.strval($target).'/message-'.strval($myId).'.json');
      file_put_contents('/var/www/html/thechat/json/messages/users/'.strval($myId).'/message-'.strval($target).'.json', json_encode($my2you4json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
      file_put_contents('/var/www/html/thechat/json/messages/users/'.strval($target).'/message-'.strval($myId).'.json', json_encode($you2my4json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

      header('Location: /thechat/?target='.$target);
    } else {
      echo '<script>alert("メッセージを入力してください");</script>';
    }
  }
}
?>