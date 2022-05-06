<?php
// ==========================================
// Date Created:   5/3//2022
// Developer: Richard Rodgers
// ==========================================
include '../db.php';
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ../login');
}
$pagename = "Network";
$pageheader = "Pending Members";
include 'template/head.php';

// Approving pending registrations
if (isset($_POST['approve'])) {
  $name = $_POST['name'];
  $userid = $_POST['userid'];
  $sql = "UPDATE `users` SET `status` = 'active' WHERE `id` = '$userid'";
  if ($result = mysqli_query($conn, $sql)) {
    $_SESSION['account-approved'] = "<div class='alert alert-success'>The account for $name has been approved.</div>";
    header('Location: pending-accounts');
  }
}

// Fetching pending accounts (users) only.
$sql = "SELECT id, first_name, last_name, email, phone FROM `users` WHERE `status` = 'pending' AND `role` = '2' ORDER BY `id` DESC";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<?php include 'template/offcanvas.php'; ?>
<?php include 'template/navigation.php'; ?>

<!-- MAIN CONTENT -->
<div class="main-content">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12">

        <!-- Header -->
        <div class="header">
          <div class="header-body">
            <div class="row align-items-center">
              <div class="col">

                <!-- Pretitle -->
                <h6 class="header-pretitle">
                  <?php echo $pagename; ?>
                </h6>

                <!-- Title -->
                <h1 class="header-title text-truncate">
                  <?php echo $pageheader; ?>
                </h1>

              </div>
            </div> <!-- / .row -->
            <div class="row align-items-center">
              <div class="col">

                <!-- Nav -->
                <ul class="nav nav-tabs nav-overflow header-tabs">
                  <li class="nav-item">
                    <a href="network" class="nav-link text-nowrap">
                      Active <span class="badge rounded-pill bg-secondary-soft"><?php ActiveUsers($conn); ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="inactive-accounts" class="nav-link text-nowrap">
                      Inactive <span class="badge rounded-pill bg-secondary-soft"><?php InactiveUsers($conn); ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="suspended-accounts" class="nav-link text-nowrap">
                      Suspended <span class="badge rounded-pill bg-secondary-soft"><?php SuspendedUsers($conn); ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="pending-accounts" class="nav-link text-nowrap active">
                      Pending <span class="badge rounded-pill bg-secondary-soft"><?php PendingUsers($conn); ?></span>
                    </a>
                  </li>
                </ul>

              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <?php
              if (isset($_SESSION['account-approved'])) {
                echo $_SESSION['account-approved'];
                unset($_SESSION['account-approved']);
              }
            ?>
          </div>
        </div>
        <!-- Contact Cards -->
        <div class="row">
          <!-- Cards -->
          <div data-list='{"valueNames": ["item-name", "item-title", "item-email", "item-phone", "item-score", "item-company"], "page": 9, "pagination": {"paginationClass": "list-pagination"}}' id="contactsCards">

            <!-- Header -->
            <div class="row align-items-center mb-4">
              <div class="col">

                <!-- Form -->
                <form>
                  <div class="input-group input-group-lg input-group-merge input-group-reverse">
                    <input class="form-control list-search" type="search" placeholder="Search">
                    <span class="input-group-text">
                      <i class="fe fe-search"></i>
                    </span>
                  </div>
                </form>

              </div>
              <div class="col-auto me-n3">

                <!-- Select -->
                <form>
                  <select class="form-select form-select-sm form-control-flush" data-choices='{"searchEnabled": false}'>
                    <option selected>9 per page</option>
                    <option>All</option>
                  </select>
                </form>

              </div>
              <div class="col-auto">

                <!-- Dropdown -->
                <div class="dropdown">

                  <!-- Toggle -->
                  <button class="btn btn-sm btn-white" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fe fe-sliders me-1"></i> Filter <span class="badge bg-primary ms-1 d-none">0</span>
                  </button>

                  <!-- Menu -->
                  <form class="dropdown-menu dropdown-menu-end dropdown-menu-card">
                    <div class="card-header">

                      <!-- Title -->
                      <h4 class="card-header-title">
                        Filters
                      </h4>

                      <!-- Link -->
                      <button class="btn btn-sm btn-link text-reset d-none" type="reset">
                        <small>Clear filters</small>
                      </button>

                    </div>
                    <div class="card-body">

                      <!-- List group -->
                      <div class="list-group list-group-flush mt-n4 mb-4">
                        <div class="list-group-item">
                          <div class="row">
                            <div class="col">

                              <!-- Text -->
                              <small>Title</small>

                            </div>
                            <div class="col-auto">

                              <!-- Select -->
                              <select class="form-select form-select-sm" name="item-title" data-choices='{"searchEnabled": false}'>
                                <option value="*" selected>Any</option>
                                <option value="Designer">Designer</option>
                                <option value="Developer">Developer</option>
                                <option value="Owner">Owner</option>
                                <option value="Founder">Founder</option>
                              </select>

                            </div>
                          </div> <!-- / .row -->
                        </div>
                        <div class="list-group-item">
                          <div class="row">
                            <div class="col">

                              <!-- Text -->
                              <small>Lead scrore</small>

                            </div>
                            <div class="col-auto">

                              <!-- Select -->
                              <select class="form-select form-select-sm" name="item-score" data-choices='{"searchEnabled": false}'>
                                <option value="*" selected>Any</option>
                                <option value="1/10">1+</option>
                                <option value="2/10">2+</option>
                                <option value="3/10">3+</option>
                                <option value="4/10">4+</option>
                                <option value="5/10">5+</option>
                                <option value="6/10">6+</option>
                                <option value="7/10">7+</option>
                                <option value="8/10">8+</option>
                                <option value="9/10">9+</option>
                                <option value="10/10">10</option>
                              </select>

                            </div>
                          </div> <!-- / .row -->
                        </div>
                      </div>

                      <!-- Button -->
                      <button class="btn w-100 btn-primary" type="submit">
                        Apply filter
                      </button>

                    </div>
                  </form>

                </div>

              </div>
            </div> <!-- / .row -->

            <!-- Body -->
            <div class="list row">
              <?php foreach ($row as $user) { ?>
              <div class="col-12 col-md-6 col-xl-4">

                <!-- Card -->
                <div class="card">
                  <div class="card-body">

                    <!-- Header -->
                    <div class="row align-items-center">
                      <div class="col">

                        <!-- Checkbox -->
                        <div class="form-check form-check-circle">
                          <input class="form-check-input list-checkbox" type="checkbox" id="cardsCheckboxOne">
                          <label class="form-check-label" for="cardsCheckboxOne"></label>
                        </div>

                      </div>
                      <div class="col-auto">

                        <!-- Dropdown -->
                        <div class="dropdown">
                          <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fe fe-more-vertical"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <form method="post">
                              <input type="hidden" name="name" value="<?php echo $user['first_name'], " ", $user['last_name']; ?>">
                              <input type="hidden" name="userid" value="<?php echo $user['id']; ?>">
                              <button type="submit" name="approve">Approve</button>
                            </form>
                          </div>
                        </div>

                      </div>
                    </div> <!-- / .row -->

                    <!-- Image -->
                    <a href="profile-posts.html" class="avatar avatar-xl card-avatar">
                      <img src="assets/img/default-profile-photo.svg" class="avatar-img rounded-circle" alt="...">
                    </a>

                    <!-- Body -->
                    <div class="text-center mb-5">

                      <!-- Heading -->
                      <h2 class="card-title">
                        <a class="item-name" href="profile-posts.html"><?php echo $user['first_name'], " ", $user['last_name']; ?></a>
                      </h2>

                      <!-- Text -->
                      <p class="small text-muted mb-3">
                        <span class="item-title">Designer</span> at <span class="item-company">Verified</span>
                      </p>

                      <!-- Buttons -->
                      <a class="btn btn-sm btn-white" href="<?php echo "tel:", $user['phone']; ?>">
                        <i class="fe fe-phone me-1"></i> Call
                      </a>
                      <a class="btn btn-sm btn-white" href="<?php echo "mailto:", $user['email']; ?>">
                        <i class="fe fe-mail me-1"></i> Email
                      </a>

                    </div>

                    <!-- Divider -->
                    <hr class="card-divider mb-0">

                    <!-- List group -->
                    <div class="list-group list-group-flush mb-n3">
                      <div class="list-group-item">
                        <div class="row">
                          <div class="col">

                            <!-- Text -->
                            <small>Location</small>

                          </div>
                          <div class="col-auto">

                            <!-- Text -->
                            <small>Butler County, Ohio</small>

                          </div>
                        </div> <!-- / .row -->
                      </div>
                      <div class="list-group-item">
                        <div class="row">
                          <div class="col">

                            <!-- Text -->
                            <small>Score</small>

                          </div>
                          <div class="col-auto">

                            <!-- Badge -->
                            <span class="item-score badge bg-danger-soft">1/10</span>

                          </div>
                        </div> <!-- / .row -->
                      </div>
                    </div>

                  </div>
                </div>

              </div>
              <?php } ?>
            </div>

            <!-- Pagination -->
            <div class="row g-0">

              <!-- Pagination (prev) -->
              <ul class="col list-pagination-prev pagination pagination-tabs justify-content-start">
                <li class="page-item">
                  <a class="page-link" href="#">
                    <i class="fe fe-arrow-left me-1"></i> Prev
                  </a>
                </li>
              </ul>

              <!-- Pagination -->
              <ul class="col list-pagination pagination pagination-tabs justify-content-center"></ul>

              <!-- Pagination (next) -->
              <ul class="col list-pagination-next pagination pagination-tabs justify-content-end">
                <li class="page-item">
                  <a class="page-link" href="#">
                    Next <i class="fe fe-arrow-right ms-1"></i>
                  </a>
                </li>
              </ul>

            </div>

            <!-- Alert -->
            <div class="list-alert alert alert-dark alert-dismissible border fade" role="alert">

              <!-- Content -->
              <div class="row align-items-center">
                <div class="col">

                  <!-- Checkbox -->
                  <div class="form-check">
                    <input class="form-check-input" id="cardAlertCheckbox" type="checkbox" checked disabled>
                    <label class="form-check-label text-white" for="cardAlertCheckbox">
                      <span class="list-alert-count">0</span> deal(s)
                    </label>
                  </div>

                </div>
                <div class="col-auto me-n3">

                  <!-- Button -->
                  <button class="btn btn-sm btn-white-20">
                    Suspend
                  </button>

                  <!-- Button -->
                  <button class="btn btn-sm btn-white-20">
                    Delete
                  </button>

                </div>
              </div> <!-- / .row -->

              <!-- Close -->
              <button type="button" class="list-alert-close btn-close" aria-label="Close">

              </button>

            </div>

          </div>
        </div><!-- End contact cards -->

      </div>
    </div> <!-- / .row -->
  </div><!-- End container -->

</div> <!-- / .main-content -->

<!-- Google Maps autocomplete script -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZm4AFgY_p4lNYcGbcaB26K3JWiLIeZOA&libraries=places&callback=initMap&solution_channel=GMP_QB_addressselection_v1_cABC" async defer></script>

<?php include 'template/footer.php'; ?>
