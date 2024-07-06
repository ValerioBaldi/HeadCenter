<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario</title>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales/it.js'></script>
    <link rel="stylesheet" href="../1 bootstrap/css/bootstrap.css" />
    <script src="../1 bootstrap/js/bootstrap.bundle.js"></script>
    <link rel="icon" href="../2 images/senzabordo.png">
    <link rel = "stylesheet" href = "../style.css" />
    <link rel = "stylesheet" href = "../digital.css" />
</head>
<body>

    <?php
        $dbconnect = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=postgres") or die('could not connect: ' . pg_last_error());
        $query = "SELECT report_id as rid, starting_time, ending_time FROM headache";
        $result = pg_query($dbconnect, $query) or die('query failed: ' . pg_last_error());
        $resultArr = pg_fetch_all($result);

        if ($resultArr) {
            $events = array();
            foreach ($resultArr as $array) {
                $events[] = array(
                    'id' => htmlspecialchars($array['rid']),
                    'title' =>  ' ',//'Report ' . htmlspecialchars($array['rid']),
                    'start' => htmlspecialchars($array['starting_time']),
                    'end' => htmlspecialchars($array['ending_time']),
                    'color' => 'red',
                    'type'  => 'Headache'
                );
            }
        } 
        

        pg_free_result($result);

        $query2 = "SELECT report_id as rid, digital_usage_from as starting_time, digital_usage_to as ending_time FROM digital";  // Modifica con il nome della tua tabella
        $result2 = pg_query($dbconnect, $query2) or die('query2 failed: ' . pg_last_error());
        $resultArr2 = pg_fetch_all($result2);

        if ($resultArr2) {
            foreach ($resultArr2 as $array) {
                $events[] = array(
                    'id' => htmlspecialchars($array['rid']),
                    'title' => '', // Imposta il titolo su una stringa vuota
                    'start' => htmlspecialchars($array['starting_time']),
                    'end' => htmlspecialchars($array['ending_time']),
                    'color' => 'green',
                    'type'  => 'Digital'
                );
            }
        }
        pg_free_result($result2);

        $query3 = "SELECT report_id as rid, sleeping_time_from as starting_time, sleeping_time_to as ending_time FROM sleep";  // Modifica con il nome della tua tabella
        $result3 = pg_query($dbconnect, $query3) or die('query2 failed: ' . pg_last_error());
        $resultArr3 = pg_fetch_all($result3);

        if ($resultArr3) {
            foreach ($resultArr3 as $array) {
                $events[] = array(
                    'id' => htmlspecialchars($array['rid']),
                    'title' => '', // Imposta il titolo su una stringa vuota
                    'start' => htmlspecialchars($array['starting_time']),
                    'end' => htmlspecialchars($array['ending_time']),
                    'color' => 'blue',
                    'type'  => 'Sleep'
                );
            }
        }
        pg_free_result($result3);
        pg_close($dbconnect);

        echo '<script>var events = ' . json_encode($events) . ';</script>';
    ?>

     <!-- navbar in alto -->
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
                    <a class="nav-link" href="headache.html">Registra mal di testa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Download.html">Scarica una registrazione</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="coffee.html">Registra qualità del sonno</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="digital.html">Registra uso di dispositivi digitali</a>
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
    
    <strong><h1 class="fw-bolder text-center" style="color:rgb(80, 197, 255)">Calendario delle registrazioni</h1></strong>
    
    
    <img src="../2 images/logo.png" class="top-left-logo">


    <!-- language selection -->
        <div class="language">
        <br><br><br><br>
        <a class="nav-link dropdown-toggle" href="#" role="button"
        data-bs-toggle="dropdown" aria-expanded="false">
        Lingua
        </a>
        <ul class="dropdown-menu text-center">
        <li><a class="dropdown-item" href="../calendar.php">English</a></li>
        <li><a class="dropdown-item" href="calendar.php">Italiano</a></li>
        </ul>
        </div>
        <br><br>

        <!-- info point -->
        <img src="../2 images/question.png" alt="description" class="bottom-right-image">

    <!-- logged in as -->
    <h6 class="bottom-left-logged">Accesso effetuato come:</h6>


    <div id='calendar'></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                initialDate: '2020-01-01',
                headerToolbar: {
                    left: 'prevYear,prev,next,nextYear today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                locale: 'it',
                events: events,
                selectable: true,
                editable: true,
                navLinks: true, // can click day/week names to navigate views
                
                eventContent: function(arg) {
                    let customDiv = document.createElement('div');
                    customDiv.style.backgroundColor = arg.event.backgroundColor; 
                    customDiv.style.borderRadius = '50%';
                    customDiv.style.width = '10px'; 
                    customDiv.style.height = '10px'; 
                    customDiv.style.display = 'inline-block'; 
                    return { domNodes: [customDiv] }; 
                },

                eventClick: function(info) {
                    var reportLink = 'report' + info.event.extendedProps.type +'.php?rid=' + info.event.id;
                    var linkHtml = '<a href="' + reportLink + '">Clicca qui per visualizzare la tua registrazione</a>';
                    var modalHtml = '<div class="modal" id="reportModal"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Report</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body">' + linkHtml + '</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div></div></div></div>';

                    var modalContainer = document.createElement('div');
                    modalContainer.innerHTML = modalHtml;
                    document.body.appendChild(modalContainer);

                    var modal = new bootstrap.Modal(document.getElementById('reportModal'));
                    modal.show();

                    modalContainer.addEventListener('hidden.bs.modal', function() {
                        document.body.removeChild(modalContainer);
                    });
                }
            });
            calendar.render();
        });
    </script>
</body>
</html>