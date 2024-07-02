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
                    'color' => 'red'
                );
            }
            echo '<script>var events = ' . json_encode($events) . ';</script>';
        } else {
            echo '<script>var events = [];</script>';
        }

        pg_free_result($result);
        pg_close($dbconnect);
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
                    var reportLink = 'reportHeadache.php?rid=' + info.event.id;
                    var linkHtml = '<a href="' + reportLink + '">Click here to see the content of your report</a>';
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