<?php
$dba = "Verified";
$adminsiteurl = $_SERVER['DOCUMENT_ROOT'].'/web/admin/';
$siteurl = $_SERVER['DOCUMENT_ROOT'].'/web/';

$baseurl = 'http://'.$_SERVER['HTTP_HOST'].'/web/admin/';

include $adminsiteurl.'assets/functions.php';
roleCheck($conn);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?=$baseurl?>assets/favicon/favicon.svg" type="image/x-icon"/>

    <!-- Map CSS -->
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css" />

    <!-- Libs CSS -->
    <link rel="stylesheet" href="<?=$baseurl?>template/assets/css/libs.bundle.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?=$baseurl?>template/assets/css/theme.bundle.css" />

    <!-- Title -->
    <title><?php echo $pagename, " - ", $dba; ?></title>
  </head>
  <body>
