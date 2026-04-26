<?php
session_start();
include('../config/db.php');

// التحقق من أن المستخدم مدير (Role Check)
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
    die("خطأ: غير مسموح لك بدخول هذه الصفحة.");
}

// جلب إحصائيات سريعة
$total_ads = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM ads"))['total'];
$pending_ads = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM ads WHERE status='pending'"))['total'];

// جلب الإعلانات المعلقة للمراجعة
$query = "SELECT ads.*, users.full_name FROM ads 
          JOIN users ON ads.user_id = users.id 
          WHERE ads.status = 'pending' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم - المدير العام</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="admin-container" style="padding: 20px;">
        <h1>مرحباً بك في لوحة الإدارة</h1>
        
        <div class="stats-row" style="display: flex; gap: 20px; margin-bottom: 30px;">
            <div class="stat-card" style="background:#2c3e50; color:white; padding:20px; border-radius:10px; flex:1;">
                <h3>إجمالي الإعلانات</h3>
                <p style="font-size: 24px;"><?php echo $total_ads; ?></p>
            </div>
            <div class="stat-card" style="background:#e74c3c; color:white; padding:20px; border-radius:10px; flex:1;">
                <h3>إعلانات في انتظار المراجعة</h3>
                <p style="font-size: 24px;"><?php echo $pending_ads; ?></p>
            </div>
        </div>

        <h2>طلبات النشر الجديدة</h2>
        <table border="1" style="width: 100%; border-collapse: collapse; background: white;">
            <tr style="background: #eee;">
                <th>العنوان</th>
                <th>المعلن</th>
                <th>السعر</th>
                <th>الإجراء</th>
            </tr>
            <?php while($ad = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $ad['title']; ?></td>
                <td><?php echo $ad['full_name']; ?></td>
                <td><?php echo $ad['price']; ?> د.ل</td>
                <td>
                    <a href="approve_ad.php?id=<?php echo $ad['id']; ?>" style="color: green;">موافقة</a> | 
                    <a href="delete_ad.php?id=<?php echo $ad['id']; ?>" style="color: red;">حذف</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>