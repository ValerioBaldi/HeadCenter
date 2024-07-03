<?php
if ($_SERVER["REQUEST_METHOD"] !="POST") { /* verifica richiesta post */
    header("Location: headache.html");
    exit;
}
else {
   /*  connessione */
$dbconn = pg_connect("host=localhost port=5432 dbname=postgres
        user=postgres password=123456")
        or die('Could not connect: ' . pg_last_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Request method is POST<br>";
}

?>

<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <?php
            if($dbconn) {
                  /*  create table headache (
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
                ); 
                name="ache_position_hidden">
                name="ache_type_hidden">
                name="repercussions_hidden">
                
                */

               
                $report_id = 2;
                $report_by = 2;
                $headache_date = $_POST['headache_date'];
                $from = $_POST['starting_time'];
                $to = $_POST['ending_time'];
                $still_going = $_POST["still_going"];
                $ache_position = $_POST['ache_position_hidden'];
                $ache_intensity = $_POST['ache_intensity'];
                $ache_type = $_POST['ache_type_hidden'];
                $painkillers = $_POST['painkillers_hidden'];
                $repercussions = $_POST['repercussions_hidden'];
                $symptoms = $_POST['symptoms'];
                $notes = $_POST['notes'];
                
                // Formatta l'orario con la data fornita
                $starting_time = $headache_date . ' ' . $from;
                $ending_time = $headache_date . ' ' . $to;


                $q2 = "insert into headache values ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13)";
                $data=pg_query_params($dbconn, $q2,
                        array($report_id, $report_by, $headache_date, $starting_time,
                        $ending_time, $still_going, $ache_position, $ache_intensity,
                        $ache_type, $painkillers, $repercussions, $symptoms, $notes));
                if ($data) {
                    
                  /* pagina a cui rimanda in caso di richiesta inviata */
                     header("Location: okpag.html") ;
                }
                /* else {
                    header("Location: /coffee.html");
                     exit;
                } */
               /* qui non ci arriva */
           /*  else {
                header("Location: /coffee.html");
                     exit;
            } */
        }
    
?>
</body>
</html>