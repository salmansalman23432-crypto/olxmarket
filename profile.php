<?php 
include('config/db.php'); 
include('includes/functions.php'); 
include('includes/header.php'); 

// التأكد من أن المستخدم مسجل دخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<div class="container" style="padding: 40px 0;">
    <div style="max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; color: #2c3e50; margin-bottom: 30px;">تحديث البيانات الشخصية</h2>
        
        <?php if(isset($_GET['success'])): ?>
            <p style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; text-align: center;">تم تحديث بياناتك بنجاح!</p>
        <?php endif; ?>

        <form action="actions/update_profile.php" method="POST">
            <div style="margin-bottom: 15px;">
                <label>الاسم الكامل:</label>
                <input type="text" name="full_name" value="<?php echo $user['full_name']; ?>" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label>البريد الإلكتروني:</label>
                <input type="email" name="email" value="<?php echo $user['email']; ?>" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label>رقم الهاتف:</label>
                <input type="text" name="phone" value="<?php echo $user['phone']; ?>" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 20px; padding: 10px; background: #fff3cd; border-radius: 5px;">
                <label>كلمة المرور الجديدة (اتركها فارغة إذا لم ترد التغيير):</label>
                <input type="password" name="new_password" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <button type="submit" name="update_profile" style="width: 100%; padding: 12px; background: #e67e22; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">حفظ التغييرات</button>
        </form>
    </div>
</div>

<?php include('includes/footer.php'); ?>