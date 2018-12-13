<?php 
$servername = "localhost";
$username = "root";
$password = "29555823";
$dbname = "mentor";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->query("SET NAMES 'UTF8'");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>