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
                );  */

               
                $report_id=1;
                $digital_date = $_POST['digital_date'];
                $from = $_POST['digital_usage_from'];
                $to= $_POST['digital_usage_to'];
                $symptoms= $_POST['symptoms_hidden'];
                $devices_type = $_POST['devices_type_hidden'];
                $usage_for= $_POST['usage_for_hidden'];
                
                // Formatta l'orario con la data fornita
                $digital_usage_from = $digital_date . ' ' . $from;
                $digital_usage_to = $digital_date . ' ' . $to;


                $q2 = "insert into digital values ($1, $2, $3, $4, $5, $6, $7)";
                $data=pg_query_params($dbconn, $q2,
                        array($report_id, $digital_date, $digital_usage_from, $digital_usage_to,
                        $symptoms, $devices_type, $usage_for));
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