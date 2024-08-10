<?php
require_once '../config/config.php';

// Hapus semua variabel sesi
$_SESSION = array();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login
header("Location: " . $base_url . "auth");
exit();
