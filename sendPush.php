<?php
require_once 'vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

const VAPID_SUBJECT = 'https://ubuntu-2nd/thechat/';
const PUBLIC_KEY = 'BB2yhZ8QYVb6m86xKyGkX8UFq8iqHICC41mUMoQ-YAIdASL9YuBaj0-Kmm23u_NVZ1aoE0VxOaOAwK01HqciFN4';
const PRIVATE_KEY = 'WT31k_u2E011Wbwqr0GtvdBa8v7lmn9kAplz4d4p4s0';

// push通知認証用のデータ
$subscription = Subscription::create([
    'endpoint' => 'https://fcm.googleapis.com/fcm/send/f4QxqG6qZLE:APA91bFmesaq4LgqkCkz4xTycVHkOJwyS5EFaah-8S_IQtYgTcHWQcZbstn3tKtNJNW-X9zGb-BwsVOfiMPd55xB2hp34xJz2O2TByRoUDSTFxBCSJqpb3FlTaooeZ4T6_7QssH-Y1Sl',
    'publicKey' => 'BPOGbqDp3KBVtal7twxmHde0RDt3WrBuYxAG6kiATo9TK3WPVijlJtDm5rTT11o6MYNpCdHAn7y1JEN++iA/2ik=',
    'authToken' => '2w9Cr5TAZsTerkDYx1oRoA==',
]);

// ブラウザに認証させる
$auth = [
    'VAPID' => [
        'subject' => VAPID_SUBJECT,
        'publicKey' => PUBLIC_KEY,
        'privateKey' => PRIVATE_KEY,
    ]
];

$webPush = new WebPush($auth);

$report = $webPush->sendOneNotification(
    $subscription,
    'push通知！'
);

$endpoint = $report->getRequest()->getUri()->__toString();

if ($report->isSuccess()) {
    echo '送信成功！';
} else {
    echo '送信失敗やで';
}