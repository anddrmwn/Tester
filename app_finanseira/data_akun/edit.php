<?php
require_once '../config/config.php';
require_once '../config/middleware.php';
$title = 'Account Data';
$pages = 'Account Data';
$master = null;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM `tb_users` WHERE `user_id` = '$id'";
    $res = mysqli_fetch_assoc(mysqli_query($koneksi, $query));

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        // Mengambil nilai dari formulir dan mencegah SQL injection dengan htmlspecialchars
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $role = htmlspecialchars($_POST['role']);

        // Mengecek apakah password diisi atau tidak
        $password_update = '';
        if (!empty($_POST['password'])) {
            $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
            $password_update = ", `password`='$password'";
        }

        // Membuat query untuk memasukkan data ke dalam database
        $query = "UPDATE `tb_users` SET `username`='$username',`email`='$email' $password_update ,`role`='$role' WHERE `user_id`='$id'";

        // Melakukan query ke database
        if (mysqli_query($koneksi, $query)) {
            echo '<script>alert("Data berhasil diperbaharui.");window.location.href="' . $base_url . 'data_akun"</script>';
        } else {
            echo '<script>alert("Gagal memperbaharui data: ' . mysqli_error($koneksi) . '");</script>';
        }

        // Menutup koneksi database
        mysqli_close($koneksi);
    }
} else {
    echo "ID tidak valid atau tidak diberikan.";
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
                                    <h6 class="m-0 font-weight-bold text-primary">Edit Data <?= $title ?></h6>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="window.location.href='<?= $base_url ?>data_akun'">Kembali</button>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label for="username" class="col-form-label col-form-label-sm">Username</label>
                                            <input type="text" class="form-control form-control-sm" name="username" id="username" placeholder="Username" maxlength="75" value="<?= $res['username'] ?>" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="col-form-label col-form-label-sm">Email</label>
                                            <input type="email" class="form-control form-control-sm" name="email" id="email" placeholder="Email" maxlength="150" value="<?= $res['email'] ?>" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-form-label col-form-label-sm">Password <sup>(opsional)</sup></label>
                                            <input type="text" name="password" id="password" class="form-control form-control-sm" placeholder="Password" maxlength="155" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="role" class="col-form-label col-form-label-sm">Role</label>
                                            <select name="role" id="role" class="form-control form-control-sm" required>
                                                <option value="">--- Choose ---</option>
                                                <option value="admin" <?= $res['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                                <option value="operator" <?= $res['role'] === 'operator' ? 'selected' : '' ?>>Operator</option>
                                                <option value="user" <?= $res['role'] === 'user' ? 'selected' : '' ?>>User</option>
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