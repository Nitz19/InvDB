<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Homepage</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body class="bg-light">

	<div class="container mt-5">
		<div class="jumbotron text-center">
			<h1 class="display-4">Welcome to Our Inventory System</h1>
			<p class="lead">Manage and Track</p>
		</div>

		<?php
if(isset($_SESSION['valid'])) {			
	include("connection.php");					
	$result = mysqli_query($mysqli, "SELECT * FROM user"); 
?>
<div class="alert alert-success text-center">
	Welcome, <strong><?php echo $_SESSION['fullname']; ?></strong>! 🎉 <br>
	<a href="logout.php" class="btn btn-danger btn-sm mt-2">Logout</a>
</div>

		
		<div class="text-center mt-4">
			<a href="view.php" class="btn btn-primary btn-lg">View and Add Products</a>
		</div>
		
		<?php	
		} else {
			?>
			<div class="alert alert-warning text-center">
				<strong>You must be logged in to view this page.</strong>
			</div>
			<div class="text-center mt-4">
				<a href="login.php" class="btn btn-success">Login</a>
				<a href="register.php" class="btn btn-info ml-2">Register</a>
			</div>
			<?php
		}
		?>
		
		<footer class="text-center mt-5">
			<p>Created by <a href="https://www.facebook.com/peko.cruz.7" target="_blank" class="text-primary">Group 9</a></p>
		</footer>
	</div>

	
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
