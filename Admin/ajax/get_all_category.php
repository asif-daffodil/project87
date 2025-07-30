<?php
require_once('../db.php');

$query = "SELECT * FROM categories ORDER BY id DESC";
$catResult = mysqli_query($conn, $query);

$categories = [];
if ($catResult && mysqli_num_rows($catResult) > 0) {
    while ($row = mysqli_fetch_assoc($catResult)) {
        $categories[] = $row;
    }
}

echo json_encode(['success' => true, 'data' => $categories]);
