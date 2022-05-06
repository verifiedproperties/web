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
$pagename = "Open";
$pageheader = "Available Orders";
include 'template/head.php';

$emptyFields = $order_canceled = null;

// Cancel single orders
if (isset($_POST['cancel-order'])) {
  $order_id = $_POST['order_id'];
  $query = "UPDATE `work-orders` SET `status` = 'canceled' WHERE `id` = '$order_id'";

  if (mysqli_query($conn, $query)) {
    $order_canceled = "<div class='alert alert-success'>Your order has been canceled!</div>";
  } else {
    echo "Error canceling the order!";
  }
}

// Fetching users
$usersquery = "SELECT * FROM users";
$result = mysqli_query($conn, $usersquery);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Getting total count of pending orders
$query = "SELECT `id` FROM `work-orders` WHERE `status` = 'pending'";
if ($result = mysqli_query($conn, $query)) {
  // Assigns total number of pending orders to -> '$pending_orders' variable
  $pending_orders = mysqli_num_rows($result);
}

// Getting total count of open orders
$openquery = "SELECT `id` FROM `work-orders` WHERE `status` = 'open' OR `status` = 'rejected'";
if ($result = mysqli_query($conn, $openquery)) {
  // Assigns total number of pending orders to -> '$pending_orders' variable
  $open_orders = mysqli_num_rows($result);
}

// Getting total count of completed orders
$completedquery = "SELECT `id` FROM `work-orders` WHERE `status` = 'approved'";
if ($result = mysqli_query($conn, $completedquery)) {
  // Assigns total number of completed orders to -> '$completed_orders' variable
  $completed_orders = mysqli_num_rows($result);
}

// Fetching open orders
$sql = "SELECT `work-orders`.*, users.first_name, users.last_name FROM `work-orders` LEFT JOIN users ON `work-orders`.assignee = users.id WHERE `work-orders`.status = 'open' OR `work-orders` .status = 'rejected' ORDER BY date_created DESC";
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
                    <a href="#!" class="nav-link text-nowrap active">
                      Open <span class="badge rounded-pill bg-secondary-soft"><?php echo $open_orders; ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="pending" class="nav-link text-nowrap">
                      Pending <span class="badge rounded-pill bg-secondary-soft"><?php echo $pending_orders; ?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="completed" class="nav-link text-nowrap">
                      Completed <span class="badge rounded-pill bg-secondary-soft"><?php echo $completed_orders; ?></span>
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

                  <div class="col-auto me-n3" id="csvImportcontainer">
                      <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#importCsv">
                        <i class="fe fe-upload"></i> Import
                      </button>
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
                          <input class="form-check-input list-checkbox" type="checkbox" id="listCheckboxOne" value="<?=$row['id']?>">
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
                      <td><?=$row['first_name']?> <?=$row['last_name']?></td>
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

<!-- Google Maps autocomplete script -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZm4AFgY_p4lNYcGbcaB26K3JWiLIeZOA&libraries=places&callback=initMap&solution_channel=GMP_QB_addressselection_v1_cABC" async defer></script>

<script type="text/javascript">
  $('#assign-orders').click(function(){
    let id = $('#users-list').val();
    const tasks = [];
    const checkboxes = $('.list-checkbox');
    checkboxes.each(function(){
      if($(this).is(':checked')){
        tasks.push($(this).val());
      }
    })
    if(tasks.length > 0){
      $.ajax({
        url: 'ajax-assign-orders.php',
        type: 'POST',
        dataType:'json',
        data:{
          user_id: id,
          tasks: tasks
        },
        beforeSend: function(){
          $('body').css('opacity', '0.4');
          $('body').css('pointer-events', 'none');
        },
        success: function(data){
          $('body').css('opacity', '1');
          $('body').css('pointer-events', 'auto');
          if(data.code == 200){
            window.location.href = '';
          }
        }
      })
    }else{
      alert('Select tasks to assign!');
    }
    $('.btn-close').click();
  })


  $(document).ready(function () {
    <?php if(isset($ids)){ ?>

      let button = `<button type='button' onclick="window.location.href='download-csv.php?id=<?=implode(',', $ids)?>'" class='btn btn-sm btn-info'><i class="fe fe-download"></i> Export</button>`;
      $('#csvbuttoncontainer').html(button);
    <?php } ?>

  })

  function showAttachments(id) {
    $.ajax({
      url: 'fetch-attachments.php',
      type: 'POST',
      dataType: 'json',
      data: {
        id: id,
      },
      beforeSend: function(){
        $('.attachments-container').html('<i class="fe fe-spin fe-spinner"></i>');
      },
      success: function(data){
        if(data.length > 0){
          console.log('asdasd');
          let slides = '';
          let inner = '';
          let i = 0;
          data.forEach(function(val){
            slides += `<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="${i}" ${i==0?"class='active'":""} aria-current="true" aria-label="Slide ${i+1}"></button>`;
            inner += `<div class="carousel-item ${i==0?"active":""}">
                <img src="${val.file}" class="d-block w-100" alt="Attachment ${i+1}">
              </div>`
            i++;
          });
          let carousel = `<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              ${slides}
            </div>
            <div class="carousel-inner">
              ${inner}
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>`;
          $('.attachments-container').html(carousel);
        }
      }
    })

  }

</script>
<?php include 'template/footer.php'; ?>
