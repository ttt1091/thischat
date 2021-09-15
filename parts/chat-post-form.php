<div id="bottomUpButton" class="mobile-call-form">
  <img src="static/icons/png/outline_edit_white_24dp.png" alt="">
</div>
<div id="postForm" class="post-form bottom-down">
  <form action="" method="POST" enctype="multipart/form-data">
    <div class="post-form-wrap">
      <div class="post-form-bar">
        <input type="hidden" name="mode" value="send">
        <input type="hidden" name="target" value="<?= $targetId ?>">
        <div class="post-form-bar-items"><input class="send-files" name="messageFile" type="file"></div>
        <div class="post-form-bar-items"><button class="send-button">送信</button></div>
      </div>
      <div class="post-form-body">
        <textarea name="messageBody" id="" placeholder="メッセージ入力"></textarea>
      </div>
    </div>
  </form>
</div>