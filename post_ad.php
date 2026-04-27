<?php include('includes/header.php'); 
if(!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); } ?>
<div class="container">
    <h2>أضف إعلانك (خدمة، عقار، سيارة)</h2>
    <form action="actions/add_ad_action.php" method="POST" enctype="multipart/form-data" class="auth-form">
        <input type="text" name="title" placeholder="عنوان الإعلان (مثلاً: سباك ممتاز في جنزور)" required>
        <select name="category_id" required>
            <option value="1">خدمات</option>
            <option value="2">عقارات</option>
            <option value="3">سيارات</option>
        </select>
        <textarea name="description" placeholder="وصف الخدمة أو المنتج بالتفصيل..." rows="5" required></textarea>
        <input type="number" name="price" placeholder="السعر بالدينار الليبي" required>
        <label>صورة الإعلان (صورة واحدة):</label>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">نشر الإعلان</button>
    </form>
</div>
<?php include('includes/footer.php'); ?>