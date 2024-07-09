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

    <link rel="stylesheet" href="../1 bootstrap/css/bootstrap.css" />
    <script src="../1 bootstrap/js/bootstrap.bundle.js"></script>
    <!-- <link rel="icon" href="2 images/senzabordo.png"> -->
    <link rel = "stylesheet" href = "../style.css" />
    <link rel = "stylesheet" href = "../digital.css" />
    <title>Digital Devices Recording</title>
    

   <!--  <script type="text/javascript" language="javascript">

/* controllo validità nei form */
        function validaIscrizione() {
        var email=document.iscrizione.email.value;
        var email_valid= /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-]{2,})+.)+([a-zA-Z0-9]{2,})+$/;
        var telefono=document.iscrizione.telefono.value;
        var telefono_valid= /^[0-9]{1,10}.[0-9]{2}$/;
        if (!email_valid.test(email)) {
        alert("E-mail non valida");
        document.iscrizione.email.focus();
        return false;
        }
        if(email==""){
            alert("Inserisci e-mail");
            document.iscrizione.email.focus();
            return false;
        }
        if (document.iscrizione.nome.value==""){
            alert("Inserisci il nome");
            document.iscrizione.nome.focus();
            return false;
        }
        if (document.iscrizione.cognome.value==""){
            alert("Inserisci il cognome");
            document.iscrizione.cognome.focus();
            return false;
        }
        if (document.iscrizione.DataDiNascita.value==""){
            alert("Inserisci la data di nascita");
            document.iscrizione.DataDiNascita.focus();
            return false;
        }
        if (!telefono_valid.test(telefono)) {
        alert("Telefono non valido");
        document.iscrizione.telefono.focus();
        return false;
        }
        if (document.iscrizione.classe.value==""){
            alert("Scegli la classe");
            document.iscrizione.classe.focus();
            return false;
        }
        /*alert("Dati inseriti correttamente");*/
        return true;
        }


        function validaCollabora() {
        var email=document.collabora.email.value;
        var email_valid= /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-]{2,})+.)+([a-zA-Z0-9]{2,})+$/;
        if (!email_valid.test(email)) {
        alert("E-mail non valida");
        document.collabora.email.focus();
        return false;
        }
        if(email==""){
            alert("Inserisci e-mail");
            document.collabora.email.focus();
            return false;
        }
        if (document.collabora.descrizione.value==""){
            alert("Compila la descrizione");
            document.collabora.descrizione.focus();
            return false;
        }
        alert("Dati inseriti correttamente");
        return true;
        }
        </script>
 -->
 
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
                <a class="nav-link" href="headachePage.php">Registra mal di testa</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="DownloadPage.php">Scarica una registrazione</a>
            </li>
              <li class="nav-item">
                <a class="nav-link" href="coffeePage.php">Registra qualità del sonno</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="digitalPage.php">Registra uso di dispositivi digitali</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="calendar.php">Calendario delle registrazioni</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="settings.html">Impostazioni</a>
              </li>
            </ul>
          </div>
        </div>
  
    </nav>


<br>
<br>
    <!--titoletto-->
   
   <strong><h1 class="fw-bolder text-center" style="color:rgb(80, 197, 255)">Digital Devices Recording</h1></strong>
   
   
   <img src="../2 images/logo.png" class="top-left-logo">


  <!-- language selection -->
    <div class="language">
      <br><br><br><br>
    <a class="nav-link dropdown-toggle" href="#" role="button"
      data-bs-toggle="dropdown" aria-expanded="false">
       Lingua
      </a>
      <ul class="dropdown-menu text-center">
      <li><a class="dropdown-item" href="../digitalPage.php">English</a></li>
      <li><a class="dropdown-item" href="digitalPage.php">Italiano</a></li>
      </ul>
    </div>
    <br><br>

    <!-- info point -->
    <img src="../2 images/question.png" alt="description" class="bottom-right-image">

    <?php
        echo "<h6 class=\"bottom-left-logged\">Accesso effetuato come: $username</h6>";
    ?>

<div class="container">
  <div class="summary">
    <h2>Summary</h2>
    <ul id="summary-list">
        <li class="summary-item active">Durata</li>
        <li class="summary-item">Sintomi</li>
        <li class="summary-item">Tipi di dispositivi</li>
        <li class="summary-item">Motivo</li>
    </ul>
  </div>

<!--   report_id int NOT NULL,
  digital_usage_from timestamp NOT NULL,
  digital_usage_to timestamp NOT NULL,
  symptoms char(100),
  devices_type char(40) NOT NULL,
  usage_for char(30) NOT NULL 

    -->

  <div class="form-container">
      <form id="multi-step-form" action = "digital.php" method = "POST" name = "digital">
          <!-- Pagina 1 della form -->
          <div class="form-page" style="text-align: center;" id="page1">
              <h4 >Quando hai usato dei dispositivi digitali?</h4>
              <br><br>
              <label for="digital_date">Data:</label>
              <input type="date" id="digital_date" name="digital_date" required>
              <br><br>
              <label for="digital_usage_from">Da:</label>
              <input type="time" id="digital_usage_from" name="digital_usage_from" required />
              <br><br>
              <label for="digital_usage_to">A:</label>
              <input type="time" id="digital_usage_to" name="digital_usage_to" required />
              <br><br><br>
              <button type="button" onclick="nextPage()">Continua</button>
          </div>
          <!-- Pagina 2 della form -->
          <div class="form-page" style="text-align: center;" id="page2">
              <h4 >Che sintomi hai sperimentato?</h4>
              <br><br>
              <div class="container-fluid">
                <div class="row justify-content-between">
                  <div class="col-sm-4">
        
              <label for="symptom1">Nessun sintomo</label>
              <input type="checkbox" id="symptom1" name="symptoms" value="Nessun sintomo" onclick="updateConcatenatedValues('symptoms')">
              <br><br>
              <label for="symptom2">Occhi arrossati</label>
              <input type="checkbox" id="symptom2" name="symptoms" value="Occhi arrossati" onclick="updateConcatenatedValues('symptoms')">
              <br><br>
              <label for="symptpm3">Mal di testa</label>
              <input type="checkbox" id="symptom3" name="symptoms" value="Mal di testa" onclick="updateConcatenatedValues('symptoms')">
              <br><br>
              </div>
              <div class="col-sm-4">

              <label for="symptom4">Mal di schiena</label>
              <input type="checkbox" id="symptom4" name="symptoms" value="Mal di schiena" onclick="updateConcatenatedValues('symptoms')">
              <br><br>
              <label for="symptom5">Dolore al collo</label>
              <input type="checkbox" id="symptom5" name="symptoms" value="Dolore al collo" onclick="updateConcatenatedValues('symptoms')">
              <br><br>
              <label for="symptom6">Altro</label>
              <input type="checkbox" id="symptom6" name="symptoms" value="Altro" onclick="updateConcatenatedValues('symptoms')">
                  </div>
                </div>
              </div>
              <br><br>

              <button type="button" onclick="nextPage()">Continua</button>
          </div>

          <!--pagina 3-->
          <div class="form-page" style="text-align: center;" id="page3">
            <h4 >Che tipo di dispositivi hai usato?</h4>
            <br><br>
            <div class="container-fluid">
              <div class="row justify-content-between">
          
                   
                <div class="col-sm-4">
      
            <label for="type1">Smartphone</label>
            <input type="checkbox" id="type1" name="devices_type" value="Smartphone" onclick="updateConcatenatedValues('devices_type')">
            <br><br>
            <label for="type2">Computer</label>
            <input type="checkbox" id="type2" name="devices_type" value="Computer" onclick="updateConcatenatedValues('devices_type')">
            <br><br>
            <label for="type3">Tablet</label>
            <input type="checkbox" id="type3" name="devices_type" value="Tablet" onclick="updateConcatenatedValues('devices_type')">
            <br><br>
                </div>
                <div class="col-sm-4">

            <label for="type4">Videogiochi</label>
            <input type="checkbox" id="type4" name="devices_type" value="Videogame console" onclick="updateConcatenatedValues('devices_type')">
            <br><br>
            <label for="type5">Lettore e-book </label>
            <input type="checkbox" id="type5" name="devices_type" value="Lettore E-book" onclick="updateConcatenatedValues('devices_type')">
            <br><br>
            <label for="type6">Altro</label>
            <input type="checkbox" id="type6" name="devices_type" value="Altro" onclick="updateConcatenatedValues('devices_type')">
                </div>
              </div>
            </div>
            <br><br>
            <button type="button" onclick="nextPage()">Continua</button>
        </div>
          <!-- Pagina 4 della form -->
          <div class="form-page" style="text-align: center;" id="page4">
            <h4>Per cosa li hai utilizzati?</h4>
            <br><br>
            <label for="usage1">Lavoro</label>
            <input type="radio" id="usage1" name="usage_for" value="Lavoro" onclick="updateConcatenatedValues('usage_for')">
            <br><br>
            <label for="usage2">Intrattenimento</label>
            <input type="radio" id="usage2" name="usage_for" value="Intrattenimento" onclick="updateConcatenatedValues('usage_for')">
            <br><br>
            <label for="usage3">Entrambia</label>
            <input type="radio" id="usage3" name="usage_for" value="Sia lavoro che intrattenimento" onclick="updateConcatenatedValues('usage_for')">
            <br><br><br>

            <!-- Campi nascosti per memorizzare i valori concatenati -->
            <input type="hidden" id="symptoms_hidden" name="symptoms_hidden">
            <input type="hidden" id="devices_type_hidden" name="devices_type_hidden">
            <input type="hidden" id="usage_for_hidden" name="usage_for_hidden">

              <button type="submit">Registra</button>
          </div>

          
      </form>
  </div>
</div>

<script src="digitals.js"></script>


<script>
   
  function updateConcatenatedValues(group) {
      var checkboxes = document.querySelectorAll(`input[name="${group}"]`);
      var values = [];
      checkboxes.forEach((checkbox) => {
          if (checkbox.checked) {
              values.push(checkbox.value);
          }
      });
      document.getElementById(`${group}_hidden`).value = values.join(';');
  }
 
  </script>

  
</body>
</html>
