<?php

$loginBtn =  [
  'keyboard' =>
  [
    [
      ['text' => 'Africa'],
      ['text' => 'America'],
      ['text' => 'Antarctica']
    ],
    [
      ['text' => 'Arctic'],
      ['text' => 'Asia'],
      ['text' => 'Atlantic']
    ],
    [
      ['text' => 'Australia'],
      ['text' => 'Europe'],
      ['text' => 'Indian']
    ],
    [
      ['text' => 'Pacific']
    ],
    [
      ['text' => 'Back to settings']
    ]
  ]
];
$jsonLoginBtn = json_encode($loginBtn);
sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'You can change settings.', 'reply_markup' => $jsonLoginBtn]);
