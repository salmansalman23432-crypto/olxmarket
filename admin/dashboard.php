<?php 
include('../config/db.php'); 
include('../includes/functions.php'); // لضمان عمل دالة get_ad_image

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$filter = isset($_GET['filter']) ? mysqli_real_escape_string($conn, $_GET['filter']) : 'all';
$where_clause = " WHERE 1=1 "; // قاعدة ثابتة لتسهيل إضافة الشروط
if ($filter != 'all') {
    $where_clause .= " AND ads.status = '$filter'";
}

// الاستعلام المعدل: تأكد من أسماء الأعمدة في جداولك (user_id, category_id)
$query = "SELECT ads.*, users.full_name, categories.name as cat_name 
          FROM ads 
          LEFT JOIN users ON ads.user_id = users.id 
          LEFT JOIN categories ON ads.category_id = categories.id
          $where_clause 
          ORDER BY ads.created_at DESC";

$ads_result = mysqli_query($conn, $query);

// التحقق من وجود خطأ في الاستعلام لرؤيته مباشرة
if (!$ads_result) {
    die("خطأ في الاستعلام: " . mysqli_error($conn));
}

// الإحصائيات
$total_ads = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM ads"))['count'];
$pending_ads_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM ads WHERE status = 'pending'"))['count'];
$active_ads_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM ads WHERE status = 'active'"))['count'];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة بوابة ليبيا</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { background: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .admin-wrapper { max-width: 1200px; margin: 30px auto; padding: 20px; }
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-box { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; }
        .stat-box h3 { font-size: 1.8rem; color: var(--primary); margin: 0; }
        .filter-bar { background: white; padding: 15px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .admin-table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; }
        .admin-table th, .admin-table td { padding: 15px; text-align: right; border-bottom: 1px solid #eee; }
        .admin-table th { background: #fafafa; color: #666; }
        .btn-sm { padding: 6px 12px; border-radius: 5px; text-decoration: none; font-size: 0.8rem; color: white; display: inline-block; }
        .btn-approve { background: #27ae60; }
        .btn-delete { background: #e74c3c; }
        .status-pending { color: #d35400; font-weight: bold; }
    </style>
</head>
<body>

<div class="admin-wrapper">
    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
        <h2>لوحة التحكم</h2>
        <a href="../index.php" style="text-decoration: none; color: var(--primary);">خروج للموقع ←</a>
    </div>

    <div class="stats-grid">
        <div class="stat-box"><h3><?php echo $total_ads; ?></h3><p>الإجمالي</p></div>
        <div class="stat-box"><h3><?php echo $pending_ads_count; ?></h3><p>بانتظار المراجعة</p></div>
        <div class="stat-box"><h3><?php echo $active_ads_count; ?></h3><p>نشطة</p></div>
    </div>

    <div class="filter-bar">
        <strong>تصفية الحالات:</strong>
        <a href="?filter=all">الكل</a> | 
        <a href="?filter=pending">قيد الانتظار</a> | 
        <a href="?filter=active">النشطة</a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>العنوان</th>
                <th>المعلن</th>
                <th>السعر</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php if(mysqli_num_rows($ads_result) > 0): ?>
                <?php while($ad = mysqli_fetch_assoc($ads_result)): ?>
                <tr>
                    <td><?php echo $ad['title']; ?></td>
                    <td><?php echo $ad['full_name'] ? $ad['full_name'] : 'غير معروف'; ?></td>
                    <td><?php echo number_format($ad['price'], 0); ?> د.ل</td>
                    <td><span class="status-<?php echo $ad['status']; ?>"><?php echo $ad['status']; ?></span></td>
                    <td>
                        <?php if($ad['status'] == 'pending'): ?>
                            <a href="approve_ad.php?id=<?php echo $ad['id']; ?>" class="btn-sm btn-approve">موافقة</a>
                        <?php endif; ?>
                        <a href="delete_ad.php?id=<?php echo $ad['id']; ?>" class="btn-sm btn-delete" onclick="return confirm('حذف؟')">حذف</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" style="text-align: center; padding: 30px;">لا توجد بيانات لعرضها حالياً.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>