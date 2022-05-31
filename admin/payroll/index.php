<?php
// ==========================================
// Date Created:   5/29/2022
// Developer: Richard Rodgers
// ==========================================
include '../../db.php';
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ../../login');
}
$pagename = "Payroll";
$pageheader = "";
include '../template/head.php';
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
            </div> <!-- / .row -->
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <!-- Errors goes in here -->
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
                        <a class="list-sort text-muted" data-sort="item-client" href="#">Name</a>
                      </th>
                      <th>
                        <a class="list-sort text-muted" data-sort="item-location" href="#">Order Count</a>
                      </th>
                      <th>
                        <a class="list-sort text-muted" data-sort="item-county" href="#">Payable</a>
                      </th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody class="list">
                    <tr>
                      <td>Richard Rodgers</td>
                      <td>55</td>
                      <td>$550.00</td>
                      <td class="text-end">

                        <!-- Dropdown -->
                        <div class="dropdown">
                          <a class="dropdown-ellipses dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fe fe-more-vertical"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <form method="post" action="process.php">
                              <input type="hidden" name="form_id" value="">
                              <button type="submit" name="delete_form" class="dropdown-item">Delete</button>
                            </form>
                            <a href="form-details?form_id=" class="dropdown-item">Form Details</a>
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
              </div>
            </div>
          </div>
        </div> <!-- / .row -->
      </div>
    </div>
  </div>
</div> <!-- / .main-content -->

<?php include '../template/footer.php'; ?>
