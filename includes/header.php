<?php 
include_once(dirname(__DIR__) . '/config/db.php'); 
include_once(dirname(__DIR__) . '/includes/functions.php'); 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سوق جنزور</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/style.css'); ?>">
</head>
<body>
<header class="main-header">
    <div class="container navbar-flex">
        <a href="<?php echo base_url('index.php'); ?>" class="logo-area">
            <span style="font-size: 2rem;">🛒</span>
            <div class="logo-text">
                <h1 style="margin: 0; font-size: 1.4rem;">سوق جنزور</h1>
                <p style="margin: 0; font-size: 0.8rem; opacity: 0.8;">بوابتك للخدمات والسلع في بلدية جنزور</p>
            </div>
        </a>
        <nav class="nav-menu">
			<a href="<?php echo base_url('help.php'); ?>" style="color: white; text-decoration: none; font-size: 0.9rem; margin-left: 15px; border-left: 1px solid rgba(255,255,255,0.3); padding-left: 15px;">المساعدة</a>

			<?php if(isset($_SESSION['user_id'])): ?>
				<span style="font-size: 0.9rem;">مرحباً، <a href="<?php echo base_url('profile.php'); ?>" style="color: var(--accent); text-decoration: none; font-weight: bold;"><?php echo $_SESSION['full_name']; ?></a></span>
				<a href="<?php echo base_url('post_ad.php'); ?>"><button class="btn-post">أضف إعلان</button></a>
				<a href="<?php echo base_url('actions/logout.php'); ?>" style="color: white; text-decoration: none; font-size: 0.9rem; margin-right: 10px;">خروج</a>
			<?php else: ?>
				<a href="<?php echo base_url('login.php'); ?>" class="btn-login">دخول / تسجيل</a>
			<?php endif; ?>
		</nav>
    </div>
</header>
<main>