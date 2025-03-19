<?php
include("connection.php");

$catName = $_POST['catName'];

// Insert new category
mysqli_query($mysqli, "INSERT INTO category(catName, dateCreated) VALUES('$catName', NOW())");
$catID = mysqli_insert_id($mysqli);

echo json_encode(['catID' => $catID, 'catName' => $catName]);
?>
