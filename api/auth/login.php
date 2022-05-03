<?php
include_once '../config/database.php';
require "../../vendor/autoload.php";
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$email = '';
$password = '';

$database = new Database();
$conn = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

$email = $data->email;
$password = $data->password;
$table_name = 'users';

if (!empty($email) && !empty($password)) { 

    $query = "SELECT * FROM `users` WHERE `email` = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $hash = $row['password']; 

    $verify = password_verify($password, $hash); 
    
    if ($verify == true) {
        if ($row['status'] == "active") {
            $secret_key = "D46BBCBB0CB1DBEE29E8A0AA5CA1CF51DF6C48779B3F9CD24211148747719D12";
            $issuer_claim = "localhost"; // this can be the servername
            $audience_claim = "127.0.0.1";
            $issuedat_claim = time(); // issued at
            $notbefore_claim = $issuedat_claim + 300; //not before in seconds
            $expire_claim = $issuedat_claim + 600; // expire time in seconds
            $token = array(
                "iss" => $issuer_claim,
                "aud" => $audience_claim,
                "iat" => $issuedat_claim,
                "nbf" => $notbefore_claim,
                "exp" => $expire_claim,
                "data" => array(
                    "id" => $row['id'],
                    "firstname" => $row['first_name'],
                    "lastname" => $row['last_name'],
                    "email" => $row['email'],
                    "role" => $row['role']
            ));

            http_response_code(200);

            $jwt = JWT::encode($token, $secret_key, 'HS256');
            echo json_encode(
                array(
                    "message" => "Successful login.",
                    "jwt" => $jwt,
                    "email" => $email,
                    "expireAt" => $expire_claim
                )
            );
        }if ($row['status'] == "pending") {
            http_response_code(401);
            echo json_encode( array("message" => "Account is pending"));
        }if ($row['status'] == "suspended") {
            http_response_code(401);
            echo json_encode(array("message" => "Account is suspended"));
        }if ($row['status'] == "closed") {
            http_response_code(401);
            echo json_encode(array("message" => "Account is closed"));
        }
    }else {
        http_response_code(401);
        echo json_encode(array("message" => "Login failed.", "password" => $password));
    }

}else {
    http_response_code(401);
    echo json_encode(array("message" => "Login failed. All fields are required"));
}
 
?>