<?php

$loginBtn =  [
  'keyboard' =>
  [
    [
      ['text' => 'English']
    ],
    [
      ['text' => 'Ukrainian']
    ],
    [
      ['text' => 'Back to Language']
    ]
  ]
];
$jsonLoginBtn = json_encode($loginBtn);
sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'You can change settings.', 'reply_markup' => $jsonLoginBtn]);
