<?php
session_start();
if(!isset($_SESSION['valid'])) {
    header('Location: login.php');
}

include_once("connection.php");

if(isset($_POST['Submit'])) {
    $supplierName = $_POST['supplierName'];
    $supplierDesc = $_POST['supplierDesc'];
    if(empty($supplierName)) {

        echo "<font color='red'>Supplier Name field is empty.</font><br/>";
    } else {
    
        $result = mysqli_query($mysqli, "INSERT INTO supplier(supplierName, supplierDesc, dateCreated) VALUES('$supplierName', '$supplierDesc', NOW())");

        if($result) {
            echo "<font color='green'>Supplier added successfully.</font>";
            echo "<br/><a href='add.php'>Go Back to Add Product</a>";
        } else {
            echo "<font color='red'>Error adding supplier. Please try again.</font>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Supplier</title>
</head>
<body>
    <a href="add.php">Back to Add Product</a><br/><br/>
    <form action="add_supplier.php" method="post">
        <table width="25%" border="0">
            <tr> 
                <td>Supplier Name</td>
                <td><input type="text" name="supplierName"></td>
            </tr>
            <tr> 
                <td>Description</td>
                <td><textarea name="supplierDesc"></textarea></td>
            </tr>
            <tr> 
                <td></td>
                <td><input type="submit" name="Submit" value="Add Supplier"></td>
            </tr>
        </table>
    </form>
</body>
</html>
