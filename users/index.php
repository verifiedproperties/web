<?php
// ==========================================
// Date Created:   3/25/2022
// Developer: Richard Rodgers
// ==========================================
$pagename = "Dashboard";
$pageheader = null;
include '../db.php';
session_start();
$username = $_SESSION['username'];
if (!isset($_SESSION['username'])) {
  header('Location: ../login');
}

// Fetching the role of the logged in user
$query = "SELECT `role` FROM `users` WHERE `email` = '$username' LIMIT 1";
$result = mysqli_query($conn, $query);
$role = mysqli_fetch_array($result, MYSQLI_ASSOC);

if ($role['role'] != '2') {
  header('Location: ../login');
}

echo "<h1>Welcome to the Client Area! Your role id is: </h1>", $role['role'];
echo "<br><a href='../logout.php'>Logout</a>";
