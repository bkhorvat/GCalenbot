<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/bot/databaseconnect.php';
$stmt = $conn->prepare("SELECT timezone FROM Users WHERE chat_id=?");
$stmt->execute([$chat_id]);
$user = $stmt->fetch();
$userTimezone = $user['timezone'];

$loginBtn =  [
  'keyboard' =>
  [
    [
      ['text' => 'Set timezone']
    ],
    [
      ['text' => 'Back to settings']
    ]
  ]
];
if($userTimezone)
{
  array_unshift($loginBtn['keyboard'], [['text' => 'Your timezone is: '.$userTimezone]]);
  $message = 'Your timezone is: '.$userTimezone;
}else{
  $message = 'You can set timezone.';
}


$jsonLoginBtn = json_encode($loginBtn);
sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => $message, 'reply_markup' => $jsonLoginBtn]);
