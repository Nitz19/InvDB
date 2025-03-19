<?php
session_start();
include_once("connection.php");


if (isset($_GET['id'])) {
    $prodID = $_GET['id'];

    
    $result = mysqli_query($mysqli, "DELETE FROM product WHERE prodID = $prodID");

    if ($result) {
       
        header("Location: view.php?msg=Product deleted successfully");
        exit();
    } else {
        echo "<div style='color:red; text-align:center;'>Error deleting product: " . mysqli_error($mysqli) . "</div>";
    }
} else {
    echo "<div style='color:red; text-align:center;'>Invalid request. Product ID not provided.</div>";
}
?>
