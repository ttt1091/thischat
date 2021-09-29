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
$view_day = 1;
$myId = intval($_COOKIE['theChatYouID']);
$select_job_user = $dbh->prepare("SELECT * FROM `jobster_user_settings` WHERE `manager_id` = :mid");
$select_job_user->execute([
  ':mid' => $myId
]);

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
<?php for($calendar_weekly_count = 1; $calendar_weekly_count <= $calendar_weekly; $calendar_weekly_count++){ ?>
          <div class="jobster-work-register-calendar-weekly">
  <?php for($colender_weekly_in_days_count=1;$colender_weekly_in_days_count<=7;$colender_weekly_in_days_count++){ ?>
    <?php if($calendar_weekly_count==1){
      if($colender_weekly_in_days_count<($calendar_settings+1)){ $day_disable = 'background-disable';$day_view_flag = 0; }
      elseif($colender_weekly_in_days_count==1) { $day_disable = 'background-sunday';$day_view_flag = 1; }
      elseif($colender_weekly_in_days_count==7) { $day_disable = 'background-saturday';$day_view_flag = 1; }
      else { $day_disable = '';$day_view_flag = 1; }
    ?>
            <dl class="<?= $day_disable ?>">
              <dt>
                <?php if(($calendar_settings+1)<=$colender_weekly_in_days_count){ echo $view_day;$view_day++; } else { echo '　'; } ?>
              </dt>
              <dd class="official-message"></dd>
              <dd>
<?php if($day_view_flag==1){ ?>
                <div>
                  <div>
                    <label for="">
                      <input type="checkbox" name="" id="">
                      Default
                    </label>
                  </div>
                  <div>
                    <select name="" id="">
                      <option value="null">-</option>
<?php for ($count_start = 9; $count_start < 23; $count_start++){ ?>
                      <option value="<?= $count_start ?>"><?= $count_start ?></option>
<?php } ?>
                    </select>
                    <select name="" id="">
                      <option value="null">-</option>
<?php for ($count_end = 9; $count_end < 23; $count_end++){ ?>
                      <option value="<?= $count_end ?>"><?= $count_end ?></option>
<?php } ?>
                    </select>
                  </div>
                </div>
<?php } ?>
              </dd>
            </dl>
    <?php } else {
      if($colender_weekly_in_days_count==1) { $day_disable = 'background-sunday';$day_view_flag = 1; }
      elseif($colender_weekly_in_days_count==7) { $day_disable = 'background-saturday';$day_view_flag = 1; }
      else { $day_disable = ''; }
    ?>
            <dl class="<?= $day_disable ?>">
              <dt>
                <?php echo $view_day;$view_day++; ?>
              </dt>
              <dd class="official-message"></dd>
              <dd>
<?php if($day_view_flag==1){ ?>
                <div>
                  <div>
                    <label for="">
                      <input type="checkbox" name="" id="">
                      Default
                    </label>
                  </div>
                  <div>
                    <select name="" id="">
                      <option value="null">-</option>
<?php for ($count = 9; $count < 23; $count++){ ?>
                      <option value="<?= $count ?>"><?= $count ?></option>
<?php } ?>
                    </select>
                    <select name="" id="">
                      <option value="null">-</option>
<?php for ($count = 9; $count < 23; $count++){ ?>
                      <option value="<?= $count ?>"><?= $count ?></option>
<?php } ?>
                    </select>
                  </div>
                </div>
<?php } ?>
              </dd>
            </dl>
    <?php } ?>
  <?php } ?>
          </div>
<?php } ?>

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