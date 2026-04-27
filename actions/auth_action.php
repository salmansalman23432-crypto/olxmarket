<?php
include('../config/db.php');

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    $user = mysqli_fetch_assoc($result);

    if ($user && (password_verify($pass, $user['password']) || $pass === $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role'] = $user['user_role']; 
        header("Location: ../index.php");
    } else {
        header("Location: ../login.php?error=wrong_credentials");
    }
}