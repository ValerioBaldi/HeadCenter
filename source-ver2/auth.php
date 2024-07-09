<?php

$host = "localhost";
$user = "postgres";
$pass = "postgres";
$db = "postgres";
$con = pg_connect("host=$host port=5432 dbname=$db user =$user password=$pass")
 or die ("Could not connect to Server\n");
 $username = $_POST['username'];
 $password = $_POST['password'];


 $query = "SELECT id FROM users WHERE username = ('$username')
 AND  pass = ('$password')";

 $result = pg_query($con, $query);
 if(pg_num_rows($result) != 1) {
   header('Location: auth.html' );
 } else {
  header('Location: Home.php');
  session_start();
  $_SESSION['username'] = $username;
  $row = pg_fetch_assoc($result);
        $_SESSION = $row['id'];
  }
 if(!$result) {
   die("SOMETHING IS WRONG");
 }



  pg_close($con);
    ?>
