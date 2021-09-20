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
      exec('php sendPush.php');
      header('Location: /thechat/?target='.$target);
    } else {
      echo '<script>alert("メッセージを入力してください");</script>';
    }
  }
}
?>