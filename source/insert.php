<?php
session_start();

$host = "localhost";
$user = "postgres";
$pass = "postgres";
$db = "postgres";
$con = pg_connect("host=$host port=5432 dbname=$db user=$user password=$pass")
or die ("Could not connect to Server\n");

if(!$con){
    echo "Error : Unable to open Database\n";
} else {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['first_name'];
    $surname = $_POST['surname'];
    $age = $_POST['age'];

    $user_id = 0;
    $query1 = "SELECT MAX(id) as max_id FROM users";
    $result = pg_query($con, $query1);

    if ($result) {
        $row = pg_fetch_assoc($result);
        $max_id = $row['max_id'];
        $user_id = $max_id + 1;
    } else {
        echo "Error: " . pg_last_error($con);
    }

    $query = "INSERT INTO users (id, username, pass, first_name, surname, age) VALUES ($1, $2, $3, $4, $5, $6)";
    $result = pg_query_params($con, $query, array($user_id, $username, $password, $firstname, $surname, $age));

    if ($result) {
        $_SESSION["id"]=$user_id;
        $_SESSION["username"] = $username;
        header("Location: Home.php");
        exit();
    } else {
        echo "Error: " . pg_last_error($con);
    }
}

pg_close($con);
?>