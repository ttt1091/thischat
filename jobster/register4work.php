<?php include('/var/www/html/thechat/variable.php'); ?>
<?php include('/var/www/html/thechat/setting/pdo.php'); ?>

<?php

ini_set( 'display_errors', 1 );
//////////////////////////////////////////
//  JobSterSettings
//////////////////////////////////////////
$calendar_now = date('Ym');
$calendar_year = intval(date('Y'));
$calendar_month = intval(date('m'));

$calendar_settings = date('w', strtotime($calendar_now.'01'));

$lastday = date( 't' , strtotime($calendar_year . "/" . $calendar_month . "/01"));

$calendar_resources = $calendar_settings + $lastday;

if($calendar_resources==28){
  $calendar_weekly = 4;
} elseif($calendar_resources<=35) {
  $calendar_weekly = 5;
} else {
  $calendar_weekly = 6;
}

echo $calendar_weekly;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<?php include($rootPath.'parts/head.php'); ?>
<link rel="apple-touch-icon" href="static/favicon/apple-touch-icon.png">
<meta name="apple-mobile-web-app-title" content="theChat">
</head>
<body style="padding-top:56px;">

<?php include($rootPath.'parts/topnav.php'); ?>




<div class="container-fluid">
  <div class="row" style="flex-wrap: nowrap!important;">
    <div class="left-col">
      <?php include($rootPath.'jobster/parts/left-menu.php'); ?>
    </div><!-- //left-col-END -->

    <div class="col-md message-col" style="overflow-x: hidden;">

<div class="jobster-wrap">

<div>
  <h2>シフト登録</h2>
  <div class="jobster-work-register">
    <div class="jobster-work-register-this">
      <div class="jobster-work-register-calendar-wrap">
        <div>2021/09</div>
        <div>
<?php for ($calendar_weekly_count = 1; $calendar_weekly_count <= $calendar_weekly; $calendar_weekly_count++){ ?>
  <?= $calendar_weekly_count ?>
<?php } ?>
          <div class="jobster-work-register-calendar-weekly">
            <dl class="background-disable">
              <dt>29日</dt>
              <dd class="official-message"></dd>
              <dd></dd>
            </dl>
            <dl class="background-disable">
              <dt>30日</dt>
              <dd class="official-message"></dd>
              <dd></dd>
            </dl>
            <dl class="background-disable">
              <dt>31日</dt>
              <dd class="official-message"></dd>
              <dd></dd>
            </dl>
            <dl>
              <dt>1日</dt>
              <dd class="official-message"></dd>
              <dd>
                <div>
                  <div>
                    <label for="">
                      <input type="checkbox" name="" id="">
                      Default
                    </label>
                  </div>
                  <div>
                    <select name="" id="">
<?php for ($count = 9; $count < 23; $count++){ ?>
                      <option value="<?= $count ?>"><?= $count ?></option>
<?php } ?>
                    </select>
                    <select name="" id="">
<?php for ($count = 9; $count < 23; $count++){ ?>
                      <option value="<?= $count ?>"><?= $count ?></option>
<?php } ?>
                    </select>
                  </div>
                </div>
              </dd>
            </dl>
            <dl>
              <dt>2日</dt>
              <dd class="official-message"></dd>
              <dd>
                <div>
                  <div>
                    <label for="">
                      <input type="checkbox" name="" id="">
                      Default
                    </label>
                  </div>
                  <div>
                    <select name="" id="">
<?php for ($count = 9; $count < 23; $count++){ ?>
                      <option value="<?= $count ?>"><?= $count ?></option>
<?php } ?>
                    </select>
                    <select name="" id="">
<?php for ($count = 9; $count < 23; $count++){ ?>
                      <option value="<?= $count ?>"><?= $count ?></option>
<?php } ?>
                    </select>
                  </div>
                </div>
              </dd>
            </dl>
            <dl>
              <dt>3日</dt>
              <dd class="official-message"></dd>
              <dd>
                <div>
                  <div>
                    <label for="">
                      <input type="checkbox" name="" id="">
                      Default
                    </label>
                  </div>
                  <div>
                    <select name="" id="">
<?php for ($count = 9; $count < 23; $count++){ ?>
                      <option value="<?= $count ?>"><?= $count ?></option>
<?php } ?>
                    </select>
                    <select name="" id="">
<?php for ($count = 9; $count < 23; $count++){ ?>
                      <option value="<?= $count ?>"><?= $count ?></option>
<?php } ?>
                    </select>
                  </div>
                </div>
              </dd>
            </dl>
            <dl>
              <dt>4日</dt>
              <dd class="official-message"></dd>
              <dd>
                <div>
                  <div>
                    <label for="">
                      <input type="checkbox" name="" id="">
                      Default
                    </label>
                  </div>
                  <div>
                    <select name="" id="">
<?php for ($count = 9; $count < 23; $count++){ ?>
                      <option value="<?= $count ?>"><?= $count ?></option>
<?php } ?>
                    </select>
                    <select name="" id="">
<?php for ($count = 9; $count < 23; $count++){ ?>
                      <option value="<?= $count ?>"><?= $count ?></option>
<?php } ?>
                    </select>
                  </div>
                </div>
              </dd>
            </dl>
          </div>

        </div>
      </div>
    </div>
    <div class="jobster-work-register-next">
      <div class="jobster-work-register-calendar-wrap">
        <div>2021/10</div>
        <div></div>
      </div>
    </div>
  </div>
</div>

</div>

    </div><!-- //message-col-END -->

    <div class="right-col">
      <?php include($rootPath.'parts/right-default.php'); ?>
    </div><!-- //right-col-END -->
  </div><!-- //row-END -->

  <div class="close-mask" style="display: none;"></div>

</div><!-- //container-END -->


<?php $dbh = null; ?>
  

<?php include($rootPath.'parts/service-worker.php'); ?>
<?php include($rootPath.'parts/bottom-js.php'); ?>

</body>
</html>