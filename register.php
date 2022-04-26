<?php
// ==========================================
// Date Created:   3/24/2022
// Developer: Richard Rodgers
// ==========================================
$dba = "Verified";
$pagename = "Join";
include 'db.php';

$empty_error = $email_registered = $first_name = $last_name = $email = $password = null;

// if the register button is clicked, the following script will run.
if (isset($_POST['register'])) {
  $first_name = $_POST['fname'];
  $last_name = $_POST['lname'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $email_check = mysqli_query($conn, "SELECT id FROM users WHERE email = '".$email."'"); // Checks to see if the email provided is already in the database

  // Checking for results
  if (mysqli_num_rows($email_check) > 0) {
    $email_registered = "<small class='text-danger'>The email address provided is already in use.</small>";
  } else { // If the email provided is not registered, proceed with the INSERT by first checking to see if all fields were filled out.
    if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($password)) {
      $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $first_name, $last_name, $email, $password);
      $result = $stmt->execute();

      if (!$result) { // If the code above failed to execute, this script will run.
        echo("Unable to create account: " . mysqli_error($conn));
      } else { // Else, if the registration was successful.. The user will be taken to the login page with a success message.
        header('Location: login?signup=success');
      }
    } else { // Display error message if any of the required fields are missing an input.
      $empty_error = "<p class='text-warning'>All fields are required.</p>";
    }
  }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Verified Properties Software" />

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
            Sign up
          </h1>

          <!-- Subheading -->
          <p class="text-muted text-center mb-5">
            Let our growing network of field reps work for you.
          </p>
          <?php echo $empty_error; ?>

          <!-- Form -->
          <form class="row g-3" method="POST">

            <div class="col-6">
              <label class="form-label">First Name</label>
              <input class="form-control" type="text" name="fname" placeholder="John" value="<?php echo $first_name; ?>">
            </div>

            <div class="col-6">
              <label class="form-label">Last Name</label>
              <input class="form-control" type="text" name="lname" placeholder="Smith" value="<?php echo $last_name; ?>">
            </div>

            <div class="col-12">
              <label class="form-label">Work Email</label>
              <input class="form-control" type="email" name="email" placeholder="name@address.com" value="<?php echo $email; ?>">
              <?php echo $email_registered; ?>
            </div>

            <div class="col-12">
              <label class="form-label">Password</label>
              <input class="form-control" type="password" name="password" placeholder="Enter your password" value="<?php echo $password; ?>">
            </div>

            <div class="col-12">
              <button class="btn btn-lg w-100 btn-primary mt-3 mb-3" type="submit" name="register">Join Verified</button>
            </div>

            <div class="col-12">
              <div class="text-center">
                <small class="text-muted text-center">
                  Already have an account? <a href="login">Log in</a>.
                </small>
              </div>
            </div>

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
