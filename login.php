<?php 
include('config/db.php'); 
include('includes/functions.php'); 
include('includes/header.php'); 

$redirect_url = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : 'index.php';
?>

<div class="container" style="padding: 50px 0;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; background: white; padding: 40px; border-radius: 15px; box-shadow: 0 5px 25px rgba(0,0,0,0.1);">
        
        <div>
            <h2 style="margin-bottom: 25px; color: var(--primary);">تسجيل الدخول</h2>
            
            <?php if(isset($_GET['error']) && $_GET['error'] == 'wrong_credentials'): ?>
                <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb; font-size: 0.9rem;">
                    ❌ البريد الإلكتروني أو كلمة المرور غير صحيحة.
                </div>
            <?php endif; ?>

            <form action="actions/auth_action.php" method="POST">
                <input type="hidden" name="redirect_to" value="<?php echo htmlspecialchars($redirect_url); ?>">
                
                <div style="margin-bottom: 15px;">
                    <label>البريد الإلكتروني:</label>
                    <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-top: 5px;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label>كلمة المرور:</label>
                    <input type="password" name="password" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-top: 5px;">
                </div>
                <button type="submit" name="login" class="btn-login" style="width: 100%; border: none; padding: 15px; cursor: pointer;">دخول</button>
            </form>
        </div>

        <div style="border-right: 1px solid #eee; padding-right: 50px;">
            <h2 style="margin-bottom: 25px; color: var(--success);">إنشاء حساب جديد</h2>

            <?php if(isset($_GET['error']) && $_GET['error'] == 'email_exists'): ?>
                <div style="background: #fff3cd; color: #856404; padding: 12px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #ffeeba; font-size: 0.9rem;">
                    ⚠️ هذا البريد الإلكتروني مسجل مسبقاً! جرب الدخول.
                </div>
            <?php endif; ?>

            <form action="actions/auth_action.php" method="POST">
                <input type="hidden" name="redirect_to" value="<?php echo htmlspecialchars($redirect_url); ?>">
                
                <div style="margin-bottom: 15px;">
                    <label>الاسم بالكامل:</label>
                    <input type="text" name="full_name" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-top: 5px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label>البريد الإلكتروني:</label>
                    <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-top: 5px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label>رقم الهاتف:</label>
                    <input type="text" name="phone" placeholder="09XXXXXXXX" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-top: 5px;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label>كلمة المرور:</label>
                    <input type="password" name="password" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-top: 5px;">
                </div>
                <button type="submit" name="register" class="btn-post" style="width: 100%; padding: 15px; cursor: pointer;">إنشاء حساب</button>
            </form>
        </div>

    </div>
</div>

<?php include('includes/footer.php'); ?>