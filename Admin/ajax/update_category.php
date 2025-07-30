<?php 
    require_once('../db.php');

    if (isset($_POST['id']) && isset($_POST['categoryName'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);
        
        $query = "UPDATE categories SET name = '$categoryName' WHERE id = '$id'";
        
        if (mysqli_query($conn, $query)) {
            echo json_encode(['success' => true, 'message' => 'Category updated successfully']);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid request']);
    }
?>