<?php

$webApp = $update['message']['web_app_data']['button_text'];

try {
  if($webApp == 'Web app')
  {
    require_once $_SERVER['DOCUMENT_ROOT'].'/bot/databaseconnect.php';
    $stmt = $conn->prepare("SELECT timezone FROM Users WHERE chat_id=?");
    $stmt->execute([$chat_id]);
    $user = $stmt->fetch();
    $userTimezone = $user['timezone'];

    date_default_timezone_set($userTimezone);

    $dataJson = $update['message']['web_app_data']['data'];
    $data = json_decode($dataJson, true);

    $startTime = new DateTime($data['startDate'].$data['startTime']);
    $startTime = $startTime->format('Y-m-d\TH:i:sP');
    $endTime = new DateTime($data['endDate'].$data['endTime']);
    $endTime = $endTime->format('Y-m-d\TH:i:sP');
    $summary = $data['title'];

    require_once $_SERVER['DOCUMENT_ROOT'].'/bot/googleCalendar/newClient.php';

    $service = new Google_Service_Calendar($client);

    $event = new Google_Service_Calendar_Event(array(
    'summary' =>  $summary,
    'start' => array('dateTime' => $startTime),
    'end' => array('dateTime' => $endTime),
    ));

    $calendarId = 'primary';
    $event = $service->events->insert($calendarId, $event);

    if($summary == ''){
      $summary = 'Without title';
    }

    sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => $summary.', Start: '.$data['startDate'].' '.$data['startTime'].', End: '.$data['endDate'].' '.$data['endTime']]);

  }
} catch (\Exception $e) {
  sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'Обновите токен: https://www.testmyproject.pl/bot/oAuth2.0/index.php?chat_id='.$chat_id]);
}
