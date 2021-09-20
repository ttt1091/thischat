<?php include('/var/www/html/thechat/variable.php'); ?>
<?php include('/var/www/html/thechat/setting/pdo.php'); ?>
<?php
ini_set('display_errors', "On");

if(isset($_POST['register'])){
  if(!empty($_POST['username'])){ $userName = h($_POST['username']);$check=1; } else { header('Location: /thechat/thechat?errors=1'); }
  if($check===1){
    if(!empty($_POST['userid'])){ $userId= h($_POST['userid']);$check=2; } else { header('Location: /thechat/thechat?errors=2'); }
  }
  if($check===2){
    if(!empty($_POST['userpass'])){ $userPass = h($_POST['userpass']);$check=3; } else { header('Location: /thechat/thechat?errors=3'); }
  }

  if($check===3){
    
    $now = date('Y-m-d H:i:s');
    $now2 = date('Y-m-d H:i:s');
    $ip = $_SERVER["REMOTE_ADDR"];
    $ip = ip2long($ip);
    $userName = h($_POST['username']);
    $userId= h($_POST['userid']);
    $userPass = h($_POST['userpass']);

    try {
      $user_create = $dbh->prepare("INSERT INTO `managers`(login,name,password,site_group,sex,user_rank,status,ip2long,online,user_key,lasted_dt,created_dt) VALUES (:logins,:names,:pass,:groups,:sex,:ranks,:statused,:ip2long,:onlines,:userkey,:lasted,:created)");
      $group = 'site01';
      $sex = 'male';
      $rank = 1;
      $status = 1;
      $online = makeRandStr(13);
      $user_key = makeRandStr(13);
      $dbh->beginTransaction();

      $user_create->bindParam( ':logins', $userId, PDO::PARAM_STR);
      $user_create->bindParam( ':names', $userName, PDO::PARAM_STR);
      $user_create->bindParam( ':pass', $userPass, PDO::PARAM_STR);
      $user_create->bindParam( ':groups', $group, PDO::PARAM_STR);
      $user_create->bindParam( ':sex', $sex, PDO::PARAM_STR);
      $user_create->bindParam( ':ranks', $rank, PDO::PARAM_INT);
      $user_create->bindParam( ':statused', $status, PDO::PARAM_INT);
      $user_create->bindParam( ':ip2long', $ip, PDO::PARAM_STR);
      $user_create->bindParam( ':onlines', $online, PDO::PARAM_STR);
      $user_create->bindParam( ':userkey', $user_key, PDO::PARAM_STR);
      $user_create->bindParam( ':lasted', $now, PDO::PARAM_STR);
      $user_create->bindParam( ':created', $now, PDO::PARAM_STR);
      $user_create->execute();
      $dbh->commit();


      $loginSet = $dbh->prepare("SELECT * FROM `managers` WHERE `login` = :loginid AND `password` = :loginpass");
      $loginSet->execute(
        [
          ':loginid' => $userId,
          ':loginpass' => $userPass,
        ]
      );
      $loginSets = $loginSet->fetch(PDO::FETCH_ASSOC);

      
      $jobster_create = $dbh->prepare("INSERT INTO `jobster_user_settings`(
        manager_id,name,user_mode,view_flag
      ) VALUES (
        :managerid,:name,:usermode,:viewflag
      )");
      $dbh->beginTransaction();
      
      $parame_one = 1;
      $jobster_create->bindParam( ':managerid', $loginSets['id'], PDO::PARAM_INT);
      $jobster_create->bindParam( ':name', $loginSets['name'], PDO::PARAM_STR);
      $jobster_create->bindParam( ':usermode', $parame_one, PDO::PARAM_INT);
      $jobster_create->bindParam( ':viewflag', $parame_one, PDO::PARAM_INT);
      $jobster_create->execute();
      $dbh->commit();
      
      setcookie('theChatYouID', $loginSets['id'], time()+43200);
      setcookie('key', $loginSets['user_key'], time()+43200);

      $dbh=null;

      header('Location: /thechat/');
    } catch (Exception $e) {
      echo $e;
    } 
  }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat</title>
  <link rel="apple-touch-icon" sizes="180x180" href="static/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="static/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="static/favicon/favicon-16x16.png">
  <link rel="mask-icon" href="static/favicon/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#2b5797">
  <meta name="theme-color" content="#ffffff">
  <link href="static/css/bootstrap.min.css" rel="stylesheet">
  
</head>
<body style="padding-top:4.5rem;">

<?php include($rootPath.'parts/topnav.php'); ?>


<div class="container">
  <div class="row">
    <div class="col-sm">
      <div class="card">
        <div class="card-header">
          初期設定ページ
        </div>
        <div class="card-body">
          <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Hello!!</h4>
            <p>
              このページは初めてアクセスした時に表示されます。<br>
              まずは下記の設定項目を入力の上、管理者アカウントを作成してください。
            </p>
            <hr>
            <p class="mb-0">※困ったときにはいつでもサポートまで連絡をしてください。</p>
          </div>
          <form action="" method="POST">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="userName" name="username" placeholder="表示名設定" aria-describedby="userNameHelp">
              <label for="userName">表示名設定</label>
              <div id="userNameHelp" class="form-text">※他の人と被ることは出来ません。</div>
            </div>
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="loginId" name="userid" placeholder="ログインID設定" aria-describedby="loginIdHelp">
              <label for="loginId" class="form-label">ログインID設定</label>
              <div id="loginIdHelp" class="form-text">
                ※他の人と被ることは出来ません。<br>
                <span class="text-danger">※半角英数字6文字以上で入力してください。</span>
              </div>
            </div>
            <div class="form-floating mb-3">
              <input type="password" class="form-control" id="loginPassword" name="userpass" placeholder="パスワード設定" aria-describedby="loginPasswordHelp">
              <label for="loginPassword" class="form-label">パスワード設定</label>
              <div id="loginPasswordHelp" class="form-text">
                ※他の人と被ることは出来ません。<br>
                <span class="text-danger">※半角英数字6文字以上で入力してください。</span>
              </div>
            </div>
            <div class="mb-3">
              <input type="hidden" name="register" value="on">
              <button class="btn btn-primary" type="submit" name="submit" value="go">登録</button>
            </div>
          </form>
          
        </div>
      </div>
    </div>
  </div>
</div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</body>
</html>