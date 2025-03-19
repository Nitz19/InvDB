<?php
include("connection.php");

if(isset($_POST['submit'])) {
	$fullname = $_POST['name'];
	$email = $_POST['email'];
	$pass = $_POST['password'];
	$confirm_pass = $_POST['confirm_password'];


	if($fullname == "" || $email == "" || $pass == "" || $confirm_pass == "") {
		$message = "⚠️ All fields should be filled. Please complete the form.";
	} 
	
	elseif($pass != $confirm_pass) {
		$message = "❌ Passwords do not match. Please try again.";
	} 
	else {
	
		$hashedPassword = password_hash($pass, PASSWORD_BCRYPT);
		
	
		$query = "INSERT INTO user(fullname, email, password, dateCreated) 
		          VALUES('$fullname', '$email', '$hashedPassword', NOW())";

		if(mysqli_query($mysqli, $query)) {
			$message = "✅ Registration successful! <a href='login.php' class='btn btn-success btn-sm'>Login</a>";
		} else {
			$message = "❌ Error while inserting record: " . mysqli_error($mysqli);
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">
	<div class="card shadow-lg">
		<div class="card-header bg-primary text-white text-center">
			<h3>Register</h3>
		</div>
		<div class="card-body">
			<a href="index.php" class="btn btn-outline-secondary mb-3">🏠 Back to Home</a>

			<?php if(isset($message)) { ?>
				<div class="alert alert-info">
					<?php echo $message; ?>
				</div>
			<?php } ?>
			
			<form method="post" action="">
				<div class="form-group">
					<label for="name">Full Name</label>
					<input type="text" class="form-control" name="name" placeholder="Enter your full name" required>
				</div>
				<div class="form-group">
					<label for="email">Email Address</label>
					<input type="email" class="form-control" name="email" placeholder="Enter your email" required>
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" name="password" placeholder="Enter your password" required>
				</div>
				<div class="form-group">
					<label for="confirm_password">Confirm Password</label>
					<input type="password" class="form-control" name="confirm_password" placeholder="Re-enter your password" required>
				</div>
				<button type="submit" name="submit" class="btn btn-primary btn-block">Register</button>
			</form>
		</div>
		<div class="card-footer text-center">
			Already have an account? <a href="login.php" class="text-primary">Login here</a>.
		</div>
	</div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
