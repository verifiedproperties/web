<!-- NAVIGATION -->
<nav class="navbar navbar-vertical fixed-start navbar-expand-md navbar-light" id="sidebar">
  <div class="container-fluid">

    <!-- Toggler -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Brand -->
    <a class="navbar-brand" href="./dashboard">
      <img src="./assets/img/logo.svg" class="navbar-brand-img mx-auto" alt="Verified Logo">
    </a>

    <!-- User (xs) -->
    <div class="navbar-user d-md-none">

      <!-- Dropdown -->
      <div class="dropdown">

        <!-- Toggle -->
        <a href="#" id="sidebarIcon" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <div class="avatar avatar-sm avatar-online">
            <img src="assets/img/avatars/profiles/avatar-1.jpg" class="avatar-img rounded-circle" alt="...">
          </div>
        </a>

        <!-- Menu -->
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarIcon">
          <a href="./profile-posts.html" class="dropdown-item">Profile</a>
          <a href="./account-general.html" class="dropdown-item">Settings</a>
          <hr class="dropdown-divider">
          <a href="../logout" class="dropdown-item">Logout</a>
        </div>

      </div>

    </div>

    <!-- Collapse -->
    <div class="collapse navbar-collapse" id="sidebarCollapse">

      <!-- Form -->
      <form class="mt-4 mb-3 d-md-none">
        <div class="input-group input-group-rounded input-group-merge input-group-reverse">
          <input class="form-control" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-text">
            <span class="fe fe-search"></span>
          </div>
        </div>
      </form>

      <!-- Navigation -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="dashboard">
            <i class="fe fe-home"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="open-orders">
            <i class="fe fe-feather"></i> Work Orders
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="network">
            <i class="fe fe-users"></i> Network Members
          </a>
        </li>
        <a class="nav-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
          <i class="fe fe-headphones"></i> Support
        </a>
        <div class="collapse " id="sidebarDashboards">
          <ul class="nav nav-sm flex-column">
            <li class="nav-item">
              <a href="./tickets" class="nav-link ">
                Tickets
              </a>
            </li>
            <li class="nav-item">
              <a href="./announcements" class="nav-link ">
                Announcements
              </a>
            </li>
            <li class="nav-item">
              <a href="./knowledgebase" class="nav-link ">
                Knowledgebase
              </a>
            </li>
          </ul>
        </div>
        <li class="nav-item d-md-none">
          <a class="nav-link" data-bs-toggle="offcanvas" href="#sidebarOffcanvasActivity" aria-contrtols="sidebarOffcanvasActivity">
            <span class="fe fe-bell"></span> Notifications
          </a>
        </li>
      </ul>

      <!-- Divider -->
      <hr class="navbar-divider my-3">

      <!-- Heading -->
      <h6 class="navbar-heading">
        Verified Resources
      </h6>

      <!-- Navigation -->
      <ul class="navbar-nav mb-md-4">
        <li class="nav-item">
          <a class="nav-link " href="assets/import-template.csv">
            <i class="fe fe-download"></i> Import Template
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="./docs/changelog.html">
            <i class="fe fe-git-branch"></i> Changelog <span class="badge bg-secondary ms-auto">v1.0.0</span>
          </a>
        </li>
      </ul>

      <!-- Push content down -->
      <div class="mt-auto"></div>


        <!-- User (md) -->
        <div class="navbar-user d-none d-md-flex" id="sidebarUser">

          <!-- Icon -->
          <a class="navbar-user-link" data-bs-toggle="offcanvas" href="#sidebarOffcanvasActivity" aria-controls="sidebarOffcanvasActivity">
            <span class="icon">
              <i class="fe fe-bell"></i>
            </span>
          </a>

          <!-- Dropup -->
          <div class="dropup">

            <!-- Toggle -->
            <a href="#" id="sidebarIconCopy" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="avatar avatar-sm avatar-online">
                <img src="assets/img/avatars/profiles/avatar-1.jpg" class="avatar-img rounded-circle" alt="...">
              </div>
            </a>

            <!-- Menu -->
            <div class="dropdown-menu" aria-labelledby="sidebarIconCopy">
              <a href="./account-settings" class="dropdown-item">Settings</a>
              <hr class="dropdown-divider">
              <a href="../logout" class="dropdown-item">Logout</a>
            </div>

          </div>

          <!-- Icon -->
          <a class="navbar-user-link" data-bs-toggle="offcanvas" href="#sidebarOffcanvasSearch" aria-controls="sidebarOffcanvasSearch">
            <span class="icon">
              <i class="fe fe-search"></i>
            </span>
          </a>

        </div>

    </div> <!-- / .navbar-collapse -->

  </div>
</nav>
