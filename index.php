<?php include('/var/www/html/thechat/variable.php'); ?>
<?php include('/var/www/html/thechat/setting/pdo.php'); ?>
<?php

//////////////////////////////////////////
//  一時設定
//////////////////////////////////////////

$myId = intval($_COOKIE['theChatYouID']);
$my_profiles = $dbh->prepare("SELECT * FROM `managers` WHERE `status` = '1' AND `id` = :myid");
$my_profiles->execute(
  [
    'myid' => $myId,
  ]
);
$myProf = $my_profiles->fetch(PDO::FETCH_ASSOC);
$myName = $myProf['name'];

if(isset($_POST['mode'])){
  if($_POST['mode']=='read'){
    $messageId = $_POST['messageId'];
    $now = date('Y/m/d H:i:s');
    $targetId = $_GET['target'];

    $set_read_time = $dbh->prepare('UPDATE `messages` SET `opened_dt` = :now WHERE `messages`.`id` = :messageid');
    $set_read_time->execute(
      [
        'now' => $now,
        'messageid' => $messageId
      ]
    );
    header('Location: /thechat/?target='.$targetId);
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="apple-touch-icon" sizes="180x180" href="static/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="static/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="static/favicon/favicon-16x16.png">
  <link rel="manifest" href="static/favicon/site.webmanifest">
  <link rel="mask-icon" href="static/favicon/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#2b5797">
  <meta name="theme-color" content="#ffffff">
  <link href="static/css/bootstrap.min.css" rel="stylesheet">
  <link href="static/css/styles.css?r=<?= rand(); ?>" rel="stylesheet">
  <script src="static/js/jquery-3.6.0.min.js"></script>
  <link rel="manifest" href="/manifest.json">
  <script>
//     if ("serviceWorker" in navigator) {
//       window.addEventListener("load", function () {
//         navigator.serviceWorker.register("https://ubuntu-2nd/thechat/sw.js").then(
//           function (registration) {
//             console.log(
//               "ServiceWorker registration successful with scope: ",
//               registration.scope
//             );
//           },
//           function (err) {
//             console.log("ServiceWorker registration failed: ", err);
//           }
//         );
//       });
//     }
  </script>
</head>
<body style="padding-top:56px;">

<?php include($rootPath.'parts/topnav.php'); ?>




<div class="container-fluid">
  <div class="row">
    <div class="left-col">
      <div class="chat-list">
        <div class="chat-list-ttl">チャットルーム</div>
        <div class="chat-list-items"><a href="">AllChat</a></div>
<?php
  $manager_que = $dbh->query("SELECT * FROM `managers` WHERE `status` = '1' AND `group` = 'site01'");
  while($managers = $manager_que->fetch(PDO::FETCH_ASSOC)){
?>
        <div class="chat-list-items"><a href="/thechat/?target=<?= $managers['id']; ?>"><?= $managers['name']; ?></a></div>
<?php } ?>
      </div>
    </div>
    <div class="col-md message-col">
      <div class="chat-ttl">チャットルーム</div>
      <div class="chat-body">

<?php
if(isset($_GET['target'])){
  $targetId = $_GET['target'];
  $select_mng = $dbh->prepare("SELECT * FROM `managers` WHERE `status` = '1' AND `id` = :mid");
  $select_mng->execute(
    [
      'mid' => $_GET['target'],
    ]
  );
  $row = $select_mng->fetch(PDO::FETCH_ASSOC);
  $mname = $row['name'];
  
  $select_message_mng = $dbh->prepare("SELECT * FROM `messages` WHERE `status` = '1' AND 
  (`send` = :mid AND `receive` = :myid) OR
  (`send` = :myid AND `receive` = :mid)");
  $select_message_mng->execute(
    [
      'mid' => $_GET['target'],
      'myid' => $myId,
    ]
  );
  while($messages = $select_message_mng->fetch(PDO::FETCH_ASSOC)){
    if(isset($messages['subject'])){ $subject = $messages['subject']; } else { $subject = ''; }
    $send = $messages['send'];
    $body = nl2br($messages['body']);
    $openTime = $messages['opened_dt'];
    $messageId = $messages['id'];
    if($send==$myId){
    // Send Message
?>

        <div class="chat-items">
          <div class="chat-items-right send-message">
            <div class="chat-items-top">
              <div class="chat-send-name"><?= $myName ?></div>
              <div class="chat-send-time">2021/07/25 12:32</div>
            </div>
            <div class="chat-items-body">
<?php
if(!empty($subject)){
  echo '<div class="message-subject">'.$subject.'</div>';
  echo '<div class="message-body">'.$body.'</div>';
} else {
  echo '<div class="message-body">'.$body.'</div>';
}
?>
            </div>
          </div>
          <div class="chat-items-thumb"><img src="static/images/dummy-001.jpg" alt=""></div>
        </div>

<?php
    } else {
    // Receive Message
    if($openTime=='1900-01-01 00:00:00'){
    // unread
?>
        <div class="chat-items">
          <div class="chat-items-thumb"><img src="static/images/dummy-001.jpg" alt=""></div>
          <div class="chat-items-right unread-mail">
            <div class="chat-items-top">
              <div class="chat-send-name"><?= $mname ?></div>
              <div class="chat-send-time">2021/07/25 12:32</div>
            </div>
            <div class="chat-items-body">
              <div class="unread-alert">
                <form action="" method="post">
                  <input type="hidden" name="mode" value="read">
                  <input type="hidden" name="messageId" value="<?= $messageId ?>">
                  <input type="image" src="static/icons/png/unread_white.png" alt="">
                </form>
              </div>
            </div>
          </div>
        </div>

<?php
    } else {
    // read
?>
        <div class="chat-items">
          <div class="chat-items-thumb"><img src="static/images/dummy-001.jpg" alt=""></div>
          <div class="chat-items-right">
            <div class="chat-items-top">
              <div class="chat-send-name"><?= $mname ?></div>
              <div class="chat-send-time">2021/07/25 12:32</div>
            </div>
            <div class="chat-items-body">
<?php
if(!empty($subject)){
  echo '<div class="message-subject">'.$subject.'</div>';
  echo '<div class="message-body">'.$body.'</div>';
} else {
  echo '<div class="message-body">'.$body.'</div>';
}
?>
            </div>
          </div>
        </div>
<?php
      }
    }
  }
} else {
  $targetId = '';
}
?>

        <div id="lastPostView"></div>
      </div>

      <div id="bottomUpButton" class="mobile-call-form">
        <img src="static/icons/png/outline_edit_white_24dp.png" alt="">
      </div>
      <div id="postForm" class="post-form bottom-down">
        <form action="">
          <div class="post-form-wrap">
            <div class="post-form-bar">
              <input type="hidden" name="mode" value="send">
              <input type="hidden" name="target" value="<?= $targetId ?>">
              <div class="post-form-bar-items"><input class="send-files" type="file"></div>
              <div class="post-form-bar-items"><button class="send-button">送信</button></div>
            </div>
            <div class="post-form-body">
              <textarea name="" id="" placeholder="メッセージ入力"></textarea>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="right-col">
      <?php include($rootPath.'parts/right-default.php'); ?>
    </div>
  </div>
  <div class="close-mask" style="display: none;"></div>
</div>


<?php $dbh = null; ?>
  
<script src="static/js/bootstrap.js"></script>
<script>
$('[data-btn="leftbtn"]').on('click',
  function () {
    $('.left-col').animate({'marginLeft':'300px'},500);
    $('.close-mask').css({'display':'none'}).fadeIn(500);
  }
);
$('[data-btn="rightbtn"]').on('click',
  function () {
    $('.right-col').animate({'marginRight':'300px'},500);
    $('.close-mask').css({'display':'none'}).fadeIn(500);
  }
);

$('.close-mask').on('click',
  function () {
    $('.left-col').animate({'marginLeft':'0px'},500);
    $('.right-col').animate({'marginRight':'0px'},500);
    $('.close-mask').css({'display':'block'}).fadeOut(500);
  }
);

$(".chat-body").animate({scrollTop:$('#lastPostView').offset().top}, { duration: 1000, easing: 'swing', });

$('#bottomUpButton').on('click',
  function(){
    $('#postForm').toggleClass("bottom-up");
    $('#postForm').toggleClass("bottom-down");
  }
);
</script>

<script>
//if ('serviceWorker' in navigator) {
//  navigator.serviceWorker.register('sw.js').then(function(registration) {
    // 登録成功
//    console.log('ServiceWorker の登録に成功しました。スコープ: ', registration.scope);
//  }).catch(function(err) {
    // 登録失敗
//    console.log('ServiceWorker の登録に失敗しました。', err);
//  });
//}
</script>
</body>
</html>