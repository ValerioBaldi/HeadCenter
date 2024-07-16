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
    <!-- <link rel="icon" href="2 images/senzabordo.png"> -->
    <link rel = "stylesheet" href = "style.css" />
    <link rel = "stylesheet" href = "digital.css" />
    <title>Headache Recording</title>
    

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
                <a class="nav-link" href="DownloadPage.php">Select reports to Download</a>
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
   
   <strong><h1 class="fw-bolder text-center" style="color:rgb(80, 197, 255)">Headache Recording</h1></strong>
   
   
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
      <li><a class="dropdown-item" href="headachePage.php">English</a></li>
      <li><a class="dropdown-item" href="source-ita/headachePage.php">Italiano</a></li>
      </ul>
    </div>
    <br><br>

    <!-- info point -->
    <img src="2 images/question.png" alt="description" class="bottom-right-image">

    <?php
      echo "<h6 class=\"bottom-left-logged\">Logged in as: $username</h6>";
    ?>



<div class="container">
  <div class="summary">
    <h2>Summary</h2>
    <ul id="summary-list">
        <li class="summary-item active">Duration</li>
        <li class="summary-item">Location</li>
        <li class="summary-item">Intensity</li>
        <li class="summary-item">Type of pain</li>
        <li class="summary-item">Painkillers</li>
        <li class="summary-item">Repercussion</li>
        <li class="summary-item">Symptoms</li>
        <li class="summary-item">Additional</li>
        <li class="summary-item">Brief</li>
    </ul>
  </div>

<!--   create table headache (
    report_id int NOT NULL PRIMARY KEY,
    report_by int NOT NULL,
    headache_date date,
    starting_time timestamp NOT NULL,
    ending_time timestamp,
    still_going boolean,
    ache_position char(20),
    ache_intensity char(10),
    ache_type char(20),
    painkillers char(100),
    repercussions char(100),
    symptoms char(100),
    notes char(200)
); -->

  <div class="form-container">
      <form id="multi-step-form" action = "headache.php" method = "POST" name = "headache">
          <!-- Pagina 1 della form -->
          <div class="form-page" style="text-align: center;" id="page1">
              <h4 >When has it started?</h4>
              <br><br>
              <label for="digital_date">Date:</label>
              <input type="date" id="headache_date" name="headache_date" required>
              <br><br>
              <label for="starting_time">From:</label>
              <input type="time" id="starting_time" name="starting_time" required />
              <br><br>
              <label for="ending_time">To:</label>
              <input type="time" id="ending_time" name="ending_time" />
              <br><br>
              <label for="still_going">Is it still going?</label>
              <input type="checkbox" id="still_going" name="still_going" value="true">
              <br><br><br>
              <button type="button" onclick="nextPage()">Next</button>
          </div>
          <!-- Pagina 2 della form -->
          <div class="form-page" style="text-align: center;" id="page2">
              <h4 >Where do you feel the pain?</h4>
              <br><br>
              <div class="container-fluid">
                <div class="row justify-content-between">
                  <div class="col-sm-4">
        
              <label for="symptom1">Right forehead</label>
              <input type="checkbox" id="symptom1" name="ache_position" value="Right forehead" onclick="updateConcatenatedValues('ache_position')">
              <br><br>
              <label for="symptom2">Neck left</label>
              <input type="checkbox" id="symptom2" name="ache_position" value="Neck left" onclick="updateConcatenatedValues('ache_position')">
              <br><br>
              <label for="symptpm3">Temples</label>
              <input type="checkbox" id="symptom3" name="ache_position" value="Temples" onclick="updateConcatenatedValues('ache_position')">
              <br><br>
              </div>
              <div class="col-sm-4">

              <label for="symptom4">Left forehead</label>
              <input type="checkbox" id="symptom4" name="ache_position" value="Left forehead" onclick="updateConcatenatedValues('ache_position')">
              <br><br>
              <label for="symptom5">Neck right</label>
              <input type="checkbox" id="symptom5" name="ache_position" value="Neck right" onclick="updateConcatenatedValues('ache_position')">
              <br><br>
              <label for="symptom6">Hairband area</label>
              <input type="checkbox" id="symptom6" name="ache_position" value="Hairband area" onclick="updateConcatenatedValues('ache_position')">
                  </div>
                </div>
              </div>
              <br><br>

              <button type="button" onclick="nextPage()">Next</button>
          </div>

          <!--pagina 3-->
          <div class="form-page" style="text-align: center;" id="page3">
            <h4>How much does it hurt?</h4>
            <br><br>
          <label for="usage1">Low</label>
          <input type="radio" id="ache1" name="ache_intensity" value="Low">
          <br><br>
          <label for="usage2">Medium</label>
          <input type="radio" id="ache2" name="ache_intensity" value="Medium">
          <br><br>
          <label for="usage3">High</label>
          <input type="radio" id="ache3" name="ache_intensity" value="High">
          <br><br><br>

          <button type="button" onclick="nextPage()">Next</button>
        </div>
        <!-- pagina 4 -->
        <div class="form-page" style="text-align: center;" id="page4">
            <h4 >What kind of pain do you feel?</h4>
            <br><br>
            <div class="container-fluid">
              <div class="row justify-content-between">
                <div class="col-sm-4">
      
            <label for="symptom1">Constrictive</label>
            <input type="checkbox" id="symptom1" name="ache_type" value="Constrictive" onclick="updateConcatenatedValues('ache_type')">
            <br><br>
            <label for="symptom2">Pulsating</label>
            <input type="checkbox" id="symptom2" name="ache_type" value="Pulsating" onclick="updateConcatenatedValues('ache_type')">
            <br><br>
            </div>
            <div class="col-sm-4">

            <label for="symptom4">Nevralgic</label>
            <input type="checkbox" id="symptom4" name="ache_type" value="Nevralgic" onclick="updateConcatenatedValues('ache_type')">
            <br><br>
            <label for="symptom5">Piercing</label>
            <input type="checkbox" id="symptom5" name="ache_type" value="Piercing" onclick="updateConcatenatedValues('ache_type')">
            <br><br><br>
               </div>
              </div>
            </div>
            <button type="button" onclick="nextPage()">Next</button>
        </div>
        <!-- pagina 5 -->
        <div class="form-page" style="text-align: center;" id="page5">
            <h4 >Have you taken any painkiller?</h4>
            <br><br>
            <div class="container-fluid">
              <div class="row justify-content-between">
                <div class="col-sm-4">
      
            <label for="symptom1">Yes</label>
            <input type="radio" id="symptom1" name="painkillers" value="true" onclick="updateConcatenatedValues('painkillers')">
            <br><br>
            </div>
            <div class="col-sm-4">

            <label for="symptom4">No</label>
            <input type="radio" id="symptom4" name="painkillers" value="false" onclick="updateConcatenatedValues('painkillers')">
            <br><br>
               </div>
              </div>
            </div>
            <textarea rows="5" columns="25" placeholder="If yes, write which one" name="painkillers" maxlength="100" oninput="updateConcatenatedValues('painkillers')"></textarea> 
            <br><br><br>
            <button type="button" onclick="nextPage()">Next</button>
        </div>
        <!--pagina 6-->
        <div class="form-page" style="text-align: center;" id="page6">
            <h4>Had your pain lead to any repercussion?</h4>
            <br><br>
            <label for="usage1">Worse performance at work/school</label>
          <input type="checkbox" id="usage1" name="repercussions" value="Worse performance at work/school" onclick="updateConcatenatedValues('repercussions')">
          <br><br>
          <label for="usage2">Couldn't work/study</label>
          <input type="checkbox" id="usage2" name="repercussions" value="Couldn't work/study" onclick="updateConcatenatedValues('repercussions')">
          <br><br>
          <label for="usage3">Costricted to rest</label>
          <input type="checkbox" id="usage3" name="repercussions" value="Costricted to rest" onclick="updateConcatenatedValues('repercussions')">
          <br><br>
          <label for="usage2">Bad quality of sleep</label>
          <input type="checkbox" id="usage2" name="repercussions" value="Bad quality of sleep" onclick="updateConcatenatedValues('repercussions')">
          <br><br>
          <label for="usage2">Add other:</label>
          <br><br>
          <textarea rows="5" columns="25" placeholder="..." name="repercussions" maxlength="100" oninput="updateConcatenatedValues('repercussions')"></textarea> 
          <br><br><br>

          <button type="button" onclick="nextPage()">Next</button>
        </div>
        <!--pagina 7-->
        <div class="form-page" style="text-align: center;" id="page7">
            <h4>Did you feel any other symptoms?</h4>
            <br><br>
          <textarea rows="5" columns="25" placeholder="..." name="symptoms" maxlength="100"></textarea> 
          <br><br><br>

          <button type="button" onclick="nextPage()">Next</button>
        </div>
        <!--pagina 8-->
        <div class="form-page" style="text-align: center;" id="page8">
            <h4>Add a note</h4>
            <br><br>
          <textarea rows="5" columns="25" placeholder="..." name="notes" maxlength="100"></textarea> 
          <br><br><br>

          <button type="button" onclick="nextPage()">Next</button>
        </div>
          <!-- Pagina 9 della form -->
          <div class="form-page" style="text-align: center;" id="page9">
              <h4>Summary</h4>
              <br><br>
              <div id="summary-content">
                <p id="summary-headache-date"></p>
                <p id="summary-starting-time"></p>
                <p id="summary-ending-time"></p>
                <p id="summary-still-going"></p>
                <p id="summary-ache-position"></p>
                <p id="summary-ache-intensity"></p>
                <p id="summary-ache-type"></p>
                <p id="summary-painkillers"></p>
                <p id="summary-repercussions"></p>
                <p id="summary-symptoms"></p>
                <p id="summary-notes"></p>
            </div>


            <!-- Campi nascosti per memorizzare i valori concatenati -->
            <input type="hidden" id="ache_position_hidden" name="ache_position_hidden">
            <input type="hidden" id="ache_type_hidden" name="ache_type_hidden">
            <input type="hidden" id="painkillers_hidden" name="painkillers_hidden">
            <input type="hidden" id="repercussions_hidden" name="repercussions_hidden">

              <button type="submit">Submit</button>
          </div>

          
      </form>
  </div>
</div>

<script src="headaches.js"></script>


<script>
   
   function updateConcatenatedValues(group) {
    var inputs = document.querySelectorAll(`input[name="${group}"]`);
    var textarea = document.querySelector(`textarea[oninput="updateConcatenatedValues('${group}')"]`);
    var values = [];

    if (textarea && textarea.value) {
        values.push(textarea.value);
    }

    inputs.forEach((input) => {
        if (input.checked) {
            values.push(input.value);
        }
    });

    document.getElementById(`${group}_hidden`).value = values.join(';');
}

 
  </script>

  
</body>
</html>