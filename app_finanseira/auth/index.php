<?php
require_once '../config/config.php';

$pages = 'Login';

$errorMessage = ''; // Initialize an empty error message

if (isset($_POST['submit'])) {
	$user = htmlspecialchars($_POST['user']);
	$password = htmlspecialchars($_POST['password']);

	// Validate the user credentials
	$query = "SELECT * FROM `tb_users` WHERE `username` = '$user' OR `email` = '$user'";
	$result = mysqli_query($koneksi, $query);

	if ($result) {
		if ($row = mysqli_fetch_assoc($result)) {
			// Verify password
			if (password_verify($password, $row['password'])) {
				// Successful login
				$_SESSION['user_id'] = $row['user_id'];
				$_SESSION['nama_lengkap'] = $row['nama_lengkap'];
				$_SESSION['logged_in'] = TRUE;
				header("Location: " . $base_url);
				exit();
			} else {
				$errorMessage = "Incorrect password";
			}
		} else {
			$errorMessage = "User not found";
		}
	} else {
		$errorMessage = "Login failed. Please try again later.";
		error_log("SQL Error: " . mysqli_error($koneksi));
	}
}
?>

<!doctype html>
<html lang="en">

<head>
	<title>Form Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="<?= $base_url ?>assets/images/frame-23.png" type="image/x-icon">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
	<link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">

</head>

<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img" style="background-image: url(<?= $base_url ?>assets/images/frame-22.png);">
						</div>
						<div class="login-wrap p-4 p-md-5">
							<div class="d-flex">
								<div class="w-100">
									<h3 class="mb-4 font-weight-bold">Login to your Account</h3>
								</div>
							</div>
							<form action="" method="post" class="signin-form">
								<div class="form-group mb-3">
									<div class="input-group border">
										<div class="input-group-prepend">
											<span class="input-group-text border-0 bg-transparent">
												<i class="fas fa-user"></i>
											</span>
										</div>
										<input type="text" name="user" id="user" class="form-control border-0" placeholder="Enter email or username" autocomplete="off" maxlength="150" required>
									</div>
								</div>
								<div class="form-group mb-3">
									<div class="input-group border">
										<div class="input-group-prepend">
											<span class="input-group-text border-0 bg-transparent">
												<i class="fas fa-lock"></i>
											</span>
										</div>
										<input type="password" name="password" id="password" class="form-control border-0" placeholder="Password" autocomplete="off" required>
										<div class="input-group-append">
											<span class="input-group-text border-0 bg-transparent toggle-password" style="cursor: pointer;">
												<i class="fas fa-eye"></i>
											</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<button type="submit" name="submit" class="form-control btn btn-primary rounded submit px-3">Login to continue</button>
								</div>
							</form>
							<p class="text-center">Don’t have an account? <a href="<?= $base_url ?>auth/register.php">Sign Up</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="<?= $base_url ?>assets/js/jquery.min.js"></script>
	<script src="<?= $base_url ?>assets/js/popper.js"></script>
	<script src="<?= $base_url ?>assets/js/bootstrap.min.js"></script>
	<script src="<?= $base_url ?>assets/js/main.js"></script>
	<script>
		$(document).ready(function() {
			// Toggle password visibility
			$(".toggle-password").click(function() {
				var passwordField = $("#password");
				var fieldType = passwordField.attr("type");

				if (fieldType === "password") {
					passwordField.attr("type", "text");
				} else {
					passwordField.attr("type", "password");
				}

				// Toggle eye icon
				$(this).find("i").toggleClass("fa-eye fa-eye-slash");
			});
		});
	</script>

	<?php
	// Display error message in JavaScript alert
	if (!empty($errorMessage)) {
		echo "<script>
			alert('$errorMessage');
			window.location.href='" . $base_url . "/auth';	
		</script>";
	}
	?>
</body>

</html>