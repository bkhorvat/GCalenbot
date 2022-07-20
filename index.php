<?php

require_once 'bot/telegramBotConf.php';//telegram bot token, base url, require vendor
require_once 'bot/getWebHookTelegram.php'; // Get webHooh from telegram
require_once $_SERVER['DOCUMENT_ROOT'].'/bot/googleCalendar/access_token.php'; //Getting the user's $access_token from the database

//Methods
require_once 'bot/methods/sendRequestToTelegram.php'; // method send message to Telegram
require_once 'bot/methods/str_starts_with.php';

//Commands
require_once 'bot/timezone/indexTimezone.php';//Timezone
require_once 'bot/language/indexLanguage.php';//language
require_once 'bot/oAuth2.0/indexoAuth.php';//oAuth2.0 /start command
require_once 'bot/googleCalendar/event/indexEvent.php';//event

switch ($text)
{
  case 'Settings':
    require_once 'bot/commands/settingsCommand.php';
    break;
  case 'Back to menu':
    require_once 'bot/commands/startCommand.php';
    break;
  case 'Back to settings':
    require_once 'bot/commands/settingsCommand.php';
    break;
}

//Web app Commands
require_once 'bot/webapp/indexWebApp.php';

//test command
if($text == '/up')
{
  $a = date('d.m.Y H:i:sP', $update['message']['date']);
  $up = file_get_contents('php://input');
  sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => $a]);
}
/*
if($update){
  sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => file_get_contents('php://input')]);
}

function endsWith($haystack, $needle) {
    $length = strlen($needle);
    return $length > 0 ? substr($haystack, -$length) === $needle : true;
}

if(str_starts_with($update['inline_query']['query'], '/event ') && endsWith($update['inline_query']['query'], '+'))
{
  $text = $update['inline_query']['query'];
  $text = str_replace('+', '', $text);
  require_once 'bot/googleCalendar/event/addEventCommand.php';
}
*/
if($user)
{
  if($text == '/start 123'){
    $keyboard =  [
      'keyboard' =>
      [
        [
          [
            'text' => 'Add event',
            'web_app' => ['url' => "https://www.testmyproject.pl/bot/webapp/index.php"]
          ]
        ],
        [
          ['text' => 'Menu']
        ],
        [
          ['text' => 'Back to chat']
        ],
      ]
    ];
    sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'Use menu for add event.', 'reply_markup' => json_encode($keyboard)]);
  }
}else{
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
if($text == 'Back to chat'){
  $inlineKeyboardd = [
    'inline_keyboard' =>
    [
      [
        [
          'text' => 'Back to chat',
          'switch_inline_query' => ''
        ]
      ]
    ]
  ];
  sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'You can back to chat. Click!.', 'reply_markup' => json_encode($inlineKeyboardd)]);
}

if($update['inline_query'])
{
  $text = $update['inline_query']['query'];
  $inline_query_id = $update['inline_query']['id'];
  $updateAll = json_encode($update['inline_query']);
  sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => $updateAll]);
  $result =  [
    [
      "type" => "article",
      "id" => "1",
      "title" => "Trulalaasdlma",
      "input_message_content" => [
        "message_text" => "temkaml ajskanld"
      ]
    ]
  ];
  $result2 = [];
  sendRequest('answerInlineQuery', ['inline_query_id' => $inline_query_id, 'results' => $result2, 'switch_pm_text' => 'Edd event', 'switch_pm_parameter' => '123']);

}
