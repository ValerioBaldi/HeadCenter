<?php

$host = "localhost";
$user = "postgres";
$pass = "postgres";
$db = "mydata";
$con = pg_connect("host=$host dbname=$db user =$user password=$pass")
 or die ("Could not connect to Server\n");
 $username = $_POST['username'];
 $password = $_POST['password'];


 $query = "SELECT * FROM register WHERE username = ('$username')
 AND  password = ('$password')";
  header('Location: Home.html');
  session_start();
$_SESSION['username'] = $username;

 $result = pg_query($con, $query);
 if(pg_num_rows($result) != 1) {
   header('Location: auth.html' );

 } else {

 }
 if(!$result) {
   die("SOMETHING IS WRONG");
 }

// setcookie('Email', $email, time() + 10000000, "/");


  pg_close($con);
    ?>
