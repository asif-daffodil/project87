<?php  
    session_start();
    require_once('./db.php');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (!isset($_SESSION['user'])) {
        header('Location: ../sign-in.php');
        exit();
    }

    if ($_SESSION['user']['role'] !== 'admin') {
        header('Location: ../');
        exit();
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- link jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- link data table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>

    <!-- link sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body>
    