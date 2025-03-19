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
        $brandName = trim($_POST['brandName']);
        $userID = $_SESSION['id'];

        // Check for empty fields
        if (empty($prodName) || empty($prodQty) || empty($prodPrice) || empty($catID) || empty($supplierID) || empty($brandName)) {
            echo "<div class='alert alert-danger'>Please fill all required fields.</div>";
        } else {
            // Check if the brand already exists
            $brandResult = mysqli_query($mysqli, "SELECT * FROM brand WHERE brandName='$brandName' LIMIT 1");
            if (mysqli_num_rows($brandResult) > 0) {
                $brandRow = mysqli_fetch_assoc($brandResult);
                $brandID = $brandRow['brandID'];
            } else {
                // Insert new brand if it doesn't exist
                $insertBrand = mysqli_query($mysqli, "INSERT INTO brand(brandName, brandDesc, dateCreated) VALUES('$brandName', 'Auto-added', NOW())");
                if ($insertBrand) {
                    $brandID = mysqli_insert_id($mysqli);
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

        <!-- Category Dropdown + Add/Delete Options -->
        <div class="form-group">
            <label>Category:</label>
            <div class="input-group">
                <select name="catID" id="catID" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php
                    $catResult = mysqli_query($mysqli, "SELECT * FROM category WHERE dateDeleted IS NULL");
                    while ($catRow = mysqli_fetch_assoc($catResult)) {
                        echo "<option value='" . $catRow['catID'] . "'>" . $catRow['catName'] . "</option>";
                    }
                    ?>
                </select>
                <div class="input-group-append">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addCategoryModal">+ Add</button>
                    <button type="button" class="btn btn-danger" id="deleteCategory">- Delete</button>
                </div>
            </div>
        </div>
<!-- Supplier Dropdown + Add/Delete Options -->
<div class="form-group">
    <label>Supplier:</label>
    <div class="input-group">
        <select name="supplierID" id="supplierID" class="form-control" required>
            <option value="">Select Supplier</option>
            <?php
            $supplierResult = mysqli_query($mysqli, "SELECT * FROM supplier WHERE dateDeleted IS NULL");
            while ($supplierRow = mysqli_fetch_assoc($supplierResult)) {
                echo "<option value='" . $supplierRow['supplierID'] . "'>" . $supplierRow['supplierName'] . "</option>";
            }
            ?>
        </select>
        <div class="input-group-append">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addSupplierModal">+ Add</button>
            <button type="button" class="btn btn-danger" id="deleteSupplier">- Delete</button>
        </div>
    </div>
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

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="addCategoryForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Category</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="text" id="newCategory" name="newCategory" class="form-control" placeholder="Enter category name" required>
                </div>
                <div class="modal-footer">
                    <button type="button" id="saveCategory" class="btn btn-success">Add Category</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Add Supplier Modal -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="addSupplierForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="text" id="newSupplier" name="newSupplier" class="form-control" placeholder="Enter supplier name" required>
                </div>
                <div class="modal-footer">
                    <button type="button" id="saveSupplier" class="btn btn-info">Add Supplier</button>
                </div>
            </div>
        </form>
    </div>
</div>



<!-- Include JS & Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- AJAX to Add and Delete Category & Supplier -->
<script>
$(document).ready(function() {
    // Add Category via AJAX
    $('#saveCategory').on('click', function() {
        var categoryName = $('#newCategory').val();
        if (categoryName !== '') {
            $.post('add_category.php', { catName: categoryName }, function(data) {
                $('#catID').append('<option value="' + data.catID + '" selected>' + data.catName + '</option>');
                $('#addCategoryModal').modal('hide');
                $('#newCategory').val('');
            }, 'json');
        }
    });

    // Add Supplier via AJAX
    $('#saveSupplier').on('click', function() {
        var supplierName = $('#newSupplier').val();
        if (supplierName !== '') {
            $.post('add_supplier.php', { supplierName: supplierName }, function(data) {
                $('#supplierID').append('<option value="' + data.supplierID + '" selected>' + data.supplierName + '</option>');
                $('#addSupplierModal').modal('hide');
                $('#newSupplier').val('');
            }, 'json');
        }
    });

    // Delete Category via AJAX
    $('#deleteCategory').on('click', function() {
        var catID = $('#catID').val();
        if (catID !== '') {
            if (confirm('Are you sure you want to delete this category?')) {
                $.post('delete_category.php', { catID: catID }, function(response) {
                    if (response.status === 'success') {
                        $('#catID option[value="' + catID + '"]').remove();
                        alert('Category deleted successfully!');
                    } else {
                        alert('Error deleting category.');
                    }
                }, 'json');
            }
        } else {
            alert('Please select a category to delete.');
        }
    });
});

// Delete Supplier via AJAX
$('#deleteSupplier').on('click', function() {
    var supplierID = $('#supplierID').val();
    if (supplierID !== '') {
        if (confirm('Are you sure you want to delete this supplier?')) {
            $.post('delete_supplier.php', { supplierID: supplierID }, function(response) {
                if (response.status === 'success') {
                    $('#supplierID option[value="' + supplierID + '"]').remove();
                    alert('Supplier deleted successfully!');
                } else {
                    alert('Error deleting supplier.');
                }
            }, 'json');
        }
    } else {
        alert('Please select a supplier to delete.');
    }
});
</script>

</body>
</html>
