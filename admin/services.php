<?php
// ==========================================
// Date Created:   5/8/2022
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

// Fetching categories
$sql = "SELECT `id`, `name` FROM `categories`";
if ($result = mysqli_query($conn, $sql)) {
  $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// creates service in database
if (isset($_POST['create-service'])) {
  $category = $_POST['catedgory'];
  $title = $_POST['service-title'];
  $turnaround = $_POST['turnaround'];
  $price = $_POST['price'];
  $description = $_POST['description'];

  if (!empty($category) && !empty($title) && !empty($turnaround) && !empty($price) && !empty($description)) {
    $stmt = $conn->prepare("INSERT INTO `services` (title, turnaround, price, description, category)");
    $stmt->bind_param("sssss", $title, $turnaround, $price, $description);
    $result = $stmt->execute();

    if (false == $result) {
      echo "Failed to create service: " . mysqli_error($conn);
    } else {
      $_SESSION['service-created'] = "The service has been created successfully.";
      header('Location: services');
    }
  } else {
    header('Location: services.php?error=none');
  }
}
?>

<?php include 'template/offcanvas.php'; ?>
<?php //include 'template/navigation.php'; ?>

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
                  <?php echo $pagename; ?>
                </h6>

                <!-- Title -->
                <h1 class="header-title text-truncate">
                  <?php echo $pageheader; ?>
                </h1>

              </div>
              <div class="col-auto">

                <!-- Buttons -->
                <button type="button" name="new-service" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#servicemodal">New Service</button>

              </div>
            </div> <!-- / .row -->
          </div>
        </div>
        <!-- Alerts -->
        <div class="row">
          <div class="col-12">
            <?php
              if (isset($_SESSION['service-created'])) {
                echo $_SESSION['service-created'];
                unset($_SESSION['service-created']);
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
                        <a class="list-sort text-muted" data-sort="item-client" href="#">Id</a>
                      </th>
                      <th>
                        <a class="list-sort text-muted" data-sort="item-location" href="#">Title</a>
                      </th>
                      <th>
                        <a class="list-sort text-muted" data-sort="item-county" href="#">Turnaround Time</a>
                      </th>
                      <th>
                        <a class="list-sort text-muted" data-sort="item-service" href="#">Category</a>
                      </th>
                      <th>
                        <a class="list-sort text-muted" data-sort="item-start" href="#">Price</a>
                      </th>
                      <th>
                        <a class="list-sort text-muted" data-sort="item-due" href="#">Created</a>
                      </th>
                      <th>
                        <a class="list-sort text-muted" data-sort="item-assignee" href="#">Updated</a>
                      </th>
                      <th>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="list">
                    <tr>
                      <td>

                        <!-- Checkbox -->
                        <div class="form-check">
                          <input class="form-check-input list-checkbox" type="checkbox" id="listCheckboxOne">
                          <label class="form-check-label" for="listCheckboxOne"></label>
                        </div>

                      </td>
                      <td>32</td>
                      <td>

                        <!-- Text -->
                        <span class="item-stage">
                          Visual Inspection
                        </span>

                      </td>
                      <td>3-5 Days</td>
                      <td>

                        <!-- Text -->
                        <span class="item-service">Residential Real State</span>

                      </td>
                      <td>$24.99</td>
                      <td>August 13, 2022</td>
                      <td>August 18, 2022</td>
                      <td class="text-end">

                        <!-- Dropdown -->
                        <div class="dropdown">
                          <a class="dropdown-ellipses dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fe fe-more-vertical"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <form method="post">
                              <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                              <button type="submit" name="cancel-order" class="dropdown-item">Cancel</button>
                            </form>
                            <button type="button" class="dropdown-item" onclick="showAttachments('<?=$row['id']?>')" data-bs-toggle="modal" data-bs-target="#showAttachments">Show Attachments</button>
                          </div>
                        </div>

                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
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
            <select class="form-select" name="users-list" id="users-list">
              <?php foreach ($users as $user) { ?>
              <option value="<?php echo htmlspecialchars($user['id']); ?>"><?php echo htmlspecialchars($user['first_name']), ' ', htmlspecialchars($user['last_name']); ?></option>
              <?php }; ?>
            </select>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" name="assign-orders" id="assign-orders" class="btn btn-primary" form="user-selection">Assign</button>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="importCsv" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-card card">
        <div class="card-header">
          <!-- Title -->
          <h4 class="card-header-title" id="exampleModalCenterTitle">
            Import CSV
          </h4>

          <!-- Close -->
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>
        <form class="form-horizontal" action="save_bulk_orders.php" method="post" name="upload_excel" enctype="multipart/form-data">
          <div class="card-body">
                <fieldset>
                    <!-- File Button -->
                    <div class="form-group">
                        <div class="col-md-4">
                            <input type="file" name="file" id="file" class="input-large" required="">
                        </div>
                    </div>
                </fieldset>
          </div>
          <div class="modal-footer">
            <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="showAttachments" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-card card">
        <div class="card-header">
          <!-- Title -->
          <h4 class="card-header-title" id="exampleModalCenterTitle">
            Attachments
          </h4>

          <!-- Close -->
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>
        <div class="attachments-container">

        </div>
      </div>
    </div>
  </div>
</div>

<!-- New service modal window -->
<div class="modal" id="servicemodal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Service</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class=""method="post" class="row g-3" id="new-service">
          <div class="col-12 mb-3">
            <label class="form-label">Category</label>
            <select class="form-select" name="category">
              <?php foreach ($row as $category) { ?>
                <option value="<?php $category['id'];  ?>"><?php echo $category['name']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="col-12 mb-3">
            <label class="form-label">Service Title</label>
            <input type="text" name="service-title" class="form-control">
          </div>
          <div class="col-12 mb-3">
            <label class="form-label">Turnaround Time</label>
            <select class="form-select" name="turnaround">
              <option value="3-5">1-2 Days</option>
              <option value="">3-5 Days</option>
            </select>
          </div>
          <div class="col-12 mb-3">
            <label class="form-label">Price</label>
            <input type="text" name="price" class="form-control" placeholder="$0.00" data-inputmask="'alias': 'currency', 'numericInput': 'true', 'prefix': '$'">
          </div>
          <div class="col-12 mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="8" cols="50" class="form-control"></textarea>
          </div>
        </form>
      </div><!-- End modal body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="create-service" form="new-service">Create Service</button>
      </div>
    </div>
  </div>
</div>

<!-- Google Maps autocomplete script -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZm4AFgY_p4lNYcGbcaB26K3JWiLIeZOA&libraries=places&callback=initMap&solution_channel=GMP_QB_addressselection_v1_cABC" async defer></script>
<?php include 'template/footer.php'; ?>
