<div class="chat-list">
  <div class="chat-list-ttl">チャットルーム</div>
  <?php
  $manager_que = $dbh->query("SELECT * FROM `managers` WHERE `status` = '1' AND `site_group` = 'site01'");
  while ($managers = $manager_que->fetch(PDO::FETCH_ASSOC)) {
    // UnRead Check
    if ($managers['id'] != $myId) {
      $unread_que = $dbh->prepare("SELECT COUNT(*) AS `unread_count` FROM `messages` WHERE `status` = '1' 
      AND `receive` = :receiveid  
      AND `send` = :sendid 
      AND `opened_dt` LIKE '9999-12-31%'");
      $unread_que->execute([
        "receiveid" => $myId,
        "sendid" => $managers['id']
      ]);
      $unread = $unread_que->fetch(PDO::FETCH_ASSOC);
      if ($unread['unread_count'] == '0') {
        $unread_count = '';
      } else {
        $unread_count = $unread['unread_count'];
      }
    ?>

<div class="chat-list-items"><a href="/thechat/?target=<?= $managers['id']; ?>"><?= $managers['name']; ?><?php if (empty($unread_count)) {
    } else { ?><span class="unread-point"><?= $unread_count ?></span><?php } ?></a></div>

<?php } else {
      $unread_count = '';
    }
  ?>
  <?php } ?>
</div>