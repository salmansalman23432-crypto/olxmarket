<?php 
include('config/db.php'); 
include('includes/functions.php'); 
include('includes/header.php'); 

// حماية الصفحة: منع غير المسجلين من الإضافة
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<div class="container" style="padding: 40px 0;">
    <div style="max-width: 700px; margin: auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
        <h2 style="text-align: center; color: var(--primary); margin-bottom: 30px; border-bottom: 2px solid var(--accent); padding-bottom: 10px;">إضافة إعلان جديد</h2>
        
        <form action="actions/post_ad_action.php" method="POST" enctype="multipart/form-data">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: bold;">عنوان الإعلان:</label>
                <input type="text" name="title" placeholder="مثال: شقة للإيجار بجانب جزيرة جنزور" required 
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: bold;">القسم:</label>
                <select name="category_id" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; cursor: pointer;">
                    <option value="">اختر القسم المناسب</option>
                    <option value="1">🛠 خدمات</option>
                    <option value="2">🏠 عقارات</option>
                    <option value="3">🚗 سيارات</option>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: bold;">السعر (د.ل):</label>
                <input type="number" name="price" placeholder="0.00" required 
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: bold;">تفاصيل الإعلان:</label>
                <textarea name="description" rows="5" placeholder="اكتب تفاصيل الخدمة أو السلعة هنا..." required 
                          style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-family: inherit;"></textarea>
            </div>

            <div style="margin-bottom: 30px; padding: 15px; background: #f9f9f9; border-radius: 8px; border: 1px dashed #ccc;">
                <label style="display: block; margin-bottom: 8px; font-weight: bold;">صورة الإعلان:</label>
                <input type="file" name="ad_image" accept="image/*">
                <p style="font-size: 0.8rem; color: #777; margin-top: 5px;">* إذا لم ترفع صورة، سيتم وضع صورة القسم تلقائياً.</p>
            </div>

            <button type="submit" name="submit_ad" 
                    style="width: 100%; padding: 15px; background: var(--success); color: white; border: none; border-radius: 8px; font-size: 1.1rem; font-weight: bold; cursor: pointer; transition: 0.3s;">
                نشر الإعلان الآن
            </button>
        </form>
    </div>
</div>

<?php include('includes/footer.php'); ?>