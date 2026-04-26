<?php
// إعدادات قاعدة البيانات
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "olx_market_db";

// إنشاء الاتصال
$conn = mysqli_connect($host, $user, $pass, $dbname);

// التحقق من الاتصال
if (!$conn) {
    die("فشل الاتصال: " . mysqli_connect_error());
}

// ضبط الترميز لدعم اللغة العربية بشكل كامل
mysqli_set_charset($conn, "utf8mb4");

// مسار ثابت للمشروع ليسهل علينا استدعاء الملفات
define('BASE_URL', 'http://localhost/your_project_name/'); 
?>