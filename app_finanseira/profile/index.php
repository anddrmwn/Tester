<?php
require_once '../config/config.php';
require_once '../config/middleware.php';

$title = 'Profile';
$pages = 'Profile';
$master = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_avatar'])) {
    // Mendapatkan nama file dan path sementara pada server
    $fileTmp = $_FILES['avatar']['tmp_name'];
    $fileName = $_FILES['avatar']['name'];
    $fileSize = $_FILES['avatar']['size'];
    $fileError = $_FILES['avatar']['error'];

    // Memeriksa apakah file yang diunggah adalah gambar
    $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
    $uploadedExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if (!in_array($uploadedExtension, $allowedExtensions)) {
        echo '<script>alert("Hanya file gambar yang diizinkan (JPG, JPEG, PNG, GIF)."); window.location.href="' . $base_url . 'profile"</script>';
        exit();
    }

    // Memeriksa apakah ada file yang diunggah
    if ($fileError === 0) {
        // Memeriksa ukuran file
        if ($fileSize > 0) {
            // Mengatur path untuk menyimpan file di server
            $uploadPath = '../assets/img/';

            // Mendapatkan ekstensi file
            $uploadedExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Membuat nama file unik dengan ekstensi yang sama
            $uniqueFileName = uniqid('avatar_') . '.' . $uploadedExtension;

            // Menambahkan path untuk menyimpan file di server
            $destination = $uploadPath . $uniqueFileName;

            // Memindahkan file yang diunggah ke path yang ditentukan
            if (move_uploaded_file($fileTmp, $destination)) {
                // Membuat query untuk memperbarui nama file avatar dalam database
                $query = "UPDATE `tb_users` SET `avatar`='$uniqueFileName', `last_changed`=CURRENT_TIMESTAMP WHERE `user_id`='$user_id'";

                // Melakukan query ke database
                if (mysqli_query($koneksi, $query)) {
                    echo '<script>alert("Avatar berhasil diubah.");window.location.href="' . $base_url . 'profile"</script>';
                } else {
                    echo '<script>alert("Gagal memperbarui data: ' . mysqli_error($koneksi) . '");</script>';
                }
            } else {
                echo '<script>alert("Gagal mengunggah file.");</script>';
            }
        } else {
            echo '<script>alert("Ukuran file terlalu besar.");</script>';
        }
    } else {
        echo '<script>alert("Terjadi kesalahan saat mengunggah file.");</script>';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_avatar'])) {
    // Membuat query untuk memperbarui nama file avatar dalam database
    $query = "UPDATE `tb_users` SET `avatar`=NULL, `last_changed`=CURRENT_TIMESTAMP WHERE `user_id`='$user_id'";

    // Melakukan query ke database
    if (mysqli_query($koneksi, $query)) {
        echo '<script>alert("Avatar berhasil dihapuskan.");window.location.href="' . $base_url . 'profile"</script>';
    } else {
        echo '<script>alert("Gagal menghapus data: ' . mysqli_error($koneksi) . '");</script>';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['biodata'])) {
    // Mengambil nilai dari formulir dan mencegah SQL injection dengan htmlspecialchars
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);

    // Membuat query untuk memasukkan data ke dalam database
    $query = "UPDATE `tb_users` SET `username`='$username', `email`='$email', `nama_lengkap`='$nama_lengkap', `last_changed`=CURRENT_TIMESTAMP WHERE `user_id`='$user_id'";

    // Melakukan query ke database
    if (mysqli_query($koneksi, $query)) {
        echo '<script>alert("Akun Profile Anda Berhasil Diperbaharui.");window.location.href="' . $base_url . 'profile"</script>';
    } else {
        echo '<script>alert("Gagal memperbaharui data: ' . mysqli_error($koneksi) . '");</script>';
    }

    // Menutup koneksi database
    mysqli_close($koneksi);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    // Mengambil nilai dari formulir dan mencegah SQL injection dengan htmlspecialchars
    $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);

    // Membuat query untuk memasukkan data ke dalam database
    $query = "UPDATE `tb_users` SET `password`='$password', `last_changed`=CURRENT_TIMESTAMP WHERE `user_id`='$user_id'";

    // Melakukan query ke database
    if (mysqli_query($koneksi, $query)) {
        echo '<script>alert("Password Telah Diperbaharui.");window.location.href="' . $base_url . 'profile"</script>';
    } else {
        echo '<script>alert("Gagal memperbaharui data: ' . mysqli_error($koneksi) . '");</script>';
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
                            <div class="card mb-3">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Avatar</h6>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="form-group text-center">
                                            <img src="<?= $base_url ?>assets/img/<?= $account['avatar'] === NULL ? 'boy.png' : $account['avatar'] ?>" style="max-width: 100px" class="img-profile rounded-circle" alt="">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="avatar" id="avatar">
                                                <label class="custom-file-label" for="avatar">Choose file</label>
                                            </div>
                                        </div>
                                        <div class="float-right">
                                            <button type="submit" name="remove_avatar" class="btn btn-danger btn-sm">Remove</button>
                                            <button type="submit" name="change_avatar" class="btn btn-primary btn-sm">Change</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card mb-3">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary"><?= $title ?> Settings</h6>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label for="nama_lengkap" class="col-form-label col-form-label-sm">Nama Lengkap</label>
                                            <input type="text" class="form-control form-control-sm" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" maxlength="155" value="<?= $account['nama_lengkap'] === NULL ? '-' : $account['nama_lengkap'] ?>" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="username" class="col-form-label col-form-label-sm">Username</label>
                                            <input type="text" class="form-control form-control-sm" name="username" id="username" placeholder="Username" maxlength="75" value="<?= $account['username'] ?>" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="col-form-label col-form-label-sm">Email</label>
                                            <input type="email" class="form-control form-control-sm" name="email" id="email" placeholder="Email" maxlength="150" value="<?= $account['email'] ?>" autocomplete="off" required>
                                        </div>
                                        <div class="float-right">
                                            <button type="submit" name="biodata" class="btn btn-primary btn-sm">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card mb-3">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Secutiry & Password</h6>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label for="password" class="col-form-label col-form-label-sm">Password</label>
                                            <input type="password" class="form-control form-control-sm" name="password" id="password" placeholder="********" maxlength="155" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="last_changed" class="col-form-label col-form-label-sm">Last Changed : <?= date('d-m-Y H:i:s', strtotime($account['last_changed'])) ?></label>
                                        </div>
                                        <div class="float-right">
                                            <button type="submit" name="change_password" class="btn btn-primary btn-sm">Update</button>
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
    <script>
        $(document).ready(function() {
            // Menangkap peristiwa input pada elemen input file
            $('#avatar').on('change', function() {
                // Mengambil nama file yang dipilih
                var fileName = $(this).val().split('\\').pop();
                // Mengubah label custom-file-label menjadi nama file yang dipilih
                $(this).next('.custom-file-label').html(fileName);
            });
        });
    </script>
</body>

</html>