<div class="jobster-main-items">
  <h2>Tomorrow</h2>
  <div class="jobster-main-table-wrap">
    <table class="jobster-main-table">
      <thead>
        <tr>
          <th colspan="16"><?= date("Y/m/d", strtotime('+1 day')) ?></th>
        </tr>
        <tr>
          <th colspan="2">Time</th>
          <?php
          $timeCount = 9;
          while ($timeCount < 23) { ?>
            <th class="jobster-col-times"><?= $timeCount ?></th>
          <?php $timeCount++;
          } ?>
        </tr>
      </thead>
      <tbody>
        <?php
        $jobster_user_query = $dbh->query("SELECT * FROM `jobster_user_settings` WHERE `view_flag` = '1'");
        while ($jobster_users = $jobster_user_query->fetch(PDO::FETCH_ASSOC)) {
          $TomorrowDay = date("Y-m-d", strtotime('+1 day'));
          $managerId = $jobster_users['manager_id'];
          try {
            $jobster_work_query = $dbh->prepare("SELECT * FROM `jobster_working` WHERE `job_days` = :workday AND `manager_id` = :managerid");
            $jobster_work_query->execute([
              "workday" => $TomorrowDay,
              "managerid" => $managerId
            ]);
            $jobster_working = $jobster_work_query->fetch(PDO::FETCH_ASSOC);
          } catch (Exception $e) {
            echo $e;
          }
          if (isset($jobster_working['start_time'])) {
            $startTime = $jobster_working['start_time'];
          } else {
            $startTime = '';
          }
          if (isset($jobster_working['end_time'])) {
            $endTime = $jobster_working['end_time'];
          } else {
            $endTime = '';
          }

        ?>
          <tr>
            <td>
              <a href="<?= $rootWebPath ?>?target=<?= $jobster_users['manager_id'] ?>">
                <?= $jobster_users['name'] ?>
              </a>
            </td>
            <td class="jobster-col-work-time"><?= $startTime ?>-<?= $endTime ?></td>

            <?php
            $timeCountCheck = 9;
            while ($timeCountCheck < 23) {
            ?>
              <td class="jobster-col-times
    <?php if (!empty($startTime)) {
                if ($startTime >= $timeCountCheck && $startTime < $timeCountCheck + 1) {
                  echo ' jobster-col-working';
                } elseif ($startTime <= $timeCountCheck && $endTime > $timeCountCheck) {
                  echo ' jobster-col-working';
                }
              } ?>
    ">
              </td>
            <?php $timeCountCheck++;
            } ?>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>