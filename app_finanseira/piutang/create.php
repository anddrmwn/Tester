<?php
require_once '../config/config.php';
require_once '../config/middleware.php';

$title = 'Receivables';
$pages = 'Receivables';
$master = null;

// Mendapatkan nomor transaksi terakhir dari database
$query_last_transaction = "SELECT MAX(SUBSTRING_INDEX(`no_transaksi`, '#', -1)) AS last_transaction FROM `tb_piutang`";
$result_last_transaction = mysqli_query($koneksi, $query_last_transaction);

if ($result_last_transaction && mysqli_num_rows($result_last_transaction) > 0) {
    $row_last_transaction = mysqli_fetch_assoc($result_last_transaction);
    // Mengambil nomor transaksi terakhir dan menambahkannya dengan 1
    $last_transaction_number = isset($row_last_transaction['last_transaction']) ? intval($row_last_transaction['last_transaction']) : 0;
    $next_transaction_number = $last_transaction_number + 1;
} else {
    // Jika tidak ada nomor transaksi sebelumnya, mulai dengan nomor 1
    $next_transaction_number = 1;
}

// Buat nomor transaksi otomatis
$auto_generated_transaction_number = "Invoice #" . $next_transaction_number;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Mengambil nilai dari formulir dan mencegah SQL injection dengan htmlspecialchars
    $tanggal = htmlspecialchars($_POST['tanggal']);
    $no_transaksi = htmlspecialchars($_POST['no_transaksi']);
    $nama = htmlspecialchars($_POST['nama']);
    $jatuh_tempo = htmlspecialchars($_POST['jatuh_tempo']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $jumlah = htmlspecialchars($_POST['jumlah']);
    $tipe = htmlspecialchars($_POST['tipe']);

    // Membuat query untuk memasukkan data ke dalam database
    $query = "INSERT INTO `tb_piutang` (`piutang_id`, `user_id`, `tanggal`, `no_transaksi`, `nama`, `jatuh_tempo`, `deskripsi`, `jumlah`, `tipe`, `created_at`) VALUES (NULL, '$user_id', '$tanggal', '$no_transaksi', '$nama', '$jatuh_tempo', '$deskripsi', '$jumlah', '$tipe', CURRENT_TIMESTAMP)";

    // Melakukan query ke database
    if (mysqli_query($koneksi, $query)) {
        echo '<script>alert("Data berhasil disimpan.");window.location.href="' . $base_url . 'piutang"</script>';
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
                                    <h6 class="m-0 font-weight-bold text-primary">Tambah Data <?= $title ?></h6>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="window.location.href='<?= $base_url ?>piutang'">Back</button>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label for="tanggal" class="col-form-label col-form-label-sm">Date</label>
                                            <input type="date" class="form-control form-control-sm" name="tanggal" id="tanggal" placeholder="Tanggal" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="no_transaksi" class="col-form-label col-form-label-sm">Transaction Number</label>
                                            <input type="text" class="form-control form-control-sm bg-transparent" name="no_transaksi" id="no_transaksi" placeholder="No Transaksi" value="<?= $auto_generated_transaction_number ?>" maxlength="55" autocomplete="off" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama" class="col-form-label col-form-label-sm">Name</label>
                                            <input type="text" name="nama" id="nama" class="form-control form-control-sm" placeholder="Nama" autocomplete="off" maxlength="155" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="jatuh_tempo" class="col-form-label col-form-label-sm">Due Date</label>
                                            <input type="date" class="form-control form-control-sm" name="jatuh_tempo" id="jatuh_tempo" placeholder="Jatuh Tempo" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="jumlah" class="col-form-label col-form-label-sm">Total</label>
                                            <input type="text" class="form-control form-control-sm bg-transparent" name="jumlah" id="jumlah" placeholder="Jumlah" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="deskripsi" class="col-form-label col-form-label-sm">Description</label>
                                            <textarea class="form-control form-control-sm" name="deskripsi" id="deskripsi" placeholder="Deskripsi" autocomplete="off" required></textarea>
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