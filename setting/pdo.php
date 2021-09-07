<?php

// ドライバ呼び出しを使用して MySQL データベースに接続します
$dsn = 'mysql:dbname=thechat;host=127.0.0.1';
$user = 'admin';
$password = 'khUhw81!fwe';

try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo $e->getMessage() . "\n";
    exit();
}