<?php
require_once 'config/config.php';
require_once 'config/middleware.php';

$title = 'Dashboard';
$pages = 'Dashboard';
$master = null;

function rupiah($angka)
{
    $hasil_rupiah = "Rp" . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

$tanggal = date('Y-m-d');

$sum_piutang = mysqli_fetch_assoc($query_jumlah = mysqli_query($koneksi, "SELECT SUM(`jumlah`) AS `total_piutang` FROM `tb_piutang` WHERE DATE(`created_at`) = '$tanggal'  AND `user_id` = '$user_id'"));
$sum_pajak = mysqli_fetch_assoc($query_jumlah = mysqli_query($koneksi, "SELECT SUM(`jumlah`) AS `total_pajak` FROM `tb_pajak` WHERE DATE(`created_at`) = '$tanggal'  AND `user_id` = '$user_id'"));
$query_new_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total_new_user FROM `tb_users` WHERE `role` = 'user' AND DATE(`created_at`) = '$tanggal'"));
$query_customer_support = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total_customer_support FROM `tb_customer_support` WHERE DATE(`tanggal`) = '$tanggal' AND `user_id` = '$user_id'"));
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once '_partikel/head.php' ?>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php require_once '_partikel/sidebar.php' ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php require_once '_partikel/navbar.php' ?>

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

                    <?php if ($account['role'] === 'admin') : ?>
                        <div class="row mb-3">
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Receivables</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= rupiah($sum_piutang['total_piutang']) ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-funnel-dollar fa-2x text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Tax</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= rupiah($sum_pajak['total_pajak']) ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-money-check fa-2x text-light"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">New User</div>
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $query_new_user['total_new_user'] ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-users fa-2x text-info"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Customer Support</div>
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $query_customer_support['total_customer_support'] ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-headset fa-2x text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php elseif ($account['role'] === 'user') : ?>
                        <div class="row mb-3">
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Receivables</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= rupiah($sum_piutang['total_piutang']) ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-funnel-dollar fa-2x text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Tax</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= rupiah($sum_pajak['total_pajak']) ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-money-check fa-2x text-light"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Customer Support</div>
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $query_customer_support['total_customer_support'] ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-headset fa-2x text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="row mb-3">
                            <div class="col-xl-12 col-md-12 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        Anda Dilarang Mengakses Menu Ini
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php require_once '_partikel/modal_logout.php' ?>
            <?php require_once '_partikel/footer.php' ?>
        </div>
    </div>

    <?php require_once '_partikel/javascript.php' ?>

</body>

</html>