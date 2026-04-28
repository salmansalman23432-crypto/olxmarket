<?php 
include('../config/db.php'); 
include('../includes/functions.php'); 

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$filter = isset($_GET['filter']) ? mysqli_real_escape_string($conn, $_GET['filter']) : 'all';
$where_clause = " WHERE 1=1 ";
if ($filter != 'all') { $where_clause .= " AND ads.status = '$filter'"; }

$query = "SELECT ads.*, users.full_name, categories.name as cat_name 
          FROM ads 
          LEFT JOIN users ON ads.user_id = users.id 
          LEFT JOIN categories ON ads.category_id = categories.id
          $where_clause 
          ORDER BY ads.created_at DESC";

$ads_result = mysqli_query($conn, $query);

// الإحصائيات السريعة
$total_ads = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM ads"))['count'];
$pending_ads_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM ads WHERE status = 'pending'"))['count'];
$active_ads_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM ads WHERE status = 'active'"))['count'];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة بوابة ليبيا - الإحصائيات</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { background: #f4f7f6; font-family: 'Segoe UI', Tahoma, sans-serif; }
        .admin-wrapper { max-width: 1200px; margin: 30px auto; padding: 20px; }
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-box { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center; border-top: 5px solid var(--primary); }
        .stat-box h3 { font-size: 2rem; margin: 0; color: var(--primary); }
        
        .admin-table { width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .admin-table th, .admin-table td { padding: 15px; text-align: right; border-bottom: 1px solid #eee; }
        .admin-table th { background: #f8f9fa; color: #666; font-size: 0.9rem; }
        
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); overflow: auto; }
        .modal-content { background: white; margin: 5% auto; padding: 20px; width: 60%; border-radius: 15px; position: relative; }
        .close-modal { position: absolute; left: 20px; top: 15px; font-size: 25px; cursor: pointer; color: #999; }
        
        .btn-sm { padding: 7px 12px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; color: white; border: none; cursor: pointer; }
        .btn-preview { background: #3498db; }
        .btn-approve { background: #27ae60; }
        .btn-delete { background: #e74c3c; }
        
        .status-tag { font-size: 0.75rem; padding: 3px 8px; border-radius: 4px; background: #eee; color: #666; }
        .time-cell { font-size: 0.8rem; color: #777; white-space: nowrap; }
    </style>
</head>
<body>

<div class="admin-wrapper">
    <div style="display: flex; justify-content: space-between; margin-bottom: 25px; align-items: center;">
        <h2 style="color: #2c3e50;">لوحة تحكم النظام</h2>
        <a href="../index.php" class="btn-sm" style="background: #666;">العودة للموقع ←</a>
    </div>

    <div class="stats-grid">
        <div class="stat-box"><h3><?php echo $total_ads; ?></h3><p>الإجمالي</p></div>
        <div class="stat-box" style="border-top-color: #f39c12;"><h3><?php echo $pending_ads_count; ?></h3><p>بانتظار المراجعة</p></div>
        <div class="stat-box" style="border-top-color: #27ae60;"><h3><?php echo $active_ads_count; ?></h3><p>إعلانات نشطة</p></div>
    </div>

    <div style="background: white; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
        <strong>تصفية: </strong>
        <a href="?filter=all" style="margin: 0 10px; color: <?php echo $filter=='all'?'var(--primary)':'#555'; ?>;">الكل</a>
        <a href="?filter=pending" style="margin: 0 10px; color: <?php echo $filter=='pending'?'var(--primary)':'#f39c12'; ?>;">المعلقة</a>
        <a href="?filter=active" style="margin: 0 10px; color: <?php echo $filter=='active'?'var(--primary)':'#27ae60'; ?>;">النشطة</a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>العنوان</th>
                <th>المعلن</th>
                <th>السعر</th>
                <th>تاريخ النشر</th> <th>الحالة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php while($ad = mysqli_fetch_assoc($ads_result)): ?>
            <?php 
                $raw_img_path = get_ad_image($ad['image'], $ad['category_id']);
                $final_img_url = (strpos($raw_img_path, 'http') === 0) ? $raw_img_path : '../' . $raw_img_path;
            ?>
            <tr>
                <td><strong><?php echo htmlspecialchars($ad['title']); ?></strong></td>
                <td><?php echo htmlspecialchars($ad['full_name']); ?></td>
                <td><?php echo number_format($ad['price'], 0); ?> د.ل</td>
                <td class="time-cell">
                    <?php echo date('Y/m/d', strtotime($ad['created_at'])); ?><br>
                    <small><?php echo date('H:i', strtotime($ad['created_at'])); ?></small>
                </td>
                <td><span class="status-tag"><?php echo $ad['status']; ?></span></td>
                <td>
                    <button class="btn-sm btn-preview" 
                            onclick="previewAd('<?php echo addslashes(htmlspecialchars($ad['title'])); ?>', '<?php echo addslashes(htmlspecialchars($ad['description'])); ?>', '<?php echo number_format($ad['price'], 0); ?>', '<?php echo addslashes($final_img_url); ?>', '<?php echo $ad['id']; ?>', '<?php echo $ad['status']; ?>')">
                        👁 معاينة
                    </button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div id="previewModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <h2 id="m-title" style="color: var(--primary); margin-bottom: 15px;"></h2>
        <img id="m-img" src="" style="width:100%; max-height:400px; object-fit:contain; border-radius:10px; background:#f9f9f9; margin-bottom:15px;">
        <p id="m-desc" style="background:#f9f9f9; padding:15px; border-radius:8px; white-space:pre-line;"></p>
        <div style="font-size:1.2rem; margin:15px 0;">السعر: <span id="m-price" style="color:var(--success); font-weight:bold;"></span> د.ل</div>
        <div id="m-actions" style="display: flex; gap: 10px; border-top: 1px solid #eee; padding-top: 20px;"></div>
    </div>
</div>

<script>
function previewAd(title, desc, price, imgUrl, id, status) {
    document.getElementById('m-title').innerText = title;
    document.getElementById('m-desc').innerText = desc;
    document.getElementById('m-price').innerText = price;
    document.getElementById('m-img').src = imgUrl;

    let actionsHtml = '';
    if(status === 'pending') {
        actionsHtml += `<a href="approve_ad.php?id=${id}" class="btn-sm btn-approve">✅ موافقة</a>`;
    }
    actionsHtml += `<a href="delete_ad.php?id=${id}" class="btn-sm btn-delete" onclick="return confirm('حذف؟')">🗑 حذف</a>`;
    
    document.getElementById('m-actions').innerHTML = actionsHtml;
    document.getElementById('previewModal').style.display = 'block';
}

function closeModal() { document.getElementById('previewModal').style.display = 'none'; }
window.onclick = function(event) { if (event.target == document.getElementById('previewModal')) { closeModal(); } }
</script>

</body>
</html>