<?php
// ==========================================
// Date Created:   4/13//2022
// Developer: Richard Rodgers
// ==========================================
include '../../db.php';
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ../../login');
}
$pagename = "New Order";
$pageheader = "Create a new order";
include '../template/head.php';
?>

    <!-- MAIN CONTENT -->
    <div class="main-content">
      <div class="container-lg">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-10 col-xl-8">

            <!-- Form -->
            <form class="tab-content py-6" id="wizardSteps">
              <div class="tab-pane fade show active" id="wizardStepOne" role="tabpanel" aria-labelledby="wizardTabOne">

                <!-- Header -->
                <div class="row justify-content-center">
                  <div class="col-12 col-md-10 col-lg-8 col-xl-6 text-center">

                    <!-- Pretitle -->
                    <h6 class="mb-4 text-uppercase text-muted">
                      Step 1 of 3
                    </h6>

                    <!-- Title -->
                    <h1 class="mb-3">
                      Let’s start with the basics.
                    </h1>

                    <!-- Subtitle -->
                    <p class="mb-5 text-muted">
                      Understanding the type of team you're creating help us to ask all the right questions.
                    </p>

                  </div>
                </div> <!-- / .row -->

                <!-- Team name -->
                <div class="form-group">

                  <!-- Label -->
                  <label class="form-label">
                    Team name
                  </label>

                  <!-- Input -->
                  <input type="text" class="form-control">

                </div>

                <!-- Team description -->
                <div class="form-group">

                  <!-- Label -->
                  <label class="form-label mb-1">
                    Team description
                  </label>

                  <!-- Text -->
                  <small class="form-text text-muted">
                    This is how others will learn about the project, so make it good!
                  </small>

                  <!-- Quill -->
                  <div data-quill></div>

                </div>

                <!-- Team members -->
                <div class="form-group">

                  <!-- Label -->
                  <label class="form-label">
                    Add team members
                  </label>

                  <!-- Select -->
                  <select class="form-select mb-3" data-choices='{"searchEnabled": false, "choices": [
                    {
                      "value": "Dianna Smiley",
                      "label": "Dianna Smiley",
                      "customProperties": {
                        "avatarSrc": "../assets/img/avatars/profiles/avatar-1.jpg"
                      }
                    },
                    {
                      "value": "Ab Hadley",
                      "label": "Ab Hadley",
                      "customProperties": {
                        "avatarSrc": "../assets/img/avatars/profiles/avatar-2.jpg"
                      }
                    },
                    {
                      "value": "Adolfo Hess",
                      "label": "Adolfo Hess",
                      "customProperties": {
                        "avatarSrc": "../assets/img/avatars/profiles/avatar-3.jpg"
                      }
                    },
                    {
                      "value": "Daniela Dewitt",
                      "label": "Daniela Dewitt",
                      "customProperties": {
                        "avatarSrc": "../assets/img/avatars/profiles/avatar-4.jpg"
                      }
                    }
                  ]}'></select>

                </div>

                <!-- Divider -->
                <hr class="my-5">

                <!-- Footer -->
                <div class="nav row align-items-center">
                  <div class="col-auto">

                    <!-- Button -->
                    <button class="btn btn-lg btn-white" type="reset">Cancel</button>

                  </div>
                  <div class="col text-center">

                    <!-- Step -->
                    <h6 class="text-uppercase text-muted mb-0">Step 1 of 3</h6>

                  </div>
                  <div class="col-auto">

                    <!-- Button -->
                    <a class="btn btn-lg btn-primary" data-toggle="wizard" href="#wizardStepTwo">Continue</a>

                  </div>
                </div>

              </div>
              <div class="tab-pane fade" id="wizardStepTwo" role="tabpanel" aria-labelledby="wizardTabTwo">

                <!-- Header -->
                <div class="row justify-content-center">
                  <div class="col-12 col-md-10 col-lg-8 col-xl-6 text-center">

                    <!-- Pretitle -->
                    <h6 class="mb-4 text-uppercase text-muted">
                      Step 2 of 3
                    </h6>

                    <!-- Title -->
                    <h1 class="mb-3">
                      Next, let’s upload some files.
                    </h1>

                    <!-- Subtitle -->
                    <p class="mb-5 text-muted">
                      We need to style your team page and make sure you have all your starting files.
                    </p>

                  </div>
                </div> <!-- / .row -->

                <!-- Project cover -->
                <div class="form-group">

                  <!-- Label -->
                  <label class="form-label mb-1">
                    Project cover
                  </label>

                  <!-- Text -->
                  <small class="form-text text-muted">
                    Please use an image no larger than 1200px * 600px.
                  </small>

                  <!-- Dropzone -->
                  <div class="dropzone dropzone-single mb-3" data-dropzone='{"url": "https://", "maxFiles": 1, "acceptedFiles": "image/*"}'>

                    <!-- Fallback -->
                    <div class="fallback">
                      <div class="form-group">
                        <label class="form-label" for="projectCoverUploads">Choose file</label>
                        <input class="form-control" type="file" id="projectCoverUploads">
                      </div>
                    </div>

                    <!-- Preview -->
                    <div class="dz-preview dz-preview-single">
                      <div class="dz-preview-cover">
                        <img class="dz-preview-img" src="data:image/svg+xml,%3csvg3c/svg%3e" alt="..." data-dz-thumbnail>
                      </div>
                    </div>

                  </div>
                </div>

                <!-- Divider -->
                <hr class="mt-5 mb-5">

                <!-- Starting files -->
                <div class="form-group">

                  <!-- Label -->
                  <label class="form-label mb-1">
                    Starting files
                  </label>

                  <!-- Text -->
                  <small class="form-text text-muted">
                    Upload any files you want to start the projust with.
                  </small>

                  <!-- Card -->
                  <div class="card">
                    <div class="card-body">
                      <div class="dropzone dropzone-multiple" data-dropzone='{"url": "https://"}'>

                        <!-- Fallback -->
                        <div class="fallback">
                          <div class="form-group">
                            <label class="form-label" for="customFileUpload">Choose file</label>
                            <input class="form-control" type="file" id="customFileUpload" multiple>
                          </div>
                        </div>

                        <!-- Preview -->
                        <ul class="dz-preview dz-preview-multiple list-group list-group-lg list-group-flush">
                          <li class="list-group-item px-0">
                            <div class="row align-items-center">
                              <div class="col-auto">

                                <!-- Image -->
                                <div class="avatar">
                                  <img class="avatar-img rounded" src="data:image/svg+xml,%3csvg3c/svg%3e" alt="..." data-dz-thumbnail>
                                </div>

                              </div>
                              <div class="col ms-n3">

                                <!-- Heading -->
                                <h4 class="mb-1" data-dz-name>...</h4>

                                <!-- Text -->
                                <p class="small text-muted mb-0" data-dz-size></p>

                              </div>
                              <div class="col-auto">

                                <!-- Dropdown -->
                                <div class="dropdown">

                                  <!-- Toggle -->
                                  <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fe fe-more-vertical"></i>
                                  </a>

                                  <!-- Menu -->
                                  <div class="dropdown-menu dropdown-menu-end">
                                    <a href="#" class="dropdown-item" data-dz-remove>
                                      Remove
                                    </a>
                                  </div>

                                </div>

                              </div>
                            </div>
                          </li>
                        </ul>

                      </div>
                    </div>
                  </div>
                </div>

                <!-- Divider -->
                <hr class="my-5">

                <!-- Footer -->
                <div class="nav row align-items-center">
                  <div class="col-auto">

                    <!-- Button -->
                    <a class="btn btn-lg btn-white" data-toggle="wizard" href="#wizardStepOne">Back</a>

                  </div>
                  <div class="col text-center">

                    <!-- Step -->
                    <h6 class="text-uppercase text-muted mb-0">Step 2 of 3</h6>

                  </div>
                  <div class="col-auto">

                    <!-- Button -->
                    <a class="btn btn-lg btn-primary" data-toggle="wizard" href="#wizardStepThree">Continue</a>

                  </div>
                </div>

              </div>
              <div class="tab-pane fade" id="wizardStepThree" role="tabpanel" aria-labelledby="wizardTabThree">

                <!-- Header -->
                <div class="row justify-content-center">
                  <div class="col-12 col-md-10 col-lg-8 col-xl-6 text-center">

                    <!-- Pretitle -->
                    <h6 class="mb-4 text-uppercase text-muted">
                      Step 3 of 3
                    </h6>

                    <!-- Title -->
                    <h1 class="mb-3">
                      Let’s get some last details.
                    </h1>

                    <!-- Subtitle -->
                    <p class="mb-5 text-muted">
                      Setting up tags, dates, and permissions makes sure to keep your team organized and safe.
                    </p>

                  </div>
                </div> <!-- / .row -->

                <!-- Project tags -->
                <div class="form-group">

                  <!-- Label -->
                  <label class="form-label">
                    Project tags
                  </label>

                  <!-- Select -->
                  <select class="form-control" data-choices='{"removeItemButton": true}' multiple>
                    <option>CSS</option>
                    <option>HTML</option>
                    <option>JavaScript</option>
                    <option>Bootstrap</option>
                  </select>

                </div>

                <div class="row">
                  <div class="col-12 col-md-6">

                    <!-- Start date -->
                    <div class="form-group">

                      <!-- Label -->
                      <label class="form-label">
                        Start date
                      </label>

                      <!-- Input -->
                      <input type="text" class="form-control" data-flatpickr>

                    </div>

                  </div>
                  <div class="col-12 col-md-6">

                    <!-- Start date -->
                    <div class="form-group">

                      <!-- Label -->
                      <label class="form-label">
                        End date
                      </label>

                      <!-- Input -->
                      <input type="text" class="form-control" data-flatpickr>

                    </div>

                  </div>
                </div> <!-- / .row -->

                <!-- Divider -->
                <hr class="mt-5 mb-5">

                <div class="row">
                  <div class="col-12 col-md-6">

                    <!-- Private project -->
                    <div class="form-group">

                      <!-- Label -->
                      <label class="form-label mb-1">
                        Private project
                      </label>

                      <!-- Text -->
                      <small class="form-text text-muted">
                        If you are available for hire outside of the current situation, you can encourage others to hire you.
                      </small>

                      <!-- Switch -->
                      <div class="form-check form-switch">
                        <input class="form-check-input" id="switchOne" type="checkbox">
                        <label class="form-check-label" for="switchOne"></label>
                      </div>

                    </div>

                  </div>
                  <div class="col-12 col-md-6">

                    <!-- Warning -->
                    <div class="card bg-light border">
                      <div class="card-body">

                        <!-- Heading -->
                        <h4 class="mb-2">
                          <i class="fe fe-alert-triangle"></i> Warning
                        </h4>

                        <!-- Text -->
                        <p class="small text-muted mb-0">
                          Once a project is made private, you cannot revert it to a public project.
                        </p>

                      </div>
                    </div>

                  </div>
                </div> <!-- / .row -->

                <!-- Divider -->
                <hr class="my-5">

                <!-- Footer -->
                <div class="nav row align-items-center">
                  <div class="col-auto">

                    <!-- Button -->
                    <a class="btn btn-lg btn-white" data-toggle="wizard" href="#wizardStepTwo">Back</a>

                  </div>
                  <div class="col text-center">

                    <!-- Step -->
                    <h6 class="text-uppercase text-muted mb-0">Step 3 of 3</h6>

                  </div>
                  <div class="col-auto">

                    <!-- Button -->
                    <button class="btn btn-lg btn-primary" type="submit">Create</button>

                  </div>
                </div>

              </div>
            </form>

          </div>
        </div>
      </div>

    </div> <!-- / .main-content -->

    <?php include '../template/footer.php'; ?>
