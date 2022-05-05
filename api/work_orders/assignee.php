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
                $user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);
                $item = new Workorder($db);
                $assignee = isset($_GET['assignee']) ? $_GET['assignee'] : die();
                
                if($assignee == $user_id){
                    
                    $rows = $item->getAssigneeorders($assignee);

                    if($rows){
                        echo json_encode($rows);
                    }else{
                        http_response_code(404);
                        echo json_encode(
                            array("message" => "No record found.")
                        );
                    }
                }else{
                    http_response_code(401);
                    echo json_encode(array(
                        "message" => "Access denied. You can access only your orders."
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