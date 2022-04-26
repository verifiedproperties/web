<?php
// ==========================================
// Date Created:   4/22/2022
// Developer: M Nabeel Arshad
// ==========================================
include '../db.php';
$id = $_POST['id'];
$attachments = [];
$sql = "SELECT * FROM attachments WHERE workorder_id = '{$id}'";
$res = $conn->query($sql);
while ($row = $res->fetch_assoc()) {
	$attachments[] = $row;
}
echo json_encode($attachments);