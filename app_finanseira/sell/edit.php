<?php
require_once '../config/config.php';
require_once '../config/middleware.php';

$title = 'Sales Data';
$pages = 'Sales Data';
$master = null;

// ambil data by get ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM `tb_sell` WHERE `sell_id` = '$id'";
    $res = mysqli_fetch_assoc(mysqli_query($koneksi, $query));

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        // Mengambil nilai dari formulir dan mencegah SQL injection dengan htmlspecialchars
        $tanggal = htmlspecialchars($_POST['tanggal']);
        $jenis_penjualan = htmlspecialchars($_POST['jenis_penjualan']);
        $deskripsi = htmlspecialchars($_POST['deskripsi']);
        $jumlah = htmlspecialchars($_POST['jumlah']);
        $tipe = htmlspecialchars($_POST['tipe']);

        // Membuat query untuk memperbarui data di dalam database
        $query = "UPDATE `tb_sell` SET 
                    `tanggal`='$tanggal',
                    `jenis_penjualan`='$jenis_penjualan',
                    `deskripsi`='$deskripsi',
                    `jumlah`='$jumlah',
                    `tipe`='$tipe' 
                  WHERE `sell_id`='$id'";

        // Melakukan query ke database
        if (mysqli_query($koneksi, $query)) {
            echo '<script>alert("Data berhasil diperbaharui.");window.location.href="' . $base_url . 'sell"</script>';
        } else {
            echo '<script>alert("Gagal memperbaharui data: ' . mysqli_error($koneksi) . '");</script>';
        }
    }
} else {
    echo "ID tidak valid atau tidak diberikan.";
}

// Kueri untuk mengambil data tb_subpos
$query = "SELECT * FROM `tb_subpos` where pos = 7";
$result_pos = mysqli_query($koneksi, $query);
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
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="window.location.href='<?= $base_url ?>sell'">Back</button>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label for="tanggal" class="col-form-label col-form-label-sm">Date</label>
                                            <input type="date" class="form-control form-control-sm" name="tanggal" id="tanggal" placeholder="Tanggal" value="<?= $res['tanggal'] ?>" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_penjualan" class="col-form-label col-form-label-sm">Sales data type</label>
                                            <select name="jenis_penjualan" id="jenis_penjualan" class="form-control form-control-sm" required>
                                                <?php foreach ($result_pos as $pos) : ?>
                                                    <option value="<?= $pos['kode'] ?>" <?= $pos['kode'] == $res['jenis_penjualan'] ? 'selected' : '' ?>><?= $pos['nama'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="deskripsi" class="col-form-label col-form-label-sm">Description</label>
                                            <textarea class="form-control form-control-sm" name="deskripsi" id="deskripsi" placeholder="Deskripsi" autocomplete="off" required><?= $res['deskripsi'] ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="jumlah" class="col-form-label col-form-label-sm">Total</label>
                                            <input type="number" class="form-control form-control-sm" name="jumlah" id="jumlah" placeholder="Jumlah" value="<?= $res['jumlah'] ?>" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="tipe" class="col-form-label col-form-label-sm">Type</label>
                                            <select class="form-control form-control-sm" name="tipe" id="tipe" required>
                                                <option value="Nonkas" <?= ($res['tipe'] == 'Nonkas') ? 'selected' : '' ?>>Non kas</option>
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

<?php
// Menutup koneksi database setelah semua operasi selesai
mysqli_close($koneksi);
?>