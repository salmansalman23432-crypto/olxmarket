<?php
include('../config/db.php');

if (isset($_POST['update_profile']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $new_password = $_POST['new_password'];

    // التحديث يستثني الإيميل تماماً لزيادة الأمان
    $sql = "UPDATE users SET full_name='$full_name', phone='$phone' WHERE id='$user_id'";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['full_name'] = $full_name;

        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE users SET password='$hashed_password' WHERE id='$user_id'");
        }

        header("Location: ../profile.php?success=1");
    } else {
        echo "خطأ في التحديث: " . mysqli_error($conn);
    }
}