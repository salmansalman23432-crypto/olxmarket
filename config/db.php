<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/olxmarket/');
}

$conn = mysqli_connect("localhost", "root", "", "olx_market_db");
if (!$conn) { die("خطأ في الاتصال: " . mysqli_connect_error()); }
mysqli_set_charset($conn, "utf8mb4");