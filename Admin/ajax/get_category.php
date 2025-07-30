<?php  
    require_once('../db.php');

    if ($_POST['id']) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $query = "SELECT * FROM categories WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $category = mysqli_fetch_assoc($result);
            echo json_encode(['success' => true, 'data' => $category]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Category not found']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid request']);
    }
?>