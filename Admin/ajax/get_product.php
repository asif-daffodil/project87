<?php  
    require_once('../db.php');
    $id = $_POST['id'];
    $query = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    $row['success'] = true;
    $row['data'] = $data;
    $row['test'] = $_POST['id'];
    echo json_encode($row);