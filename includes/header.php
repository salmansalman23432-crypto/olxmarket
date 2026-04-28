<?php 
include_once(dirname(__DIR__) . '/config/db.php'); 
include_once(dirname(__DIR__) . '/includes/functions.php'); 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بوابة ليبيا - الخدمات والسلع</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/style.css'); ?>">
</head>
<body>
<header class="main-header">
    <div class="container navbar-flex">
        <a href="<?php echo base_url('index.php'); ?>" class="logo-area">
            <span style="font-size: 2.2rem;">🇱🇾</span>
            <div class="logo-text">
                <h1 style="margin: 0; font-size: 1.5rem;">بوابة ليبيا</h1>
                <p style="margin: 0; font-size: 0.75rem; opacity: 0.9;">سوقك المفتوح للخدمات والسلع في كل المدن</p>
            </div>
        </a>
        <nav class="nav-menu">
			<a href="<?php echo base_url('help.php'); ?>" style="color: white; text-decoration: none; font-size: 0.9rem; margin-left: 10px;">المساعدة</a>
			
			<?php if(isset($_SESSION['user_id'])): ?>
				<span style="font-size: 0.85rem; color: #ddd; margin-left: 5px;">مرحباً، 
					<a href="<?php echo base_url('profile.php'); ?>" style="color: var(--accent); text-decoration: none; font-weight: bold;">
						<?php echo explode(' ', $_SESSION['full_name'])[0]; // جلب الاسم الأول فقط لجمالية التصميم ?>
					</a>
				</span>
				
				<a href="<?php echo base_url('post_ad.php'); ?>"><button class="btn-post">أضف إعلان</button></a>
				<a href="<?php echo base_url('actions/logout.php'); ?>" style="color: white; text-decoration: none; font-size: 0.8rem; margin-right: 5px;">خروج</a>
			<?php else: ?>
				<a href="<?php echo base_url('login.php'); ?>" class="btn-login">دخول / تسجيل</a>
			<?php endif; ?>
		</nav>
    </div>
</header>

<?php if(isset($_GET['status'])): ?>
    <div id="status-alert" style="background: var(--success); color: white; padding: 15px; text-align: center; font-weight: bold; position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); min-width: 320px;">
        <?php 
            switch($_GET['status']) {
                case 'posted': echo "✅ تم نشر إعلانك بنجاح في بوابة ليبيا!"; break;
                case 'welcome': echo "👋 مرحباً بك في عائلة بوابة ليبيا!"; break;
                case 'success': echo "⚙️ تم تحديث بياناتك بنجاح."; break;
            }
        ?>
    </div>
    <script>setTimeout(() => { document.getElementById('status-alert').remove(); }, 4000);</script>
<?php endif; ?>
<main>