<?php
    if ($_SERVER["REQUEST_METHOD"] !="POST") { /* verifica richiesta post */
        header("Location: DownloadPage.php");
        exit;
    }
    else {
        require('../fpdf186/fpdf.php');

        $type=$_POST['type'];
        $start=$_POST['starting_date'];
        $end=$_POST['ending_date'];
        $dbconnect = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=postgres") or die('could not connect: ' . pg_last_error());
        if($type=="headache"){
            $query = "SELECT starting_time, ending_time, ache_position, ache_intensity, ache_type,
                painkillers, repercussions, symptoms FROM headache where starting_time <=  $1 AND ending_time >=  $2"; //to add the check on the user_id
            $result= pg_query_params($query,array($end, $start)) or die('query failed: ' . pg_last_error());

            //pdf creation and download
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 12);

            $pdf->Cell(0, 10, $type."".'Report', 0, 1, 'C');
            $pdf->Ln(10);

            while ($row = pg_fetch_assoc($result)) {
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(0, 10, 'From: ' . $row['starting_time'], 0, 1);
                $pdf->Cell(0, 10, 'To: ' . $row['ending_time'], 0, 1);
                $pdf->Cell(0, 10, 'Symptoms: ' . $row['symptoms'], 0, 1);
                $pdf->Cell(0, 10, 'Ache Position: ' . $row['ache_position'], 0, 1);
                $pdf->Cell(0, 10, 'Ache Intensity: ' . $row['ache_intensity'], 0, 1);
                $pdf->Cell(0, 10, 'Ache Type: ' . $row['ache_type'], 0, 1);
                $pdf->Cell(0, 10, 'Painkillers: ' . $row['painkillers'], 0, 1);
                $pdf->Cell(0, 10, 'Repercussions: ' . $row['repercussions'], 0, 1);
                $pdf->Ln(10);
            }
            $pdf->Output('D', $start."".$type."".'_report.pdf');
        }
        elseif($type=="sleep"){
            $query = "SELECT sleeping_time_from, sleeping_time_to, coffee_cups, sleeping_rate, awaken_during_sleep
                FROM sleep where sleeping_time_from <=  $1 AND sleeping_time_to >=  $2"; //to add the check on the user_id
            $result= pg_query_params($query,array($end, $start)) or die('query failed: ' . pg_last_error());

            //pdf creation and download
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 12);

            $pdf->Cell(0, 10, $type."".'Report', 0, 1, 'C');
            $pdf->Ln(10);

            while ($row = pg_fetch_assoc($result)) {
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(0, 10, 'From: ' . $row['sleeping_time_from'], 0, 1);
                $pdf->Cell(0, 10, 'To: ' . $row['sleeping_time_to'], 0, 1);
                $pdf->Cell(0, 10, 'Coffee cups: ' . $row['coffee_cups'], 0, 1);
                $pdf->Cell(0, 10, 'Sleeping rate: ' . $row['sleeping_rate'], 0, 1);
                $pdf->Cell(0, 10, 'Awaken during sleep: ' . $row['awaken_during_sleep'], 0, 1);
                $pdf->Ln(10);
            }
            $pdf->Output('D', $start."".$type."".'_report.pdf');
        }
        elseif($type=="digital"){
            $query = "SELECT digital_usage_from, digital_usage_to, symptoms, devices_type, usage_for
                FROM digital where digital_usage_from <= $1 AND digital_usage_to >= $2"; //to add the check on the user_id
            $result= pg_query_params($query,array($end, $start)) or die('query failed: ' . pg_last_error());
                
                //pdf creation and download
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 12);

            $pdf->Cell(0, 10, $type."".'Report', 0, 1, 'C');
            $pdf->Ln(10);

            while ($row = pg_fetch_assoc($result)) {
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(0, 10, 'From: ' . $row['digital_usage_from'], 0, 1);
                $pdf->Cell(0, 10, 'To: ' . $row['digital_usage_to'], 0, 1);
                $pdf->Cell(0, 10, 'Symptoms: ' . $row['symptoms'], 0, 1);
                $pdf->Cell(0, 10, 'Devices Type: ' . $row['devices_type'], 0, 1);
                $pdf->Cell(0, 10, 'Usage For: ' . $row['usage_for'], 0, 1);
                $pdf->Ln(10);
            }
            $pdf->Output('D', $start."".$type."".'_report.pdf');
        }
        else{
            echo "<h1>Error in the post</h1>";
            exit;
        }

        pg_free_result($result);
        pg_close($dbconnect);
    }
?>
