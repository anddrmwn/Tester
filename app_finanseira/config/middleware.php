<?php
// Jika belum ada sesi login, redirect ke halaman auth
if (!isset($_SESSION['logged_in'])) {
    header("Location: " . $base_url . "auth");
    exit();
}
