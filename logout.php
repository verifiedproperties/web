<?php
// ==========================================
// Date Created:   3/26/2022
// Developer: Richard Rodgers
// ==========================================
session_start();
session_destroy();
session_start();
$_SESSION['loggedout'] = "You've been logged out!";
header('Location: login');
