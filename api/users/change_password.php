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
    $password = $data->password;
    $confirm_password = $data->confirm_password;
  
    if (!empty($password) && !empty($confirm_password)) {
        if ($password === $confirm_password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param("ss", $hashed_password, $id);
            $result = $stmt->execute();
        
            if (false == $result) {
                http_response_code(400);
                echo json_encode(array("message" => "Unable to change password."));
            } else {
                
                http_response_code(200);
                echo json_encode(array("message" => "Password is updated successfully!"));

            }
        }else{
            http_response_code(401);
            echo json_encode( array("message" => "Your passwords don't match."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Something is missing!"));
    }

   
?>