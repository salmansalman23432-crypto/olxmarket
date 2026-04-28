<?php 
include('config/db.php'); 
include('includes/functions.php'); 
include('includes/header.php'); 

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$cat = isset($_GET['cat']) ? mysqli_real_escape_string($conn, $_GET['cat']) : '';

// الاستعلام الأساسي مع شرط الحالة "نشط" فقط لضمان الخصوصية والأمان
$query = "SELECT ads.*, categories.name as cat_name FROM ads 
          JOIN categories ON ads.category_id = categories.id 
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

<section class="search-bar-section">
    <div class="container">
        <form action="index.php" method="GET" class="search-form">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="ماذا تريد أن تشتري اليوم في ليبيا؟">
            <select name="cat">
                <option value="">كل الأقسام</option>
                <option value="1" <?php if($cat == '1') echo 'selected'; ?>>🛠 خدمات</option>
                <option value="2" <?php if($cat == '2') echo 'selected'; ?>>🏠 عقارات</option>
                <option value="3" <?php if($cat == '3') echo 'selected'; ?>>🚗 سيارات</option>
            </select>
            <button type="submit">بحث</button>
        </form>
    </div>
</section>

<div class="container" style="margin-bottom: 50px;">
    <div class="ads-grid">
        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="ad-card">
                
                    <div class="image-wrapper">
                        <div class="category-badge"><?php echo $row['cat_name']; ?></div>
                        <img src="<?php echo get_ad_image($row['image'], $row['category_id']); ?>" class="category-bg">
                        
                        <div class="user-avatar-overlay">
                            <img src="<?php echo base_url('uploads/default.jpg'); ?>">
                        </div>
                    </div>

                    <div class="ad-content">
                        <div style="font-size: 0.75rem; color: #999; margin-bottom: 5px;">
                            🕒 <?php echo time_ago($row['created_at']); ?>
                        </div>
                        <h3 style="margin: 0 0 10px 0; font-size: 1.1rem;"><?php echo $row['title']; ?></h3>
                        <p style="font-size: 0.85rem; color: #666; height: 35px; overflow: hidden;">
                            <?php echo mb_substr($row['description'], 0, 60, 'utf-8'); ?>...
                        </p>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                            <span class="price"><?php echo number_format($row['price'], 0); ?> د.ل</span>
                            <a href="view-ad.php?id=<?php echo $row['id']; ?>" class="view-btn">التفاصيل</a>
                        </div>
                    </div>
                    
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="grid-column: 1/-1; text-align: center; padding: 50px; background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <div style="font-size: 3rem; margin-bottom: 20px;">🔍</div>
                <h3>لا توجد إعلانات نشطة تطابق بحثك حالياً.</h3>
                <p style="color: #777;">جرب البحث بكلمات أخرى أو تصفح الأقسام.</p>
                <a href="index.php" style="display: inline-block; margin-top: 15px; color: var(--primary); font-weight: bold;">استكشف كل الإعلانات</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>