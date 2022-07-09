 <?php
 require_once $_SERVER['DOCUMENT_ROOT'].'/bot/databaseconnect.php';
 $stmt = $conn->prepare("SELECT timezone FROM Users WHERE chat_id=?");
 $stmt->execute([$chat_id]);
 $user = $stmt->fetch();
 $userTimezone = $user['timezone'];

 date_default_timezone_set($userTimezone);

 function checkingDate($data)
 {
   $date = explode(" ", $data);
   $time = $date[1];

   $count = substr_count($date[0], '-');

   switch ($count)
   {
     case 0:
       $date = 'Y-m-'.$date[0];
       $date = date($date);
       break;
     case 1:
       $date ='Y-'.$date[0];
       $date = date($date);
       break;
     case 2:
       $date = date($date[0]);
       break;
   }

   return $date.' '.$time;
 }

 function add_event($str) {
   $data = str_replace('/event', '', $str);

   if(strstr($str, 'Start') && strstr($str, 'End')){
     $data = explode('Start', $data);
     $summary = $data[0];
     $data = explode('End', $data[1]);
     $startData = $data[0];
     $endData = $data[1];
   }
   elseif(strstr($str, 'Start') && strstr($str, 'End') == false){
     $data = explode('Start', $data);
     $summary = $data[0];
     $startData = $data[1];
   }else{
     $summary = $data;
   }

   if(strlen(trim($startData)) > 5)
   {
     $date = checkingDate(trim($startData));
     $startTime = new DateTime($date);
     $startTime = $startTime->format('Y-m-d\TH:i:sP');
   }else{
     $startTime = new DateTime(trim($startData));
     $startTime = $startTime->format('Y-m-d\TH:i:sP');
   }

   if($endData){
     if(strlen(trim($endData)) > 5)
     {
       $date = checkingDate(trim($endData));
       $endTime = new DateTime($date);
       $endTime = $endTime->format('Y-m-d\TH:i:sP');
     }else{
       $endTime = new DateTime(trim($endData));
       $endTime = $endTime->format('Y-m-d\TH:i:sP');
     }
   }else{
     $endTime = new DateTime($startTime);
     $endTime->add(new DateInterval('PT1H'));
     $endTime = $endTime->format('Y-m-d\TH:i:sP');
   }

   require_once $_SERVER['DOCUMENT_ROOT'].'/bot/googleCalendar/newClient.php';

   $service = new Google_Service_Calendar($client);

   $event = new Google_Service_Calendar_Event(array(
 'summary' =>  $summary,
 'start' => array('dateTime' => $startTime),
 'end' => array('dateTime' => $endTime),
 ));

   $calendarId = 'primary';
   $event = $service->events->insert($calendarId, $event);

 }

try {
    add_event($text);
    sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'Event is add.']);
} catch (Exception $e) {
    sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => 'Обновите токен: https://www.testmyproject.pl/bot/oAuth2.0/index.php?chat_id='.$chat_id]);
}
