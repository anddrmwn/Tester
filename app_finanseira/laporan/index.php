<?php
require_once '../config/config.php';
require_once '../config/middleware.php';

$title = 'Report';
$pages = 'Report';
$master = null;

function filterByDate($koneksi, $start, $end)
{
    // Ubah format tanggal dari 'Y-m-d' menjadi 'Y-m-d H:i:s'
    $start_datetime = $start . " 00:00:00";
    $end_datetime = $end . " 23:59:59";
}

// Ambil nilai dari form jika tersedia
$start = isset($_GET['start']) ? $_GET['start'] : null;
$end = isset($_GET['end']) ? $_GET['end'] : null;

// Lakukan filter jika tanggal start dan end tersedia
if ($start && $end) {
    $result = filterByDate($koneksi, $start, $end);
}

function rupiah($angka)
{
    $hasil_rupiah = "Rp" . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

function subtotalPiutang($koneksi, $tanggal, $start, $end)
{
    $query_jumlah = mysqli_query($koneksi, "SELECT SUM(`jumlah`) AS `total_piutang` FROM `tb_piutang` WHERE tanggal between '$start' and '$end'");

    $sum_piutang = 0;

    if ($query_jumlah) {
        $row_piutang = mysqli_fetch_assoc($query_jumlah);

        $sum_piutang = $row_piutang['total_piutang'] ?? 0;
    }

    return $subtotal = $sum_piutang;
}
function subtotalPajak($koneksi, $tanggal, $start, $end)
{
    $query_jumlah = mysqli_query($koneksi, "SELECT SUM(`jumlah`) AS `total_pajak` FROM `tb_pajak` WHERE tanggal between '$start' and '$end'");

    $sum_pajak = 0;

    if ($query_jumlah) {
        $row_pajak = mysqli_fetch_assoc($query_jumlah);

        $sum_pajak = $row_pajak['total_pajak'] ?? 0;
    }

    return $subtotal = $sum_pajak;
}

function subtotalPenjualan($koneksi, $tanggal, $start, $end)
{
    $query_nominal = mysqli_query($koneksi, "SELECT SUM(`jumlah`) AS `total_penjualan` FROM `tb_sell` WHERE tanggal between '$start' and '$end'");
    $sum_penjualan = 0;

    if ($query_nominal) {
        $row_penjualan = mysqli_fetch_assoc($query_nominal);

        $sum_penjualan = $row_penjualan['total_penjualan'] ?? 0;
    }
    return $subtotal = $sum_penjualan;
}

function subtotalPembelian($koneksi, $tanggal, $start, $end)
{
    $query_nominal = mysqli_query($koneksi, "SELECT SUM(`jumlah`) AS `total_pembelian` FROM `tb_buyyer` where tanggal between '$start' and '$end'");

    $sum_pembelian = 0;

    if ($query_nominal) {
        $row_pembelian = mysqli_fetch_assoc($query_nominal);

        $sum_pembelian = $row_pembelian['total_pembelian'] ?? 0;
    }

    return $subtotal = $sum_pembelian;
}

function subtotalBeban($koneksi, $tanggal, $start, $end)
{
    $query_nominal = mysqli_query($koneksi, "SELECT SUM(`jumlah`) AS `total_beban` FROM `tb_beban` where tanggal between '$start' and '$end'");

    $sum_beban = 0;

    if ($query_nominal) {
        $row_beban = mysqli_fetch_assoc($query_nominal);

        $sum_beban = $row_beban['total_beban'] ?? 0;
    }

    return $subtotal = $sum_beban;
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

                <!-- Main Content -->
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
                                        <!-- Tambahkan kondisi untuk memeriksa apakah nilai sudah ada atau tidak -->
                                        <input type="date" name="start" id="start" class="form-control form-control-sm mr-2" autocomplete="off" value="<?= isset($_GET['start']) ? $_GET['start'] : null ?>" required>
                                        <label class="my-1 mr-2 col-form-label col-form-label-sm">s/d</label>
                                        <!-- Tambahkan kondisi untuk memeriksa apakah nilai sudah ada atau tidak -->
                                        <input type="date" name="end" id="end" class="form-control form-control-sm mr-2" autocomplete="off" value="<?= isset($_GET['end']) ? $_GET['end'] : null ?>" required>
                                        <button type="submit" class="btn btn-primary btn-sm my-2 mr-1">Submit</button>
                                        <!-- Tombol reset untuk mengembalikan nilai form ke nilai default -->
                                        <button type="button" class="btn btn-secondary btn-sm my-2" onclick="window.location.href='<?= $base_url ?>laporan'">Reset</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Report Data Recap</h6>
                                </div>
                                <div class="table-responsive p-3">
                                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Category</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            // Mendapatkan tanggal hari ini dalam format 'Y-m-d'
                                            $tanggal = date('Y-m-d');
                                            // Hitung subtotal untuk masing-masing kategori
                                            $subtotalPenjualan = subtotalPenjualan($koneksi, $tanggal, $start, $end);
                                            $subtotalPembelian = subtotalPembelian($koneksi, $tanggal, $start, $end);
                                            $subtotalLabaKotor = $subtotalPenjualan - $subtotalPembelian;
                                            $subtotalBeban = subtotalBeban($koneksi, $tanggal, $start, $end);
                                            $subtotalLabaOperasi = $subtotalLabaKotor - $subtotalBeban;
                                            $subtotalPajak = subtotalPajak($koneksi, $tanggal, $start, $end);
                                            $subtotalLabaBersih = $subtotalLabaOperasi - $subtotalPajak;
                                            $subtotalPiutang = subtotalPiutang($koneksi, $tanggal, $start, $end);
                                            $subtotalPendapatan = $subtotalLabaBersih + $subtotalPenjualan +  $subtotalLabaKotor ;
                                            $subtotalPengeluaran = $subtotalBeban + $subtotalPembelian + $subtotalPajak + $subtotalPiutang  ;
                                            $subtotalSaldo = $subtotalPendapatan - $subtotalPengeluaran;
                                            ?>
                                                <tr>
                                                    <td><?php echo "$no";$no++?></td>
                                                    <td>
                                                        Sales
                                                    </td>
                                                    <td><?= rupiah($subtotalPenjualan)?></td>
                                                </tr>

                                                <tr>
                                                    <td><?php echo "$no";$no++?></td>
                                                    <td>
                                                        Buy
                                                    </td>
                                                    <td><?= rupiah($subtotalPembelian)?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo "$no";$no++?></td>
                                                    <td>
                                                        Gross profit
                                                    </td>
                                                    <td><?= rupiah($subtotalLabaKotor)?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo "$no";$no++?></td>
                                                    <td>
                                                        Expense</td>
                                                    <td>
                                                        <?= rupiah($subtotalBeban)?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo "$no";$no++?></td>
                                                    <td>Operating profit</td>
                                                    <td><?= rupiah($subtotalLabaOperasi)?></td>
                                                </tr>
                                            
                                                <tr>
                                                    <td><?php echo "$no";$no++?></td>
                                                    <td>Tax</td>
                                                    <td><?= rupiah($subtotalPajak)?></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td><?php echo "$no";$no++?></td>
                                                    <td>
                                                        Receivable
                                                    </td>
                                                    <td>
                                                        <?= rupiah($subtotalPiutang)?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo "$no";$no++?></td>
                                                    <td>Net profit</td>
                                                    <td><?= rupiah($subtotalLabaBersih)?></td>
                                                </tr>

                                                <tr>
                                                    <td><?php echo "$no";$no++?></td>
                                                    <td>
                                                        Income
                                                    </td>
                                                    <td><?= rupiah( $subtotalPendapatan)?></td>
                                                </tr>

                                                <tr>
                                                    <td><?php echo "$no";$no++?></td>
                                                    <td>
                                                        Expenditure
                                                    </td>
                                                    <td><?= rupiah( $subtotalPengeluaran)?></td>
                                                </tr>

                                                <tr>
                                                    <td><?php echo "$no";$no++?></td>
                                                    <td>
                                                        Final balance
                                                    </td>
                                                    <td><?= rupiah( $subtotalSaldo)?></td>
                                                </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Content -->

            </div>

            <?php require_once '../_partikel/modal_logout.php' ?>
            <?php require_once '../_partikel/footer.php' ?>
        </div>
    </div>

    <?php require_once '../_partikel/javascript.php' ?>

</body>
</html>