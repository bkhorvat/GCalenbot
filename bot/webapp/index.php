<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <title>Add events</title>
  </head>
  <body>
<div>
  <form action="index.php" method="post" id="event-form">
    <div class="form-group">
      <label for="title">Title:</label>
      <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
    </div>
    <div class="form-group">
      <label for="start-date" class="col-sm-2 col-form-label">Start date:</label>
      <input type="date" class="form-control" id="startDate" name="start_date">
      <label for="start-time" class="col-sm-2 col-form-label">Start time:</label>
      <input type="time" class="form-control" id="startTime" name="start_time">
    </div>
    <div class="form-group">
      <label for="end-date" class="col-sm-2 col-form-label">End date:</label>
      <input type="date" class="form-control" id="endDate" name="end_date">
      <label for="end-time" class="col-sm-2 col-form-label">End time:</label>
      <input type="time" class="form-control" id="endTime" name="end_time">
    </div>
    <button type="submit" class="btn btn-primary">Add event</button>
  </form>
</div>
<div>
  <h1 id="time">Итог - <div id="min"></div> </h1>
</div>
  </body>
  <script language="javascript">
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
    if(hours < 10){
      hours = '0'+hours;
    }
    let minutes = date.getMinutes();
    if(minutes < 10){
      minutes = '0'+minutes;
    }
    const startTime = hours+':'+minutes;
    const endTime = hours+1+':'+minutes;

    document.querySelector('#startDate').value = dateToday;
    document.querySelector('#startTime').value = startTime;
    document.querySelector('#endDate').value = dateToday;
    document.querySelector('#endTime').value = endTime;

    document.getElementById('event-form').addEventListener('submit', function(e) {
    // что бы не отправилась форма.
    e.preventDefault();
    let result = new Object();
    result.title = document.getElementById('title').value;
    result.startDate = document.getElementById('startDate').value;
    result.startTime = document.getElementById('startTime').value;
    result.endDate = document.getElementById('endDate').value;
    result.endTime = document.getElementById('endTime').value;
    Telegram.WebApp.sendData(JSON.stringify(result));
  });

  </script>
</html>