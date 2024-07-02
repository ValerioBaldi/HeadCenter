<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabella Headache Report</title>
</head>
<body>
<?php
echo "<div class='miodiv' style='text-align:left;'>";
echo "<table class='mytable2'>";
$dbconnect = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=postgres") or die('could not connect: ' . pg_last_error());
$query = "SELECT rid AS rid, starting_time AS starting, ending_time AS ending FROM headache_report";
$result = pg_query($dbconnect, $query) or die('query failed: ' . pg_last_error());
$resultArr = pg_fetch_all($result);

echo '<table border="1">
        <tr>
            <th>RID</th>
            <th>Starting</th>
            <th>Ending</th>
        </tr>';

if ($resultArr) {
    foreach ($resultArr as $array) {
        echo '<tr>
                <td>' . htmlspecialchars($array['rid']) . '</td>
                <td>' . htmlspecialchars($array['starting']) . '</td>
                <td>' . htmlspecialchars($array['ending']) . '</td>
            </tr>';
    }
} else {
    echo '<tr><td colspan="3">No data found</td></tr>';
}

echo '</table>';

pg_free_result($result);
pg_close($dbconnect);
echo "</div>";
?>
</body>
</html>
