<?php
$host = "localhost";
$user = "postgres";
$pass = "postgres";
$db = "mydata";
$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
or die ("Could not connect to Server\n");
if(!$con){
  echo "Error : Unable to open Database\n";

} else {
$username = $_POST['username'];
$password = $_POST['password'];

$query = "INSERT INTO register (username, password) VALUES ('$username','$password')";
$result = pg_query($con, $query);
header("Location: Home.html");
// setcookie('Email', $email['Email'], time() + 10000000, "/");

}
pg_close($con);
?>
