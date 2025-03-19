<?php
include("connection.php");

$supplierName = $_POST['supplierName'];

// Insert new supplier
mysqli_query($mysqli, "INSERT INTO supplier(supplierName, dateCreated) VALUES('$supplierName', NOW())");
$supplierID = mysqli_insert_id($mysqli);

echo json_encode(['supplierID' => $supplierID, 'supplierName' => $supplierName]);
?>
