<?php

if($text == 'English')
{
  sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'You change language to english.']);
}elseif($text == 'Ukrainian')
{
  sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'Ви змінили мову на українську.']);
}
