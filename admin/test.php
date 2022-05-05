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
include 'template/head.php';

if (isset($_POST['submitt'])) {
  $fname = $_POST['fname'];

  echo "Yur name is '".$fnam."'";
  exit();
}

?>

<form method="post">
  <label class="form-label">Test</label>
  <input type="text" name="fname" class="form-control">
  <button type="submit" name="submitt">Submit</button>
</form>
