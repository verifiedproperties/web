<?php
// ==========================================
// Date Created:   0/0//0000
// Developer: Richard Rodgers
// ==========================================
include '../db.php';
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ../login');
}
$pagename = "Blank";
$pageheader = "Create a new order";
include 'template/head.php';

$emptyFields = null;
?>

<?php include 'template/offcanvas.php'; ?>
<?php include 'template/navigation.php'; ?>

  <!-- MAIN CONTENT -->
  <div class="main-content">
    <!-- HEADER -->
    <div class="header">
      <div class="container-fluid">

        <!-- Body -->
        <div class="header-body">
          <div class="row align-items-end">
            <div class="col">

              <!-- Pretitle -->
              <h6 class="header-pretitle">
                Page name
              </h6>

              <!-- Title -->
              <h1 class="header-title">
                Header title
              </h1>

            </div>
          </div> <!-- / .row -->
        </div> <!-- / .header-body -->

      </div>
    </div> <!-- / .header -->

    <!-- CARDS -->
    <div class="container-fluid">
      <div class="row">

      </div>
    </div><!-- End contianer-fluid -->
  </div><!-- / .main-content -->

<!-- Google Maps autocomplete script -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZm4AFgY_p4lNYcGbcaB26K3JWiLIeZOA&libraries=places&callback=initMap&solution_channel=GMP_QB_addressselection_v1_cABC" async defer></script>

<?php include 'template/footer.php'; ?>
