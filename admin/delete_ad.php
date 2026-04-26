<?php
session_start();
include('../config/db.php');

// حماية الصفحة
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') { exit("Access Denied"); }

$id = $_GET['id'];

// أولاً: جلب مسار الصورة لحذفها من السيرفر لتوفير المساحة
$res = mysqli_query($conn, "SELECT image_path FROM ad_images WHERE ad_id = '$id'");
$img = mysqli_fetch_assoc($res);
if ($img) {
    unlink("../uploads/" . $img['image_path']); // حذف الملف الفيزيائي
}

// ثانياً: حذف السجل من قاعدة البيانات (سيتم حذف الصور المرتبطة تلقائياً بسبب Foreign Key ON DELETE CASCADE)
$query = "DELETE FROM ads WHERE id = '$id'";

if (mysqli_query($conn, $query)) {
    header("Location: dashboard.php?msg=deleted");
}
?>