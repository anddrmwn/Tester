<?php
require_once '../config/config.php';
require_once '../config/middleware.php';
$title = 'Account Data';
$pages = 'Account Data';
$master = null;

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM `tb_users` ORDER BY `created_at` ASC";
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
                                    <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='<?= $base_url ?>data_akun/create.php'">Add Data</button>
                                </div>
                                <div class="table-responsive p-3">
                                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Fullname</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Role</th>
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
                                                    <td><?= $row['nama_lengkap'] === NULL ? '-' : $row['nama_lengkap'] ?></td>
                                                    <td><?= $row['username'] ?></td>
                                                    <td><?= $row['email'] ?></td>
                                                    <td><?= $row['role'] ?></td>
                                                    <td><a href="<?= $base_url ?>data_akun/edit.php?id=<?= $row['user_id'] ?>">Edit</a> | <a href="<?= $base_url ?>data_akun/delete.php?id=<?= $row['user_id'] ?>" onclick="return confirm('Are you sure you want to delete this data?')">Delete</a></td>
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