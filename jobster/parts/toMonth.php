<?php
$manager_count = $dbh->query("SELECT COUNT(`id`) AS `mcount` FROM `jobster_user_settings` WHERE `view_flag` = 1");
$mcount = $manager_count->fetch(PDO::FETCH_ASSOC);
?>
<div class="jobster-main-items">
  <h2>toMonth</h2>
  <div class="jobster-main-table-wrap">
    <table class="jobster-main-table monthy-table">
      <thead>
        <tr>
          <th colspan="<?= $mcount['mcount']+2 ?>"><?= date("Y年m月") ?></th>
        </tr>
        <tr>
          <th class="jobster-to-month-th-min">Day</th>
          <th class="jobster-to-month-th-min">SUM</th>
<?php
  $jobster_user_query = $dbh->query("SELECT * FROM `jobster_user_settings` WHERE `view_flag` = 1 ORDER BY id ASC");
  while ($jobster_users = $jobster_user_query->fetch(PDO::FETCH_ASSOC)) {
?>
          <th class="monthy-table-cell-name"><?= $jobster_users['name'] ?></th>
<?php
  }
?>
        </tr>
      </thead>
      <tbody>
<?php
$thisYear = strval(date('Y'));
$thisMonth = strval(date('m'));

if($thisYear=='2024'||$thisYear=='2028'||$thisYear=='2032'||$thisYear=='2036'||$thisYear=='2040'||$thisYear=='2044'||$thisYear=='2048'||$thisYear=='2052'){
  if($thisMonth=='2'){ $lastDay=29; }
  elseif($thisMonth=='4'||$thisMonth=='6'||$thisMonth=='9'||$thisMonth=='11'){ $lastDay=30; }
  else{ $lastDay=31; }
} else {
  if($thisMonth=='2'){ $lastDay=28; }
  elseif($thisMonth=='4'||$thisMonth=='6'||$thisMonth=='9'||$thisMonth=='11'){ $lastDay=30; }
  else{ $lastDay=31; }
}

for ($monthDay = 1; $monthDay <= $lastDay; $monthDay++) {
$monthDayDB = strval(sprintf('%02d', $monthDay));
$monthDays = $thisYear.'-'.$thisMonth.'-'.$monthDayDB;
$working_count = $dbh->query("SELECT COUNT(`id`) AS `wcount` FROM `jobster_working` WHERE `job_days` = '$monthDays' AND `working` != 0");
$wcount = $working_count->fetch(PDO::FETCH_ASSOC);

$working_people = $dbh->query("SELECT * FROM `jobster_user_settings` WHERE `view_flag` = '1'");
$mid = [];
while ($push_mid = $working_people->fetch(PDO::FETCH_ASSOC)){
  array_push($mid, $push_mid['manager_id']);
}
?>
        <tr>
          <td><?= $monthDay.'日' ?></td>
          <td class="text-center"><?= $wcount['wcount'].'人' ?></td>
<?php
  foreach($mid as $mid_val){
    try {
      $go_work = $dbh->query("SELECT * FROM `jobster_working` WHERE `job_days` = '$monthDays' AND `manager_id` = '$mid_val'");
      $working = $go_work->fetch(PDO::FETCH_ASSOC);
      $working_flag = 1;
    } catch (Exception  $e) {
      $working_flag = 0;
    }
?>
          <td class="text-center<?php if(isset($working['working'])){ if($working['working']==2){ echo ' bg-tamago'; }elseif($working['working']==='0'){ echo ' bg-wasurenagusa'; } } ?>">
<?php
  if(!empty($working['start_time'])){
    $start_time = $working['start_time'];
    $end_time = $working['end_time'];
    if(empty($working['certification'])){
      echo '<span class="no-certification">'.$start_time.'-'.$end_time.'</span>';
    } else {
      echo $start_time.'-'.$end_time;
    }
  } else {
  }
?>
          </td>
<?php } ?>
        </tr>
<?php } ?>
      </tbody>
    </table>
  </div>
</div>