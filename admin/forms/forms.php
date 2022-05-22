<?php
// ==========================================
// Date Created:   4/18//2022
// Developer: Richard Rodgers
// ==========================================
include '../../db.php';
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ../../login');
}
$pagename = "Forms";
$pageheader = "";
include '../template/head.php';

// Fetching forms
$query = "SELECT * FROM forms";
$result = mysqli_query($conn, $query);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<?php include '../template/offcanvas.php'; ?>
<?php include '../template/navigation.php'; ?>

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
                <a href="new-order" class="btn btn-secondary ms-2" data-bs-toggle="modal" data-bs-target="#new-form">
                  <span class="fe fe-plus"></span>New Form
                </a>

              </div>
            </div> <!-- / .row -->
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <!-- Add alerts here.. -->
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
                        <a class="list-sort text-muted" data-sort="item-location" href="#">Name</a>
                      </th>
                      <th>
                        <a class="list-sort text-muted" data-sort="item-county" href="#">Created</a>
                      </th>
                      <th>
                        <a class="list-sort text-muted" data-sort="item-service" href="#">Updated</a>
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
                          <input class="form-check-input list-checkbox" type="checkbox" id="listCheckboxOne" value="<?=$row['id']?>">
                          <label class="form-check-label" for="listCheckboxOne"></label>
                        </div>

                      </td>
                      <td><?php echo htmlspecialchars($row['id']); ?></td>
                      <td>

                        <!-- Text -->
                        <span class="item-stage">
                          <?php echo htmlspecialchars($row['name']); ?>
                        </span>

                      </td>
                      <td><?php echo htmlspecialchars($row['created']); ?></td>
                      <td>

                        <!-- Text -->
                        <span class="item-service"><?php echo htmlspecialchars($row['updated']); ?></span>

                      </td>
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
                  <?php } ?>
                </table>
              </div>
              <?php if (mysqli_num_rows($result) <= 0) {
                echo "<p class='text-center mt-4 mb-4'>There are no forms to display.</p>";
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

<!-- New form modal window -->
<div class="modal" id="new-form" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" class="row g-3">
          <div class="col-8">
            <label class="form-label">Form name</label>
            <input type="text" name="form_name" class="form-control" placeholder="Choose a name for your new form" required>
          </div>
          <div class="col-4">
            <label class="form-label">Photos required</label>
            <input type="number" name="photos_required" class="form-control">
          </div>
          <div class="col-12">
            <label class="form-label">Instructions</label>
            <textarea name="instructions" class="form-control" rows="3" required></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Crate form</button>
      </div>
    </div>
  </div>
</div>

<?php include '../template/footer.php'; ?>
