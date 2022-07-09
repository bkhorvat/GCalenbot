<?php

$loginBtn =  [
  'keyboard' =>
  [
    [
      ['text' => 'Timezone']
    ],
/*
    [
      ['text' => 'Language']
    ],
*/
    [
      ['text' => 'Back to menu']
    ]
  ]
];
$jsonLoginBtn = json_encode($loginBtn);
sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'You can change settings.', 'reply_markup' => $jsonLoginBtn]);
