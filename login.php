<?php
// ==========================================
// Date Created:   3/24/2022
// Developer: Richard Rodgers
// ==========================================
session_start();

$dba = "Verified";
$pagename = "Sign In";
include 'db.php';
$invalid_credentials = $empty_error = $email = $password = $suspended_err = $account_closed = $account_pending = null;


// The following script will check for an existing session, if it already exits, the script will also check for the current user role
// and send the user to it's rightful place.
if (isset($_SESSION['username'])) { // Run the rollowing script if SESSION already exists.
  $username = $_SESSION['username'];
  $sql = "SELECT `role` FROM `users` WHERE `email` = '".$username."' LIMIT 1";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

  foreach ($row as $user) {
    if ($user['role'] == "1") { // If user role is 'Admin', they shall be taken to the admin dashboard.
      header('Location: admin/dashboard');
    } elseif ($user['role'] == "2") { // Else if the user role is 'Client', obsiously they will be taken to the client interface.
      header('Location: client/index');
    }
  }
} elseif (isset($_POST['login'])) { // Run this script if session does not exist.
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $plain_pass = mysqli_real_escape_string($conn, $_POST['password']);

  if (!empty($email) && !empty($plain_pass)) { // If the email and password fields are NOT empty, run the following script.
    // Fetching the hashed password from the database using the email
    // address provided by the user input.
    $query = "SELECT * FROM `users` WHERE `email` = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $hash = $row['password']; // The hashed password retrieved from the database
    // is stored inside the '$hash' variable.

    $verify = password_verify($plain_pass, $hash); // Checking to see if the password entered
    // matches the hashed password in the database.

    if ($verify == true) {
      if ($row['status'] == "active") {
        if ($row['role'] == '1') {
          $_SESSION['username'] = $email;
          header('Location: admin/dashboard');
        } elseif ($row['role'] == '2') {
          $_SESSION['username'] = $email;
          header('Location: client/index');
        }
      } if ($row['status'] == "pending") {
        $account_pending = "<div class='alert alert-warning text-white'>Sorry! Your account is pending, please try again later.</div>";
      } if ($row['status'] == "suspended") {
        $suspended_err = "<div class='alert alert-danger'>Your account has been suspended. For more information please contact us at 513-318-5632.</div>";
      } if ($row['status'] == "closed") {
        $account_closed = "<div class='alert alert-danger'>As per your request, this account is scheduled to be deleted. For assistance call 513-318-5632.</div>";
      }
    } else {
      $invalid_credentials = "<div class='alert alert-danger'>Invalid credentials, please try again!</div>";
    }

  } else {
    $empty_error = "<div class='alert alert-warning'>All fields are required, please try again!</div>";
  }

}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Create and review orders by signing in." />

    <!-- Favicon -->
    <link rel="shortcut icon" href="./assets/favicon/favicon.ico" type="image/x-icon"/>

    <!-- Theme CSS -->
    <link rel="stylesheet" href="assets/theme.bundle.css" />

    <!-- Title -->
    <title><?php echo $pagename, " - ", $dba; ?></title>
  </head>
  <body class="d-flex align-items-center bg-auth border-top border-top-2 border-primary">

    <!-- CONTENT
    ================================================== -->
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-12 col-md-5 col-lg-6 col-xl-4 px-lg-6 my-5 align-self-center">

          <!-- Heading -->
          <h1 class="display-4 text-center mb-3">
            Sign in
          </h1>

          <!-- Subheading -->
          <p class="text-muted text-center mb-5">
            Create and review orders by signing in.
          </p>

          <?php echo $invalid_credentials; ?>
          <?php echo $empty_error; ?>
          <?php echo $suspended_err; ?>
          <?php echo $account_closed; ?>
          <?php echo $account_pending; ?>

          <?php
            if(isset($_SESSION['success'])&&$_SESSION['success']){
              echo "<div class=\"alert alert-success\">{$_SESSION['success']}</div>";
              unset($_SESSION['success']);
            }
          ?>
          <!-- Form -->
          <form method="POST" autocomplete="off">

            <!-- Email address -->
            <div class="form-group">

              <!-- Label -->
              <label class="form-label">
                Email Address
              </label>

              <!-- Input -->
              <input class="form-control" type="email" name="email" placeholder="name@address.com" value="<?php echo $email; ?>" autocomplete="off">

            </div>

            <!-- Password -->
            <div class="form-group">
              <div class="row">
                <div class="col">

                  <!-- Label -->
                  <label class="form-label">
                    Password
                  </label>

                </div>
                <div class="col-auto">

                  <!-- Help text -->
                  <a href="#" class="form-text small text-muted">
                    Forgot password?
                  </a>

                </div>
              </div> <!-- / .row -->

              <!-- Input group -->
              <div class="input-group input-group-merge">

                <!-- Input -->
                <input class="form-control" type="password" name='password' placeholder="Enter your password" value="<?php echo $password; ?>">

                <!-- Icon -->
                <span class="input-group-text">
                  <i class="fe fe-eye"></i>
                </span>

              </div>
            </div>

            <!-- Submit -->
            <button type="submit" name="login" class="btn btn-lg w-100 btn-primary mb-3">
              Sign in
            </button>

            <!-- Link -->
            <p class="text-center">
              <small class="text-muted text-center">
                Don't have an account yet? <a href="register">Sign up</a>.
              </small>
            </p>

          </form>

        </div>
        <div class="col-12 col-md-7 col-lg-6 col-xl-8 d-none d-lg-block">

          <!-- Image -->
          <div class="bg-cover h-100 min-vh-100 mt-n1 me-n3" style="background-image: url(assets/img/auth-side-cover.jpg);"></div>

        </div>
      </div> <!-- / .row -->
    </div>

    <!-- JAVASCRIPT -->
    <!-- Map JS -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.js'></script>

    <!-- Vendor JS -->
    <script src="./assets/js/vendor.bundle.js"></script>

    <!-- Theme JS -->
    <script src="./assets/js/theme.bundle.js"></script>

  </body>
</html>
