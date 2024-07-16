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
    <title> registrazione mal di testa</title>
    

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
                <a class="nav-link" href="DownloadPage.php">Seleziona registrazioni da scaricare</a>
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
            </ul>
          </div>
        </div>
  
    </nav>


<br>
<br>
    <!--titoletto-->
   
   <strong><h1 class="fw-bolder text-center" style="color:rgb(80, 197, 255)"> Registrazione mal di testa</h1></strong>
   
   
   <img src="../2 images/logo.png" class="top-left-logo">


  <!-- language selection -->
    <div class="language">
      <br><br><br><br>
      <img src="../2 images/italy.png" style="width: 3px0px; height:20px; display: inline-block; vertical-align: middle;"> 
    <a class="nav-link dropdown-toggle" href="#" role="button"
      data-bs-toggle="dropdown" aria-expanded="false"  style=" display: inline-block; vertical-align: middle;">
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
        echo "<h6 class=\"bottom-left-logged\">Accesso effetuato come: $username</h6>";
    ?>

<div class="container">
  <div class="summary">
    <h2>Sommario</h2>
    <ul id="summary-list">
        <li class="summary-item active">Durata</li>
        <li class="summary-item">Posizione</li>
        <li class="summary-item">Intensità</li>
        <li class="summary-item">Tipo di doloro</li>
        <li class="summary-item">Antidolorifici</li>
        <li class="summary-item">Ripercussioni</li>
        <li class="summary-item">Sintomi</li>
        <li class="summary-item">Note</li>
        <li class="summary-item">Riassunto</li>
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
              <h4 >Quando è iniziato?</h4>
              <br><br>
              <label for="digital_date">Data:</label>
              <input type="date" id="headache_date" name="headache_date" required>
              <br><br>
              <label for="starting_time">Da:</label>
              <input type="time" id="starting_time" name="starting_time" required />
              <br><br>
              <label for="ending_time">A:</label>
              <input type="time" id="ending_time" name="ending_time" />
              <br><br>
              <label for="still_going"> È ancora in corso?</label>
              <input type="checkbox" id="still_going" name="still_going" value="true">
              <br><br><br>
              <button type="button" onclick="nextPage()">Continua</button>
          </div>
          <!-- Pagina 2 della form -->
          <div class="form-page" style="text-align: center;" id="page2">
              <h4 >Dove senti il dolore?</h4>
              <br><br>
              <div class="container-fluid">
                <div class="row justify-content-between">
                  <div class="col-sm-4">
        
              <label for="symptom1">Fronte destra</label>
              <input type="checkbox" id="symptom1" name="ache_position" value="Fronte destra" onclick="updateConcatenatedValues('ache_position')">
              <br><br>
              <label for="symptom2">Collo destro</label>
              <input type="checkbox" id="symptom2" name="ache_position" value="Collo destro" onclick="updateConcatenatedValues('ache_position')">
              <br><br>
              <label for="symptpm3">Tempie</label>
              <input type="checkbox" id="symptom3" name="ache_position" value="Tempie" onclick="updateConcatenatedValues('ache_position')">
              <br><br>
              </div>
              <div class="col-sm-4">

              <label for="symptom4">Fronte sinistra</label>
              <input type="checkbox" id="symptom4" name="ache_position" value="Fronte sinistra" onclick="updateConcatenatedValues('ache_position')">
              <br><br>
              <label for="symptom5">Collo sinistro</label>
              <input type="checkbox" id="symptom5" name="ache_position" value="Collo sinistro" onclick="updateConcatenatedValues('ache_position')">
              <br><br>
              <label for="symptom6"> Centro della testa</label>
              <input type="checkbox" id="symptom6" name="ache_position" value="Centro della testa" onclick="updateConcatenatedValues('ache_position')">
                  </div>
                </div>
              </div>
              <br><br>

              <button type="button" onclick="nextPage()">Continua</button>
          </div>

          <!--pagina 3-->
          <div class="form-page" style="text-align: center;" id="page3">
            <h4>Quanto fa male?</h4>
            <br><br>
          <label for="usage1">Poco</label>
          <input type="radio" id="ache1" name="ache_intensity" value="Poco">
          <br><br>
          <label for="usage2">Mediamente</label>
          <input type="radio" id="ache2" name="ache_intensity" value="Mediamente">
          <br><br>
          <label for="usage3">Tanto</label>
          <input type="radio" id="ache3" name="ache_intensity" value="Tanto">
          <br><br><br>

          <button type="button" onclick="nextPage()">Continua</button>
        </div>
        <!-- pagina 4 -->
        <div class="form-page" style="text-align: center;" id="page4">
            <h4 >Che tipo di dolore senti?</h4>
            <br><br>
            <div class="container-fluid">
              <div class="row justify-content-between">
                <div class="col-sm-4">
      
            <label for="symptom1">Costrittivo</label>
            <input type="checkbox" id="symptom1" name="ache_type" value="Costrittivo" onclick="updateConcatenatedValues('ache_type')">
            <br><br>
            <label for="symptom2">Pulsante</label>
            <input type="checkbox" id="symptom2" name="ache_type" value="Pulsante" onclick="updateConcatenatedValues('ache_type')">
            <br><br>
            </div>
            <div class="col-sm-4">

            <label for="symptom4">Nevralgico</label>
            <input type="checkbox" id="symptom4" name="ache_type" value="Nevralgico" onclick="updateConcatenatedValues('ache_type')">
            <br><br>
            <label for="symptom5">Penetrante</label>
            <input type="checkbox" id="symptom5" name="ache_type" value="Penetrante" onclick="updateConcatenatedValues('ache_type')">
            <br><br><br>
               </div>
              </div>
            </div>
            <button type="button" onclick="nextPage()">Continua</button>
        </div>
        <!-- pagina 5 -->
        <div class="form-page" style="text-align: center;" id="page5">
            <h4 >Hai assunto degli antidolorifici?</h4>
            <br><br>
            <div class="container-fluid">
              <div class="row justify-content-between">
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
            <textarea rows="5" columns="25" placeholder="Se sì, che Antidolorifici hai assunto" maxlength="100" name="painkillers" oninput="updateConcatenatedValues('painkillers')"></textarea> 
            <br><br><br>
            <button type="button" onclick="nextPage()">Continua</button>
        </div>
        <!--pagina 6-->
        <div class="form-page" style="text-align: center;" id="page6">
            <h4>Il dolore ha avuto qualche ripercussione?</h4>
            <br><br>
            <label for="usage1"> Pegiori performance a lavoro o con lo studio</label>
          <input type="checkbox" id="usage1" name="repercussions" value="Pegiori performance a lavoro o con lo studio" onclick="updateConcatenatedValues('repercussions')">
          <br><br>
          <label for="usage2"> Impossibilitato a lavorare e/o studiare</label>
          <input type="checkbox" id="usage2" name="repercussions" value="Impossibilitato a lavorare e/o studiare" onclick="updateConcatenatedValues('repercussions')">
          <br><br>
          <label for="usage3">Costretto a riposarmi</label>
          <input type="checkbox" id="usage3" name="repercussions" value="Costretto a riposarmi" onclick="updateConcatenatedValues('repercussions')">
          <br><br>
          <label for="usage2"> Problemi col sonno</label>
          <input type="checkbox" id="usage2" name="repercussions" value="Problemi col sonno" onclick="updateConcatenatedValues('repercussions')">
          <br><br>
          <label for="usage2">Aggiungi altro:</label>
          <br><br>
          <textarea rows="5" columns="25" placeholder="..." name="repercussions" oninput="updateConcatenatedValues('repercussions')" maxlength="100"></textarea> 
          <br><br><br>

          <button type="button" onclick="nextPage()">Continua</button>
        </div>
        <!--pagina 7-->
        <div class="form-page" style="text-align: center;" id="page7">
            <h4>Hai percepito qualche altro sintomo?</h4>
            <br><br>
          <textarea rows="5" columns="25" placeholder="..." name="symptoms" maxlength="100"></textarea> 
          <br><br><br>

          <button type="button" onclick="nextPage()">Continua</button>
        </div>
        <!--pagina 8-->
        <div class="form-page" style="text-align: center;" id="page8">
            <h4>Aggiungi una nota</h4>
            <br><br>
          <textarea rows="5" columns="25" placeholder="..." name="notes" maxlength="100"></textarea> 
          <br><br><br>

          <button type="button" onclick="nextPage()">Continua</button>
        </div>
          <!-- Pagina 9 della form -->
          <div class="form-page" style="text-align: center;" id="page9">
              <h4>Sommario</h4>
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

              <button type="submit">Registra</button>
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