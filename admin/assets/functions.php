<?php
// ==========================================
// Date Created:   4/30//2022
// Developer: Richard Rodgers
// ==========================================

// Checks the user's role.
function roleCheck($conn) {
  $loggedin = $_SESSION['username']; // Fetches the username from the session and
  // assigns it to the "$loggedin" veriable.

  // This query will fetch the role id for the logged in user.
  $funsql = "SELECT `role` FROM `users` WHERE `email` = '".$loggedin."' LIMIT 1";
  $result = mysqli_query($conn, $funsql);
  $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

  // Assigning the role id to a veriable.
  foreach ($row as $row) {
    $role = $row['role'];
  }

  // If the user does not have the admin role, they shall be redirected
  // to a 404 page to cause confusion as if the admin directory does not exist.
  if ($role != '1') {
    header('Location: ../404');
  }

}

// Getting total count of active accounts (users) only.
function ActiveUsers($conn) {
  $query = "SELECT `id` FROM `users` WHERE `role` = '2' AND `status` = 'active'";
  if ($result = mysqli_query($conn, $query)) {
    $TotalActiveUsers = mysqli_num_rows($result);
    echo $TotalActiveUsers;
  }
}

// Getting total count of inactive accounts (users) only.
function InactiveUsers($conn) {
  $query = "SELECT `id` FROM `users` WHERE `role` = '2' AND `status` = 'inactive'";
  if ($result = mysqli_query($conn, $query)) {
    $TotalInactiveUsers = mysqli_num_rows($result);
    echo $TotalInactiveUsers;
  }
}

// Getting Total count of suspended accounts (users) only.
function SuspendedUsers($conn) {
  $query = "SELECT `id` FROM `users` WHERE `role` = '2' AND `status` = 'suspended'";
  if ($result = mysqli_query($conn, $query)) {
    $TotalSuspendedUsers = mysqli_num_rows($result);
    echo $TotalSuspendedUsers;
  }
}

// Getting total count of pending accounts (users) only.
function PendingUsers($conn) {
  $query = "SELECT `id` FROM `users` WHERE `role` = '2' AND `status` = 'pending'";
  if ($result = mysqli_query($conn, $query)) {
    $TotalPendingUsers = mysqli_num_rows($result);
    echo $TotalPendingUsers;
  }
}
