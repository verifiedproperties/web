<?php
// ==========================================
// Date Created:   4/13/2022
// Developer: Richard Rodgers
// ==========================================
include '../db.php';
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ../login');
}
$pagename = "Completed";
$pageheader = "Create a new order";
include 'template/head.php';

$emptyFields = $order_canceled = null;

// Applying filters
if (isset($_POST['apply-filter'])) {
  $from_date = $_POST['from_date'];
  $to_date = $_POST['to_date'];

  $query = "SELECT * FROM `work-orders` WHERE `date_completed` BETWEEN '".$from_date."' AND '".$to_date."' ORDER BY `date_completed` DESC";
  $result = mysqli_query($conn, $query);
  $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else { // Fetches unfiltered completed results

  $sql = "SELECT * FROM `work-orders` WHERE status = '4' ORDER BY date_created DESC";
  $result = mysqli_query($conn, $sql);
  $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
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
                    <a href="#!" class="nav-link text-nowrap">
                      Open <span class="badge rounded-pill bg-secondary-soft"><?php OpenOrders($conn); ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="pending" class="nav-link text-nowrap">
                      Pending <span class="badge rounded-pill bg-secondary-soft"><?php PendingOrders($conn); ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="completed" class="nav-link text-nowrap active">
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
            <?php echo $order_canceled; ?>
            <?php if(isset($_SESSION['error'])&&$_SESSION['error']){
              echo "<div class=\"alert alert-danger\">{$_SESSION['error']}</div>";
              unset($_SESSION['error']);
            }
            if(isset($_SESSION['success'])&&$_SESSION['success']){
              echo "<div class=\"alert alert-success\">{$_SESSION['success']}</div>";
              unset($_SESSION['success']);
            }
            ?>
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
                      <form class="dropdown-menu dropdown-menu-end dropdown-menu-card" method="post">
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
                          <div class="row">
                            <small class="mb-5">Filter by completed date</small>
                          </div>
                          <!-- List group -->
                          <div class="list-group list-group-flush mt-n4 mb-4">
                            <div class="list-group-item">
                              <div class="row">
                                <div class="col">

                                  <!-- Text -->
                                  <small>From</small>

                                </div>
                                <div class="col-auto">
                                  <input type="text" class="form-control" name="from_date" placeholder="Select date" data-flatpickr>
                                </div>
                              </div> <!-- / .row -->
                            </div>
                            <div class="list-group-item">
                              <div class="row">
                                <div class="col">

                                  <!-- Text -->
                                  <small>To</small>

                                </div>
                                <div class="col-auto">
                                  <input type="text" class="form-control" name="to_date" placeholder="Select date" data-flatpickr>
                                </div>
                              </div> <!-- / .row -->
                            </div>
                          </div>

                          <!-- Button -->
                          <button type="submit" class="btn w-100 btn-primary" name="apply-filter">Apply Filter</button>

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
                        <a class="list-sort text-muted" data-sort="item-approved" href="#">Approved</a>
                      </th>
                      <th>
                        <a class="list-sort text-muted" data-sort="item-approved-by" href="#">Approve by</a>
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
                      <td>-</td>
                      <td>-</td>
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
                              <button type="submit" name="cancel-order" class="dropdown-item">Reopen</button>
                            </form>
                            <button type="button" name="view-report" class="dropdown-item">View report</button>
                            <button type="button" name="download-gallery" class="dropdown-item">Download Gallery</button>
                            <button type="button" name="reject-order" class="dropdown-item">Reject Order</button>
                          </div>
                        </div>

                      </td>
                    </tr>
                  </tbody>
                  <?php } ?>
                </table>
              </div>
              <?php if (mysqli_num_rows($result) <= 0) {
                echo "<p class='text-center mt-4 mb-4'>There are no work orders to display.</p>";
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
                      <button class="btn btn-sm btn-white-20" data-bs-toggle="modal" data-bs-target="#modalMembers">
                        Assign
                      </button>

                      <!-- Button -->
                      <button class="btn btn-sm btn-white-20">
                        Cancel
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

<!-- MODALS -->
<!-- Modal: Members -->
<div class="modal fade" id="modalMembers" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-card card" data-list='{"valueNames": ["name"]}'>
        <div class="card-header">

          <!-- Title -->
          <h4 class="card-header-title" id="exampleModalCenterTitle">
            Assign work order(s)
          </h4>

          <!-- Close -->
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>
        <div class="card-body">
          <form method="post" id="user-selection">
            <select class="form-select" name="users-list">
              <?php foreach ($users as $user) { ?>
              <option value="<?php echo htmlspecialchars($user['id']); ?>"><?php echo htmlspecialchars($user['first_name']), ' ', htmlspecialchars($user['last_name']); ?></option>
              <?php }; ?>
            </select>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" name="assign-orders" class="btn btn-primary" form="user-selection">Assign</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Google Maps autocomplete script -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZm4AFgY_p4lNYcGbcaB26K3JWiLIeZOA&libraries=places&callback=initMap&solution_channel=GMP_QB_addressselection_v1_cABC" async defer></script>
<script type="text/javascript">
  $(document).ready(function () {
    let button = `<button type='button' onclick="window.location.href='download-csv.php?id=<?=implode(',', $ids)?>'" class='btn btn-sm btn-info'><i class="fe fe-arrow-down"></i>CSV</button>`;
    $('#csvbuttoncontainer').html(button);
  })
</script>
<?php include 'template/footer.php'; ?>
