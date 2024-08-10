<?php
require_once 'config/config.php';
require_once 'config/middleware.php';

$title = 'About Us Features';
$pages = 'About Us Features';
$master = null;
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

                    <div class="row mb-3">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-header" style="background-image: url('<?= $base_url ?>assets/images/frame-26.png'); background-repeat: no-repeat; background-size: cover; background-position: center; padding: 130px 0;">
                                </div>
                                <div class="card-body text-center h5">
                                    Finanseira is a website about structural financial arrangements which was created naturally by the Cloud-Based Financial Information Systems Group. chaired by Muhammad Rahadyan, Deputy Chairman by Muhamad Andi Darmawan, Manager by Dhafin Azka, and Staff by Alif Firmansyah. The purpose of creating this financial website is to pass the final assignment at the final level which will be related to the field of information economics effectively.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Content -->

            </div>

            <?php require_once '_partikel/modal_logout.php' ?>
            <?php require_once '_partikel/footer.php' ?>
        </div>
    </div>

    <?php require_once '_partikel/javascript.php' ?>

</body>

</html>