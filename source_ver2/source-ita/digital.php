<?php
if ($_SERVER["REQUEST_METHOD"] !="POST") { /* verifica richiesta post */
    header("Location: digital.html");
    exit;
}
else {
   /*  connessione */
$dbconn = pg_connect("host=localhost port=5432 dbname=postgres
        user=postgres password=postgres")
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
                /*report_id int NOT NULL,
                digital_usage_from timestamp NOT NULL,
                digital_usage_to timestamp NOT NULL,
                symptoms char(100),
                devices_type char(40) NOT NULL,
                usage_for char(30) NOT NULL */
                $report_id=0;
                $query1="select max(report_id) as MAX_id from digital";
                $result=pg_query($dbconn, $query1);
                if ($result) {
                    $row = pg_fetch_assoc($result);
                    $max_id = $row['max_id'];
                    $report_id = $max_id+1;
                } else {
                    echo "Error: " . pg_last_error($dbconn);
                }
               
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