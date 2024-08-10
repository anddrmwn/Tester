<?php
require_once '../config/config.php';
require_once '../config/middleware.php';

$title = 'Buy Data';
$pages = 'Buy Data';
$master = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Mengambil nilai dari formulir dan mencegah SQL injection dengan htmlspecialchars
    $tanggal = htmlspecialchars($_POST['tanggal']);
    $jenis_pembelian = htmlspecialchars($_POST['jenis_pembelian']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $jumlah = htmlspecialchars($_POST['jumlah']);
    $tipe = htmlspecialchars($_POST['tipe']);
    
   
    // Membuat query untuk memasukkan data ke dalam database
    $query = "INSERT INTO `tb_buyyer` VALUES (NULL, '$user_id', '$tanggal', '$jenis_pembelian', '$deskripsi', '$jumlah','$tipe', CURRENT_TIMESTAMP)";

    // Melakukan query ke database
    if (mysqli_query($koneksi, $query)) {
        echo '<script>alert("Data berhasil disimpan.");window.location.href="' . $base_url . 'buyyer"</script>';
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
                                    <h6 class="m-0 font-weight-bold text-primary">Add Data <?= $title ?></h6>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="window.location.href='<?= $base_url ?>buyyer'">Back</button>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label for="tanggal" class="col-form-label col-form-label-sm">Date</label>
                                            <input type="date" class="form-control form-control-sm" name="tanggal" id="tanggal" placeholder="Tanggal" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                         <FORM METHOD=POST action="<?php echo $_SERVER["PHP_SELF"];?>"> 
                                            <label for="jenis_pembelian" class="col-form-label col-form-label-sm">Buy data type</label>
                                            <select name="jenis_pembelian" id="jenis_pembelian" class="form-control form-control-sm" required>
                                                <?php
                                                include 'config.php';

                                                // Write a SQL query to fetch the data from the tb_subpos table
                                                $query = "SELECT * FROM tb_subpos where pos = 6";

                                                // Use the mysqli_query() function to execute the query
                                                $res = mysqli_query($koneksi,$query);

                                                // Initialize the $select_str variable
                                                $select_str = "";

                                                // Loop through the result set using the mysqli_fetch_row() function
                                                while ($row = mysqli_fetch_row($res)) 
                                                {
                                                // Append the options to the $select_str variable
                                                $select_str .= "<OPTION VALUE=\"$row[0]\" >$row[1]</OPTION>\n"; 
                                                }

                                                // Print the $select_str variable
                                                echo $select_str;
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="deskripsi" class="col-form-label col-form-label-sm">Description</label>
                                            <input type="text" class="form-control form-control-sm" name="deskripsi" id="deskripsi" placeholder="Deskripsi" value="0" min="0" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="jumlah" class="col-form-label col-form-label-sm">Total</label>
                                            <input type="number" class="form-control form-control-sm" name="jumlah" id="jumlah" placeholder="Jumlah" value="0" min="0" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="tipe" class="col-form-label col-form-label-sm">Type</label>
                                            <select class="form-control form-control-sm" name="tipe" id="tipe" required>
                                                <option value="Kas">Kas</option>
                                            </select>
                                        </div>
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
</body>

</html>