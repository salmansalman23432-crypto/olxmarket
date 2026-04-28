<?php 
include('config/db.php'); 
include('includes/functions.php'); 
include('includes/header.php'); 

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT ads.*, categories.name as cat_name, users.full_name, users.phone 
          FROM ads 
          JOIN categories ON ads.category_id = categories.id 
          JOIN users ON ads.user_id = users.id 
          WHERE ads.id = '$id'";
$result = mysqli_query($conn, $query);
$ad = mysqli_fetch_assoc($result);

if(!$ad) { echo "<div class='container'><h2>الإعلان غير موجود!</h2></div>"; include('includes/footer.php'); exit; }
?>

<div class="container" style="padding: 30px 0;">
    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 30px; align-items: start;">
        
        <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <img src="<?php echo get_ad_image($ad['image'], $ad['category_id']); ?>" style="width: 100%; max-height: 500px; object-fit: contain; background: #eee;">
            <div style="padding: 25px;">
                <h1 style="color: var(--primary); margin-bottom: 10px;"><?php echo $ad['title']; ?></h1>
                <div style="display: flex; gap: 15px; color: #777; font-size: 0.9rem; margin-bottom: 20px;">
                    <span>📁 القسم: <?php echo $ad['cat_name']; ?></span>
                    <span>🕒 نُشر: <?php echo time_ago($ad['created_at']); ?></span>
                </div>
                <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">
                <h3 style="margin-bottom: 10px;">الوصف:</h3>
                <p style="line-height: 1.8; color: #444; white-space: pre-line;"><?php echo $ad['description']; ?></p>
            </div>
        </div>

        <div style="position: sticky; top: 20px;">
            <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); text-align: center;">
                <div style="font-size: 1.5rem; color: var(--success); font-weight: bold; margin-bottom: 20px;">
                    السعر: <?php echo number_format($ad['price'], 0); ?> د.ل
                </div>
                
                <div style="padding: 15px; background: #f8f9fa; border-radius: 10px; margin-bottom: 20px;">
                    <p style="margin: 0; color: #666;">المعلن:</p>
                    <strong style="font-size: 1.1rem; color: var(--primary);"><?php echo $ad['full_name']; ?></strong>
                </div>

                <?php if(isset($_SESSION['user_id'])): ?>
                    <?php 
                    $wa_phone = preg_replace('/[^0-9]/', '', $ad['phone']);
                    if(substr($wa_phone, 0, 1) == '0') { $wa_phone = '218' . substr($wa_phone, 1); }
                    $wa_msg = "مرحباً " . $ad['full_name'] . "، بخصوص إعلانك (" . $ad['title'] . ") على بوابة ليبيا...";
                    ?>
                    <a href="https://wa.me/<?php echo $wa_phone; ?>?text=<?php echo urlencode($wa_msg); ?>" 
                       target="_blank"
                       style="display: block; background: #25D366; color: white; text-decoration: none; padding: 15px; border-radius: 8px; font-weight: bold; font-size: 1.1rem; margin-bottom: 10px;">
                       💬 تواصل عبر واتساب
                    </a>

                    <a href="tel:<?php echo $ad['phone']; ?>" 
                       style="display: block; border: 2px solid var(--primary); color: var(--primary); text-decoration: none; padding: 12px; border-radius: 8px; font-weight: bold;">
                       📞 اتصال هاتفي
                    </a>
                <?php else: ?>
                    <div style="background: #fff3cd; padding: 15px; border-radius: 8px; border: 1px solid #ffeeba;">
                        <p style="margin: 0 0 10px 0; font-size: 0.9rem; color: #856404;">يجب تسجيل الدخول لرؤية رقم الهاتف والتواصل مع المعلن.</p>
                        <a href="login.php?redirect_to=view-ad.php?id=<?php echo $id; ?>" class="btn-login" style="display: block; text-align: center;">دخول / تسجيل</a>
                    </div>
                <?php endif; ?>
            </div>
            
            <div style="margin-top: 20px; padding: 15px; background: #f9f9f9; color: #777; border-radius: 10px; font-size: 0.85rem; line-height: 1.5; border: 1px solid #eee;">
                ⚠️ <b>تنبيه أمان:</b> تأكد من فحص السلعة في مكان عام قبل الدفع. لا تقم بتحويل عربون مسبقاً.
            </div>
        </div>

    </div>
</div>

<?php include('includes/footer.php'); ?>