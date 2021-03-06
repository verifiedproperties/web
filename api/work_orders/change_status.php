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

                $id = isset($_GET['id']) ? $_GET['id'] : die();
                $item = new Workorder($db);
                $row = $item->getWorkorder($id);
                $today = date('Y-m-d H:i:s');
                if ($row) {
                    if($row[0]['assignee'] == $user_id){
                        $id=htmlspecialchars(strip_tags($id));
                        $stmt = $db->prepare("UPDATE `work-orders` SET status = 2, date_completed = ? WHERE id = ?");
                        echo json_encode($db->error_list);
                        $stmt->bind_param("ss",$today,$id);
                        $result = $stmt->execute();

                        if (false == $result) {
                            http_response_code(400);
                            echo json_encode(array("message" => "Unable to change work order status."));
                        } else {
                            http_response_code(200);
                            echo json_encode(array("message" => "Order completed!"));
                        }
                    }else{
                        http_response_code(404);
                        echo json_encode(
                            array("message" => "This work order has not been assigned to you.")
                        );
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
