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
               $order_id = isset($_POST['workorder_id']) ? $_POST['workorder_id'] : die();
               $row = $item->getWorkorder($order_id);
               if($row){
                    if($row[0]['assignee'] == $user_id){
                        $files = $_FILES['files'];
                        if (!empty($order_id)) {
                                $attachments_error = '';
                                if(!empty($_FILES['files'])){
                                
                                    $target_dir = "../../admin/assets/attachments/";
                                    for ($i=0; $i < count($_FILES['files']['name']); $i++) {
                                        if($_FILES['files']['tmp_name'][$i] == ''){
                                            continue;
                                        }
                                        $target_file = $target_dir . time().'_'.basename($_FILES["files"]["name"][$i]);
                                        $uploadOk = 1;
                                        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                                        
                                        // Check if image file is a actual image or fake image
                                        $check = getimagesize($_FILES["files"]["tmp_name"][$i]);
                                        if($check !== false) {
                                            $uploadOk = 1;
                                        } else {
                                            $attachments_error .= "<br><b><u>".htmlspecialchars( basename( $_FILES["files"]["name"][$i]))."</u></b> File is not an image.";
                                            $uploadOk = 0;
                                            continue;
                                        }
                                
                                        // Check file size
                                        if ($_FILES["files"]["size"][$i] > 500000) {
                                            $attachments_error .= "<br><b><u>".htmlspecialchars( basename( $_FILES["files"]["name"][$i]))."</u></b> Sorry, your file is too large.";
                                            $uploadOk = 0;
                                            continue;
                                        }
                                
                                        // Allow certain file formats
                                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                                        && $imageFileType != "gif" ) {
                                            $attachments_error .=  "<br><b><u>".htmlspecialchars( basename( $_FILES["files"]["name"][$i]))."</u></b>Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                            $uploadOk = 0;
                                            continue;
                                        }
                                        // Check if $uploadOk is set to 0 by an error
                                        if ($uploadOk == 1) {
                                            if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_file)) {
                                                $sql = "INSERT INTO attachments (`file`, `workorder_id`) VALUES('{$target_file}', '{$order_id}')";
                                                $db->query($sql);
                                            }else{
                                                $attachments_error .=  "<br><b><u>".htmlspecialchars( basename( $_FILES["files"]["name"][$i]))."</u></b>Sorry, there was an error uploading your file.";
                                                continue;
                                            }
                                        }
                                    }
    
                                    http_response_code(200);
                                    echo json_encode(
                                        array(
                                            "message" => "Successful uploaded attached files.",
                                            "attachments_error" => $attachments_error
                                         )
                                    );
                                }
                                
                                
                         
                        } else {
                            http_response_code(400);
                            echo json_encode(array("message" => "Something is missing!"));
                        }
                    
                    }else{
                        http_response_code(404);
                        echo json_encode(
                            array("message" => "This work order has not been assigned to you.")
                        );
                    }
                    
                }else{  
                    http_response_code(404);
                    echo json_encode(
                        array("message" => "No Found Work Order.")
                    );
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