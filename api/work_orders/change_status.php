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

    $headers = getallheaders();
    if(array_key_exists("Authorization",$headers)){
        $arr = explode(" ", $headers["Authorization"]);
        $jwt = $arr[1];
        
        if($jwt){
            try {
                $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
                
                $user_id = json_encode($decoded->data->id);
                // Access is granted. Add code of the operation here 
                
                    
                if (!empty($id) && !empty($status)) {
                    $stmt = $db->prepare("UPDATE work-orders SET status = 4 WHERE id = ?");
                    $stmt->bind_param("s", $id);
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