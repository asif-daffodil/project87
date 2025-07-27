<?php
require_once('./db.php');

if (isset($_POST['id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $deleteQuery = "DELETE FROM categories WHERE id = '$id'";
    if (mysqli_query($conn, $deleteQuery)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
}   
?>