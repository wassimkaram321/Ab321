<?php

namespace App\Traits;

trait NotificationTrait
{

    public function send_notification($device_token, $title, $body)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $SERVER_API_KEY = 'AAAAI46Pfms:APA91bFnmvVFQ5tWOQklZDLL2V078BNL6QQNayvjl30vM4YbUYoUiIpxHc353jmoby8sD4lB-TtLA1ycNOUq5HtugwlGWEXQ7-fqI0hF8jPvuDjbSIfZAzCgALT6PnolEYzZEKOMI6EY';
        $data = [
            'to' => $device_token, //$FcmToken,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ]
        ];
        $headers = [
            'Authorization:key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
        $encodedData = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
    }
}
