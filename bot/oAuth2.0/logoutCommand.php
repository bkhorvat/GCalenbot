<?php
$client = new Google\Client;
$path = $_SERVER['DOCUMENT_ROOT'].'/bot/oAuth2.0/client_secret_577470576859-cr1ili98sk47a0n5ct0vs0gh2b7jkb9c.apps.googleusercontent.com.json';
$client->setAuthConfig($path);
$client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
$client->setAccessType('offline');
$client->setAccessToken($access_token);
$client->revokeToken();

$sql = "DELETE FROM Users WHERE access_token=?";
$stmt= $conn->prepare($sql);
$stmt->execute([$access_token]);

$loginBtn =  [
  'keyboard' =>
  [
    [
      ['text' => '/start']
    ]
  ]
];
$jsonLoginBtn = json_encode($loginBtn);
sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'You are logout.', 'reply_markup' => "$jsonLoginBtn"]);
