<?php
$testTodayDate = date('Y-m-d');

$instructionToaddEvent[0] =
"
Додайте подію до свого GoogleCalendars відіславши цьому боту повідомленя з текстом:
/event Заголовок події Start рік-місяць-день год:хв End рік-місяць-день год:хв
";
$instructionToaddEvent[1] =
"
Доприкладу:
/event Зустрітися з Анею Start ".$testTodayDate." 10:00 End ".$testTodayDate." 12:00
";
$instructionToaddEvent[2] =
"
Ви можете зробити це набагато швидше.
/event Заголовок події
В такому випадку подія буде записана на актуальний момент і день.
";
$instructionToaddEvent[3] =
"
Якщо ви не вказуєте дату закінчення події то вона триватиме 1 годину.
";
$instructionToaddEvent[4] =
"
Ви можете вказати тільки час початку так:
/event Заголовок події Start 22:00

Якщо ви впишете день не вказавши місяця то подія буде записана в триваючий місяць:
/event Заголовок події Start 21 22:00

Але якщо треба то вкажіть місяць:
/event Заголовок події Start 06-21 22:00
";
sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => $instructionToaddEvent[0]]);
sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => $instructionToaddEvent[1]]);
sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => $instructionToaddEvent[2]]);
sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => $instructionToaddEvent[3]]);
sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => $instructionToaddEvent[4]]);
