<?php
    if ($_SERVER["REQUEST_METHOD"] !="POST") { /* verifica richiesta post */
        header("Location: digitalPage.php");
        exit;
    }
    else {
        require('../../fpdf186/fpdf.php');

        $type=$_POST['type'];
        $start=$_POST['starting_date'];
        $end=$_POST['ending_date'];
        $id=$_SESSION['id'];
        $dbconnect = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=postgres") or die('could not connect: ' . pg_last_error());
        if($type=="headache"){
            $query = "SELECT starting_time, ending_time, ache_position, ache_intensity, ache_type,
                painkillers, repercussions, symptoms FROM headache where starting_time <=  $1 AND ending_time >=  $2 AND report_by=$3"; //to add the check on the user_id
            $result= pg_query_params($query,array($end, $start, $id)) or die('query failed: ' . pg_last_error());

            //pdf creation and download
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 12);

            $pdf->Cell(0, 10, $type."".'Report', 0, 1, 'C');
            $pdf->Ln(10);

            while ($row = pg_fetch_assoc($result)) {
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(0, 10, 'Da: ' . $row['starting_time'], 0, 1);
                $pdf->Cell(0, 10, 'A: ' . $row['ending_time'], 0, 1);
                $pdf->Cell(0, 10, 'Sintomi: ' . $row['symptoms'], 0, 1);
                $pdf->Cell(0, 10, 'Posizione: ' . $row['ache_position'], 0, 1);
                $pdf->Cell(0, 10, 'Intensità: ' . $row['ache_intensity'], 0, 1);
                $pdf->Cell(0, 10, 'Tipo di dolore: ' . $row['ache_type'], 0, 1);
                $pdf->Cell(0, 10, 'Antidolorifici: ' . $row['painkillers'], 0, 1);
                $pdf->Cell(0, 10, 'Ripercussioni: ' . $row['repercussions'], 0, 1);
                $pdf->Ln(10);
            }
            $pdf->Output('D', $start."".$type."".'_registrazione.pdf');
        }
        elseif($type=="sleep"){
            $query = "SELECT sleeping_time_from, sleeping_time_to, coffee_cups, sleeping_rate, awaken_during_sleep
                FROM sleep where sleeping_time_from <=  $1 AND sleeping_time_to >=  $2 AND report_by=$3"; //to add the check on the user_id
            $result= pg_query_params($query,array($end, $start, $id)) or die('query failed: ' . pg_last_error());

            //pdf creation and download
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 12);

            $pdf->Cell(0, 10, $type."".'Report', 0, 1, 'C');
            $pdf->Ln(10);

            while ($row = pg_fetch_assoc($result)) {
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(0, 10, 'Da: ' . $row['sleeping_time_from'], 0, 1);
                $pdf->Cell(0, 10, 'A: ' . $row['sleeping_time_to'], 0, 1);
                $pdf->Cell(0, 10, 'Tazze di caffé: ' . $row['coffee_cups'], 0, 1);
                $pdf->Cell(0, 10, 'Qualità del sonno: ' . $row['sleeping_rate'], 0, 1);
                $pdf->Cell(0, 10, 'Risveglio durante il sonno: ' . $row['awaken_during_sleep'], 0, 1);
                $pdf->Ln(10);
            }
            $pdf->Output('D', $start."".$type."".'_registrazione.pdf');
        }
        elseif($type=="digital"){
            $query = "SELECT digital_usage_from, digital_usage_to, symptoms, devices_type, usage_for
                FROM digital where digital_usage_from <= $1 AND digital_usage_to >= $2 AND report_by=$3"; //to add the check on the user_id
            $result= pg_query_params($query,array($end, $start, $id)) or die('query failed: ' . pg_last_error());
                
                //pdf creation and download
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 12);

            $pdf->Cell(0, 10, $type."".'Report', 0, 1, 'C');
            $pdf->Ln(10);

            while ($row = pg_fetch_assoc($result)) {
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(0, 10, 'Da: ' . $row['digital_usage_from'], 0, 1);
                $pdf->Cell(0, 10, 'A: ' . $row['digital_usage_to'], 0, 1);
                $pdf->Cell(0, 10, 'Sintomi: ' . $row['symptoms'], 0, 1);
                $pdf->Cell(0, 10, 'Tipi di dispositivo: ' . $row['devices_type'], 0, 1);
                $pdf->Cell(0, 10, 'Utilizzo: ' . $row['usage_for'], 0, 1);
                $pdf->Ln(10);
            }
            $pdf->Output('D', $start."".$type."".'_registrazione.pdf');
        }
        else{
            echo "<h1>Error in the post</h1>";
            exit;
        }

        pg_free_result($result);
        pg_close($dbconnect);
    }
?>
