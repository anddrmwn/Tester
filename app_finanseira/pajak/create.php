<?php
require_once '../config/config.php';
require_once '../config/middleware.php';

$title = 'Tax';
$pages = 'Tax';
$master = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Mengambil nilai dari formulir dan mencegah SQL injection dengan htmlspecialchars
    $tanggal = htmlspecialchars($_POST['tanggal']);
    $gaji = htmlspecialchars($_POST['gaji']);
    $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
    $jenis_pajak = htmlspecialchars($_POST['jenis_pajak']);
    $npwp = htmlspecialchars($_POST['npwp']);
    $persentase = htmlspecialchars($_POST['persentase']);
    $jumlah = htmlspecialchars($_POST['jumlah']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $tipe = htmlspecialchars($_POST['tipe']);
   

    // Membuat query untuk memasukkan data ke dalam database
    $query = "INSERT INTO tb_pajak  VALUES (NULL, '$user_id', '$tanggal', '$gaji', '$nama_lengkap', '$jenis_pajak', '$npwp', '$persentase', '$jumlah', '$deskripsi', '$tipe', CURRENT_TIMESTAMP)";

    // Melakukan query ke database
    if (mysqli_query($koneksi, $query)) {
        echo '<script>alert("Data berhasil disimpan.");window.location.href="' . $base_url . 'pajak"</script>';
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
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="window.location.href='<?= $base_url ?>pajak'">Back</button>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label for="tanggal" class="col-form-label col-form-label-sm">Date</label>
                                            <input type="date" class="form-control form-control-sm" name="tanggal" id="tanggal" placeholder="Tanggal" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="gaji" class="col-form-label col-form-label-sm">Input Salary</label>
                                            <input type="number" class="form-control form-control-sm" name="gaji" id="gaji" placeholder="Masukan Gaji" min="1" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_lengkap" class="col-form-label col-form-label-sm">Full Name</label>
                                            <input type="text" class="form-control form-control-sm" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_pajak" class="col-form-label col-form-label-sm">Tax Type</label>
                                            <select name="jenis_pajak" id="jenis_pajak" class="form-control form-control-sm" required>
                                                <option value="">--- Choose ---</option>
                                                <option value="PPH">PPH</option>
                                                <option value="PPN">PPN</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="npwp" class="col-form-label col-form-label-sm">NPWP</label>
                                            <input type="number" class="form-control form-control-sm" name="npwp" id="npwp" placeholder="NPWP" min="1" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="persentase" class="col-form-label col-form-label-sm">Persentase %</label>
                                            <input type="number" class="form-control form-control-sm" name="persentase" id="persentase" placeholder="Persentase %" min="1" max="100" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="jumlah" class="col-form-label col-form-label-sm">Total</label>
                                            <input type="text" class="form-control form-control-sm bg-transparent" name="jumlah" id="jumlah" placeholder="Jumlah" autocomplete="off" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="deskripsi" class="col-form-label col-form-label-sm">Description</label>
                                            <input type="text" class="form-control form-control-sm" name="deskripsi" id="deskripsi" placeholder="Deskripsi" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="tipe" class="col-form-label col-form-label-sm">Type</label>
                                            <select class="form-control form-control-sm" name="tipe" id="tipe" required>
                                                <option value="Kas">Kas</option>
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