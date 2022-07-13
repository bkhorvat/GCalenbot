<?php
if($user)
{
  $loginBtn =  [
    'keyboard' =>
    [
/*      [
        ['text' => 'Next 10 events'],
      ],

      [
        ['text' => 'Instructions']
      ],
*/
      [
        ['text' => 'Settings']
      ],
      [
        [
          'text' => 'Add event',
          'web_app' => ['url' => "https://www.testmyproject.pl/bot/webapp/index.php"]
        ]
      ],
      [
        ['text' => 'Logout']
      ],

    ]
  ];
  $jsonLoginBtn = json_encode($loginBtn);

  sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'Menu are open.', 'reply_markup' => $jsonLoginBtn]);
  sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'Set up a time zone into settings before using!']);
}else
{
  $loginBtn =  [
    'inline_keyboard' =>
    [
      [
        ['text' => 'Login', 'url' => "https://www.testmyproject.pl/bot/oAuth2.0/index.php?chat_id=$chat_id"]
      ]
    ]
  ];
  $jsonLoginBtn = json_encode($loginBtn);
  sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'Hello! Welcome to CalendarHelper! This bot is interface for Google Calendar. Please, login via your Google account for start. Click login.', 'reply_markup' => $jsonLoginBtn]);
  sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'After login click /start one more.']);
}
