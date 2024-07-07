<?php
if ($_SERVER["REQUEST_METHOD"] !="POST") { /* verifica richiesta post */
    header("Location: coffee.html");
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
                $report_id=1;
                $report_by=1;
                $sleeping_date = $_POST['sleeping_date'];
                $from = $_POST['sleeping_time_from'];
                $to= $_POST['sleeping_time_to'];
                $coffee_cups= $_POST['coffee_cups'];
                $sleeping_rate = $_POST['sleeping_rate'];
                $awaken_during_sleep= $_POST['awaken_during_sleep'];
                
                $sleeping_time_from = $sleeping_date . ' ' . $from;
                $sleeping_time_to = $sleeping_date . ' ' . $to;

                $q2 = "insert into sleep values ($1, $2, $3, $4, $5, $6, $7, $8)";
                $data=pg_query_params($dbconn, $q2,
                        array($report_id, $report_by, $sleeping_date, $sleeping_time_from, $sleeping_time_to,
                        $coffee_cups, $sleeping_rate, $awaken_during_sleep));
                if ($data) {
                    header("Location: okpag.html") ;
                }
            }
    
        ?>
    </body>
</html>