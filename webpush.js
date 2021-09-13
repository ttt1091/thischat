/**
 * サービスワーカーの登録
 */
 self.addEventListener('load', async () => {
  if ('serviceWorker' in navigator) {
      window.sw = await navigator.serviceWorker.register('./sw.js', {scope: '/'});
  }
});


/**
* WebPushを許可する仕組み
*/
async function allowWebPush() {
  if ('Notification' in window) {
      let permission = Notification.permission;

      if (permission === 'denied') {
          alert('Push通知が拒否されているようです。ブラウザの設定からPush通知を有効化してください');
          return false;
      } else if (permission === 'granted') {
          alert('すでにWebPushを許可済みです');
          return false;
      }
  }
  // 取得したPublicKey
  const appServerKey = 'BB2yhZ8QYVb6m86xKyGkX8UFq8iqHICC41mUMoQ-YAIdASL9YuBaj0-Kmm23u_NVZ1aoE0VxOaOAwK01HqciFN4';
  const applicationServerKey = urlB64ToUint8Array(appServerKey);

  // push managerにサーバーキーを渡し、トークンを取得
  let subscription = undefined;
  try {
      subscription = await window.sw.pushManager.subscribe({
          userVisibleOnly: true,
          applicationServerKey
      });
  } catch (e) {
      alert('Push通知機能が拒否されたか、エラーが発生しましたので、Push通知は送信されません。');
      return false;
  }


  // 必要なトークンを変換して取得（これが重要！！！）
  const key = subscription.getKey('p256dh');
  const token = subscription.getKey('auth');
  const request = {
      endpoint: subscription.endpoint,
      userPublicKey: btoa(String.fromCharCode.apply(null, new Uint8Array(key))),
      userAuthToken: btoa(String.fromCharCode.apply(null, new Uint8Array(token)))
  };

  console.log(request);
}



/**
* トークンを変換するときに使うロジック
* @param {*} base64String 
*/
function urlB64ToUint8Array (base64String) {
  const padding = '='.repeat((4 - base64String.length % 4) % 4);
  const base64 = (base64String + padding)
      .replace(/\-/g, '+')
      .replace(/_/g, '/');

  const rawData = window.atob(base64);
  const outputArray = new Uint8Array(rawData.length);

  for (let i = 0; i < rawData.length; ++i) {
      outputArray[i] = rawData.charCodeAt(i);
  }
  return outputArray;
}