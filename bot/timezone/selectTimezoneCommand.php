<?php

function takeTimezone($text)
{
  $regions = [
    'Africa/', 'America/', 'Antarctica/',
    'Arctic/', 'Asia/', 'Atlantic/',
    'Australia/', 'Europe/', 'Indian/', 'Pacific/'
  ];

  foreach ($regions as $region) {
    if(str_starts_with ( $text, $region)){
      $timezone = $text;
    }
  }
  return $timezone;
}

$timezone = takeTimezone($text);

if($timezone)
{
  require_once $_SERVER['DOCUMENT_ROOT'].'/bot/databaseconnect.php';
  $sql = "UPDATE Users SET timezone=? WHERE chat_id=?";
  $conn->prepare($sql)->execute([$timezone, $chat_id]);

  sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'You timezone is '.$text]);
}
