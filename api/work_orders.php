<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once 'config/database.php';
    include_once 'class/workorder.php';
    $database = new Database();
    $db = $database->getConnection();
    $items = new Workorder($db);
    $rows = $items->getWorkorders();
    if($rows){
        echo json_encode($rows);
    }else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>