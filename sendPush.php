<?php
require_once 'vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

const VAPID_SUBJECT = 'https://ubuntu-2nd/thechat/';
const PUBLIC_KEY = 'BB2yhZ8QYVb6m86xKyGkX8UFq8iqHICC41mUMoQ-YAIdASL9YuBaj0-Kmm23u_NVZ1aoE0VxOaOAwK01HqciFN4';
const PRIVATE_KEY = 'WT31k_u2E011Wbwqr0GtvdBa8v7lmn9kAplz4d4p4s0';

// push通知認証用のデータ
$subscription = Subscription::create([
    'endpoint' => 'https://fcm.googleapis.com/fcm/send/dHE37N_3SSM:APA91bE1rAQKnVo-eXMmhQMzF0lef6d04JinE4ob3KUhfzlrD-G1bb-MNPQZhT4MY3K2g8AHBi6pSeaTg_p00qsRwDSMpCuWC7EVblczWNMvlwnvpoD4D3bqTkfOHeGblJX0BXajUzBO',
    'publicKey' => 'BKvlcQl6Ap4uOhakOri3mkdTuscZ7BVUrXYT44Iigp3Eo4Omn3UKUQJY3yTs5xFZ4VOy5+UmCnLnmyQIDucNdy8=',
    'authToken' => 'B51cDbEjr/MPzub+Htua5w==',
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