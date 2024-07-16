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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Headache Report Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="1 bootstrap/css/bootstrap.css" />
    <script src="1 bootstrap/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="digital.css" />
    <style>
        .summary {
            position: fixed;
            top: 0;
            right: 0;
            width: 200px;
            background-color: #f8f9fa;
            border-left: 1px solid #dee2e6;
            padding: 20px;
            height: 100%;
            overflow-y: auto;
        }
        .form-container2 {
            margin-right: 220px; /* Space for the summary section */
            text-align: center;
            padding-left: 10%;
        }
        .summary-item {
            cursor: pointer;
            margin-bottom: 10px;
        }
        .summary-item.active {
            font-weight: bold;
        }
    </style>
    <script>
        function scrollToSection(sectionId) {
            document.getElementById(sectionId).scrollIntoView({ behavior: 'smooth' });
        }

        function updateSummary() {
            const summaryFields = [
                'headache_date', 'starting_time', 'ending_time', 'still_going', 
                'ache_position_hidden', 'ache_intensity', 'ache_type_hidden', 
                'painkillers_hidden', 'repercussions_hidden', 'symptoms', 'notes'
            ];

            summaryFields.forEach(field => {
                const element = document.getElementById(field);
                if (element) {
                    document.getElementById('summary-' + field).innerText = element.value || 'N/A';
                }
            });
        }

        function updateConcatenatedValues(name) {
            const checkboxes = document.querySelectorAll(`input[name="${name}"]:checked`);
            const values = Array.from(checkboxes).map(checkbox => checkbox.value).join(', ');
            document.getElementById(name + '_hidden').value = values;
            updateSummary();
        }
    </script>
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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

  <br><br>
  <strong><h1 class="fw-bolder text-center" style="color:rgb(80, 197, 255)">Headache Recording</h1></strong>
  <img src="2 images/logo.png" class="top-left-logo">

  <!-- language selection -->
  <div class="language">
    <br><br><br><br>
    <img src="2 images/uk.png" style="width: 3px0px; height:20px; display: inline-block; vertical-align: middle;"> 
    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false" style=" display: inline-block; vertical-align: middle;">
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

  <div style= "background-color: rgb(204, 247, 247); ; border: 2px solid black;">
    <div class="summary">
        <h2>Summary</h2>
        <ul id="summary-list">
            <li class="summary-item active" onclick="scrollToSection('1')">Duration</li>
            <li class="summary-item" onclick="scrollToSection('2')">Location</li>
            <li class="summary-item" onclick="scrollToSection('3')">Intensity</li>
            <li class="summary-item" onclick="scrollToSection('4')">Type of pain</li>
            <li class="summary-item" onclick="scrollToSection('5')">Painkillers</li>
            <li class="summary-item" onclick="scrollToSection('6')">Repercussion</li>
            <li class="summary-item" onclick="scrollToSection('7')">Symptoms</li>
            <li class="summary-item" onclick="scrollToSection('8')">Additional</li>
            <li class="summary-item" onclick="scrollToSection('9')">Brief</li>
        </ul>
    </div>

    <div class="form-container2">
        <form id="multi-step-form" action="headache.php" method="POST" name="headache">
            <!-- Pagina 1 della form -->
            <div id="1">
                <h4>When has it started?</h4>
                <br><br>
                <label for="headache_date">Date:</label>
                <input type="date" id="headache_date" name="headache_date" required onchange="updateSummary()">
                <br><br>
                <label for="starting_time">From:</label>
                <input type="time" id="starting_time" name="starting_time" required onchange="updateSummary()">
                <label for="ending_time">To:</label>
                <input type="time" id="ending_time" name="ending_time" onchange="updateSummary()">
                <br><br>
                <label for="still_going">Is it still going?</label>
                <input type="checkbox" id="still_going" name="still_going" value="true" onchange="updateSummary()">
                <br><br>
            </div>

            <!-- Pagina 2 della form -->
            <div id="2">
                <h4>Where do you feel the pain?</h4>
                <br><br>
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-sm-4">
                            <label for="symptom1">Right forehead</label>
                            <input type="checkbox" id="symptom1" name="ache_position" value="Right forehead" onclick="updateConcatenatedValues('ache_position')">
                            <br><br>
                            <label for="symptom2">Neck left</label>
                            <input type="checkbox" id="symptom2" name="ache_position" value="Neck left" onclick="updateConcatenatedValues('ache_position')">
                            <br><br>
                            <label for="symptom3">Temples</label>
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
                            <br><br>
                        </div>
                    </div>
                    <input type="hidden" id="ache_position_hidden" name="ache_position_hidden">
                </div>
            </div>

            <!-- Pagina 3 della form -->
            <div  id="3">
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
                <br><br>
            </div>

            <!-- Pagina 4 della form -->
            <div  id="4">
                <h4>What kind of pain do you have?</h4>
                <br><br>
                <label for="symptom1">Constrictive</label>
                <input type="checkbox" id="symptom1" name="ache_type" value="Constrictive" onclick="updateConcatenatedValues('ache_type')">
                <br><br>
                <label for="symptom2">Pulsating</label>
                <input type="checkbox" id="symptom2" name="ache_type" value="Pulsating" onclick="updateConcatenatedValues('ache_type')">
                <br><br>
                <label for="symptom4">Nevralgic</label>
                <input type="checkbox" id="symptom4" name="ache_type" value="Nevralgic" onclick="updateConcatenatedValues('ache_type')">
                <br><br>
                <label for="symptom5">Piercing</label>
                <input type="checkbox" id="symptom5" name="ache_type" value="Piercing" onclick="updateConcatenatedValues('ache_type')">
                <br><br>
                <input type="hidden" id="ache_type_hidden" name="ache_type_hidden">
            </div>

            <!-- Pagina 5 della form -->
            <div id="5">
                <h4>Have you taken any painkillers?</h4>
                <br><br>
                <div class="container-fluid">
                  <div class="row justify-content-center">
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
                <br><br>
                <input type="hidden" id="painkillers_hidden" name="painkillers_hidden">
            </div>

            <!-- Pagina 6 della form -->
            <div id="6">
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
              <textarea rows="5" columns="25" placeholder="..." name="repercussions" oninput="updateConcatenatedValues('repercussions')"></textarea> 
              <br><br><br>
                <input type="hidden" id="repercussions_hidden" name="repercussions_hidden" maxlength="100">
            </div>

            <!-- Pagina 7 della form -->
            <div id="7">
                <h4>Did you experience any symptoms?</h4>
                <br><br>
                <textarea id="symptoms" name="symptoms" rows="4" maxlength="100" cols="50" placeholder="Describe any symptoms..." onchange="updateSummary()"></textarea>
                <br><br>
            </div>

            <!-- Pagina 8 della form -->
            <div id="8">
                <h4>Additional Notes</h4>
                <br><br>
                <textarea id="notes" name="notes" rows="4" cols="50" maxlength="100" placeholder="Any additional notes..." onchange="updateSummary()"></textarea>
                <br><br>
            </div>

            <!-- Pagina 9 della form -->
            <div id="9">
                <h4>Brief Summary</h4>
                <br><br>
                <p>Date: <span id="summary-headache_date">N/A</span></p>
                <p>From: <span id="summary-starting_time">N/A</span></p>
                <p>To: <span id="summary-ending_time">N/A</span></p>
                <p>Is it still going?: <span id="summary-still_going">N/A</span></p>
                <p>Ache Position: <span id="summary-ache_position_hidden">N/A</span></p>
                <p>Intensity: <span id="summary-ache_intensity">N/A</span></p>
                <p>Ache Type: <span id="summary-ache_type_hidden">N/A</span></p>
                <p>Painkillers: <span id="summary-painkillers_hidden">N/A</span></p>
                <p>Repercussions: <span id="summary-repercussions_hidden">N/A</span></p>
                <p>Symptoms: <span id="summary-symptoms">N/A</span></p>
                <p>Notes: <span id="summary-notes">N/A</span></p>
            </div>

            <input type="submit" value="Submit">
        </form>
    </div>
  </div>
  <script src="headaches.js"></script>
</body>
</html>
