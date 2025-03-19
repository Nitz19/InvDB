<?php
session_start();
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="jumbotron text-center">
        <h2 class="display-4">Add New Product</h2>
    </div>

    <?php
    // Include database connection
    include_once("connection.php");

    // Handle form submission
    if (isset($_POST['Submit'])) {
        $prodName = $_POST['prodName'];
        $prodDesc = $_POST['prodDesc'];
        $prodQty = $_POST['prodQty'];
        $prodPrice = $_POST['prodPrice'];
        $catID = $_POST['catID'];
        $supplierID = $_POST['supplierID'];
        $brandName = trim($_POST['brandName']); // Get brand name dynamically
        $userID = $_SESSION['id'];

        // Check for empty fields
        if (empty($prodName) || empty($prodQty) || empty($prodPrice) || empty($catID) || empty($supplierID) || empty($brandName)) {
            echo "<div class='alert alert-danger'>";
            if (empty($prodName)) echo "Product Name is required.<br/>";
            if (empty($prodQty)) echo "Quantity is required.<br/>";
            if (empty($prodPrice)) echo "Price is required.<br/>";
            if (empty($catID)) echo "Category must be selected.<br/>";
            if (empty($supplierID)) echo "Supplier must be selected.<br/>";
            if (empty($brandName)) echo "Brand name is required.<br/>";
            echo "</div>";
        } else {
            // Check if the brand already exists
            $brandResult = mysqli_query($mysqli, "SELECT * FROM brand WHERE brandName='$brandName' LIMIT 1");
            if (mysqli_num_rows($brandResult) > 0) {
                $brandRow = mysqli_fetch_assoc($brandResult);
                $brandID = $brandRow['brandID']; // Get existing brandID
            } else {
                // Insert new brand if it doesn't exist
                $insertBrand = mysqli_query($mysqli, "INSERT INTO brand(brandName, brandDesc, dateCreated) VALUES('$brandName', 'Auto-added', NOW())");
                if ($insertBrand) {
                    $brandID = mysqli_insert_id($mysqli); // Get the newly inserted brandID
                } else {
                    echo "<div class='alert alert-danger text-center'>Error inserting brand: " . mysqli_error($mysqli) . "</div>";
                    exit();
                }
            }

            // Insert product with valid brandID
            $result = mysqli_query($mysqli, "INSERT INTO product(prodName, prodDesc, prodQty, prodPrice, brandID, catID, supplierID, userID, dateCreated) 
                VALUES('$prodName', '$prodDesc', '$prodQty', '$prodPrice', '$brandID', '$catID', '$supplierID', '$userID', NOW())");

            if ($result) {
                echo "<div class='alert alert-success text-center'>Product added successfully! <a href='view.php'>View Products</a></div>";
            } else {
                echo "<div class='alert alert-danger text-center'>Failed to add product. Error: " . mysqli_error($mysqli) . "</div>";
            }
        }
    }
    ?>

    <form action="add.php" method="post" name="form1">
        <div class="form-group">
            <label>Product Name:</label>
            <input type="text" name="prodName" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Description:</label>
            <textarea name="prodDesc" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label>Quantity:</label>
            <input type="number" name="prodQty" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Price:</label>
            <input type="text" name="prodPrice" class="form-control" required>
        </div>

        <!-- Category Dropdown -->
        <div class="form-group">
            <label>Category:</label>
            <select name="catID" class="form-control" required>
                <option value="">Select Category</option>
                <?php
                $catResult = mysqli_query($mysqli, "SELECT * FROM category WHERE dateDeleted IS NULL");
                while ($catRow = mysqli_fetch_assoc($catResult)) {
                    echo "<option value='" . $catRow['catID'] . "'>" . $catRow['catName'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Supplier:</label>
            <select name="supplierID" class="form-control" required>
                <option value="">Select Supplier</option>
                <?php
                $supplierResult = mysqli_query($mysqli, "SELECT * FROM supplier WHERE dateDeleted IS NULL");
                while ($supplierRow = mysqli_fetch_assoc($supplierResult)) {
                    echo "<option value='" . $supplierRow['supplierID'] . "'>" . $supplierRow['supplierName'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Brand Name:</label>
            <input type="text" name="brandName" class="form-control" required>
        </div>

        <div class="form-group text-center">
            <input type="submit" name="Submit" value="Add Product" class="btn btn-success btn-lg">
            <a href="view.php" class="btn btn-secondary btn-lg">Cancel</a>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
