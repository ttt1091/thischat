      <div>
        <div>
          <h3 class="side-menu-ttl">Menu</h3>
          <div>
            <?php
            echo $myName.'<br>';
            $ip = $_SERVER["REMOTE_ADDR"];
            $ip = ip2long($ip);
            echo $ip;
            ?>
            <br>

            <?= makeRandStr(13) ?>
          </div>
          <div class="right-items">
            <ul class="right-menu">
              <li><a href="<?= $rootWebPath . '?myid=1' ?>">MasterLogin</a></li>
              <li><a href="<?= $rootWebPath . '?myid=2' ?>">太郎Login</a></li>
              <li><a href="<?= $rootWebPath . '?myid=3' ?>">花子Login</a></li>
              <li><a href="<?= $rootWebPath . 'thechat' ?>">初期設定用</a></li>
              <li><a href="javascript:allowWebPush()">WebPushを許可する</a></li>
              <li><a href="">登録情報変更</a></li>
              <li><a href="">新規ユーザー登録</a></li>
              <li><a href="">即時チャット履歴削除</a></li>
              <li>
                <input type="button" id="push" onclick="return push()" value="Click!!">
              </li>
              <li><a href="<?= $rootWebPath . 'login' ?>">ログインフォームへ</a></li>
              <li><a href="<?= $rootWebPath . 'logout' ?>">ログアウト</a></li>
            </ul>
            <ul class="right-menu-panel">
              <li><a href="jobster/"><img src="<?= $rootWebPath ?>static/images/panels/svg/panels-job.svg" alt=""></a></li>
              <li><a href="<?= $rootWebPath . 'logout' ?>"><img src="<?= $rootWebPath ?>static/images/panels/svg/panels-logout.svg" alt=""></a></li>
              <li><a href=""><img src="<?= $rootWebPath ?>static/images/panels/svg/panels-support.svg" alt=""></a></li>
              <li><a href=""><img src="<?= $rootWebPath ?>static/images/panels/svg/panels-delete.svg" alt=""></a></li>
            </ul>
          </div>

          <div class="right-items">
            <?php include($rootPath . 'parts/right-info.php'); ?>
          </div>

        </div>
      </div>

      
<script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/0.0.11/push.min.js"></script>
<script>
 function push(){
  Push.create("通知", 
   {
    body: "チャットが来たよ",
    icon: 'apple-touch-icon.png',
    timeout: 8000,
    onClick: function () {
      window.focus(); 
      this.close();
      location.href = 'https://ubuntu-2nd/thechat/';
    }
  })
}
</script>