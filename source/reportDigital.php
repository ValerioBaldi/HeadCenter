<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario 2020-2025</title>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
    <link rel="stylesheet" href="1 bootstrap/css/bootstrap.css" />
    <script src="1 bootstrap/js/bootstrap.bundle.js"></script>
    <link rel="icon" href="2 images/senzabordo.png">
    <link rel = "stylesheet" href = "style.css" />
    <link rel = "stylesheet" href = "digital.css" />
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="home.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="coffee.html">Coffee recordings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="digital.html">Digital Devices Recordings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="calendar.php">Personal Report Calendar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="settings.html">Settings</a>
                </li>
                </ul>
            </div>
            </div>
    
        </nav>


    <br>
    <br>
        <!--titoletto-->
    
    <strong><h1 class="fw-bolder text-center" style="color:rgb(80, 197, 255)">Digital Devices Recording</h1></strong>
    
    
    <img src="2 images/logo.png" class="top-left-logo">


    <!-- language selection -->
        <div class="language">
        <br><br><br><br>
        <a class="nav-link dropdown-toggle" href="#" role="button"
        data-bs-toggle="dropdown" aria-expanded="false">
        Language
        </a>
        <ul class="dropdown-menu text-center">
        <li><a class="dropdown-item" href="chisiamo.html">English</a></li>
        <li><a class="dropdown-item" href="dovesiamo.html">Italiano</a></li>
        </ul>
        </div>
        <br><br>

        <!-- info point -->
        <img src="2 images/question.png" alt="description" class="bottom-right-image">

    <!-- logged in as -->
    <h6 class="bottom-left-logged">Logged in as:</h6>

    <?php
    if ($_SERVER["REQUEST_METHOD"] !="GET") { /* verifica richiesta post */
        header("Location: calendar.php");
        exit;
    }
    else {
        $rid= $_GET['rid'];
        $dbconnect = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=postgres") or die('could not connect: ' . pg_last_error());
        $query = "SELECT digital_date, digital_usage_from, digital_usage_to, symptoms, devices_type, usage_for
            FROM digital where report_id= $1 ";
        $result= pg_query_params($query,array($rid)) or die('query failed: ' . pg_last_error());
        
        echo "<div class='container'> <table>";
        echo "<tr><th><h2> Digital Usage Report </h2></th></tr>";
        
        while($line= pg_fetch_array($result, null, PGSQL_ASSOC)) {
            foreach($line as $colname){
                echo "<tr><td> $colname </td></tr>";
            }
        }
        echo "</table> </div>";
        pg_free_result($result);
        pg_close($dbconnect);
    }
?>