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
    <title>Registra mal di testa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../1 bootstrap/css/bootstrap.css" />
    <script src="../1 bootstrap/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../digital.css" />
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
            <a class="nav-link" href="headachePage.php">Registra mal di testa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="DownloadPage.php">Scarica registrazione</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="coffeePage.php">Registra qualità del sonno</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="digitalPage.php">Registra uso di dispositivi digitali</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="calendar.php">Calendario registrazioni</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <br><br>
  <strong><h1 class="fw-bolder text-center" style="color:rgb(80, 197, 255)">Registra mal di testa</h1></strong>
  <img src="../2 images/logo.png" class="top-left-logo">

  <!-- language selection -->
  <div class="language">
    <br><br><br><br>
    <img src="../2 images/italy.png" style="width: 3px0px; height:20px; display: inline-block; vertical-align: middle;">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false" style=" display: inline-block; vertical-align: middle;">
      Lingua
    </a>
    <ul class="dropdown-menu text-center">
      <li><a class="dropdown-item" href="../headachePage.php">English</a></li>
      <li><a class="dropdown-item" href="headachePage.php">Italiano</a></li>
    </ul>
  </div>
  <br><br>

  <!-- info point -->
  <img src="../2 images/question.png" alt="description" class="bottom-right-image">

  <?php
      echo "<h6 class=\"bottom-left-logged\">Logged in as: $username</h6>";
  ?>

  <div>
    <div class="summary">
        <h2>Summary</h2>
        <ul id="summary-list">
            <li class="summary-item active" onclick="scrollToSection('1')">Durata</li>
            <li class="summary-item" onclick="scrollToSection('2')">Posizione</li>
            <li class="summary-item" onclick="scrollToSection('3')">Intensità</li>
            <li class="summary-item" onclick="scrollToSection('4')">Tipologia di dolore</li>
            <li class="summary-item" onclick="scrollToSection('5')">Antidolorifici</li>
            <li class="summary-item" onclick="scrollToSection('6')">Ripercussioni</li>
            <li class="summary-item" onclick="scrollToSection('7')">Sintomi</li>
            <li class="summary-item" onclick="scrollToSection('8')">Note</li>
            <li class="summary-item" onclick="scrollToSection('9')">Riassunto</li>
        </ul>
    </div>

    <div class="form-container2">
        <form id="multi-step-form" action="headache.php" method="POST" name="headache">
            <!-- Pagina 1 della form -->
            <div id="1">
                <h4>Quando è iniziato?</h4>
                <br><br>
                <label for="headache_date">Data:</label>
                <input type="date" id="headache_date" name="headache_date" required onchange="updateSummary()">
                <br><br>
                <label for="starting_time">Da:</label>
                <input type="time" id="starting_time" name="starting_time" required onchange="updateSummary()">
                <label for="ending_time">A:</label>
                <input type="time" id="ending_time" name="ending_time" onchange="updateSummary()">
                <br><br>
                <label for="still_going">Ancora fa male?</label>
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
                            <label for="symptom1">Fronte destra</label>
                            <input type="checkbox" id="symptom1" name="ache_position" value="Fronte destra" onclick="updateConcatenatedValues('ache_position')">
                            <br><br>
                            <label for="symptom2">Collo sinistro</label>
                            <input type="checkbox" id="symptom2" name="ache_position" value="Collo sinistro" onclick="updateConcatenatedValues('ache_position')">
                            <br><br>
                            <label for="symptom3">Tempie</label>
                            <input type="checkbox" id="symptom3" name="ache_position" value="Tempie" onclick="updateConcatenatedValues('ache_position')">
                            <br><br>
                        </div>
                        <div class="col-sm-4">
                            <label for="symptom4">Fronte sinistra</label>
                            <input type="checkbox" id="symptom4" name="ache_position" value="Fronte sinistra" onclick="updateConcatenatedValues('ache_position')">
                            <br><br>
                            <label for="symptom5">Collo destro</label>
                            <input type="checkbox" id="symptom5" name="ache_position" value="Collo destro" onclick="updateConcatenatedValues('ache_position')">
                            <br><br>
                            <label for="symptom6">Nuca</label>
                            <input type="checkbox" id="symptom6" name="ache_position" value="Nuca" onclick="updateConcatenatedValues('ache_position')">
                            <br><br>
                        </div>
                    </div>
                    <input type="hidden" id="ache_position_hidden" name="ache_position_hidden">
                </div>
            </div>

            <!-- Pagina 3 della form -->
            <div  id="3">
                <h4>Quanto fa male?</h4>
                <br><br>
                <label for="usage1">Poco</label>
                <input type="radio" id="ache1" name="ache_intensity" value="Poco">
                <br><br>
                <label for="usage2">Medio</label>
                <input type="radio" id="ache2" name="ache_intensity" value="Medio">
                <br><br>
                <label for="usage3">Molto</label>
                <input type="radio" id="ache3" name="ache_intensity" value="Molto">
                <br><br>
            </div>

            <!-- Pagina 4 della form -->
            <div  id="4">
                <h4>Che tipologia di dolore senti?</h4>
                <br><br>
                <label for="symptom1">Costrittivo</label>
                <input type="checkbox" id="symptom1" name="ache_type" value="Costrittivo" onclick="updateConcatenatedValues('ache_type')">
                <br><br>
                <label for="symptom2">Pulsante</label>
                <input type="checkbox" id="symptom2" name="ache_type" value="Pulsante" onclick="updateConcatenatedValues('ache_type')">
                <br><br>
                <label for="symptom4">Nevralgico</label>
                <input type="checkbox" id="symptom4" name="ache_type" value="Nevralgico" onclick="updateConcatenatedValues('ache_type')">
                <br><br>
                <label for="symptom5">Pungente</label>
                <input type="checkbox" id="symptom5" name="ache_type" value="Pungente" onclick="updateConcatenatedValues('ache_type')">
                <br><br>
                <input type="hidden" id="ache_type_hidden" name="ache_type_hidden">
            </div>

            <!-- Pagina 5 della form -->
            <div id="5">
                <h4>Hai assunto degli antidolorifici?</h4>
                <br><br>
                <div class="container-fluid">
                  <div class="row justify-content-center">
                    <div class="col-sm-4">
          
                    <label for="symptom1">Sì</label>
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
                    <textarea rows="5" columns="25" placeholder="Se sì, scrivi quali antidolorifici hai assunto" name="painkillers" maxlength="100" oninput="updateConcatenatedValues('painkillers')"></textarea> 
                <br><br>
                <input type="hidden" id="painkillers_hidden" name="painkillers_hidden">
            </div>

            <!-- Pagina 6 della form -->
            <div id="6">
              <h4>Hai avuto ripercussioni?</h4>
              <br><br>
              <label for="usage1">Peggiori performance a lavoro e/o scuola</label>
              <input type="checkbox" id="usage1" name="repercussions" value="Peggiori performance a lavoro e/o scuola" onclick="updateConcatenatedValues('repercussions')">
              <br><br>
              <label for="usage2">Non sono riuscito per nulla a lavorare o studiare</label>
              <input type="checkbox" id="usage2" name="repercussions" value="Non sono riuscito per nulla a lavorare o studiare" onclick="updateConcatenatedValues('repercussions')">
              <br><br>
              <label for="usage3">Ho dovuto riposarmi</label>
              <input type="checkbox" id="usage3" name="repercussions" value="Ho dovuto riposarmi" onclick="updateConcatenatedValues('repercussions')">
              <br><br>
              <label for="usage2">Difficoltà a dormire</label>
              <input type="checkbox" id="usage2" name="repercussions" value="Difficoltà a dormire" onclick="updateConcatenatedValues('repercussions')">
              <br><br>
              <label for="usage2">Aggiungi altro:</label>
              <br><br>
              <textarea rows="5" columns="25" placeholder="..." name="repercussions" oninput="updateConcatenatedValues('repercussions')"></textarea> 
              <br><br><br>
                <input type="hidden" id="repercussions_hidden" name="repercussions_hidden" maxlength="100">
            </div>

            <!-- Pagina 7 della form -->
            <div id="7">
                <h4>Hai percepito altri sintomi?</h4>
                <br><br>
                <textarea id="symptoms" name="symptoms" rows="4" maxlength="100" cols="50" placeholder="..." onchange="updateSummary()"></textarea>
                <br><br>
            </div>

            <!-- Pagina 8 della form -->
            <div id="8">
                <h4>Note</h4>
                <br><br>
                <textarea id="notes" name="notes" rows="4" cols="50" maxlength="100" placeholder="..." onchange="updateSummary()"></textarea>
                <br><br>
            </div>

            <!-- Pagina 9 della form -->
            <div id="9">
                <h4>Riassunto</h4>
                <br><br>
                <p>Data: <span id="summary-headache_date">N/A</span></p>
                <p>Da: <span id="summary-starting_time">N/A</span></p>
                <p>A: <span id="summary-ending_time">N/A</span></p>
                <p>Fa ancora male?: <span id="summary-still_going">N/A</span></p>
                <p>Posizione: <span id="summary-ache_position_hidden">N/A</span></p>
                <p>Intensità: <span id="summary-ache_intensity">N/A</span></p>
                <p>Tipologia di dolore: <span id="summary-ache_type_hidden">N/A</span></p>
                <p>Antidolorifici: <span id="summary-painkillers_hidden">N/A</span></p>
                <p>Ripercussioni: <span id="summary-repercussions_hidden">N/A</span></p>
                <p>Sintomi: <span id="summary-symptoms">N/A</span></p>
                <p>Note: <span id="summary-notes">N/A</span></p>
            </div>

            <input type="submit" value="Submit">
        </form>
    </div>
  </div>
  <script src="headaches.js"></script>
</body>
</html>
