<?php
include("connection.php");

$catID = $_POST['catID'];

// Delete category
$query = mysqli_query($mysqli, "DELETE FROM category WHERE catID='$catID'");

if ($query) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>
