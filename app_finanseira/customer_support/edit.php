<?php
require_once '../config/config.php';
require_once '../config/middleware.php';

$title = 'Customer Support';
$pages = 'Customer Support';
$master = null;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT `tb_customer_support`.*, `tb_users`.`nama_lengkap` FROM `tb_customer_support` INNER JOIN `tb_users` ON `tb_users`.`user_id` = `tb_customer_support`.`user_id` WHERE `tb_customer_support`.`cs_id` = '$id'";
    $res = mysqli_fetch_assoc(mysqli_query($koneksi, $query));

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        // Mengambil nilai dari formulir dan mencegah SQL injection dengan htmlspecialchars
        $tanggal = htmlspecialchars($_POST['tanggal']);
        $user_id = htmlspecialchars($_POST['user_id']);
        $jenis_pengaduan = htmlspecialchars($_POST['jenis_pengaduan']);
        $deskripsi = htmlspecialchars($_POST['deskripsi']);

        // Membuat query untuk memasukkan data ke dalam database
        $query = "UPDATE `tb_customer_support` SET `tanggal`='$tanggal',`user_id`='$user_id',`jenis_pengaduan`='$jenis_pengaduan',`deskripsi`='$deskripsi' WHERE `cs_id`='$id'";

        // Melakukan query ke database
        if (mysqli_query($koneksi, $query)) {
            echo '<script>alert("Data berhasil diperbaharui.");window.location.href="' . $base_url . 'customer_support"</script>';
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
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="window.location.href='<?= $base_url ?>customer_support'">Kembali</button>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label for="tanggal" class="col-form-label col-form-label-sm">Date</label>
                                            <input type="date" class="form-control form-control-sm" name="tanggal" id="tanggal" placeholder="Tanggal" min="1" autocomplete="off" value="<?= $res['tanggal'] ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_lengkap" class="col-form-label col-form-label-sm">Create Name</label>
                                            <input type="hidden" name="user_id" id="user_id" value="<?= $res['user_id'] ?>">
                                            <input type="text" class="form-control form-control-sm bg-transparent" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Pembuat" value="<?= $res['nama_lengkap'] ?>" autocomplete="off" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_pengaduan" class="col-form-label col-form-label-sm">Report Type</label>
                                            <input type="text" name="jenis_pengaduan" id="jenis_pengaduan" class="form-control form-control-sm" placeholder="Jenis Pengaduan" autocomplete="off" maxlength="100" value="<?= $res['jenis_pengaduan'] ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="deskripsi" class="col-form-label col-form-label-sm">Description</label>
                                            <textarea name="deskripsi" id="deskripsi" cols="30" rows="4" class="form-control form-control-sm" placeholder="Deskripsi" autocomplete="off" required><?= $res['deskripsi'] ?></textarea>
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
    <script>
        $(document).ready(function() {
            // Ketika nilai gaji atau persentase berubah
            $('#gaji, #persentase').on('input', function() {
                // Ambil nilai gaji dan persentase
                var gaji = $('#gaji').val();
                var persentase = $('#persentase').val();

                // Hitung jumlah berdasarkan gaji dan persentase
                var jumlah = parseInt(gaji * (persentase / 100));

                // Set nilai jumlah ke dalam input jumlah
                $('#jumlah').val(jumlah);
            });
        });
    </script>

</body>

</html>