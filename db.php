<?php
// ==========================================
// Date Created:   3/24/2022
// Developer: Richard Rodgers
// ==========================================

// Database credentials
$server = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "verified";

// Creating connection
$conn = mysqli_connect($server, $dbusername, $dbpassword, $dbname);

// Check connection
if (!$conn) {
  die("Datbase connection failed" . mysqli_connect_error());
}
