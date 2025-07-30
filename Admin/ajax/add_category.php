<?php 
require_once('../db.php');
if (isset($_POST['categoryName'])) {
    $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);
    $query = "INSERT INTO categories (name) VALUES ('$categoryName')";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true, 'message' => 'Category added successfully', 'data' => ['id' => mysqli_insert_id($conn), 'name' => $categoryName]]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
    exit;
}
?>