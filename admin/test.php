<?php
// ==========================================
// Date Created:   4/3//2022
// Developer: Richard Rodgers
// ==========================================
include '../db.php';
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ../login');
}

echo "Hello World!";
