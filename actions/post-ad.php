<?php include('includes/header.php'); ?>

<div class="form-container">
    <h2>أضف إعلانك (خدمة، عقار، سيارة)</h2>
    <form action="actions/add_ad_action.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="عنوان الإعلان" required><br><br>
        
        <select name="category_id" required>
            <option value="1">خدمات</option>
            <option value="2">عقارات</option>
            <option value="3">سيارات</option>
        </select><br><br>

        <textarea name="description" placeholder="وصف الإعلان/الخدمة بالتفصيل" rows="5" required></textarea><br><br>
        
        <input type="number" name="price" placeholder="السعر" required><br><br>
        
        <label>صورة الإعلان (صورة واحدة فقط):</label>
        <input type="file" name="image" accept="image/*" required><br><br>
        
        <button type="submit">نشر الإعلان الآن</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>