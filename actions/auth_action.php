<?php
include('../config/db.php');

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];
    $redirect_to = isset($_POST['redirect_to']) ? $_POST['redirect_to'] : '../index.php';

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    $user = mysqli_fetch_assoc($result);

    if ($user && (password_verify($pass, $user['password']) || $pass === $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['user_role'] = $user['user_role']; 
        
        // إذا كان الرابط لا يبدأ بـ ../ أو http، نضيف ../ للعودة للمجلد الرئيسي
        if (strpos($redirect_to, 'http') === false && strpos($redirect_to, '../') === false) {
            $redirect_to = '../' . $redirect_to;
        }

        header("Location: $redirect_to");
        exit();
    } else {
        header("Location: ../login.php?error=wrong_credentials&redirect_to=" . urlencode($redirect_to));
        exit();
    }
}

if (isset($_POST['register'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = $_POST['password'];
    $redirect_to = isset($_POST['redirect_to']) ? $_POST['redirect_to'] : '../index.php';

    $check_email = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check_email) > 0) {
        header("Location: ../login.php?error=email_exists&redirect_to=" . urlencode($redirect_to));
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (full_name, email, phone, password, user_role) 
            VALUES ('$full_name', '$email', '$phone', '$hashed_password', 'user')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['user_id'] = mysqli_insert_id($conn);
        $_SESSION['full_name'] = $full_name;
        $_SESSION['user_role'] = 'user';
        
        if (strpos($redirect_to, 'http') === false && strpos($redirect_to, '../') === false) {
            $redirect_to = '../' . $redirect_to;
        }

        header("Location: $redirect_to");
        exit();
    } else {
        echo "خطأ أثناء التسجيل: " . mysqli_error($conn);
    }
}