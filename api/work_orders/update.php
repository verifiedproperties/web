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
                $checkadmin = new Permission($db);
                
                $row =  $checkadmin->checkAdmin($user_id);
                if($row == 1){
                    $id = isset($_POST['order_id']) ? $_POST['order_id'] : die();
                    $street_address = isset($_POST['street_address']) ? $_POST['street_address'] : die();
                    $secondary_address = isset($_POST['secondary_address']) ? $_POST['secondary_address'] : die();
                    $city = isset($_POST['city']) ? $_POST['city'] : die();
                    $state = isset($_POST['state']) ? $_POST['state'] : die();
                    $zip = isset($_POST['zip']) ? $_POST['zip'] : die();
                    $county = isset($_POST['county']) ? $_POST['county'] : die();
                    $country = isset($_POST['country']) ? $_POST['country'] : die();
                    $owner = isset($_POST['owner']) ? $_POST['owner'] : die();
                    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : die();
                    $due_date = isset($_POST['due_date']) ? $_POST['due_date'] : die();
                    $instructions = isset($_POST['instructions']) ? $_POST['instructions'] : die();
                    $client_name = isset($_POST['client_name']) ? $_POST['client_name'] : die();
                    $con = isset($_POST['con']) ? $_POST['con'] : die();
                    $service = isset($_POST['service']) ? $_POST['service'] : die();
                    $access_code = isset($_POST['access_code']) ? $_POST['access_code'] : die();
                    $assignee = isset($_POST['assignee']) ? $_POST['assignee'] : die();

                    if (!empty($street_address) && !empty($city) && !empty($state) && !empty($zip) && !empty($client_name) && !empty($due_date) && !empty($service) && !empty($assignee)) {
                        $stmt = $db->prepare("UPDATE `work-orders` SET client_name = ?, con = ?, street_address = ?, secondary_address = ?, city = ?, state = ?, zip = ? , county = ?
                        , country = ?, owner = ?, start_date = ?, due_date = ?, instructions = ?, assignee = ?, service = ?, access_code = ? WHERE id = ?");
                        $stmt->bind_param('sssssssssssssssss', $client_name, $con, $street_address, $secondary_address, $city, $state, $zip, $county, $country, $owner, $start_date, $due_date, $instructions, $assignee, $service, $access_code, $id);
                        $result = $stmt->execute();
                    
                        if (false == $result) {
                            http_response_code(400);
                            echo json_encode(array("message" => "Unable to update work order."));
                        } else {
                            http_response_code(200);
                            echo json_encode(array( "message" => "Successful updated work order." ));
                        }
                    } else {
                        http_response_code(400);
                        echo json_encode(array("message" => "Something is missing!"));
                    }
                }else{
                    http_response_code(401);
                    echo json_encode(array(
                        "message" => "Access denied. Only Admin can do this action."
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