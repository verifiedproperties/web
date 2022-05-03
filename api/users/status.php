<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    include_once '../config/database.php';
    $database = new Database();
    $conn = $database->getConnection();
 
    $data = json_decode(file_get_contents("php://input"));

    $id = $data->user_id;
    $status = $data->status;
     
    if (!empty($id) && !empty($status)) {
        $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
        $stmt->bind_param("ss", $status, $id);
        $result = $stmt->execute();
    
        if (false == $result) {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to change user status."));
        } else {
            
            http_response_code(200);
            echo json_encode(array("message" => "User status is changed to ".$status." successfully!"));

        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Something is missing!"));
    }

   
?>