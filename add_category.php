<?php
session_start();
if(!isset($_SESSION['valid'])) {
    header('Location: login.php');
}

include_once("connection.php");

if(isset($_POST['Submit'])) {
    $catName = $_POST['catName'];
    $catDesc = $_POST['catDesc'];

    if(empty($catName)) {
        echo "<font color='red'>Category Name field is empty.</font><br/>";
    } else {

        $result = mysqli_query($mysqli, "INSERT INTO category(catName, catDesc, dateCreated) VALUES('$catName', '$catDesc', NOW())");

        if($result) {
            echo "<font color='green'>Category added successfully.</font>";
            echo "<br/><a href='add.php'>Go Back to Add Product</a>";
        } else {
            echo "<font color='red'>Error adding category. Please try again.</font>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>
</head>
<body>
    <a href="add.php">Back to Add Product</a><br/><br/>
    <form action="add_category.php" method="post">
        <table width="25%" border="0">
            <tr> 
                <td>Category Name</td>
                <td><input type="text" name="catName"></td>
            </tr>
            <tr> 
                <td>Description</td>
                <td><textarea name="catDesc"></textarea></td>
            </tr>
            <tr> 
                <td></td>
                <td><input type="submit" name="Submit" value="Add Category"></td>
            </tr>
        </table>
    </form>
</body>
</html>
