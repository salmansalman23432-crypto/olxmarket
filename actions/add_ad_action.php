<?php
include('../config/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // جلب البيانات من النموذج
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $cat_id = $_POST['category_id'];
    $user_id = $_SESSION['user_id'] ?? 1; // مؤقتاً نستخدم 1 حتى ننهي نظام الدخول

    // معالجة رفع الصورة الواحدة
    $image_name = time() . '_' . $_FILES['image']['name'];
    $target = "../uploads/" . $image_name;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        // إدخال الإعلان
        $query = "INSERT INTO ads (user_id, category_id, title, description, price, status) 
                  VALUES ('$user_id', '$cat_id', '$title', '$desc', '$price', 'pending')";
        
        if (mysqli_query($conn, $query)) {
            $last_id = mysqli_insert_id($conn);
            // ربط الصورة بالإعلان في جدول الصور
            mysqli_query($conn, "INSERT INTO ad_images (ad_id, image_path, is_main) VALUES ('$last_id', '$image_name', 1)");
            
            header("Location: ../index.php?success=ad_added");
        }
    }
}
?>