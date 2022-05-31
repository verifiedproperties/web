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

// Getting total count of open orders
function OpenOrders($conn) {
  $sql = "SELECT `id` FROM `work-orders` WHERE `status` = '0' OR `status` = '3'";
  if ($result = mysqli_query($conn, $sql)) {
    // Assigns total count of open orders to the 'TotalOpenOrders' varibale.
    $TotalOpenOrders = mysqli_num_rows($result);
    echo $TotalOpenOrders;
  }
}

// Getting total count of pending orders
function PendingOrders($conn) {
  $sql = "SELECT `id` FROM `work-orders` WHERE `status` = '2'";
  if ($result = mysqli_query($conn, $sql)) {
    // Assigns total count of pending orders to the 'TotalPendingOrders' varibale.
    $TotalPendingOrders = mysqli_num_rows($result);
    echo $TotalPendingOrders;
  }
}

// Getting total count of rejected orders
function RejectedOrders($conn) {
  $sql = "SELECT `id` FROM `work-orders` WHERE `status` = '3'";
  if ($result = mysqli_query($conn, $sql)) {
    // Assigns total count of rejected orders to the 'TotalRejectedOrders' varibale.
    $TotalRejectedOrders = mysqli_num_rows($result);
    echo $TotalRejectedOrders;
  }
}

// Getting total count of completed orders
function CompletedOrders($conn) {
  $sql = "SELECT `id` FROM `work-orders` WHERE `status` = '4'";
  if ($result = mysqli_query($conn, $sql)) {
    // Assigns total count of completed orders to the 'TotalCompletedOrders' varibale.
    $TotalCompletedOrders = mysqli_num_rows($result);
    echo $TotalCompletedOrders;
  }
}

// Getting total count of canceled orders
function CanceledOrders($conn) {
  $sql = "SELECT * FROM `work-orders` WHERE `status` = '5'";
  if ($result = mysqli_query($conn, $sql)) {
    // Assigns total count of canceled orders to the '$TotalCanceledOrders' variable.
    $TotalCanceledOrders = mysqli_num_rows($result);
    echo $TotalCanceledOrders;
  }
}
