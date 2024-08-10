<?php
// Include configuration and middleware
require_once '../config/config.php';
require_once '../config/middleware.php';

$title = 'Buy Data';
$pages = 'Buy Data';
$master = null;

// Function to filter by date
function filterByDate($koneksi, $start, $end, $user_id)
{
    // Convert dates from 'Y-m-d' to 'Y-m-d H:i:s'
    $start_datetime = $start . " 00:00:00";
    $end_datetime = $end . " 23:59:59";
    
    // Use formatted dates and user_id in SQL query
    $query = "SELECT tb_buyyer.buy_id as buy_id, tb_buyyer.tanggal as tanggal, tb_buyyer.deskripsi as deskripsi, tb_buyyer.jumlah as jumlah, tb_buyyer.tipe as tipe, tb_subpos.nama as jenis_pembelian FROM tb_buyyer, tb_subpos WHERE tb_buyyer.tanggal BETWEEN '$start_datetime' AND '$end_datetime' AND tb_buyyer.user_id = '$user_id' AND tb_subpos.kode = tb_buyyer.jenis_pembelian AND tb_subpos.pos = 6 ORDER BY tb_buyyer.created_at ASC";
    return mysqli_query($koneksi, $query);
}

// Get values from form if available
$start = isset($_GET['start']) ? $_GET['start'] : null;
$end = isset($_GET['end']) ? $_GET['end'] : null;

// Apply filter if start and end dates are provided
if ($start && $end) {
    $result = filterByDate($koneksi, $start, $end, $user_id);
} else {
    // If no filter, display all data
    $result = mysqli_query($koneksi, "SELECT tb_buyyer.buy_id as buy_id, tb_buyyer.tanggal as tanggal, tb_buyyer.deskripsi as deskripsi, tb_buyyer.jumlah as jumlah, tb_buyyer.tipe as tipe, tb_subpos.nama as jenis_pembelian FROM tb_buyyer, tb_subpos WHERE tb_buyyer.user_id = '$user_id' AND tb_subpos.kode = tb_buyyer.jenis_pembelian AND tb_subpos.pos = 6 ORDER BY tb_buyyer.created_at ASC");
}

function rupiah($angka)
{
    return "Rp" . number_format($angka, 2, ',', '.');
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
                                        <button type="button" class="btn btn-secondary btn-sm my-2" onclick="window.location.href='<?= $base_url ?>buyyer'">Reset</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">List <?= $title ?></h6>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='<?= $base_url ?>buyyer/create.php'">Add Data</button>
                                </div>
                                <div class="table-responsive p-3">
                                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Date</th>
                                                <th>Buy type</th>
                                                <th>Description</th>
                                                <th>Total</th>
                                                <th>Type</th>
                                                <th>Action</th>
                                         
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            while ($row = mysqli_fetch_assoc($result)) :
                                            ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= date('d F Y', strtotime($row['tanggal'])) ?></td>
                                                    <td><?= $row['jenis_pembelian'] ?></td>
                                                    <td><?= $row['deskripsi'] ?></td>
                                                    <td><?= rupiah($row['jumlah']) ?></td>
                                                    <td><?= $row['tipe'] ?></td>
                                                    <td><a href="<?= $base_url ?>buyyer/edit.php?id=<?= $row['buy_id'] ?>">Edit</a> | <a href="<?= $base_url ?>buyyer/delete.php?id=<?= $row['buy_id'] ?>" onclick="return confirm('Are you sure you want to delete this data?')">Delete</a></td>
                                                </tr>
                                            <?php
                                            endwhile;
                                            ?>
                                        </tbody>
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
        $(document).ready(function() {
            $('form').submit(function(e) {
                var startDate = $('#start').val();
                var endDate = $('#end').val();

                if (startDate > endDate) {
                    alert('Mohon inputkan tanggal yang benar: Tanggal start tidak boleh lebih besar dari tanggal end');
                    e.preventDefault();
                }
            });
        });
    </script>
</body>

</html>
