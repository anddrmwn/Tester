<?php
require_once '../config/config.php';
require_once '../config/middleware.php';

$title = 'Laporan Keuangan';
$pages = 'Laporan Keuangan';
$master = null;
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
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Data Laporan</h6>
                                </div>
                                <div class="table-responsive p-3">
                                    <label>Pendapatan</label>
                                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Deskripsi</th>
                                            <th>Jumlah</th>
                                        </tr>
                                        <?php
                                        // Query untuk mendapatkan hasil dari UNION ALL
                                        $query_union = "SELECT `tanggal`, `deskripsi`, `jumlah` FROM (SELECT `tanggal`, `deskripsi`, `jumlah` FROM tb_sell UNION ALL SELECT `tanggal`, `deskripsi`, `jumlah` FROM tb_piutang) AS merged_table";

                                        // Lakukan query
                                        $result_union = mysqli_query($koneksi, $query_union);

                                        // Inisialisasi total pendapatan
                                        $total_pendapatan = 0;

                                        // Loop melalui hasil query dan tampilkan di tabel
                                        while ($row = mysqli_fetch_assoc($result_union)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['tanggal'] . "</td>";
                                            echo "<td>" . $row['deskripsi'] . "</td>";
                                            echo "<td>Rp " . number_format($row['jumlah'], 2, ",", ".") . "</td>";
                                            echo "</tr>";

                                            // Tambahkan jumlah pendapatan ke total pendapatan
                                            $total_pendapatan += $row['jumlah'];
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="2"><strong>Total Pendapatan</strong></td>
                                            <td><strong>Rp <?= number_format($total_pendapatan, 2, ",", ".") ?></strong></td>
                                        </tr>
                                    </table>

                                    <label>Pengeluaran</label>
                                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Deskripsi</th>
                                            <th>Jumlah</th>
                                        </tr>
                                        <?php
                                        // Query untuk mendapatkan hasil dari UNION ALL
                                        $query_union = "SELECT `tanggal`, `deskripsi`, `jumlah` FROM (SELECT `tanggal`, `deskripsi`, `jumlah` FROM `tb_buyyer` UNION ALL SELECT `tanggal`, `deskripsi`, `jumlah` FROM `tb_beban` UNION ALL SELECT `tanggal`, `deskripsi`, `jumlah` FROM `tb_pajak`) AS merged_table";

                                        // Lakukan query
                                        $result_union = mysqli_query($koneksi, $query_union);

                                        // Inisialisasi total Harga Pokok Penjualan
                                        $total_hpp = 0;

                                        // Loop melalui hasil query dan tampilkan di tabel
                                        while ($row = mysqli_fetch_assoc($result_union)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['tanggal'] . "</td>";
                                            echo "<td>" . $row['deskripsi'] . "</td>";
                                            echo "<td>Rp " . number_format($row['jumlah'], 2, ",", ".") . "</td>";
                                            echo "</tr>";

                                            // Tambahkan jumlah Harga Pokok Penjualan ke total Harga Pokok Penjualan
                                            $total_hpp += $row['jumlah'];
                                        }
                                        
                                        // Your code to fetch and display content

                                        // Output buffering
                                        ob_start();

                                        // Your HTML content generation code

                                        $content = ob_get_clean();

                                        // Corrected require_once path
                                        require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');

                                        try {
                                            $html2pdf = new HTML2PDF('P', 'A4', 'en', array(8, 8, 8, 8));
                                            $html2pdf->pdf->SetDisplayMode('fullpage');
                                            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                                            $html2pdf->Output('index.pdf');
                                            } catch(HTML2PDF_exception $e) {
                                              echo $e;
                                              exit;
                                            }
                                        ?>
                                      
                                        <tr>
                                            <td colspan="2"><strong>Total Pengeluaran</strong></td>
                                            <td><strong>Rp <?= number_format($total_hpp, 2, ",", ".") ?></strong></td>
                                        </tr>
                                    </table>
                                    <label>Saldo Akhir</label>
                                        <tr>
                                            <td colspan="2"><strong>Saldo Akhir</strong></td>
                                            <td><strong>Rp <?= number_format($total_pendapatan - $total_hpp) ?></strong></td>
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