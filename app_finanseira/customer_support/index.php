<?php
require_once '../config/config.php';
require_once '../config/middleware.php';

$title = 'Customer Support';
$pages = 'Customer Support';
$master = null;

$user_id = $_SESSION['user_id'];
if ($account['role'] === 'admin') {
    $query = "SELECT `tb_customer_support`.*, `tb_users`.`nama_lengkap` FROM `tb_customer_support` INNER JOIN `tb_users` ON `tb_users`.`user_id` = `tb_customer_support`.`user_id` ORDER BY `tb_customer_support`.`tanggal` DESC";
} elseif ($account['role'] === 'user') {
    $query = "SELECT `tb_customer_support`.*, `tb_users`.`nama_lengkap` FROM `tb_customer_support` INNER JOIN `tb_users` ON `tb_users`.`user_id` = `tb_customer_support`.`user_id` WHERE `tb_customer_support`.`user_id` = '$user_id' ORDER BY `tb_customer_support`.`tanggal` DESC";
}
$result = mysqli_query($koneksi, $query);
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
                                    <h6 class="m-0 font-weight-bold text-primary">List <?= $title ?></h6>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='<?= $base_url ?>customer_support/create.php'">Tambah Data</button>
                                </div>
                                <div class="table-responsive p-3">
                                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Date</th>
                                                <th>Create Name</th>
                                                <th>Report Type</th>
                                                <th>Description</th>
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
                                                    <td><?= $row['nama_lengkap'] ?></td>
                                                    <td><?= $row['jenis_pengaduan'] ?></td>
                                                    <td><?= $row['deskripsi'] ?></td>
                                                    <td>
                                                        <?php if ($row['user_id'] == $account['user_id']) : ?>
                                                            <a href="<?= $base_url ?>customer_support/edit.php?id=<?= $row['cs_id'] ?>">Edit</a> | <a href="<?= $base_url ?>customer_support/delete.php?id=<?= $row['cs_id'] ?>" onclick="return confirm('Are you sure you want to delete this data?')">Delete</a>
                                                        <?php else : ?>
                                                            Access Denied
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php
                                            endforeach;
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

</body>

</html>