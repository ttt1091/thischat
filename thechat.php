<?php include('/var/www/html/thechat/variable.php'); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
  
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
            <form action="" method="post"></form>
            <hr>
            <p class="mb-0">※困ったときにはいつでもサポートまで連絡をしてください。</p>
          </div>
          <form action="" method="post">
            <div class="form-floating mb-3">
              <input type="email" class="form-control" id="userName" placeholder="表示名設定" aria-describedby="userNameHelp">
              <label for="userName">表示名設定</label>
              <div id="userNameHelp" class="form-text">※他の人と被ることは出来ません。</div>
            </div>
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="loginId" placeholder="ログインID設定" aria-describedby="loginIdHelp">
              <label for="loginId" class="form-label">ログインID設定</label>
              <div id="loginIdHelp" class="form-text">※他の人と被ることは出来ません。</div>
            </div>
            <div class="form-floating mb-3">
              <input type="password" class="form-control" id="loginPassword" placeholder="パスワード設定" aria-describedby="loginPasswordHelp">
              <label for="loginPassword" class="form-label">パスワード設定</label>
              <div id="loginPasswordHelp" class="form-text">※他の人と被ることは出来ません。</div>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary" type="submit">登録</button>
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