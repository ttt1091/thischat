<script>
  // const getMessages = () => {

  var d = new $.Deferred();
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
                  '<div class="message-body"><div class="message-file"><a href="upload/' + dataArray[i].files + '" target="_blank"><img src="upload/' + dataArray[i].files + '"></a></div>' + dataArray[i].body + '</div>' +
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
                  '<div class="message-body"><div class="message-file"><span>' + dataArray[i].files + '</span></span><a href="upload/' + dataArray[i].files + '" target="_blank">ダウンロード</a></div>' + dataArray[i].body + '</div>' +
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
                '<div class="message-body">' + dataArray[i].body + '</div>' +
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
                    '<div class="message-body"><div class="message-file"><a href="upload/' + dataArray[i].files + '" target="_blank"><img src="upload/' + dataArray[i].files + '"></a></div>' + dataArray[i].body + '</div>' +
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
                    '<div class="message-body"><div class="message-file"><span>' + dataArray[i].files + '</span></span><a href="upload/' + dataArray[i].files + '" target="_blank">ダウンロード</a></div>' + dataArray[i].body + '</div>' +
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
                  '<div class="message-body">' + dataArray[i].body + '</div>' +
                  '</div>' +
                  '</div>' +
                  '</div>'
                );
              }
            }
          }
        });
        d.resolve();
      }
    });
  });
  // }

  //setInterval(getMessages, 5000);
</script>