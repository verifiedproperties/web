<?php
// ==========================================
// Date Created:   5/22/2022
// Developer: Richard Rodgers
// ==========================================
include '../../db.php';
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ../../login');
}

// Insert new form in database
if (isset($_POST['create-form'])) {
  $form_name = $_POST['form_name'];
  $photos_required = $_POST['photos_required'];
  $instructions = $_POST['instructions'];

  if (!empty($form_name) && !empty($photos_required) && !empty($instructions)) {
    // If all fields are not emtpy, the following script will run to insert the form in the db.
    $stmt = $conn->prepare("INSERT INTO `forms` (name, photos_required, instructions) VALUES(?,?,?)");
    $stmt->bind_param("sis", $form_name, $photos_required, $instructions);
    $result = $stmt->execute();

    if (false == $result) {
      $query_error = "Failed to create order: " . mysqli_error($conn);
    } else {
      $_SESSION['form-created'] = "<div class='alert alert-success'>Your form has been created successfully.</div>";
      header("Location: forms");
    }
  } else {
    echo "You form contains errors! Please try agan.";
  }
}
?>
