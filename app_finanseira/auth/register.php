<?php
require_once '../config/config.php';

if (isset($_POST['submit'])) {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);

    $query = "INSERT INTO `tb_users` (`user_id`, `username`, `email`, `password`) VALUES (NULL,'$username','$email','$password')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "
            <script>
                alert('Account Created Successfully');
                window.location.href='" . $base_url . "/auth/register.php';
            </script>
        ";
    } else {
        $errorMessage = "Registration Failed. Please try again later.";
        echo "<script>alert('$errorMessage');</script>";

        // Log the detailed error for debugging
        error_log("SQL Error: " . mysqli_error($koneksi));
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Form Register</title>
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
                                    <h3 class="mb-4 font-weight-bold">Create Account</h3>
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
                                        <input type="text" name="username" id="username" class="form-control border-0" placeholder="Username" autocomplete="off" maxlength="75" required>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="input-group border">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text border-0 bg-transparent">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                        </div>
                                        <input type="email" name="email" id="email" class="form-control border-0" placeholder="Email" autocomplete="off" maxlength="150" required>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="input-group border">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text border-0 bg-transparent">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="password" id="password" class="form-control border-0" placeholder="Password" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="submit" class="form-control btn btn-primary rounded submit px-3">Create Account</button>
                                </div>
                            </form>
                            <p class="text-center">Do you have account? <a href="<?= $base_url ?>auth">Sign in</a></p>
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

</body>

</html>