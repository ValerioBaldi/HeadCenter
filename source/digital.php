<?php
if ($_SERVER["REQUEST_METHOD"] !="POST") { /* verifica richiesta post */
    header("Location: /digital.html");
}
else {
   /*  connessione */
$dbconn = pg_connect("host=localhost port=5432 dbname=postgres
        user=postgres password=1234")
        or die('Could not connect: ' . pg_last_error());
}
?>
<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <?php
            if($dbconn) {
                /*report_id int NOT NULL,
                digital_usage_from timestamp NOT NULL,
                digital_usage_to timestamp NOT NULL,
                symptoms char(100),
                devices_type char(40) NOT NULL,
                usage_for char(30) NOT NULL */


                /* MANCA LA DATE */

               /*  $report_id = $_POST['report_id']; */
                $report_id=1;
                $digital_date = $_POST['digital_date'];
                $digital_usage_from = $_POST['digital_usage_from'];
                $digital_usage_to= $_POST['digital_usage_to'];
                $symptoms= $_POST['symptoms'];
                $devices_type = $_POST['devices_type'];
                $usage_for= $_POST['usage_for'];
                
                $q2 = "insert into digital values ($1, $2, $3, $4, $5, $6)";
                $data=pg_query_params($dbconn, $q2,
                        array($report_id, $digital_usage_from, $digital_usage_to,
                        $symptoms, $devices_type, $usage_for));
                if ($data) {
                    
                  /* pagina a cui rimanda in caso di richiesta inviata */
                     header("Location: okpage.html") ;
                }
        
        }
    
?>
</body>
</html>