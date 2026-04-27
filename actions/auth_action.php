<?php
include('../config/db.php');
// تأكد من أن session_start() موجودة إما هنا أو داخل ملف db.php

// أولاً: معالجة تسجيل الدخول (Login)
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    $user = mysqli_fetch_assoc($result);

    // التحقق من كلمة المرور (سواء مشفرة أو نص عادي للتوافق)
    if ($user && (password_verify($pass, $user['password']) || $pass === $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role'] = $user['user_role']; 
        header("Location: ../index.php");
        exit();
    } else {
        header("Location: ../login.php?error=wrong_credentials");
        exit();
    }
}

// ثانياً: معالجة تسجيل مستخدم جديد (Register)
if (isset($_POST['register'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = $_POST['password'];

    // تشفير كلمة المرور قبل حفظها
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // التحقق من عدم تكرار البريد الإلكتروني
    $check_email = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check_email) > 0) {
        header("Location: ../login.php?error=email_exists");
        exit();
    }

    // إدخال البيانات في الجدول
    $sql = "INSERT INTO users (full_name, email, phone, password, user_role) 
            VALUES ('$full_name', '$email', '$phone', '$hashed_password', 'user')";

    if (mysqli_query($conn, $sql)) {
        // بعد التسجيل الناجح، نقوم بتسجيل دخوله تلقائياً
        $_SESSION['user_id'] = mysqli_insert_id($conn);
        $_SESSION['full_name'] = $full_name;
        $_SESSION['role'] = 'user';
        
        header("Location: ../index.php?status=welcome");
        exit();
    } else {
        echo "خطأ أثناء التسجيل: " . mysqli_error($conn);
    }
}