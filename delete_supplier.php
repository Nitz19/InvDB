<?php
include("connection.php");

$supplierID = $_POST['supplierID'];

// Delete supplier
$query = mysqli_query($mysqli, "DELETE FROM supplier WHERE supplierID='$supplierID'");

if ($query) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>
