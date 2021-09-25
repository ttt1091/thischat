<script>
<?php
$loop_manager = $dbh->prepare("SELECT * FROM `managers` WHERE `id` != :myid AND `status` = '1'");
$loop_manager->execute([
  'myid' => $myId
]);
while ($lmv = $loop_manager->fetch(PDO::FETCH_ASSOC)) {
  echo 'console.log('.$lmv['id'].');';
  $lmvArr[] = $lmv['id'];
}
foreach ($lmvArr AS $lmvs) {
  echo 'console.log("lmvs" + '.$lmvs.');';
}
?>

function setLocal(){
<?php
  foreach ($lmvArr AS $lmvs) {
?>
  $.ajax({
    url: '/thechat/json/messages/users/<?= $myId ?>/message-<?= $lmvs ?>.json?rand=<?= rand() ?>',
    dataType: 'json',
    data: {
      name: ''
    },
    success: function(data) {
      var datalist = data;
      localStorage.setItem("messageListTo<?= $lmvs ?>", JSON.stringify(datalist));
    }
  });
<?php
  }
?>
}

function getAPImessages(){
<?php
  foreach ($lmvArr AS $lmvs) {
?>
  diff = new $.Deferred();
  $.ajax({
    url: '/thechat/json/messages/users/<?= $myId ?>/message-<?= $lmvs ?>.json',
    dataType: 'json',
    data: {
      name: ''
    },
    success: function(data) {
      let gam = data;
      localStorage.setItem("messageListTo<?= $lmvs ?>Diff", JSON.stringify(gam));
      diff.resolve();
    }
  });
<?php
  }
?>
}

// const getMessages = () => {
d = new $.Deferred();
function getMessages(){

<?php if(isset($_GET['target'])){ ?>

  $(function() {
    $(".chat-body").html('');
    $.ajax({
      url: '/thechat/json/messages/users/<?= $myId ?>/message-<?= $targetId ?>.json',
      dataType: 'json',
      data: {
        name: ''
      },
      success: function(data) {
        var dataArray = data;
        $.each(dataArray, function(i) {
          let myid = "<?= $myId ?>";
          let send = "<?= $send ?>";
          let imagefiles = /jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF/;
          let body = dataArray[i].body.replace( /\r?\n/g, '<br>' );
          if (dataArray[i].send == myid) {
            // SendMessage
            if (dataArray[i].files) {
              if (imagefiles.test(dataArray[i].files)) {
                $(".chat-body").append(
                  '<div id="message' + dataArray[i].mail_id + '" class="chat-items">' +
                  '<div class="chat-items-right send-message">' +
                  '<div class="chat-items-top">' +
                  '<div class="chat-send-name">' + dataArray[i].sendname + '</div>' +
                  '<div class="chat-send-time">' + dataArray[i].sended_dt + '</div>' +
                  '</div>' +
                  '<div class="chat-items-body">' +
                  '<div class="message-body"><div class="message-file"><a href="upload/' + dataArray[i].files + '" target="_blank"><img src="upload/' + dataArray[i].files + '"></a></div>' + body + '</div>' +
                  '</div>' +
                  '</div>' +
                  '<div class="chat-items-thumb"><img src="static/images/dummy-001.jpg" alt=""></div>' +
                  '</div>'
                );
              } else {
                $(".chat-body").append(
                  '<div id="message' + dataArray[i].mail_id + '" class="chat-items">' +
                  '<div class="chat-items-right send-message">' +
                  '<div class="chat-items-top">' +
                  '<div class="chat-send-name">' + dataArray[i].sendname + '</div>' +
                  '<div class="chat-send-time">' + dataArray[i].sended_dt + '</div>' +
                  '</div>' +
                  '<div class="chat-items-body">' +
                  '<div class="message-body"><div class="message-file"><span>' + dataArray[i].files + '</span></span><a href="upload/' + dataArray[i].files + '" target="_blank">ダウンロード</a></div>' + body + '</div>' +
                  '</div>' +
                  '</div>' +
                  '<div class="chat-items-thumb"><img src="static/images/dummy-001.jpg" alt=""></div>' +
                  '</div>'
                );
              }
            } else {
              $(".chat-body").append(
                '<div id="message' + dataArray[i].mail_id + '" class="chat-items">' +
                '<div class="chat-items-right send-message">' +
                '<div class="chat-items-top">' +
                '<div class="chat-send-name">' + dataArray[i].sendname + '</div>' +
                '<div class="chat-send-time">' + dataArray[i].sended_dt + '</div>' +
                '</div>' +
                '<div class="chat-items-body">' +
                '<div class="message-body">' + body + '</div>' +
                '</div>' +
                '</div>' +
                '<div class="chat-items-thumb"><img src="static/images/dummy-001.jpg" alt=""></div>' +
                '</div>'
              );
            }
          } else {
            // ReceiveMessage
            if (dataArray[i].opened_dt == '9999-12-31 23:59:59') {
              //未開封
              $(".chat-body").append(
                '<div id="message' + dataArray[i].mail_id + '" class="chat-items">' +
                '<div class="chat-items-thumb"><img src="static/images/dummy-001.jpg" alt=""></div>' +
                '<div class="chat-items-right unread-mail">' +
                '<div class="chat-items-top">' +
                '<div class="chat-send-name">' + dataArray[i].sendname + '</div>' +
                '<div class="chat-send-time">' + dataArray[i].sended_dt + '</div>' +
                '</div>' +
                '<div class="chat-items-body">' +
                '<div class="unread-alert">' +
                '<form action="" method="post">' +
                '<input type="hidden" name="mode" value="read">' +
                '<input type="hidden" name="messageId" value="' + dataArray[i].mail_id + '">' +
                '<input type="image" src="static/icons/png/unread_white.png" alt="">' +
                '</form>' +
                '</div>' +
                '</div>' +
                '</div>'
              );
            } else {
              //開封済み
              if (dataArray[i].files) {
                if (imagefiles.test(dataArray[i].files)) {
                  $(".chat-body").append(
                    '<div id="message' + dataArray[i].mail_id + '" class="chat-items">' +
                    '<div class="chat-items-thumb"><img src="static/images/dummy-001.jpg" alt=""></div>' +
                    '<div class="chat-items-right">' +
                    '<div class="chat-items-top">' +
                    '<div class="chat-send-name">' + dataArray[i].sendname + '</div>' +
                    '<div class="chat-send-time">' + dataArray[i].sended_dt + '</div>' +
                    '</div>' +
                    '<div class="chat-items-body">' +
                    '<div class="message-body"><div class="message-file"><a href="upload/' + dataArray[i].files + '" target="_blank"><img src="upload/' + dataArray[i].files + '"></a></div>' + body + '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>'
                  );
                } else {
                  $(".chat-body").append(
                    '<div id="message' + dataArray[i].mail_id + '" class="chat-items">' +
                    '<div class="chat-items-thumb"><img src="static/images/dummy-001.jpg" alt=""></div>' +
                    '<div class="chat-items-right">' +
                    '<div class="chat-items-top">' +
                    '<div class="chat-send-name">' + dataArray[i].sendname + '</div>' +
                    '<div class="chat-send-time">' + dataArray[i].sended_dt + '</div>' +
                    '</div>' +
                    '<div class="chat-items-body">' +
                    '<div class="message-body"><div class="message-file"><span>' + dataArray[i].files + '</span></span><a href="upload/' + dataArray[i].files + '" target="_blank">ダウンロード</a></div>' + body + '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>'
                  );
                }
              } else {
                $(".chat-body").append(
                  '<div id="message' + dataArray[i].mail_id + '" class="chat-items">' +
                  '<div class="chat-items-thumb"><img src="static/images/dummy-001.jpg" alt=""></div>' +
                  '<div class="chat-items-right">' +
                  '<div class="chat-items-top">' +
                  '<div class="chat-send-name">' + dataArray[i].sendname + '</div>' +
                  '<div class="chat-send-time">' + dataArray[i].sended_dt + '</div>' +
                  '</div>' +
                  '<div class="chat-items-body">' +
                  '<div class="message-body">' + body + '</div>' +
                  '</div>' +
                  '</div>' +
                  '</div>'
                );
              }
            }
          }
        });
        d.resolve();
        
  d.promise()
  .then(function() {
        $(".chat-body").append('<div id="lastPostView"></div>');
  });
      if($('.chat-body').scrollTop()=='0'){
        $('.chat-body').scrollTop(99999);
      }
      }
    });
  });

<?php } ?>

}
// }

$(function(){
  getMessages();
  setLocal();
  getAPImessages();
});
function diffMessage() {
  getAPImessages();
  diff.promise()
  .then(function() {
<?php
  foreach ($lmvArr AS $lmvs) {
?>
    let getLocalMessageJson<?= $lmvs ?> = localStorage.getItem("messageListTo<?= $lmvs ?>");
    let getLocalMessageJsonDiff<?= $lmvs ?> = localStorage.getItem("messageListTo<?= $lmvs ?>Diff");
    
    let getL<?= $lmvs ?> = JSON.parse(getLocalMessageJson<?= $lmvs ?>);
    let getLD<?= $lmvs ?> = JSON.parse(getLocalMessageJsonDiff<?= $lmvs ?>);

    if(getL<?= $lmvs ?>.length==getLD<?= $lmvs ?>.length){
      // console.log('同じ');
      // console.log($('.chat-body').scrollTop());
    } else {
      console.log('違う');
      console.log('getLocalMessageJson<?= $lmvs ?> : '+getL<?= $lmvs ?>.length);
      console.log('getLocalMessageJsonDiff<?= $lmvs ?> : '+getLD<?= $lmvs ?>.length);
      setLocal();
      getMessages();
      push();
      // alert('新着メッセージあり');
      if($('.chat-body').scrollTop()=='0'){
        console.log($('.chat-body').scrollTop());
        $('.chat-body').scrollTop(99999);
      }
    }
<?php
  }
?>
  });
}

setInterval(diffMessage, 3000);

</script>