<?php
// ==========================================
// Date Created:   5/7/2022
// Developer: Richard Rodgers
// ==========================================
include '../db.php';
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ../login');
}
$pagename = "Services";
$pageheader = "Active Services";
include 'template/head.php';

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
                <?php echo $pagename; ?>
              </h6>

              <!-- Title -->
              <h1 class="header-title">
                <?php echo $pageheader; ?>
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
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          ###
        </div>
      </div> <!-- / .row -->
    </div><!-- End Container-fluid -->
  </div><!-- / .main-content -->

<?php include 'template/footer.php'; ?>
