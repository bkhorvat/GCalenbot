<?php

function showTimezones($regions, $chat_id)
{

  $btns =  [
    'keyboard' =>
    [
      [
        ['text' => 'Back to regions']
      ]
    ]
  ];

  $count = 1;
  for ($i=0; $i < count($regions); $i++) {
    if(is_int($i/3) && $i != 0){
      $count++;
      $btns['keyboard'][$count][] = ['text' => $regions[$i]];
    }else{
      $btns['keyboard'][$count][] = ['text' => $regions[$i]];
    }
  }

  $jsonBtns = json_encode($btns);
  sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => $i.' timezones', 'reply_markup' => $jsonBtns]);
}

switch ($text)
{
  case 'Africa':
    require_once 'allTimezones/Africa.php';
    showTimezones($Africa, $chat_id);
  break;
  case 'America':
    require_once 'allTimezones/America.php';
    showTimezones($America, $chat_id);
  break;
  case 'Antarctica':
    require_once 'allTimezones/Antarctica.php';
    showTimezones($Antarctica, $chat_id);
  break;
  case 'Arctic':
    require_once 'allTimezones/Arctic.php';
    showTimezones($Arctic, $chat_id);
  break;
  case 'Asia':
    require_once 'allTimezones/Asia.php';
    showTimezones($Asia, $chat_id);
  break;
  case 'Atlantic':
    require_once 'allTimezones/Atlantic.php';
    showTimezones($Atlantic, $chat_id);
  break;
  case 'Australia':
    require_once 'allTimezones/Australia.php';
    showTimezones($Australia, $chat_id);
  break;
  case 'Europe':
    require_once 'allTimezones/Europe.php';
    showTimezones($Europe, $chat_id);
  break;
  case 'Indian':
    require_once 'allTimezones/Indian.php';
    showTimezones($Indian, $chat_id);
  break;
  case 'Pacific':
    require_once 'allTimezones/Pacific.php';
    showTimezones($Pacific, $chat_id);
  break;
}
