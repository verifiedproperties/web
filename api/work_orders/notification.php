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
                $user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);

                $item = new Workorder($db);
                $rows = $item->getNotification($user_id);
                if ($rows) {

                    $stmt = $db->prepare("UPDATE `work-orders` SET notification = 1 WHERE assignee = ? AND notification = 0");
                    // echo json_encode($db->error_list);
                    $stmt->bind_param("s", $user_id);
                    $result = $stmt->execute();
                    $count = count($rows);
                    if (false == $result) {
                        http_response_code(400);
                        echo json_encode(array("message" => "Unable to get notification."));
                    } else {
                        http_response_code(200);
                        echo json_encode(array(
                            "count" => $count,
                            "notifications" => $rows
                        ));
                    }

                } else {
                    http_response_code(400);
                    echo json_encode(array("message" => "No record found."));
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
