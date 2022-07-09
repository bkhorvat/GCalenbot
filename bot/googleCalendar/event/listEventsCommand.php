 <?php
try {
  require_once $_SERVER['DOCUMENT_ROOT'].'/bot/googleCalendar/newClient.php';

  $service = new Google_Service_Calendar($client);

  // Print the next 10 events on the user's calendar.
  $calendarId = 'primary';
  $optParams = array(
    'maxResults' => 10,
    'orderBy' => 'startTime',
    'singleEvents' => true,
    'timeMin' => date('c'),
  );
  $results = $service->events->listEvents($calendarId, $optParams);
  $events = $results->getItems();

  if (empty($events)) {
    sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'No upcoming events found.']);
  } else {
    $allEvents = "Upcoming events:\n";
    $numberEvents = 0;
      foreach ($events as $event) {
        $numberEvents +=1;
          $start = $event->start->dateTime;
          if (empty($start)) {
              $start = $event->start->date;
          }
        $allEvents .= "\n".$numberEvents.'. '.$event->getSummary()."\nStart at: ".$start;
      }
      sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => $allEvents]);
  }
} catch (Exception $e) {
    sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'Обновите токен: https://www.testmyproject.pl/bot/oAuth2.0/index.php?chat_id='.$chat_id]);
}
