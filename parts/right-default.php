      <div>
        <div>
          <h3>sidemenu</h3>
          <div>
            <?php
            $ip = $_SERVER["REMOTE_ADDR"];
            $ip = ip2long($ip);
            echo $ip;
            ?>
            <br>

            <?= makeRandStr(13) ?>
          </div>
          <div class="right-items">
            <ul class="right-menu">
              <li><a href="<?= $rootWebPath . 'thechat' ?>">初期設定用</a></li>
              <li><a href="">登録情報変更</a></li>
              <li><a href="">新規ユーザー登録</a></li>
              <li><a href="">即時チャット履歴削除</a></li>
            </ul>
          </div>

          <div class="right-items">
            <?php include($rootPath . 'parts/right-info.php'); ?>
          </div>

        </div>
      </div>