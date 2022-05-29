<?php
// ==========================================
// Date Created:   5/29/2022
// Developer: Richard Rodgers
// ==========================================
include '../../db.php';
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ../../login');
}
$pagename = "Payroll";
$pageheader = "";
include '../template/head.php';
?>

<h1>Hello World!</h1>
