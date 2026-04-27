<?php 
include('config/db.php'); 
include('includes/functions.php'); 
include('includes/header.php'); 
?>

<div class="container" style="display: flex; flex-wrap: wrap; gap: 30px; justify-content: center; padding: 40px 0;">
    
    <div style="flex: 1; min-width: 300px; max-width: 450px; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; margin-bottom: 25px; color: #2c3e50;">تسجيل الدخول</h2>
        <form action="actions/auth_action.php" method="POST">
            <input type="email" name="email" placeholder="البريد الإلكتروني" required style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px;">
            <input type="password" name="password" placeholder="كلمة المرور" required style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px;">
            <button type="submit" name="login" style="width: 100%; padding: 12px; background: #2c3e50; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">دخول</button>
        </form>
    </div>

    <div style="flex: 1; min-width: 300px; max-width: 450px; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; margin-bottom: 25px; color: #e67e22;">إنشاء حساب جديد</h2>
        <form action="actions/auth_action.php" method="POST">
            <input type="text" name="full_name" placeholder="الاسم بالكامل" required style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px;">
            <input type="email" name="email" placeholder="البريد الإلكتروني" required style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px;">
            <input type="password" name="password" placeholder="كلمة المرور" required style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px;">
            <input type="text" name="phone" placeholder="رقم الهاتف" required style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px;">
            <button type="submit" name="register" style="width: 100%; padding: 12px; background: #e67e22; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">تسجيل الحساب</button>
        </form>
    </div>

</div>

<?php include('includes/footer.php'); ?>