<?php
include('../config/db.php');
include('../includes/functions.php');

if (isset($_POST['submit_ad']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    $image_name = ""; // افتراضي

    // معالجة رفع الصورة إذا وجدت
    if (isset($_FILES['ad_image']) && $_FILES['ad_image']['error'] == 0) {
        $target_dir = "../uploads/";
        $extension = pathinfo($_FILES["ad_image"]["name"], PATHINFO_EXTENSION);
        $image_name = time() . "_" . uniqid() . "." . $extension; // اسم فريد للصورة
        $target_file = $target_dir . $image_name;

        if (!move_uploaded_file($_FILES["ad_image"]["tmp_name"], $target_file)) {
            $image_name = ""; // في حال فشل الرفع
        }
    }

    // إدخال البيانات في قاعدة البيانات
    $sql = "INSERT INTO ads (user_id, category_id, title, description, price, image, status) 
            VALUES ('$user_id', '$category_id', '$title', '$description', '$price', '$image_name', 'active')";

    if (mysqli_query($conn, $sql)) {
        // العودة للرئيسية مع رسالة نجاح
        header("Location: ../index.php?status=success");
    } else {
        echo "خطأ في القاعدة: " . mysqli_error($conn);
    }
} else {
    // محاولة دخول غير شرعي للملف
    header("Location: ../index.php");
}