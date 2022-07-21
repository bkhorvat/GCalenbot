<?php
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/bot/databaseconnect.php';

if($_POST['chat_id']){
$chat_id = $_POST['chat_id'];
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
       'timeMin' => date($_POST['start_date'].'\T00:00:00+02:00'),
       'timeMax' => date($_POST['end_date'].'\T23:59:59+02:00'),
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
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Statistics</title>
    <!--Telegram-->
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <!--Google charts-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable(<?php if($dataJson){echo $dataJson;}?> );

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
          <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <!--<a class="navbar-brand" href="#">Navbar</a>-->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="https://www.testmyproject.pl/bot/webapp/index.php">Add event <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="https://testmyproject.pl/bot/webapp/statistics.php">Statistics <span class="sr-only">(current)</span></a>
                </li>
                <!--
                <li class="nav-item">
                  <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                    Dropdown
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                  </div>
                </li>
                <li class="nav-item">
                  <a class="nav-link disabled">Disabled</a>
                </li>
              -->
              </ul>
              <!--
              <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
              </form>
            -->
            </div>
          </nav>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <form action="statistics.php" method="post">
            <label for="start-date" class="col-sm-2 col-form-label">Start:</label>
            <div class="col mb-3">
                <input type="date" class="form-control" id="startDate" name="start_date">
            </div>
            <!--
            <div class="col mb-3">
              <input type="time" class="form-control" id="startTime" name="start_time">
            </div>
          -->
            <label for="end-date" class="col-sm-2 col-form-label">End:</label>
            <div class="col mb-3">
              <input type="date" class="form-control" id="endDate" name="end_date">
            </div>
            <!--
            <div class="col mb-3">
              <input type="time" class="form-control" id="endTime" name="end_time">
            </div>
          -->
            <input class="form-control" id="chat_id" name="chat_id" type="text" value="" style="visibility: hidden;">
            <button type="submit" class="btn btn-primary mb-3">Check statistic</button>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div id="piechart" style="width: 100%; height: 500px;"></div>
        </div>
      </div>
    </div>
  </body>
</html>
<script>
  document.querySelector('#chat_id').value = window.Telegram.WebApp.initDataUnsafe.user.id;

    const date = new Date();

//Date date
    let month = date.getMonth()+1;
    if(month < 10){
      month = '0'+month;
    }
    let day = date.getDate();
    if(day < 10){
      day = '0'+day;
    }
    const year = date.getFullYear();
    const dateToday = year+'-'+month+'-'+day;

//Start, end time
    let hours = date.getHours();
    let endHours = hours+1;

    if(hours < 10){
      hours = '0'+hours;
    }
    if(endHours < 10){
      endHours = '0'+endHours;
    }
    let minutes = date.getMinutes();
    if(minutes < 10){
      minutes = '0'+minutes;
    }
    const startTime = hours+':'+minutes;
    const endTime = endHours+':'+minutes;

    document.querySelector('#startDate').value = dateToday;
    //document.querySelector('#startTime').value = startTime;
    document.querySelector('#endDate').value = dateToday;
    //document.querySelector('#endTime').value = endTime;
</script>
