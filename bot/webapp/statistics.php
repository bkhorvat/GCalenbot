 <?php
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/bot/databaseconnect.php';

$chat_id = $_GET['chat_id'];
$stmt = $conn->prepare("SELECT access_token FROM Users WHERE chat_id=?");
$stmt->execute([$chat_id]);
$user = $stmt->fetch();
$access_token = $user['access_token'];

require_once $_SERVER['DOCUMENT_ROOT'].'/bot/googleCalendar/newClient.php';

$service = new Google_Service_Calendar($client);

// Print the next 10 events on the user's calendar.
try{

    $calendarId = 'primary';
    $optParams = array(
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('Y-m-d\T00:00:00+02:00'),
        'timeMax' => date('Y-m-d\T23:59:59+02:00'),
    );
    $results = $service->events->listEvents($calendarId, $optParams);
    $events = $results->getItems();


    function getHourDiff($event){
      if($event['start']['date'] && $event['end']['date']){
        $hourdiff = round((strtotime($event['end']['date']) - strtotime($event['start']['date']))/3600, 1);
      }elseif($event['start']['dateTime'] && $event['end']['dateTime']){
        $hourdiff = round((strtotime($event['end']['dateTime']) - strtotime($event['start']['dateTime']))/3600, 1);
      }elseif($event['start']['dateTime'] && $event['end']['date']){
        $hourdiff = round((strtotime($event['end']['date']) - strtotime($event['start']['dateTime']))/3600, 1);
      }elseif($event['start']['date'] && $event['end']['dateTime']){
        $hourdiff = round((strtotime($event['end']['dateTime']) - strtotime($event['start']['date']))/3600, 1);
      }
      return $hourdiff;
    }

    foreach ($events as $event) {
      if($jsonEvents[$event['summary']])
      {
        $jsonEvents[$event['summary']] += getHourDiff($event);
      }else{
        $jsonEvents[$event['summary']] = getHourDiff($event);
      }
    }
    $dataJson = [['Task', 'Hours per Day']];
    foreach ($jsonEvents as $key => $value) {
      array_push($dataJson, ["$key", $value]);
    }
    $dataJson = json_encode($dataJson);
}
catch(Exception $e) {
    // TODO(developer) - handle error appropriately
    echo 'Message: ' .$e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Statistics</title>

    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable(<?php echo $dataJson ?>);

        var options = {
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col">
          <div>
            <div id="piechart" style="width: 100%; height: 500px;"></div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
