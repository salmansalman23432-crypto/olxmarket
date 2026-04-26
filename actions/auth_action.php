<?php
include('../config/db.php');
session_start();

// حالة إنشاء حساب جديد
if (isset($_POST['register'])) {
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];

    $query = "INSERT INTO users (full_name, email, password, phone) VALUES ('$name', '$email', '$pass', '$phone')";
    if (mysqli_query($conn, $query)) {
        header("Location: ../login.php?msg=account_created");
    }
}

// حالة تسجيل الدخول
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_role'] = $user['user_role'];
        header("Location: ../index.php");
    } else {
        header("Location: ../login.php?error=wrong_credentials");
    }
}
?>