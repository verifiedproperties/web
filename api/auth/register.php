<?php
include_once '../config/database.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$firstName = '';
$lastName = '';
$email = '';
$password = '';
$conn = null;

$database = new Database();
$conn = $database->getConnection();

 
$first_name = isset($_POST['first_name']) ? $_POST['first_name'] : die();;
$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : die();;
$email = isset($_POST['email']) ? $_POST['email'] : die();;
$password = isset($_POST['password']) ? $_POST['password'] : die();;
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$table_name = 'users';
$email_check = mysqli_query($conn, "SELECT id FROM users WHERE email = '".$email."'"); // Checks to see if the email provided is already in the database

if (mysqli_num_rows($email_check) > 0) {
    http_response_code(400);
    echo json_encode(array("message" => "Email is duplicated!"));

  } else {   
    if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($password)) {
      $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);
      $result = $stmt->execute();

      if (!$result) {  
        http_response_code(400);
        echo json_encode(array("message" => "Unable to register the user."));
      } else {  
        http_response_code(200);
        echo json_encode(array("message" => "User was successfully registered."));
      }
    } else {  
        http_response_code(400);
        echo json_encode(array("message" => "All fileds are required"));
    }
  }
  
?>