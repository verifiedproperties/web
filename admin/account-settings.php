<?php
ob_start();
// ==========================================
// Date Created:   4/3//2022
// Developer: Richard Rodgers
// ==========================================
include '../db.php';
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ../login');
}
$pagename = "Account Settings";
$pageheader = "Create a new order";
include 'template/head.php';

$username = $_SESSION['username']; // Assigning the logged in user's username to a variable

// Updating user profile
if (isset($_POST['save-changes'])) {
$first_name = $_POST['fname'];
$last_name = $_POST['lname'];
$email = $_POST['email'];
$phone_number = $_POST['phone'];
$dob = $_POST['dob'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if (!empty($first_name) && !empty($last_name) && !empty($phone_number) && !empty($dob) && !empty($password) && !empty($confirm_password)) {
  if ($_POST['password'] === $_POST['confirm_password']) {
    $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ?, dob = ?, password = ? WHERE email = ?");
    $stmt->bind_param("sssssss", $first_name, $last_name, $email, $phone_number, $dob, $password, $username);
    $result = $stmt->execute();

    if (!$result) {
      echo("Unable to save changes: " . mysqli_error($conn));
    } else {
      $_SESSION['changes-saved'] = "<div class='alert alert-success'>Changes saved!</div>";
    }
  } else {
    $_SESSION['password_err'] = "<div class='alert alert-danger'>Your passwords don't match.</div>";
  }

} else {
  $_SESSION['emptyFields'] = "<div class='alert alert-warning text-white'>All fields are required!</div>";
  }
}

// Fetching user profile
$query = "SELECT * FROM users WHERE email = '$username'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Account closure script
if (isset($_POST['close-account'])) {
  $sql = "UPDATE users SET `status` = 'closed' WHERE email = '$username'";
  $result = mysqli_query($conn, $sql);

  if (!$result) {
    echo("Unable to close account: " . mysqli_error($conn));
  } else {
    header('Location: ../logout.php');
    ob_end_flush();
  }
}
?>

<?php include 'template/offcanvas.php'; ?>
<?php include 'template/navigation.php'; ?>

<!-- MAIN CONTENT -->
<div class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-8">
        <!-- Header -->
        <div class="header mt-md-5">
          <div class="header-body">
            <div class="row align-items-center">
              <div class="col">

                <!-- Pretitle -->
                <h6 class="header-pretitle">
                  Overview
                </h6>

                <!-- Title -->
                <h1 class="header-title">
                  Account
                </h1>

              </div>
            </div> <!-- / .row -->
            <div class="row align-items-center">
              <div class="col">

                <!-- Nav -->
                <ul class="nav nav-tabs nav-overflow header-tabs">
                  <li class="nav-item">
                    <a href="account-general.html" class="nav-link active">
                      General
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Form -->
        <?php foreach ($row as $detail) {?>
        <form method="post">
          <!-- Errors -->
          <div class="row">
            <div class="col-12">
              <?php
              if (isset($_SESSION['changes-saved'])) {
                echo $_SESSION['changes-saved'];
                unset($_SESSION['changes-saved']);
              } if (isset($_SESSION['emptyFields'])) {
                echo $_SESSION['emptyFields'];
                unset($_SESSION['emptyFields']);
              } if (isset($_SESSION['password_err'])) {
                echo $_SESSION['password_err'];
                unset($_SESSION['password_err']);
              }
              ?>
            </div>
          </div>
          <div class="row">
            <div class="col-6 col-md-6">

              <!-- First name -->
              <div class="form-group">

                <!-- Label -->
                <label class="form-label">
                  First name
                </label>

                <!-- Input -->
                <input type="text" class="form-control" name="fname" value="<?php echo $detail['first_name']; ?>">

              </div>

            </div>
            <div class="col-6 col-md-6">

              <!-- Last name -->
              <div class="form-group">

                <!-- Label -->
                <label class="form-label">
                  Last name
                </label>

                <!-- Input -->
                <input type="text" class="form-control" name="lname" value="<?php echo $detail['last_name']; ?>">

              </div>

            </div>
            <div class="col-12">

              <!-- Email address -->
              <div class="form-group">

                <!-- Label -->
                <label class="mb-1">
                  Email address
                </label>

                <!-- Form text -->
                <small class="form-text text-muted">
                  This contact will be shown to others publicly, so choose it carefully.
                </small>

                <!-- Input -->
                <input type="email" class="form-control" name="email" value="<?php echo $detail['email']; ?>">

              </div>

            </div>
            <div class="col-12 col-md-6">

              <!-- Phone -->
              <div class="form-group">

                <!-- Label -->
                <label class="form-label">
                  Phone
                </label>

                <!-- Input -->
                <input type="text" class="form-control mb-3" placeholder="(___)___-____" data-inputmask="'mask': '(999)999-9999'" name="phone" value="<?php echo $detail['phone']; ?>">

              </div>

            </div>
            <div class="col-12 col-md-6">

              <!-- Birthday -->
              <div class="form-group">

                <!-- Label -->
                <label class="form-label">
                  Birthday
                </label>

                <!-- Input -->
                <input type="text" class="form-control" name="dob" data-flatpickr value="<?php echo htmlspecialchars($detail['dob']); ?>">

              </div>

            </div>
            <div class="col-6 col-md-6">
              <div class="form-group">
                <label class="form-label">Password</label>

                <input type="password" class="form-control" name="password" value="<?php echo htmlspecialchars($detail['password']); ?>">
              </div>
            </div>
            <div class="col-6 col-md-6">
              <label class="form-label">Confirm Password</label>
              <input type="password" class="form-control" name="confirm_password" value="<?php echo htmlspecialchars($detail['password']); ?>">
            </div>
          </div> <!-- / .row -->

          <!-- Button -->
          <button type="submit" class="btn btn-primary" name="save-changes">Save changes</button>

          <!-- Divider -->
          <hr class="mt-4 mb-5">

          <div class="row justify-content-between">
            <div class="col-12 col-md-6">

              <!-- Heading -->
              <h4>
                Close your account
              </h4>

              <!-- Text -->
              <p class="small text-muted mb-md-0">
                Please note, closing your account is a permanent action and will no be recoverable once completed.
              </p>

            </div>
            <div class="col-auto">

              <!-- Button -->
              <button type="submit" class="btn btn-danger" name="close-account" onclick="return confirm('Are you sure? Your account will be disabled and deleted after 14 days, all your records will be lost.')">Close account</button>

            </div>
          </div> <!-- / .row -->

        </form>
        <?php } ?>
        <br><br>

      </div>
    </div> <!-- / .row -->
  </div>

</div> <!-- / .main-content -->

<!-- Google Maps autocomplete script -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZm4AFgY_p4lNYcGbcaB26K3JWiLIeZOA&libraries=places&callback=initMap&solution_channel=GMP_QB_addressselection_v1_cABC" async defer></script>

<?php include 'template/footer.php'; ?>
