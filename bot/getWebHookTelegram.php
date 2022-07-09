<?php

$update = json_decode(file_get_contents('php://input'), JSON_OBJECT_AS_ARRAY);
$text = $update['message']['text'];


if($update['message']['chat']['id']){
  $chat_id = $update['message']['chat']['id'];
}elseif($update['inline_query']['from']['id']){
  $chat_id = $update['inline_query']['from']['id'];
}
