<?php
    include '../config/config.php';
    require "../../vendor/autoload.php";
    include_once '../config/database.php';
    include_once '../class/workorder.php';
    include_once '../class/permission.php';
    use \Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    \Firebase\JWT\JWT::$leeway = 600;
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: *");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    $database = new Database();
    $db = $database->getConnection();
 
    $id = isset($_POST['user_id']) ? $_POST['user_id'] : die();;
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : die();;
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : die();;
    $email = isset($_POST['email']) ? $_POST['email'] : die();;
    $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : die();;
    $dob = isset($_POST['dob']) ? $_POST['dob'] : die();;
    
    $headers = getallheaders();
    if(array_key_exists("Authorization",$headers)){
        $arr = explode(" ", $headers["Authorization"]);
        $jwt = $arr[1];
        
        if($jwt){
            try {
                $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
                
                $user_id = json_encode($decoded->data->id);
                // Access is granted. Add code of the operation here 
                $user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);

                if($user_id == $id){
                    if (!empty($first_name) && !empty($last_name) && !empty($phone_number) && !empty($dob)) {
                        $stmt = $db->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ?, dob = ? WHERE id = ?");
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
                }else{
                    http_response_code(401);
                    echo json_encode(array(
                        "message" => "Access denied. You can change your profile only."
                    )); 
                }
        
            }catch (Exception $e){
        
                http_response_code(401);
                echo json_encode(array(
                    "message" => "Access denied.",
                    "error" => $e->getMessage()
                ));
            }
        }
    }else{
        http_response_code(401);
        echo json_encode(array(
            "message" => "Access denied."
        ));
    }
   
?>