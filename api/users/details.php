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

    $id = isset($_GET['user_id']) ? $_GET['user_id'] : die();;

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
                    $sql = "SELECT id, first_name, last_name, email, phone, address, dob, joined FROM `users` WHERE id = $id";
                    $result = mysqli_query($db, $sql);
                    $rows = mysqli_fetch_array($result, MYSQLI_ASSOC);

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
