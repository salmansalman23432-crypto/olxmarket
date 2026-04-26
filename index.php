<?php 
// 1. استدعاء الإعدادات وقاعدة البيانات والدوال
include('config/db.php'); 
include('includes/functions.php'); // لضمان عمل دالة base_url و get_ad_image
include('includes/header.php'); 

// 2. منطق البحث والفلترة (المكان الصحيح للكود)
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$cat = isset($_GET['cat']) ? mysqli_real_escape_string($conn, $_GET['cat']) : '';

// بناء الاستعلام بناءً على المدخلات
$query = "SELECT ads.*, categories.name as cat_name, ad_images.image_path 
          FROM ads 
          JOIN categories ON ads.category_id = categories.id 
          LEFT JOIN ad_images ON ads.id = ad_images.ad_id 
          WHERE ads.status = 'active'";

if (!empty($search)) {
    $query .= " AND (ads.title LIKE '%$search%' OR ads.description LIKE '%$search%')";
}
if (!empty($cat)) {
    $query .= " AND ads.category_id = '$cat'";
}

$query .= " ORDER BY ads.created_at DESC";
$result = mysqli_query($conn, $query);
?>

<section class="search-bar" style="background: #2c3e50; padding: 30px; border-radius: 8px; margin-bottom: 30px; text-align: center;">
    <h2 style="color: white; margin-bottom: 15px;">ابحث عن خدمات أو سلع في جنزور والمنطقة الغربية</h2>
    <form action="index.php" method="GET" style="display: flex; gap: 10px; max-width: 800px; margin: 0 auto;">
        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="عن ماذا تبحث؟ (ميكانيكي، سباك، شقة..)" style="flex: 2; padding: 12px; border-radius: 5px; border: none;">
        
        <select name="cat" style="flex: 1; padding: 12px; border-radius: 5px; border: none;">
            <option value="">كل الأقسام</option>
            <option value="1" <?php if($cat == '1') echo 'selected'; ?>>خدمات</option>
            <option value="2" <?php if($cat == '2') echo 'selected'; ?>>عقارات</option>
            <option value="3" <?php if($cat == '3') echo 'selected'; ?>>سيارات</option>
        </select>

        <button type="submit" style="background: #e67e22; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">بحث</button>
    </form>
</section>

<div class="ads-container">
    <h2><?php echo empty($search) ? "آخر الإعلانات المضافة" : "نتائج البحث عن: " . htmlspecialchars($search); ?></h2>
    <hr><br>

    <div class="ads-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="ad-card" style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); position: relative;">
                    
                    <div class="image-wrapper" style="position: relative; height: 180px; background: #eee;">
                        <img src="<?php echo base_url('assets/images/cats/' . $row['cat_name'] . '.jpg'); ?>" 
                             style="width: 100%; height: 100%; object-fit: cover; filter: brightness(0.7);">
                        
                        <div class="user-avatar-overlay" style="position: absolute; bottom: 10px; right: 10px; width: 60px; height: 60px; border: 3px solid white; border-radius: 50%; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.3);">
                            <img src="<?php echo base_url('uploads/' . ($row['image_path'] ? $row['image_path'] : 'default-user.png')); ?>" 
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    </div>

                    <div class="ad-content" style="padding: 15px;">
                        <span style="font-size: 12px; background: #f4f4f4; padding: 3px 8px; border-radius: 3px;"><?php echo $row['cat_name']; ?></span>
                        <h3 style="margin: 10px 0; color: #2c3e50;"><?php echo $row['title']; ?></h3>
                        <p style="color: #666; font-size: 14px; height: 40px; overflow: hidden;"><?php echo substr($row['description'], 0, 80); ?>...</p>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                            <span style="font-weight: bold; color: #27ae60; font-size: 18px;"><?php echo number_format($row['price'], 0); ?> د.ل</span>
                            <a href="view-ad.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; background: #3498db; color: white; padding: 5px 15px; border-radius: 5px; font-size: 14px;">التفاصيل</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="grid-column: 1 / -1; text-align: center; padding: 50px; font-size: 18px; color: #888;">عذراً، لم نجد نتائج تطابق بحثك.</p>
        <?php endif; ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>