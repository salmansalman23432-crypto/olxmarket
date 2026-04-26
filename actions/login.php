<?php include('includes/header.php'); ?>

<div class="auth-box" style="display: flex; gap: 50px;">
    <div class="login-section">
        <h3>تسجيل الدخول</h3>
        <form action="actions/auth_action.php" method="POST">
            <input type="email" name="email" placeholder="البريد الإلكتروني" required><br><br>
            <input type="password" name="password" placeholder="كلمة المرور" required><br><br>
            <button type="submit" name="login">دخول</button>
        </form>
    </div>

    <div class="register-section">
        <h3>إنشاء حساب جديد</h3>
        <form action="actions/auth_action.php" method="POST">
            <input type="text" name="full_name" placeholder="الاسم الكامل" required><br><br>
            <input type="email" name="email" placeholder="البريد الإلكتروني" required><br><br>
            <input type="password" name="password" placeholder="كلمة المرور" required><br><br>
            <input type="text" name="phone" placeholder="رقم الهاتف" required><br><br>
            <button type="submit" name="register">إنشاء حساب</button>
        </form>
    </div>
</div>

<?php include('includes/footer.php'); ?>