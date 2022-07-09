<?php

$loginBtn =  [
  'keyboard' =>
  [
    [
      ['text' => 'Your language is: ']
    ],
    [
      ['text' => 'Change language']
    ],
    [
      ['text' => 'Back to settings']
    ]
  ]
];
$jsonLoginBtn = json_encode($loginBtn);
sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'You can change settings.', 'reply_markup' => $jsonLoginBtn]);
