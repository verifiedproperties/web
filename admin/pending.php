<?php
// ==========================================
// Date Created:   4/12/2022
// Developer: Richard Rodgers
// ==========================================
include '../db.php';
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ../login');
}
$pagename = "Pending";
$pageheader = "Create a new order";
include 'template/head.php';

$emptyFields = $order_approved = $order_rejected = null;

// Approving single orders by updating the orders tatus to "4"
if (isset($_POST['approve'])) {
  $order_id = $_POST['order_id'];
  $order_address = $_POST['order_address'];
  $sql = "UPDATE `work-orders` SET `status` = '4' WHERE `id` = '$order_id'";
  if (mysqli_query($conn, $sql)) {
    $order_approved = "<div class='alert alert-success'>You approved the order at $order_address.</div>";
  } else {
    header('Location: pending');
  }
}

// Rejecting single orders by updating the orders tatus to "rejected"
if (isset($_POST['reject'])) {
  $order_id = $_POST['order_id'];
  $order_address = $_POST['order_address'];
  $sql = "UPDATE `work-orders` SET `status` = '3' WHERE `id` = '$order_id'";
  if (mysqli_query($conn, $sql)) {
    $order_rejected = "<div class='alert alert-success'>The order at $order_address has been rejected.</div>";
  } else {
    header('Location: pending');
  }
}

// Fetching orders from database
$sql = "SELECT * FROM `work-orders` WHERE status = '2' ORDER BY date_completed DESC";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<?php include 'template/offcanvas.php'; ?>
<?php include 'template/navigation.php'; ?>

<!-- MAIN CONTENT -->
<div class="main-content">

  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">

        <!-- Header -->
        <div class="header">
          <div class="header-body">
            <div class="row align-items-center">
              <div class="col">

                <!-- Pretitle -->
                <h6 class="header-pretitle">
                  Overview
                </h6>

                <!-- Title -->
                <h1 class="header-title text-truncate">
                  <?php echo $pagename; ?>
                </h1>

              </div>
              <div class="col-auto">

                <!-- Buttons -->
                <a href="new-order" class="btn btn-secondary ms-2">
                  <span class="fe fe-plus"></span>New Order
                </a>

              </div>
            </div> <!-- / .row -->
            <div class="row align-items-center">
              <div class="col">

                <!-- Nav -->
                <ul class="nav nav-tabs nav-overflow header-tabs">
                  <li class="nav-item">
                    <a href="open-orders" class="nav-link text-nowrap">
                      Open <span class="badge rounded-pill bg-secondary-soft"><?php OpenOrders($conn); ?></span>
                    </a>
                  </li
                  <li class="nav-item">
                    <a href="pending" class="nav-link text-nowrap active">
                      Pending <span class="badge rounded-pill bg-secondary-soft"><?php PendingOrders($conn); ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="completed" class="nav-link text-nowrap">
                      Completed <span class="badge rounded-pill bg-secondary-soft"><?php CompletedOrders($conn); ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="canceled" class="nav-link text-nowrap">
                      Canceled <span class="badge rounded-pill bg-secondary-soft"><?php CanceledOrders($conn); ?></span>
                    </a>
                  </li>
                </ul>

              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <?php echo $order_approved; ?>
            <?php echo $order_rejected; ?>
          </div>
        </div>

      </div>
    </div> <!-- / .row -->
  </div>

  <!-- Tab content -->
  <div class="tab-content">
    <div class="tab-pane fade show active" id="dealsListPane" role="tabpanel" aria-labelledby="dealsListTab">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12">

            <!-- Card -->
            <div class="card" data-list='{"valueNames": ["item-name", "item-stage", "item-amount", "item-owner", "item-contacted"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="dealsList">
              <div class="card-header">
                <div class="row align-items-center">
                  <div class="col">

                    <!-- Form -->
                    <form>
                      <div class="input-group input-group-flush input-group-merge input-group-reverse">
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
                        <option selected>5 per page</option>
                        <option>10 per page</option>
                        <option>All</option>
                      </select>
                    </form>

                  </div>
                  <div class="col-auto">

                    <!-- Dropdown -->
                    <div class="dropdown">

                      <!-- Toggle -->
                      <button class="btn btn-sm btn-white" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
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
                                  <small>Stage</small>

                                </div>
                                <div class="col-auto">

                                  <!-- Select -->
                                  <select class="form-select form-select-sm" name="item-title" data-choices='{"searchEnabled": false}'>
                                    <option value="*" selected>Any</option>
                                    <option value="Appointment scheduled">Appointment scheduled</option>
                                    <option value="Kickoff call">Kickoff call</option>
                                    <option value="Quote accepted">Quote accepted</option>
                                    <option value="Project in progress">Project in progress</option>
                                    <option value="Initial review">Initial review</option>
                                    <option value="Final review">Final review</option>
                                    <option value="Completed">Completed</option>
                                  </select>

                                </div>
                              </div> <!-- / .row -->
                            </div>
                            <div class="list-group-item">
                              <div class="row">
                                <div class="col">

                                  <!-- Text -->
                                  <small>Owner</small>

                                </div>
                                <div class="col-auto">

                                  <!-- Select -->
                                  <select class="form-select form-select-sm" name="item-score" data-choices='{"searchEnabled": false}'>
                                    <option value="*" selected>Any</option>
                                    <option value="Dianna Smiley">Dianna Smiley</option>
                                    <option value="Ab Hadley">Ab Hadley</option>
                                    <option value="Adolfo Hess">Adolfo Hess</option>
                                    <option value="Daniela Dewitt">Daniela Dewitt</option>
                                    <option value="Miyah Myles">Miyah Myles</option>
                                    <option value="Ryu Duke">Ryu Duke</option>
                                    <option value="Glen Rouse">Glen Rouse</option>
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
                  <div class="col-auto me-n3" id="csvbuttoncontainer">

                  </div>
                </div> <!-- / .row -->
              </div>
              <div class="table-responsive">
                <table class="table table-sm table-hover table-nowrap card-table">
                  <thead>
                    <tr>
                      <th>

                        <!-- Checkbox -->
                        <div class="form-check mb-n2">
                          <input class="form-check-input list-checkbox-all" type="checkbox" id="listCheckboxAll">
                          <label class="form-check-label" for="listCheckboxAll"></label>
                        </div>

                      </th>
                      <th>
                        <a class="list-sort text-muted" data-sort="item-client" href="#">Client</a>
                      </th>
                      <th>
                        <a class="list-sort text-muted" data-sort="item-location" href="#">Location</a>
                      </th>
                      <th>
                        <a class="list-sort text-muted" data-sort="item-county" href="#">County</a>
                      </th>
                      <th>
                        <a class="list-sort text-muted" data-sort="item-service" href="#">Service</a>
                      </th>
                      <th>
                        <a class="list-sort text-muted" data-sort="item-start" href="#">Start</a>
                      </th>
                      <th>
                        <a class="list-sort text-muted" data-sort="item-due" href="#">Due</a>
                      </th>
                      <th>
                        <a class="list-sort text-muted" data-sort="item-completed" href="#">Completed</a>
                      </th>
                      <th>
                        <a class="list-sort text-muted" data-sort="item-assignee" href="#">Assignee</a>
                      </th>
                      <th colspan="2">
                        <a class="list-sort text-muted" data-sort="item-created" href="#">Created</a>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="list">
                    <?php foreach ($rows as $row) {
                      $ids[] = $row['id'];
                      ?>
                    <tr>
                      <td>

                        <!-- Checkbox -->
                        <div class="form-check">
                          <input class="form-check-input list-checkbox" type="checkbox" id="listCheckboxOne">
                          <label class="form-check-label" for="listCheckboxOne"></label>
                        </div>

                      </td>
                      <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                      <td>

                        <!-- Text -->
                        <span class="item-stage">
                          <?php echo htmlspecialchars($row['street_address']); ?><br>
                          <?php echo $row['city'], ", ", $row['state'], ", ", $row['zip']; ?>
                        </span>

                      </td>
                      <td><?php echo htmlspecialchars($row['county']); ?></td>
                      <td>

                        <!-- Text -->
                        <span class="item-service"><?php echo htmlspecialchars($row['service']); ?></span>

                      </td>
                      <td><?php echo htmlspecialchars(date('M d, Y', strtotime($row['start_date']))); ?></td>
                      <td><?php echo htmlspecialchars(date('M d, Y', strtotime($row['due_date']))); ?></td>
                      <td><?php echo htmlspecialchars(date('M d, Y', strtotime($row['date_completed']))); ?></td>
                      <td><?php echo htmlspecialchars($row['assignee']); ?></td>
                      <td><?php echo htmlspecialchars(date('M d, Y', strtotime($row['date_created']))); ?></td>
                      <td class="text-end">

                        <!-- Dropdown -->
                        <div class="dropdown">
                          <a class="dropdown-ellipses dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fe fe-more-vertical"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <form method="post">
                              <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                              <input type="hidden" name="order_address" value="<?php echo htmlspecialchars($row['street_address']); ?>">
                              <button type="submit" class="dropdown-item" name="reject">Reject</button>
                              <button type="submit" class="dropdown-item" name="approve">Approve</button>
                            </form>
                            <a href="#!" class="dropdown-item">
                              Download Gallery
                            </a>
                          </div>
                        </div>

                      </td>
                    </tr>
                  </tbody>
                  <?php } ?>
                </table>
              </div>
              <?php if (mysqli_num_rows($result) <= 0) {
                echo "<p class='text-center mt-4 mb-4'>Yay, great job! You're all caught up.</p>";
              } ?>
              <div class="card-footer d-flex justify-content-between">

                <!-- Pagination (prev) -->
                <ul class="list-pagination-prev pagination pagination-tabs card-pagination">
                  <li class="page-item">
                    <a class="page-link ps-0 pe-4 border-end" href="#">
                      <i class="fe fe-arrow-left me-1"></i> Prev
                    </a>
                  </li>
                </ul>

                <!-- Pagination -->
                <ul class="list-pagination pagination pagination-tabs card-pagination"></ul>

                <!-- Pagination (next) -->
                <ul class="list-pagination-next pagination pagination-tabs card-pagination">
                  <li class="page-item">
                    <a class="page-link ps-4 pe-0 border-start" href="#">
                      Next <i class="fe fe-arrow-right ms-1"></i>
                    </a>
                  </li>
                </ul>

                <!-- Alert -->
                <div class="list-alert alert alert-dark alert-dismissible border fade" role="alert">

                  <!-- Content -->
                  <div class="row align-items-center">
                    <div class="col">

                      <!-- Checkbox -->
                      <div class="form-check">
                        <input class="form-check-input" id="listAlertCheckbox" type="checkbox" checked disabled>
                        <label class="form-check-label text-white" for="listAlertCheckbox">
                          <span class="list-alert-count">0</span> Order(s)
                        </label>
                      </div>

                    </div>
                    <div class="col-auto me-n3">

                      <!-- Button -->
                      <button class="btn btn-sm btn-white-20">
                        Approve
                      </button>

                      <!-- Button -->
                      <button class="btn btn-sm btn-white-20">
                        Reject
                      </button>

                    </div>
                  </div> <!-- / .row -->

                  <!-- Close -->
                  <button type="button" class="list-alert-close btn-close" aria-label="Close"></button>

                </div>
              </div>
            </div>
          </div>
        </div> <!-- / .row -->
      </div>
    </div>
  </div>

</div> <!-- / .main-content -->

<!-- Google Maps autocomplete script -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZm4AFgY_p4lNYcGbcaB26K3JWiLIeZOA&libraries=places&callback=initMap&solution_channel=GMP_QB_addressselection_v1_cABC" async defer></script>
<script type="text/javascript">
   $(document).ready(function () {
    let button = `<button type='button' onclick="window.location.href='download-csv.php?id=<?=implode(',', $ids)?>'" class='btn btn-sm btn-info'><i class="fe fe-arrow-down"></i>CSV</button>`;
    $('#csvbuttoncontainer').html(button);
  })
</script>
<?php include 'template/footer.php'; ?>
