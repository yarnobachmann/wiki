<?php
$servername = "localhost";
$database = "wiki";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Database connection succesfull!";
} catch(Exception $e) {
  echo "Something went very wrong ;-;: " . $e->getMessage();
}

?>

