<?php 
include('includes/header.php'); 
include('config/db.php');

$ad_id = $_GET['id'];
// جلب تفاصيل الإعلان مع بيانات المعلن واسم القسم
$query = "SELECT ads.*, users.full_name, users.phone, categories.name as cat_name, ad_images.image_path 
          FROM ads 
          JOIN users ON ads.user_id = users.id 
          JOIN categories ON ads.category_id = categories.id 
          LEFT JOIN ad_images ON ads.id = ad_images.ad_id
          WHERE ads.id = '$ad_id'";

$result = mysqli_query($conn, $query);
$ad = mysqli_fetch_assoc($result);

if (!$ad) { die("الإعلان غير موجود."); }
?>

<div class="ad-details-container" style="display: flex; gap: 30px; background: white; padding: 20px; border-radius: 10px;">
    <div class="ad-image-large" style="flex: 1;">
        <img src="uploads/<?php echo $ad['image_path'] ?? 'default.jpg'; ?>" style="width: 100%; border-radius: 8px;">
    </div>

    <div class="ad-info-box" style="flex: 1;">
        <span class="category-tag" style="background: #eee; padding: 5px 10px; border-radius: 5px;"><?php echo $ad['cat_name']; ?></span>
        <h1 style="margin-top: 15px;"><?php echo $ad['title']; ?></h1>
        <p style="font-size: 24px; color: #27ae60; font-weight: bold; margin: 15px 0;">السعر: <?php echo number_format($ad['price'], 2); ?> د.ل</p>
        
        <hr>
        
        <div class="description" style="margin: 20px 0; line-height: 1.6;">
            <h3>وصف الخدمة/المنتج:</h3>
            <p><?php echo nl2br($ad['description']); ?></p>
        </div>

        <div class="seller-contact" style="background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #ddd;">
            <h4>معلومات المعلن:</h4>
            <p>الاسم: <strong><?php echo $ad['full_name']; ?></strong></p>
            <p>تاريخ النشر: <?php echo date('Y-m-d', strtotime($ad['created_at'])); ?></p>
            <br>
            <a href="tel:<?php echo $ad['phone']; ?>" style="display: block; text-align: center; background: #2c3e50; color: white; padding: 10px; text-decoration: none; border-radius: 5px;">اتصال بالمعلن: <?php echo $ad['phone']; ?></a>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>