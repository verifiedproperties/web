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

// Inserting questions into the database
if (isset($_POST['add-questions'])) {
  $question_one = $question_two = $question_three = $question_four = $question_five = $question_one_answer_type = $question_two_answer_type = $question_three_answer_type = $question_four_answer_type = $question_five_answer_type = null;
  $question_one = $_POST['question_one'];
  $question_two = $_POST['question_two'];
  $question_three = $_POST['question_three'];
  $question_four = $_POST['question_four'];
  $question_five = $_POST['question_five'];
  $form_id = $_POST['form_id'];
  $question_one_answer_type = $_POST['question_one_answer_type'];
  $question_two_answer_type = $_POST['question_two_answer_type'];
  $question_three_answer_type = $_POST['question_three_answer_type'];
  $question_four_answer_type = $_POST['question_four_answer_type'];
  $question_five_answer_type = $_POST['question_five_answer_type'];

  $stmt = $conn->prepare("INSERT INTO `questions` (question, answer_type, form_id) VALUES (?,?,?), (?,?,?), (?,?,?), (?,?,?), (?,?,?)");
  $stmt->bind_param("siisiisiisiisii", $question_one, $question_one_answer_type, $form_id, $question_two, $question_two_answer_type, $form_id, $question_three, $question_three_answer_type, $form_id,
  $question_four, $question_four_answer_type, $form_id, $question_five, $question_five_answer_type, $form_id);
  $result = $stmt->execute();

  if (false == $result) {
    echo "Something went wrong!";
  } else {
    $_SESSION['questions-added'] = "<div class='alert alert-success'>Your questions were sucessfully added!</div>";
    header('Location: ../dashboard');
  }
}

if (isset($_POST['delete_form'])) {
  $form_id = $_POST['form_id'];
  $sql = "DELETE FROM `forms` WHERE `id` = '$form_id'";
  $result = mysqli_query($conn, $sql);
  if (false == $result) {
    echo "Unable to delete form! Please contact your sytem admin.";
  } else {
    $_SESSION['form-deleted'] = "<div class='alert alert-success'>The form you selected has been deleted successfully!</div>";
    header('Location: forms');
  }
}

// Inserting answers
if (isset($_POST['add-answers'])) {
  $answer_one = $_POST['answer_one'];
  $answer_two = $_POST['answer_two'];
  $answer_three = $_POST['answer_three'];
  $answer_four = $_POST['answer_four'];
  $answer_five = $_POST['answer_five'];
  $question_id = $_POST['question_id'];

  if (!empty($answer_one)) {
    $stmt = $conn->prepare("INSERT INTO `answers` (answer, question_id) VALUES (?,?), (?,?), (?,?), (?,?), (?,?), (?,?)");
    $stmt->bind_param("sisisisisi", $answer_one, $question_id, $answer_two, $question_id, $answer_three, $question_id, $answer_four, $question_id, $answer_five, $question_id);
    $result = $stmt->execute();

    if (false == $result) {
      echo "Something went wrong!";
    } else {
      echo "Success!";
    }
  }
}
?>
