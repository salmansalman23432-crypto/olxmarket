<?php 
include('config/db.php'); 
include('includes/functions.php'); 
include('includes/header.php'); 

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$cat = isset($_GET['cat']) ? mysqli_real_escape_string($conn, $_GET['cat']) : '';

$query = "SELECT ads.*, categories.name as cat_name FROM ads 
          JOIN categories ON ads.category_id = categories.id 
          WHERE ads.status = 'active'";

if (!empty($search)) { $query .= " AND (ads.title LIKE '%$search%' OR ads.description LIKE '%$search%')"; }
if (!empty($cat)) { $query .= " AND ads.category_id = '$cat'"; }
$query .= " ORDER BY ads.created_at DESC";
$result = mysqli_query($conn, $query);
?>

<section class="search-bar-section">
    <div class="container">
        <form action="index.php" method="GET" class="search-form">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="عن ماذا تبحث في جنزور؟">
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

<div class="container">
    <div class="ads-grid">
        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="ad-card">
                    <div class="image-wrapper" style="position: relative;"> <div class="category-badge"><?php echo $row['cat_name']; ?></div>

                        <?php 
                        $image_path = 'assets/images/cats/' . $row['cat_name'] . '.jpg'; 
                        if (!empty($row['image']) && file_exists('uploads/' . $row['image'])) {
                            $image_path = 'uploads/' . $row['image'];
                        }
                        ?>
                        <img src="<?php echo base_url($image_path); ?>" class="category-bg" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <div class="user-avatar-overlay"><img src="<?php echo base_url('uploads/default.jpg'); ?>"></div>
                    </div>
                    <div class="ad-content">
                        <h3 style="margin: 0 0 10px 0; font-size: 1.1rem;"><?php echo $row['title']; ?></h3>
                        <p style="font-size: 0.9rem; color: #666; height: 40px; overflow: hidden;"><?php echo mb_substr($row['description'], 0, 60, 'utf-8'); ?>...</p>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                            <span class="price"><?php echo number_format($row['price'], 0); ?> د.ل</span>
                            <a href="<?php echo base_url('view-ad.php?id=' . $row['id']); ?>" class="view-btn">التفاصيل</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="grid-column: 1/-1; text-align: center; padding: 50px; background: white; border-radius: 10px;">
                <h3>🔍 لا توجد نتائج للبحث حالياً.</h3>
                <a href="index.php" style="color: var(--accent);">عرض كل الإعلانات</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>