<?php
// ==========================================
// Date Created:   4/18//2022
// Developer: Richard Rodgers
// ==========================================
include '../../db.php';
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ../../login');
}
$pagename = "Forms";
$pageheader = "Create Forms";
include '../template/head.php';
?>
