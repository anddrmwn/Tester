<?php
require_once '../config/config.php';
require_once '../config/middleware.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data dari database
    $query = "DELETE FROM `tb_sell` WHERE `sell_id` = '$id'";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        echo '<script>alert("Data berhasil dihapuskan.");window.location.href="' . $base_url . 'sell"</script>';
    } else {
        echo '<script>alert("Gagal menghapus data: ' . mysqli_error($koneksi) . '");</script>';
    }
} else {
    echo "ID tidak valid atau tidak diberikan.";
}
