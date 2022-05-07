<?php
ob_start();
// ==========================================
// Date Created:   3/27/2022
// Developer: Richard Rodgers
// ==========================================
include '../db.php';
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ../login');
}
$pagename = "New Order";
$pageheader = "Create a new order";
include 'template/head.php';

$street_address = $query_error = $secondary_address = $city = $state = $zip = $county = $country = $owner = $start_date =
$due_date = $instructions = $client_name = $con = $service = $access_code = null;

if (isset($_POST['create-order'])) {
  $street_address = $_POST['street_address'];
  $secondary_address = $_POST['secondary_address'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $zip = $_POST['zip'];
  $county = $_POST['county'];
  $country = $_POST['country'];
  $owner = $_POST['owner_name'];
  $start_date = $_POST['start_date'];
  $due_date = $_POST['due_date'];
  $instructions = $_POST['instructions'];
  $client_name = $_POST['client_name'];
  $con = $_POST['con'];
  $service = $_POST['service'];
  $access_code = $_POST['access_code'];
  if (!empty($street_address) && !empty($city) && !empty($state) && !empty($zip) && !empty($client_name) && !empty($due_date) && !empty($service)) {
    $stmt = $conn->prepare("INSERT INTO `work-orders` (client_name, con, street_address, secondary_address, city, state, zip, county, country, owner, start_date, due_date, instructions, service, access_code) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param('sssssssssssssss', $client_name, $con, $street_address, $secondary_address, $city, $state, $zip, $county, $country, $owner, $start_date, $due_date, $instructions, $service, $access_code);
    $result = $stmt->execute();

    if (false == $result) {
      $query_error = "Failed to create order: " . mysqli_error($conn);
    } else {
      $workorder_id = $conn->insert_id;
      $attachments_error = '';
      $target_dir = "assets/attachments/";
      for ($i=0; $i < count($_FILES['files']['name']); $i++) {
        if($_FILES['files']['tmp_name'][$i] == ''){
          continue;
        }
        $target_file = $target_dir . time().'_'.basename($_FILES["files"]["name"][$i]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["files"]["tmp_name"][$i]);
        if($check !== false) {
          $uploadOk = 1;
        } else {
          $attachments_error .= "<br><b><u>".htmlspecialchars( basename( $_FILES["files"]["name"][$i]))."</u></b> File is not an image.";
          $uploadOk = 0;
          continue;
        }

        // Check file size
        if ($_FILES["files"]["size"][$i] > 500000) {
          $attachments_error .= "<br><b><u>".htmlspecialchars( basename( $_FILES["files"]["name"][$i]))."</u></b> Sorry, your file is too large.";
          $uploadOk = 0;
          continue;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
          $attachments_error .=  "<br><b><u>".htmlspecialchars( basename( $_FILES["files"]["name"][$i]))."</u></b>Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
          continue;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 1) {
          if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_file)) {
            $sql = "INSERT INTO attachments (`file`, `workorder_id`) VALUES('{$target_file}', '{$workorder_id}')";
            $conn->query($sql);
          }else{
            $attachments_error .=  "<br><b><u>".htmlspecialchars( basename( $_FILES["files"]["name"][$i]))."</u></b>Sorry, there was an error uploading your file.";
            continue;
          }
        }
      }
      $_SESSION['success'] = "Your order has been created!".$attachments_error;
      header('Location: open-orders');
      ob_end_flush();
    }
  } else {
    $_SESSION['emptyFields'] = "<div class='alert alert-warning text-white'>One or more required fields are empty, please try again!</div>";
  }
}
?>

<!-- Google Maps autocomplete script -->
<script>
"use strict";

function initMap() {
  const componentForm = [
    'location',
    'locality',
    'administrative_area_level_1',
    'country',
    'postal_code',
  ];
  const autocompleteInput = document.getElementById('location');
  const autocomplete = new google.maps.places.Autocomplete(autocompleteInput, {
    fields: ["address_components", "geometry", "name"],
    types: ["address"],
  });
  autocomplete.addListener('place_changed', function () {
    const place = autocomplete.getPlace();
    if (!place.geometry) {
      // User entered the name of a Place that was not suggested and
      // pressed the Enter key, or the Place Details request failed.
      window.alert('No details available for input: \'' + place.name + '\'');
      return;
    }
    place.address_components.forEach((comp)=> {
      if(comp.long_name.includes('County')){
        $('#county').val(comp.long_name.replace(' County', ''));
      }
    });
    fillInAddress(place);
  });

  function fillInAddress(place) {  // optional parameter
    const addressNameFormat = {
      'street_number': 'short_name',
      'route': 'long_name',
      'locality': 'long_name',
      'administrative_area_level_1': 'long_name',
      'country': 'long_name',
      'postal_code': 'short_name',
    };
    const getAddressComp = function (type) {
      for (const component of place.address_components) {
        if (component.types[0] === type) {
          console.log(component);




          return component[addressNameFormat[type]];
        }
      }
      return '';
    };
    document.getElementById('location').value = getAddressComp('street_number') + ' '
              + getAddressComp('route');
    for (const component of componentForm) {
      // Location field is handled separately above as it has different logic.
      if (component !== 'location') {
        document.getElementById(component).value = getAddressComp(component);
      }
    }
  }
}
</script>
<?php include 'template/offcanvas.php'; ?>
<?php //include 'template/navigation.php'; ?>

  <!-- MAIN CONTENT -->
  <div class="main-content">
    <!-- CARDS -->
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
          <?php echo $query_error; ?>
          <!-- Header -->
          <div class="header mt-md-5">
            <div class="header-body">
              <div class="row align-items-center">
                <div class="col">

                  <!-- Pretitle -->
                  <h6 class="header-pretitle">
                    <?php echo $pagename; ?>
                  </h6>

                  <!-- Title -->
                  <h1 class="header-title">
                    Create a new order
                  </h1>

                </div>
              </div> <!-- / .row -->
            </div>
          </div>
          <form class="row g-3" action="" method="post" enctype="multipart/form-data">
            <!-- Errors -->
            <div class="col-12">
              <?php
                if (isset($_SESSION['emptyFields'])) {
                  echo $_SESSION['emptyFields'];
                  unset($_SESSION['emptyFields']);
                }
              ?>
            </div>
            <!-- End errors -->
            <div class="col-12">
              <label class="form-label"><img class="sb-title-icon" src="https://fonts.gstatic.com/s/i/googlematerialicons/location_pin/v5/24px.svg" alt="">Address*</label>
              <small class="form-text text-muted">You must choose a selection from Google Maps.</small>
              <input type="text" name="street_address" id="location" class="form-control" autocomplete="off" value="<?php echo $street_address; ?>" required>
            </div>
            <div class="col-12">
              <label class="form-label">Apt, suite or unit number</label>
              <input type="text" class="form-control" name="secondary_address" placeholder="Unit 23" value="<?php echo $secondary_address; ?>">
            </div>
            <div class="col-6">
              <label class="form-label">City*</label>
              <input type="text" class="form-control" name="city" id="locality" value="<?php echo $city; ?>">
            </div>
            <div class="col-6">
              <label class="form-label">State*</label>
              <input type="text" class="form-control" name="state" id="administrative_area_level_1" value="<?php echo $state ?>">
            </div>
            <div class="col-6">
              <label class="form-label">Zip*</label>
              <input type="text" class="form-control" name="zip" id="postal_code" value="<?php echo $zip; ?>">
            </div>
            <div class="col-6">
              <label class="form-label">County*</label>
              <input type="text" class="form-control" name="county" id="county" value="<?php echo $county; ?>">
            </div>
            <div hidden class="col-12">
              <label class="form-label">Country*</label>
              <input type="text" class="form-control" name="country" id="country" value="<?php echo $country; ?>">
            </div>
            <div class="col-12">
              <label class="form-label">Owner's name</label>
              <input type="text" class="form-control" name="owner_name" placeholder="Owner's name" value="<?php echo $owner; ?>">
            </div>
            <div class="col-6">
              <label class="form-label">Client name*</label>
              <input type="text" class="form-control" name="client_name" placeholder="Type the client's name" value="<?php echo $client_name; ?>">
            </div>
            <div class="col-6">
              <label class="form-label">Client order number</label>
              <input type="text" name="con" class="form-control" placeholder="Client order number" value="<?php echo $con; ?>">
            </div>
            <div class="col-6">
              <label class="form-label">Service*</label>
              <select class="form-select" name="service">
                <option value="Interior/Exterior">Interior/Exterior</option>
                <option value="Visual Inspection">Visual Inspection</option>
                <option value="Door Card">Door Card</option>
                <option value="No Contact">No Contact</option>
                <option value="Vehicle Inspection">Vehicle Inspection</option>
              </select>
            </div>
            <div class="col-6">
              <label class="form-label">Access code</label>
              <input type="text" class="form-control" name="access_code" value="<?php echo $access_code; ?>">
            </div>
            <div class="col-6">
              <label class="form-label">Start date*</label>
              <input type="text" class="form-control" name="start_date" placeholder="Choose start date" value="<?php if ($start_date == null) {
                echo date("Y-m-d");
              } else {
                echo $start_date;
              } ?>" data-flatpickr>
            </div>
            <div class="col-6">
              <label class="form-label">Due date*</label>
              <input type="text" class="form-control" name="due_date" placeholder="Select due date" value="<?php if ($due_date == null) {
                echo date('Y-m-d', strtotime('+3 days'));
              } else {
                echo $due_date;
              } ?>" data-flatpickr>
            </div>
            <div class="col-12">
              <label class="form-label">Instructions</label>
              <small class="form-text text-muted">You can use this field to provide additional details reguarding your order.</small>
              <textarea name="instructions" class="form-control" rows="5" cols="80"><?php echo $instructions; ?></textarea>
            </div>
            <div class="col-12">
              <label class="form-label">Attachments</label>
              <input class="form-control" type="file" name="files[]" id="formFileMultiple" multiple />
            </div>
            <div class="col-12">
              <!-- Divider -->
              <hr class="mt-4 mb-4">
            </div>
            <div class="col-12 pb-5">
              <button type="submit" class="btn btn-primary w-100" name="create-order">Create order</button>
            </div>
            <div class="col-12 mb-4 text-center">
              <a href="open-orders">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div><!-- End contianer-fluid -->
  </div><!-- / .main-content -->

<!-- Google Maps autocomplete script -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZm4AFgY_p4lNYcGbcaB26K3JWiLIeZOA&libraries=places&callback=initMap&solution_channel=GMP_QB_addressselection_v1_cABC" async defer></script>

<?php include 'template/footer.php'; ?>
