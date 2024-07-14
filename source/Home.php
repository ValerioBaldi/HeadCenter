<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.html");
    exit();
}

$username = $_SESSION["username"];
$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=postgres") or die('Could not connect: ' . pg_last_error());
$queryUser = "SELECT COUNT(*) FROM users WHERE username = $1";
$result = pg_query_params($dbconn, $queryUser, array($username));
$res = false;

while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    foreach ($line as $colname) {
        if ($colname == 1) {
            $res = true;
        }
    }
}

pg_free_result($result);
pg_close($dbconn);

if (!$res) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--jquery-->
  <!--   <script src="jquery-3.6.0.js"></script> -->

    <link rel="stylesheet" href="1 bootstrap/css/bootstrap.css" />
    <script src="1 bootstrap/js/bootstrap.bundle.js"></script>
    <link rel="icon" href="2 images/senzabordo.png">
    <link rel = "stylesheet" href = "style.css" />
    <!-- <link rel = "stylesheet" href = "digital.css" /> -->
    <title>Homepage</title>
</head>

<body>
<!-- navbar in alto -->
    <nav class="navbar navbar-expand-lg bg-light">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="home.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="headachePage.php">Headache recordings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="DownloadPage.php">Download reports</a>
            </li>
              <li class="nav-item">
                <a class="nav-link" href="coffeePage.php">Coffee recordings</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="digitalPage.php">Digital Devices Recordings</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="calendar.php">Personal Report Calendar</a>
              </li>
            </ul>
          </div>
        </div>
  
    </nav>


<br>
<br>
    <!--titoletto-->
   
   <strong><h1 class="fw-bolder text-center" style="color:rgb(80, 197, 255)">Homepage</h1></strong>
   
   
   <img src="2 images/logo.png" class="top-left-logo">


  <!-- language selection -->
    <div class="language">
      <br><br><br><br>
      <img src="2 images/uk.png" style="width: 3px0px; height:20px; display: inline-block; vertical-align: middle;"> 
    <a class="nav-link dropdown-toggle" href="#" role="button"
      data-bs-toggle="dropdown" aria-expanded="false" style=" display: inline-block; vertical-align: middle;">
       Language
      </a>
      <ul class="dropdown-menu text-center">
      <li><a class="dropdown-item" href="Home.php">English</a></li>
      <li><a class="dropdown-item" href="source-ita/Home.php">Italiano</a></li>
      </ul>
    </div>
    <br><br>

    <!-- info point -->
    <img src="2 images/question.png" alt="description" class="bottom-right-image">

<?php
  echo "<h6 class=\"bottom-left-logged\">Logged in as: $username</h6>";
?>

<br>
<div class="container2">

 <strong> <a style="text-decoration: none;" href="headache.php"> Headhache Report</a> <br>
  <br>
  <a  style="text-decoration: none;" href="quickheadache.php"> Quick Headhache Report</a> <br>
<br>
  <a style="text-decoration: none;" href="digitalPage.php"> Digital devices Usage Report</a> <br>
  <br>
  <a style="text-decoration: none;" href="coffeePage.php"> Sleeping Quality Report </a> <br>
  <br>
  <a style="text-decoration: none;" href="calendar.php">Personal Report Calendar  </a> <br>
  <br>
  <a  style="text-decoration: none;" href="DownloadPage.php"> Download a report </a></strong>
</div>
</body>
</html>
