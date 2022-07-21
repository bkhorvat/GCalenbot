<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <!--Telegram-->
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

    <title>Add events</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="#">Navbar</a>
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
            </ul>
            <form class="form-inline my-2 my-lg-0">
              <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
          </div>
        </nav>
      </div>
      <div class="row">
        <form action="index.php" method="post" id="event-form">
          <div class="container">
              <div class="form-group">
                <input type="text" class="form-control mb-3 mt-3" id="title" name="title" placeholder="Enter title">
              </div>
            <div class="row">
              <label for="start-date" class="col-sm-2 col-form-label">Start:</label>
              <div class="col mb-3">
                  <input type="date" class="form-control" id="startDate" name="start_date">
              </div>
              <div class="col mb-3">
                <input type="time" class="form-control" id="startTime" name="start_time">
              </div>
            </div>
            <div class="row">
              <label for="end-date" class="col-sm-2 col-form-label">End:</label>
              <div class="col mb-3">
                <input type="date" class="form-control" id="endDate" name="end_date">
              </div>
              <div class="col mb-3">
                <input type="time" class="form-control" id="endTime" name="end_time">
              </div>
            </div>
            <div class="row">
              <button type="submit" class="btn btn-primary mb-3">Add event</button>
            </div>
          </div>
        </form>
      </div>
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
