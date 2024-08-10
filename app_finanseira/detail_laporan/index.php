<?php
require_once '../config/config.php';
require_once '../config/middleware.php';

$title = 'Financial statements';
$pages = 'Financial statements';
$master = null;

function filterByDate($koneksi, $user_id, $start, $end)
{
    // Ubah format tanggal dari 'Y-m-d' menjadi 'Y-m-d H:i:s'
    $start_datetime = $start . " 00:00:00";
    $end_datetime = $end . " 23:59:59";
    
    // Query untuk semua data (pendapatan dan pengeluaran)
    $query = "
        (SELECT 'Pendapatan' AS tipe, tanggal, deskripsi, jumlah FROM tb_sell WHERE user_id = '$user_id' AND tanggal BETWEEN '$start_datetime' AND '$end_datetime')
        UNION ALL
        (SELECT 'Pengeluaran' AS tipe, tanggal, deskripsi, jumlah FROM tb_piutang WHERE user_id = '$user_id' AND tanggal BETWEEN '$start_datetime' AND '$end_datetime')
        UNION ALL
        (SELECT 'Pengeluaran' AS tipe, tanggal, deskripsi, jumlah FROM tb_buyyer WHERE user_id = '$user_id' AND tanggal BETWEEN '$start_datetime' AND '$end_datetime')
        UNION ALL
        (SELECT 'Pengeluaran' AS tipe, tanggal, deskripsi, jumlah FROM tb_beban WHERE user_id = '$user_id' AND tanggal BETWEEN '$start_datetime' AND '$end_datetime')
        UNION ALL
        (SELECT 'Pengeluaran' AS tipe, tanggal, deskripsi, jumlah FROM tb_pajak WHERE user_id = '$user_id' AND tanggal BETWEEN '$start_datetime' AND '$end_datetime')
    ";
    
    // Gabungkan query dan urutkan hasilnya
    $combined_query = $query . " ORDER BY tipe, tanggal DESC";

    return mysqli_query($koneksi, $combined_query);
}

// Ambil nilai dari form jika tersedia
$start = isset($_GET['start']) ? $_GET['start'] : null;
$end = isset($_GET['end']) ? $_GET['end'] : null;

// Dapatkan user_id dari session atau tempat lain
$user_id = $_SESSION['user_id']; // Sesuaikan dengan cara Anda mendapatkan user_id

// Inisialisasi variabel $result
$result = null;

if ($start && $end) {
    $result = filterByDate($koneksi, $user_id, $start, $end);
} else {
    $result = filterByDate($koneksi, $user_id, '1970-01-01', '2099-12-31'); // Ambil semua data jika tidak ada filter tanggal
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
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <form action="" method="get" class="form-inline">
                                        <label class="my-1 mr-2 col-form-label col-form-label-sm">Date Period</label>
                                        <input type="date" name="start" id="start" class="form-control form-control-sm mr-2" autocomplete="off" value="<?= htmlspecialchars($start) ?>" required>
                                        <label class="my-1 mr-2 col-form-label col-form-label-sm">s/d</label>
                                        <input type="date" name="end" id="end" class="form-control form-control-sm mr-2" autocomplete="off" value="<?= htmlspecialchars($end) ?>" required>
                                        <button type="submit" class="btn btn-primary btn-sm my-2 mr-1">Submit</button>
                                        <button type="button" class="btn btn-secondary btn-sm my-2" onclick="window.location.href='<?= $base_url ?>detail_laporan'">Reset</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Report Data</h6>
                                </div>
                                <div class="table-responsive p-3">
                                    <label>Income</label>
                                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                        <tr>
                                            <th>Date</th>
                                            <th>Description</th>
                                            <th>Total</th>
                                        </tr>
                                        <?php
                                        $total_pendapatan = 0;
                                        $result->data_seek(0); // Reset pointer hasil query
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            if ($row['tipe'] == 'Pendapatan') {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['tanggal']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['deskripsi']) . "</td>";
                                                echo "<td>Rp " . number_format($row['jumlah'], 2, ",", ".") . "</td>";
                                                echo "</tr>";

                                                $total_pendapatan += $row['jumlah'];
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="2"><strong>Total Income</strong></td>
                                            <td><strong>Rp <?= number_format($total_pendapatan, 2, ",", ".") ?></strong></td>
                                        </tr>
                                    </table>
                                    
                                    <label>Expenditure</label>
                                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                        <tr>
                                            <th>Date</th>
                                            <th>Description</th>
                                            <th>Total</th>
                                        </tr>
                                        <?php
                                        $total_pengeluaran = 0;
                                        $result->data_seek(0); // Reset pointer hasil query
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            if ($row['tipe'] == 'Pengeluaran') {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['tanggal']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['deskripsi']) . "</td>";
                                                echo "<td>Rp " . number_format($row['jumlah'], 2, ",", ".") . "</td>";
                                                echo "</tr>";

                                                $total_pengeluaran += $row['jumlah'];
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="2"><strong>Total Expenditure</strong></td>
                                            <td><strong>Rp <?= number_format($total_pengeluaran, 2, ",", ".") ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><strong>Final balance</strong></td>
                                            <td><strong>Rp <?= number_format($total_pendapatan - $total_pengeluaran, 2, ",", ".") ?></strong></td>
                                        </tr>
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