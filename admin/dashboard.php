<?php
// ==========================================
// Date Created:   3/25/2022
// Developer: Richard Rodgers
// ==========================================
include '../db.php';
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ../login');
}
$pagename = "Dashboard";
$pageheader = null;
include 'template/head.php';

// Getting total count of "pending" accounts
$pending_accounts = "SELECT `id` FROM `users` WHERE `status` = 'pending'";
if ($result = mysqli_query($conn, $pending_accounts)) {
  // Assigns count to the '$accounts_pending' veriable
  $accounts_pending = mysqli_num_rows($result);
}

?>
<?php include 'template/offcanvas.php'; ?>
<?php include 'template/navigation.php'; ?>

  <!-- MAIN CONTENT -->
  <div class="main-content">
    <!-- HEADER -->
    <div class="header">
      <div class="container">

        <!-- Body -->
        <div class="header-body">
          <div class="row align-items-end">
            <div class="col">

              <!-- Pretitle -->
              <h6 class="header-pretitle">
                Overview
              </h6>

              <!-- Title -->
              <h1 class="header-title">
                Dashboard
              </h1>

            </div>
            <div class="col-auto">

              <!-- Button -->
              <a href="new-order" class="btn btn-secondary lift">
                Create Order
              </a>

            </div>
          </div> <!-- / .row -->
        </div> <!-- / .header-body -->

      </div>
    </div> <!-- / .header -->

    <!-- CARDS -->
    <div class="container">
      <div class="row">
        <div class="col-12">
          <?php
            if ($accounts_pending >= 1) {
              echo "<a href='pending-accounts'><div class='alert alert-warning text-white'><i class='fe fe-users'></i> There are $accounts_pending account(s) pending activation!</div></a>";
            }
          ?>
        </div>
      </div>
      <div class="row">
        <div class="col-6 col-lg-6 col-xl">

          <!-- Value  -->
          <div class="card">
            <div class="card-body">
              <div class="row align-items-center gx-0">
                <div class="col">

                  <!-- Title -->
                  <h6 class="text-uppercase text-muted mb-2">
                    Open orders
                  </h6>

                  <!-- Heading -->
                  <span class="h2 mb-0">
                    <?php OpenOrders($conn); ?>
                  </span>
                </div>
                <div class="col-auto">

                  <!-- Icon -->
                  <span class="h2 fe fe-briefcase text-muted mb-0"></span>

                </div>
              </div> <!-- / .row -->
            </div>
          </div>

        </div>
        <div class="col-6 col-lg-6 col-xl">

          <!-- Hours -->
          <div class="card">
            <div class="card-body">
              <div class="row align-items-center gx-0">
                <div class="col">

                  <!-- Title -->
                  <h6 class="text-uppercase text-muted mb-2">
                    Pending acceptance
                  </h6>

                  <!-- Heading -->
                  <span class="h2 mb-0">
                    <?php PendingOrders($conn); ?>
                  </span>

                </div>
                <div class="col-auto">

                  <!-- Icon -->
                  <span class="h2 fe fe-star text-muted mb-0"></span>

                </div>
              </div> <!-- / .row -->
            </div>
          </div>

        </div>
        <div class="col-6 col-lg-6 col-xl">

          <!-- Exit -->
          <div class="card">
            <div class="card-body">
              <div class="row align-items-center gx-0">
                <div class="col">

                  <!-- Title -->
                  <h6 class="text-uppercase text-muted mb-2">
                    Rejected
                  </h6>

                  <!-- Heading -->
                  <span class="h2 mb-0">
                    <?php RejectedOrders($conn); ?>
                  </span>

                </div>
              </div> <!-- / .row -->
            </div>
          </div>

        </div>
        <div class="col-6 col-lg-6 col-xl">

          <!-- Time -->
          <div class="card">
            <div class="card-body">
              <div class="row align-items-center gx-0">
                <div class="col">

                  <!-- Title -->
                  <h6 class="text-uppercase text-muted mb-2">
                    Completed
                  </h6>

                  <!-- Heading -->
                  <span class="h2 mb-0">
                    <?php CompletedOrders($conn); ?>
                  </span>

                </div>
                <div class="col-auto">

                  <!-- Icon -->
                  <span class="h2 fe fe-archive text-muted mb-0"></span>

                </div>
              </div> <!-- / .row -->
            </div>
          </div>

        </div>
      </div> <!-- / .row -->
    </div><!-- End Container-fluid -->
  </div><!-- / .main-content -->

<?php include 'template/footer.php'; ?>
