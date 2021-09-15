<?php include('/var/www/html/thechat/variable.php'); ?>
<?php include('/var/www/html/thechat/setting/pdo.php'); ?>
<?php
  if(isset($_POST['login'])){
    header('Location: /thechat/');
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN</title>
  <link rel="apple-touch-icon" sizes="180x180" href="static/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="static/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="static/favicon/favicon-16x16.png">
  <!-- <link rel="manifest" href="static/favicon/site.webmanifest"> -->
  <link rel="mask-icon" href="static/favicon/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#2b5797">
  <meta name="theme-color" content="#ffffff">
  <link href="static/css/bootstrap.min.css" rel="stylesheet">
  <link href="static/css/login.css" rel="stylesheet">
</head>
<body>
  <div class="container-fluid d-flex justify-content-center align-items-center login-wrap" style="">
    <div class="card login-form">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form action="" method="POST">
          <div class="mb-3">
            <label for="" class="form-label">ID</label>
            <input type="text" class="form-control" name="loginid" value="">
          </div>
          <div class="mb-3">
            <label for="" class="form-label">PASS</label>
            <input type="password" class="form-control" name="loginpass" value="">
          </div>
          <div class="mb-3 d-grid gap-2">
            <button type="submit" class="btn btn-primary" name="login" value="go">ログイン</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>