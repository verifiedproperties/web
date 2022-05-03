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
    $first_name = $data->first_name;
    $last_name = $data->last_name;
    $email = $data->email;
    $phone_number = $data->phone_number;
    $dob = $data->dob;
     
    if (!empty($first_name) && !empty($last_name) && !empty($phone_number) && !empty($dob)) {
        $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ?, dob = ? WHERE id = ?");
        $stmt->bind_param("ssssss", $first_name, $last_name, $email, $phone_number, $dob, $id);
        $result = $stmt->execute();

    
        if (false == $result) {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to change profile settings."));
        } else {
            
            http_response_code(200);
            echo json_encode(array("message" => "Profile settings is updated successfully!"));

        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Something is missing!"));
    }

   
?>