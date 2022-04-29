<?php
// ==========================================
// Date Created:   4/19/2022
// Developer: Muhammad Nabeel Arshad
// ==========================================
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ../login');
}
include '../db.php';
 if(isset($_POST["Import"])){
		$filename=$_FILES["file"]["tmp_name"];
		 if($_FILES["file"]["size"] > 0)
		 {
		  	$file = fopen($filename, "r");
		  	$i = 0;
	        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
			{
			  	$values = [];
				if($i == 0){
				  	$keys = [];
					foreach ($getData as $key => $value) {
						$value = str_replace(' ', '_', strtolower($value));
						if($value == 'client_order_number'){
							$value = 'con';
						}
						$keys[] = "`{$value}`";
					}
					$keys = implode(',', $keys);
					$i++;
				}else{
					foreach ($getData as $key => $value) {
            if (DateTime::createFromFormat('Y-m-d', $value) !== false) {
                $value = date('Y-m-d', strtotime(str_replace('-', '/', $value)));
            }
						if($value != ''){
							$values[] = "'{$value}'";
						}else{
							$values[] = "DEFAULT";
						}
					}

					$values = implode(',', $values);
					$insert[] = "({$values})";
				}
			}
			$bulk = implode(',', $insert);
			$sql = "INSERT INTO `work-orders` ({$keys}) VALUES {$bulk}";
      
			if(mysqli_query($conn, $sql)){
				echo "success";
			}
	        fclose($file);
		 }
	}
header('location: open-orders');

 ?>
