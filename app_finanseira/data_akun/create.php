<?php
require_once '../config/config.php';
require_once '../config/middleware.php';

$title = 'Account Data';
$pages = 'Account Data';
$master = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Mengambil nilai dari formulir dan mencegah SQL injection dengan htmlspecialchars
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
    $role = htmlspecialchars($_POST['role']);

    // Membuat query untuk memasukkan data ke dalam database
    $query = "INSERT INTO `tb_users`(`user_id`, `username`, `email`, `password`, `role`) VALUES (NULL, '$username', '$email', '$password', '$role')";

    // Melakukan query ke database
    if (mysqli_query($koneksi, $query)) {
        echo '<script>alert("Data berhasil disimpan.");window.location.href="' . $base_url . 'data_akun"</script>';
    } else {
        echo '<script>alert("Gagal menyimpan data: ' . mysqli_error($koneksi) . '");</script>';
    }

    // Menutup koneksi database
    mysqli_close($koneksi);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once '../_partikel/head.php' ?>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php require_once '../_partikel/sidebar.php' ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php require_once '../_partikel/navbar.php' ?>

                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?= $pages ?></h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= $base_url ?>">Home</a></li>
                            <?php if ($master != NULL) : ?>
                                <li class="breadcrumb-item"><?= $master ?></li>
                            <?php endif; ?>
                            <li class="breadcrumb-item active" aria-current="page"><?= $pages ?></li>
                        </ol>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Add Data <?= $title ?></h6>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="window.location.href='<?= $base_url ?>data_akun'">Back</button>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label for="username" class="col-form-label col-form-label-sm">Username</label>
                                            <input type="text" class="form-control form-control-sm" name="username" id="username" placeholder="Username" maxlength="75" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="col-form-label col-form-label-sm">Email</label>
                                            <input type="email" class="form-control form-control-sm" name="email" id="email" placeholder="Email" maxlength="150" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-form-label col-form-label-sm">Password</label>
                                            <input type="text" name="password" id="password" class="form-control form-control-sm" placeholder="Password" maxlength="155" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="role" class="col-form-label col-form-label-sm">Role</label>
                                            <select name="role" id="role" class="form-control form-control-sm" required>
                                                <option value="">--- Choose ---</option>
                                                <option value="admin">Admin</option>
                                                <option value="user">User</option>
                                            </select>
                                        </div>
                                        <div class="float-right">
                                            <button type="submit" name="submit" class="btn btn-primary btn-sm">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php require_once '../_partikel/modal_logout.php' ?>
            <?php require_once '../_partikel/footer.php' ?>
        </div>
    </div>

    <?php require_once '../_partikel/javascript.php' ?>
</body>

</html>