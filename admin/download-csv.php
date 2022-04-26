<?php
// ==========================================
// Date Created:   4/18/2022
// Developer: Muhammad Nabeel Arshad
// ==========================================
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ../login');
}
include '../db.php';
$query = "SELECT * FROM `work-orders` WHERE id IN ({$_GET['id']})";
if ($result = mysqli_query($conn, $query)) {
  // $orders = mysqli_num_rows($result);
  while ($row = $result->fetch_assoc()) {
  	$orders[] = $row;
  }
}
$delimiter = ","; 
$filename = "work-orders_" . time() . ".csv";
// Create a file pointer 
$f = fopen('php://memory', 'w');
// Set column headers 
$fields = (array_keys($orders[0]));

fputcsv($f, $fields, $delimiter); 


foreach ($orders as $key => $order) { 
    $lineData = [];
    foreach ($order as $key => $value) {
    	array_push($lineData, $value);
    }
    fputcsv($f, $lineData, $delimiter);
}

fseek($f, 0);
 // Set headers to download file rather than displayed 
header('Content-Type: text/csv'); 
header('Content-Disposition: attachment; filename="' . $filename . '";'); 
 
//output all remaining data on a file pointer 
fpassthru($f); 