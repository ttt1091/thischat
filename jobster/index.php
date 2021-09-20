<?php include('/var/www/html/thechat/variable.php'); ?>
<?php include('/var/www/html/thechat/setting/pdo.php'); ?>

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
    </div><!-- //left-col-END -->

    <div class="col-md message-col">

<style>
.jobster-main-items{
  margin: 8px;
}
.jobster-main-table-wrap{
  width: 100%;
  overflow: auto;
}
.jobster-main-table{
  min-width: 503px;
  width: 100%;
  max-width: 635px;
  font-size: .8rem;
}
.jobster-main-table th, .jobster-main-table td{
  border: solid 1px #444;
  padding: 4px;
  background-color: #FFF;
}
.jobster-col-times{
  text-align: center;
  width: 32px;
}
.jobster-col-working{
  background-color: #E16B8C!important;
}
.jobster-col-work-time{
  text-align: center;
  width: 60px;
}
</style>
<div style="background-image: url('<?= $rootWebPath ?>static/images/login/background.png');height: 100vh;">
  <div class="jobster-main-items">
    <div class="jobster-main-table-wrap">
      <table class="jobster-main-table">
        <thead>
          <tr>
            <th colspan="16">2021/09/20</th>
          </tr>
          <tr>
            <th colspan="2">Time</th>
<?php
$timeCount = 9;
while ($timeCount < 23){ ?>
            <th class="jobster-col-times"><?= $timeCount ?></th>
<?php $timeCount++; } ?>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>AAA</td>
            <td class="jobster-col-work-time">9-21</td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times"></td>
            <td class="jobster-col-times"></td>
          </tr>
          <tr>
            <td>BBB</td>
            <td class="jobster-col-work-time">10-22</td>
            <td class="jobster-col-times"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times"></td>
          </tr>
          <tr>
            <td>CCC</td>
            <td class="jobster-col-work-time">9-18</td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times jobster-col-working"></td>
            <td class="jobster-col-times"></td>
            <td class="jobster-col-times"></td>
            <td class="jobster-col-times"></td>
            <td class="jobster-col-times"></td>
            <td class="jobster-col-times"></td>
          </tr>
          <tr>
            <td>DDD</td>
            <td class="jobster-col-work-time"></td>
            <td class="jobster-col-times"></td>
            <td class="jobster-col-times"></td>
            <td class="jobster-col-times"></td>
            <td class="jobster-col-times"></td>
            <td class="jobster-col-times"></td>
            <td class="jobster-col-times"></td>
            <td class="jobster-col-times"></td>
            <td class="jobster-col-times"></td>
            <td class="jobster-col-times"></td>
            <td class="jobster-col-times"></td>
            <td class="jobster-col-times"></td>
            <td class="jobster-col-times"></td>
            <td class="jobster-col-times"></td>
            <td class="jobster-col-times"></td>
          </tr>
        </tbody>
      </table>
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