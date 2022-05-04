<?php
    include '../config/config.php';
    require "../../vendor/autoload.php";
    include_once '../config/database.php';
    include_once '../class/workorder.php';
    include_once '../class/permission.php';
    use \Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    \Firebase\JWT\JWT::$leeway = 600;
    header("Access-Control-Allow-Origin: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: *");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    $database = new Database();
    $db = $database->getConnection();
 
    $id = isset($_POST['user_id']) ? $_POST['user_id'] : die();;
    $password = isset($_POST['password']) ? $_POST['password'] : die();;
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : die();;
    
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
                if($id == $user_id){
                    if (!empty($password) && !empty($confirm_password)) {
                        if ($password === $confirm_password) {
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                            $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
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
                }else{
                    http_response_code(401);
                    echo json_encode(array(
                        "message" => "Access denied. You can change your password only."
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