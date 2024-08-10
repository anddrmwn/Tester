<?php

$base_url = "https://finanseiraapps.accounting.com.dksystem.id/";

$server = "localhost";
$user = "dksystem_adminfin";
$password = "iG.ssW@7N2e(";
$nama_database = "dksystem_finanseira";

$koneksi = mysqli_connect($server, $user, $password, $nama_database);

if (!$koneksi) {
    die("Gagal terhubung dengan database: " . mysqli_connect_error());
}

session_start();

if (isset($_SESSION['user_id'])) {
    // Jika pengguna sudah masuk, ambil informasi akun
    $user_id = $_SESSION['user_id'];
    $account = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tb_users` WHERE `user_id` = '$user_id'"));
}
