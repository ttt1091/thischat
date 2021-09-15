<div class="chat-ttl">チャットルーム</div>
<div class="chat-body">

  <?php
  if (isset($_GET['target'])) {
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
    while ($messages = $select_message_mng->fetch(PDO::FETCH_ASSOC)) {
      if (isset($messages['subject'])) {
        $subject = $messages['subject'];
      } else {
        $subject = '';
      }
      $send = $messages['send'];
      $body = nl2br($messages['body']);
      $openTime = $messages['opened_dt'];
      $messageId = $messages['id'];
      if (!empty($messages['files'])) {
        $upfile = $messages['files'];
      } else {
        $upfile = '';
      }
      if ($send == $myId) {
        // Send Message
  ?>

        <div id="message<?= $messageId ?>" class="chat-items">
          <div class="chat-items-right send-message">
            <div class="chat-items-top">
              <div class="chat-send-name"><?= $myName ?></div>
              <div class="chat-send-time">2021/07/25 12:32</div>
            </div>
            <div class="chat-items-body">
              <?php
              if (!empty($subject)) {
                echo '<div class="message-subject">' . $subject . '</div>';
                if (empty($upfile)) {
                  echo '<div class="message-body">' . $body . '</div>';
                } else {
                  $image_list = ["png", "jpeg", "jpg", "gif"];
                  str_replace($image_list, "", $upfile, $image_count);
                  if ($image_count !== 0) {
                    echo '<div class="message-body">' . '<div class="message-file"><a href="upload/' . $upfile . '" target="_blank"><img src="upload/' . $upfile . '"></a></div>' . $body . '</div>';
                  } else {
                    echo '<div class="message-body">' . '<div class="message-file"><span>' . $upfile . '</span></span><a href="upload/' . $upfile . '" target="_blank">ダウンロード</a></div>' . $body . '</div>';
                  }
                }
              } else {
                if (empty($upfile)) {
                  echo '<div class="message-body">' . $body . '</div>';
                } else {
                  $image_list = ["png", "jpeg", "jpg", "gif"];
                  str_replace($image_list, "", $upfile, $image_count);
                  if ($image_count !== 0) {
                    echo '<div class="message-body">' . '<div class="message-file"><a href="upload/' . $upfile . '" target="_blank"><img src="upload/' . $upfile . '"></a></div>' . $body . '</div>';
                  } else {
                    echo '<div class="message-body">' . '<div class="message-file"><span>' . $upfile . '</span></span><a href="upload/' . $upfile . '" target="_blank">ダウンロード</a></div>' . $body . '</div>';
                  }
                }
              }
              ?>
            </div>
          </div>
          <div class="chat-items-thumb"><img src="static/images/dummy-001.jpg" alt=""></div>
        </div>

        <?php
      } else {
        // Receive Message
        if ($openTime == '1900-01-01 00:00:00') {
          // unread
        ?>
          <div id="message<?= $messageId ?>" class="chat-items">
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
          <div id="message<?= $messageId ?>" class="chat-items">
            <div class="chat-items-thumb"><img src="static/images/dummy-001.jpg" alt=""></div>
            <div class="chat-items-right">
              <div class="chat-items-top">
                <div class="chat-send-name"><?= $mname ?></div>
                <div class="chat-send-time">2021/07/25 12:32</div>
              </div>
              <div class="chat-items-body">
                <?php
                if (!empty($subject)) {
                  echo '<div class="message-subject">' . $subject . '</div>';
                  if (empty($upfile)) {
                    echo '<div class="message-body">' . $body . '</div>';
                  } else {
                    $image_list = ["png", "jpeg", "jpg", "gif"];
                    str_replace($image_list, "", $upfile, $image_count);
                    if ($image_count !== 0) {
                      echo '<div class="message-body">' . '<div class="message-file"><a href="upload/' . $upfile . '" target="_blank"><img src="upload/' . $upfile . '"></a></div>' . $body . '</div>';
                    } else {
                      echo '<div class="message-body">' . '<div class="message-file"><span>' . $upfile . '</span></span><a href="upload/' . $upfile . '" target="_blank">ダウンロード</a></div>' . $body . '</div>';
                    }
                  }
                } else {
                  if (empty($upfile)) {
                    echo '<div class="message-body">' . $body . '</div>';
                  } else {
                    $image_list = ["png", "jpeg", "jpg", "gif"];
                    str_replace($image_list, "", $upfile, $image_count);
                    if ($image_count !== 0) {
                      echo '<div class="message-body">' . '<div class="message-file"><a href="upload/' . $upfile . '" target="_blank"><img src="upload/' . $upfile . '"></a></div>' . $body . '</div>';
                    } else {
                      echo '<div class="message-body">' . '<div class="message-file"><span>' . $upfile . '</span></span><a href="upload/' . $upfile . '" target="_blank">ダウンロード</a></div>' . $body . '</div>';
                    }
                  }
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

<?php if (isset($_GET['target'])) { ?>
  <?php include($rootPath . 'parts/chat-post-form.php'); ?>
<?php } ?>