<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>

<?php

include_once("connection.php");

$result = mysqli_query($mysqli, "SELECT * FROM product WHERE userID=".$_SESSION['id']." ORDER BY prodID DESC");
?>

<!DOCTYPE html>
<html>
<head>
	<title>View Products</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="bg-light">
	<div class="container mt-5">
		<div class="card shadow-lg">
			<div class="card-header bg-primary text-white text-center">
				<h3>📦 Product Inventory</h3>
			</div>
			<div class="card-body">
				<a href="index.php" class="btn btn-outline-secondary mb-3">🏠 Back to Home</a>
				<a href="add.php" class="btn btn-success mb-3">➕ Add New Product</a>
				<a href="logout.php" class="btn btn-danger mb-3 float-right">🚪 Logout</a>

				<table class="table table-bordered table-striped table-hover">
					<thead class="thead-dark">
						<tr>
							<th>prodID</th>
							<th>prodName</th>
							<th>prodDesc</th>
							<th>prodQty</th>
							<th>prodPrice</th>
							<th>brandID</th>
							<th>catID</th>
							<th>supplierID</th>
							<th>userID</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						while($res = mysqli_fetch_array($result)) {		
							echo "<tr>";
							echo "<td>".$res['prodID']."</td>";
							echo "<td>".htmlspecialchars($res['prodName'])."</td>";
							echo "<td>".htmlspecialchars($res['prodDesc'])."</td>";
							echo "<td>".$res['prodQty']."</td>";
							echo "<td>".$res['prodPrice']."</td>";
							echo "<td>".$res['brandID']."</td>";
							echo "<td>".$res['catID']."</td>";
							echo "<td>".$res['supplierID']."</td>";
							echo "<td>".$res['userID']."</td>";
							echo "<td>
									<a href=\"edit.php?id=".$res['prodID']."\" class=\"btn btn-warning btn-sm\">✏️ Edit</a>
									<a href=\"delete.php?id=".$res['prodID']."\" class=\"btn btn-danger btn-sm\" onclick=\"return confirm('Are you sure you want to delete this product?')\">❌ Delete</a>
								</td>";		
							echo "</tr>";
						}
						?>
					</tbody>
				</table>	
			</div>
			<div class="card-footer text-center">
				<p>Created by <a href="https://www.facebook.com/peko.cruz.7" target="_blank" class="text-primary">Group 9</a></p>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
