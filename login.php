<?php session_start(); ?>
<html>
<head>
	<title>Login</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="bg-light">
<div class="container mt-5">
	<div class="card shadow-lg">
		<div class="card-header bg-primary text-white text-center">
			<h3>Login</h3>
		</div>
		<div class="card-body">
			<a href="index.php" class="btn btn-outline-secondary mb-3">🏠 Back to Home</a>

			<?php
			include("connection.php");

			if(isset($_POST['submit'])) {
				$user = mysqli_real_escape_string($mysqli, $_POST['username']);
				$pass = mysqli_real_escape_string($mysqli, $_POST['password']);

			
				if($user == "" || $pass == "") {
					echo "<div class='alert alert-warning'>⚠️ Email and Password fields cannot be empty.</div>";
				} else {
					
					$result = mysqli_query($mysqli, "SELECT * FROM user WHERE email='$user'")
						or die("❌ Could not execute the select query.");
					
					$row = mysqli_fetch_assoc($result);
					
					if(is_array($row) && !empty($row)) {
						
						if(password_verify($pass, $row['password'])) {
							$_SESSION['valid'] = $row['email'];
							$_SESSION['fullname'] = $row['fullname'];
							$_SESSION['id'] = $row['userID'];

							header('Location: index.php');
							exit();
						} else {
							echo "<div class='alert alert-danger'>❌ Invalid password. Please try again.</div>";
						}
					} else {
						echo "<div class='alert alert-danger'>❌ Invalid email or password. Please try again.</div>";
					}
				}
			} else {
			?>
	
				<form name="form1" method="post" action="">
					<div class="form-group">
						<label for="username">Email</label>
						<input type="text" name="username" class="form-control" placeholder="Enter your email">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" name="password" class="form-control" placeholder="Enter your password">
					</div>
					<button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
				</form>
			<?php
			}
			?>
		</div>
		<div class="card-footer text-center">
			Don't have an account? <a href="register.php" class="text-primary">Register here</a>.
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
