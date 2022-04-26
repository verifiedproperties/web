<?php
// ==========================================
// Date Created:   4/15/2022
// Developer: M Nabeel Arshad
// ==========================================
include '../db.php';
$user_id = $_POST['user_id'];
$tasks = $_POST['tasks'];
$sql = "UPDATE `work-orders` SET assignee = '{$user_id}' WHERE id IN(".implode(',', $tasks).")";
if (mysqli_query($conn, $sql)) {
	$response = ['code' => 200];
} else {
	$response = ['code' => 400];
}
echo json_encode($response);