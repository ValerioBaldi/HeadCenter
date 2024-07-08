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
    <title>Coffee Recordings</title>


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
                <a class="nav-link" href="calendarPage.php">Calendario delle registrazioni</a>
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

   <strong><h1 class="fw-bolder text-center" style="color:rgb(80, 197, 255)">Registra qualità del sonno</h1></strong>


   <img src="../2 images/logo.png" class="top-left-logo">


  <!-- language selection -->
    <div class="language">
      <br><br><br><br>
    <a class="nav-link dropdown-toggle" href="#" role="button"
      data-bs-toggle="dropdown" aria-expanded="false">
       Lingua
      </a>
      <ul class="dropdown-menu text-center">
      <li><a class="dropdown-item" href="../coffeePage.php">English</a></li>
      <li><a class="dropdown-item" href="coffeePage.php">Italiano</a></li>
      </ul>
    </div>
    <br><br>

    <!-- info point -->
    <img src="../2 images/question.png" alt="description" class="bottom-right-image">

    <?php
        echo "<h6 class=\"bottom-left-logged\">Accesso effetuato come: '$username'</h6>";
    ?>

<div class="container">
  <div class="summary">
    <h2>Sommario</h2>
    <ul id="summary-list">
        <li class="summary-item active">Durata</li>
        <li class="summary-item">Tazze di caffè</li>
        <li class="summary-item">Qualità del sonno</li>
        <li class="summary-item">Risveglio dal sonno</li>
    </ul>
  </div>



  <div class="form-container">
      <form id="multi-step-form" action = "coffee.php" method = "POST" name = "coffee">

          <div class="form-page" style="text-align: center;" id="page1">
              <h4 >Quanto hai dormito?</h4>
              <br><br>
              <label for="sleeping_date">Data:</label>
              <input type="date" id="sleeping_date" name="sleeping_date" required>
              <br><br>
              <label for="sleeping_time_from">Da:</label>
              <input type="time" id="sleeping_time_from" name="sleeping_time_from" required />
              <br><br>
              <label for="sleeping_time_to">A:</label>
              <input type="time" id="sleeping_time_to" name="sleeping_time_to" required />
              <br><br><br>
              <button type="button" onclick="nextPage()">Next</button>
          </div>
          <!-- Pagina 2 della form -->
          <div class="form-page" style="text-align: center;" id="page2">
              <h4 >Quante tazze di caffè hai bevuto?</h4>
              <br><br>
              <label for="coffee_cups1">1-2</label>
              <input type="radio" id="coffee_cups1" name="coffee_cups" value="1-2" >
              <br><br>
              <label for="coffee_cups2">3-4</label>
              <input type="radio" id="coffee_cups2" name="coffee_cups" value="3-4" >
              <br><br>
              <label for="coffee_cups3">5-7</label>
              <input type="radio" id="coffee_cups3" name="coffee_cups" value="5-7" >
              <br><br>
              <label for="coffee_cups4">More than 7</label>
              <input type="radio" id="coffee_cups4" name="coffee_cups" value="More than 7" >
              <br><br>
              <label for="coffee_cups6">I didn't have coffee</label>
              <input type="radio" id="coffee_cups6" name="coffee_cups" value="I didn't have coffee" >
                  
                
              <br><br><br>

              <button type="button" onclick="nextPage()">Next</button>
          </div>

          <!--pagina 3-->
          <div class="form-page" style="text-align: center;" id="page3">
            <h4 >In una scala da 1 a 5 come valuti il tuo sonno?</h4>
            <br><br>
            

            <label style="margin-right: 10px;" for="type1">1</label>
            <input style="margin-right: 20px;" type="radio" id="type1" name="sleeping_rate" value="1" >
           
            <label style="margin-right: 10px;" for="type2">2</label>
            <input style="margin-right: 20px;" type="radio" id="type2" name="sleeping_rate" value="2" >
            
            <label style="margin-right: 10px;" for="type3">3</label>
            <input style="margin-right: 20px;" type="radio" id="type3" name="sleeping_rate" value="3" >
            
            <label style="margin-right: 10px;" for="type4">4</label>
            <input style="margin-right: 20px;" type="radio" id="type4" name="sleeping_rate" value="4" >
            
            <label style="margin-right: 10px;" for="type5">5</label>
            <input style="margin-right: 20px;" type="radio" id="type5" name="sleeping_rate" value="5" >
            
            <br><br><br>
            <button type="button" onclick="nextPage()">Next</button>
        </div>
          <!-- Pagina 4 della form -->
          <div class="form-page" style="text-align: center;" id="page4">
              <h4>Ti sei svegliato durante il sonno?</h4>
              <br><br>
              <label for="awaken_during_sleep1">Sì</label>
            <input type="radio" id="usage1" name="awaken_during_sleep" value="sì" >
            <br><br>
            <label for="awaken_during_sleep2">No</label>
            <input type="radio" id="usage2" name="awaken_during_sleep" value="no" >
          
            <br><br><br>
            

              <button type="submit">Invia</button>
          </div>


      </form>
  </div>
</div>
<script src="coffee.js"></script>
</body>
</html>