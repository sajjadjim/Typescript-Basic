<?php
// Edit these if your MySQL info is different
$host = "localhost";
$user = "root";
$pass = "";            // default empty in XAMPP
$db   = "simple_app";  // must match the DB you created

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
  die("Database connection failed: " . mysqli_connect_error());
}
?>
