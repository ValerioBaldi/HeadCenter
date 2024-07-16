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
    <link rel="icon" href="../2 images/senzabordo.png">
    <link rel = "stylesheet" href = "../style.css" />
    <link rel = "stylesheet" href = "../digital.css" />
    <title>OK</title>
    

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
            </ul>
          </div>
        </div>
  
    </nav>


<br>
<br>
    <!--titoletto-->
   
   <strong><h1 class="fw-bolder text-center" style="color:rgb(80, 197, 255)">Registrazione riuscita!</h1></strong>
   
   
   <img src="../2 images/logo.png" class="top-left-logo">


  <!-- language selection -->
    <div class="language">
      <br><br><br><br>
      <img src="../2 images/italy.png" style="width: 3px0px; height:20px; display: inline-block; vertical-align: middle;">
    <a class="nav-link dropdown-toggle" href="#" role="button"
      data-bs-toggle="dropdown" aria-expanded="false" style=" display: inline-block; vertical-align: middle;">
       Lingua
      </a>
      <ul class="dropdown-menu text-center">
      <li><a class="dropdown-item" href="../Home.php">English</a></li>
      <li><a class="dropdown-item" href="Home.php">Italiano</a></li>
      </ul>
    </div>
    <br><br>

    <!-- info point -->
    <img src="../2 images/question.png" alt="description" class="bottom-right-image">

    <?php
        echo "<h6 class=\"bottom-left-logged\">Accesso effetuato come: $username</h6>";
    ?>

<br><br><br>
<h4 style="text-align: center;"> La tua registrazione è andata a buon fine.
    Clicca <a href="Home.php" >qui</a> per tornare alla home.</h4>
</body>
</html>