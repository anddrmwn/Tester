<?php

// Require necessary files
require_once '../config/config.php';
require_once '../config/middleware.php';

// Check if user is authenticated and get user_id
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Handle the case where the user ID is not set
    die('User not authenticated');
}

$title = 'Expense Data';
$pages = 'Expense Data';
$master = null;

// Fungsi untuk filter periode tanggal
function filterByDate($koneksi, $start, $end, $user_id)
{
    // Ubah format tanggal dari 'Y-m-d' menjadi 'Y-m-d H:i:s'
    $start_datetime = $start . " 00:00:00";
    $end_datetime = $end . " 23:59:59";

    // Gunakan parameter yang sudah diubah formatnya dalam kueri SQL
    $query = "SELECT tb_beban.beban_id as beban_id, tb_beban.tanggal as tanggal, tb_beban.deskripsi as deskripsi, tb_beban.jumlah as jumlah, tb_beban.tipe as tipe, tb_subpos.nama as jenis_beban 
              FROM tb_beban, tb_subpos 
              WHERE tb_beban.tanggal BETWEEN '$start_datetime' AND '$end_datetime' 
              AND tb_beban.user_id = '$user_id'  
              AND tb_subpos.kode = tb_beban.jenis_beban 
              AND tb_subpos.pos = 5 
              ORDER BY tb_beban.created_at ASC";
    return mysqli_query($koneksi, $query);
}

// Ambil nilai dari form jika tersedia
$start = isset($_GET['start']) ? $_GET['start'] : null;
$end = isset($_GET['end']) ? $_GET['end'] : null;

// Lakukan filter jika tanggal start dan end tersedia
if ($start && $end) {
    $result = filterByDate($koneksi, $start, $end, $user_id);
} else {
    // Jika tidak ada filter, tampilkan semua data
    $result = mysqli_query($koneksi, "SELECT tb_beban.beban_id as beban_id, tb_beban.tanggal as tanggal, tb_beban.deskripsi as deskripsi, tb_beban.jumlah as jumlah, tb_beban.tipe as tipe, tb_subpos.nama as jenis_beban 
                                       FROM tb_beban, tb_subpos 
                                       WHERE tb_beban.user_id = '$user_id'  
                                       AND tb_subpos.kode = tb_beban.jenis_beban 
                                       AND tb_subpos.pos = 5 
                                       ORDER BY tb_beban.created_at ASC");
}

function rupiah($angka)
{
    $hasil_rupiah = "Rp" . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
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
                                <div class="card-header">
                                    <form action="" method="get" class="form-inline">
                                        <label class="my-1 mr-2 col-form-label col-form-label-sm">Date Period</label>
                                        <input type="date" name="start" id="start" class="form-control form-control-sm mr-2" autocomplete="off" value="<?= isset($_GET['start']) ? $_GET['start'] : null ?>" required>
                                        <label class="my-1 mr-2 col-form-label col-form-label-sm">s/d</label>
                                        <input type="date" name="end" id="end" class="form-control form-control-sm mr-2" autocomplete="off" value="<?= isset($_GET['end']) ? $_GET['end'] : null ?>" required>
                                        <button type="submit" class="btn btn-primary btn-sm my-2 mr-1">Submit</button>
                                        <button type="button" class="btn btn-secondary btn-sm my-2" onclick="window.location.href='<?= $base_url ?>beban'">Reset</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">List <?= $title ?></h6>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='<?= $base_url ?>beban/create.php'">Add Data</button>
                                </div>
                                <div class="table-responsive p-3">
                                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Date</th>
                                                <th>Expense type</th>
                                                <th>Description</th>
                                                <th>Total</th>
                                                <th>Type</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($result as $row) :
                                            ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= date('d F Y', strtotime($row['tanggal'])) ?></td>
                                                    <td><?= $row['jenis_beban']  ?></td>
                                                    <td><?= $row['deskripsi'] ?></td>
                                                    <td><?= rupiah($row['jumlah']) ?></td>
                                                    <td><?= ($row['tipe']) ?></td>
                                                    <td><a href="<?= $base_url ?>beban/edit.php?id=<?= $row['beban_id'] ?>">Edit</a> | <a href="<?= $base_url ?>beban/delete.php?id=<?= $row['beban_id'] ?>" onclick="return confirm('Are you sure you want to delete this data?')">Delete</a></td>
                                                </tr>
                                            <?php
                                            endforeach;
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                            </tr>
                                        </tfoot>
                                    </table>
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
        // Menggunakan jQuery untuk memeriksa validitas tanggal saat formulir disubmit
        $(document).ready(function() {
            $('form').submit(function(e) {
                var startDate = $('#start').val();
                var endDate = $('#end').val();

                // Membandingkan tanggal start dan end
                if (startDate > endDate) {
                    alert('Mohon inputkan tanggal yang benar: Tanggal start tidak boleh lebih besar dari tanggal end.');
                    return false; // Menghentikan form submission
                }
                return true; // Melanjutkan form submission
            });
        });
    </script>
</body>
</html>
