<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>

<?php

include_once("connection.php");

$errorMsg = "";
$successMsg = "";


if(isset($_POST['update'])) {	
	$id = $_POST['id'];
	
	$name = mysqli_real_escape_string($mysqli, $_POST['name']);
	$qty = mysqli_real_escape_string($mysqli, $_POST['qty']);
	$price = mysqli_real_escape_string($mysqli, $_POST['price']);	
	
	
	if(empty($name) || empty($qty) || empty($price)) {
		if(empty($name)) {
			$errorMsg .= "<div class='alert alert-danger'>⚠️ Name field is empty.</div>";
		}
		if(empty($qty)) {
			$errorMsg .= "<div class='alert alert-danger'>⚠️ Quantity field is empty.</div>";
		}
		if(empty($price)) {
			$errorMsg .= "<div class='alert alert-danger'>⚠️ Price field is empty.</div>";
		}
	} else {	
	
		$result = mysqli_query($mysqli, "UPDATE product SET prodName='$name', prodQty='$qty', prodPrice='$price' WHERE prodID=$id");

		if($result) {
			$successMsg = "<div class='alert alert-success'>✅ Product updated successfully!</div>";
			header("Location: view.php");
		} else {
			$errorMsg = "<div class='alert alert-danger'>❌ Error updating product: " . mysqli_error($mysqli) . "</div>";
		}
	}
}
?>

<?php

$id = $_GET['id'];


$result = mysqli_query($mysqli, "SELECT * FROM product WHERE prodID=$id");

while($res = mysqli_fetch_array($result)) {
	$name = $res['prodName'];
	$qty = $res['prodQty'];
	$price = $res['prodPrice'];
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Product</title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="bg-light">
	<div class="container mt-5">
		<div class="card shadow-lg">
			<div class="card-header bg-primary text-white text-center">
				<h3>✏️ Edit Product</h3>
			</div>

			<div class="card-body">
				<a href="index.php" class="btn btn-outline-secondary mb-3">🏠 Back to Home</a>
				<a href="view.php" class="btn btn-outline-success mb-3">📦 View Products</a>
				<a href="logout.php" class="btn btn-outline-danger mb-3 float-right">🚪 Logout</a>

			
				<?php 
				if(!empty($errorMsg)) {
					echo $errorMsg;
				}
				if(!empty($successMsg)) {
					echo $successMsg;
				}
				?>

				<form method="post" action="edit.php" class="needs-validation" novalidate>
					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<div class="form-group">
						<label for="name">📛 Product Name</label>
						<input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
						<div class="invalid-feedback">Please enter a valid product name.</div>
					</div>

					<div class="form-group">
						<label for="qty">📦 Quantity</label>
						<input type="number" name="qty" class="form-control" value="<?php echo htmlspecialchars($qty); ?>" required>
						<div class="invalid-feedback">Please enter the quantity.</div>
					</div>

					<div class="form-group">
						<label for="price">💰 Price (₱)</label>
						<input type="number" step="0.01" name="price" class="form-control" value="<?php echo htmlspecialchars($price); ?>" required>
						<div class="invalid-feedback">Please enter a valid price.</div>
					</div>

					<button type="submit" name="update" class="btn btn-success btn-block">✅ Update Product</button>
				</form>
			</div>

			<div class="card-footer text-center">
				<p>Created by <a href="https://www.facebook.com/peko.cruz.7" target="_blank" class="text-primary">Group ni PEKO</a></p>
			</div>
		</div>
	</div>


	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


	<script>
		(function() {
			'use strict';
			window.addEventListener('load', function() {
				var forms = document.getElementsByClassName('needs-validation');
				var validation = Array.prototype.filter.call(forms, function(form) {
					form.addEventListener('submit', function(event) {
						if (form.checkValidity() === false) {
							event.preventDefault();
							event.stopPropagation();
						}
						form.classList.add('was-validated');
					}, false);
				});
			}, false);
		})();
	</script>
</body>
</html>
