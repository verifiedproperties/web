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
                    $data = json_decode(file_get_contents("php://input"));
                    $id = $data->id;
                    $street_address = $data->street_address;
                    $secondary_address = $data->secondary_address;
                    $city = $data->city;
                    $state = $data->state;
                    $zip = $data->zip;
                    $county = $data->county;
                    $country = $data->country;
                    $owner = $data->owner;
                    $start_date = $data->start_date;
                    $due_date = $data->due_date;
                    $instructions = $data->instructions;
                    $client_name = $data->client_name;
                    $con = $data->con;
                    $service = $data->service;
                    $access_code = $data->access_code;
                    $assignee = $data->assignee;
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