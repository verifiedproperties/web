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
        $stmt = $conn->prepare("UPDATE `work-orders` SET client_name = ?, con = ?, street_address = ?, secondary_address = ?, city = ?, state = ?, zip = ? , county = ?
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

   
?>