<?php
function base_url($path = '') {
    return BASE_URL . ltrim($path, '/');
}

function get_ad_image($image_name, $category_id) {
    if (!empty($image_name) && file_exists(dirname(__DIR__) . "/uploads/" . $image_name)) {
        return base_url("uploads/" . $image_name);
    }
    // صور افتراضية حسب القسم إذا لم يرفع المستخدم صورة
    $defaults = [
        1 => 'assets/images/cats/services.jpg',
        2 => 'assets/images/cats/realestate.jpg',
        3 => 'assets/images/cats/cars.jpg'
    ];
    return base_url($defaults[$category_id] ?? 'assets/images/cats/default.jpg');
}

function time_ago($timestamp) {
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    
    $minutes      = round($seconds / 60);           // دقيقة 
    $hours        = round($seconds / 3600);          // ساعة
    $days         = round($seconds / 86400);         // يوم
    $weeks        = round($seconds / 604800);        // أسبوع
    $months       = round($seconds / 2629440);       // شهر
    $years        = round($seconds / 31553280);      // سنة

    if ($seconds <= 60) {
        return "الآن";
    } else if ($minutes <= 60) {
        if ($minutes == 1) return "منذ دقيقة";
        if ($minutes == 2) return "منذ دقيقتين";
        return "منذ $minutes دقائق";
    } else if ($hours <= 24) {
        if ($hours == 1) return "منذ ساعة";
        if ($hours == 2) return "منذ ساعتين";
        return "منذ $hours ساعات";
    } else if ($days <= 7) {
        if ($days == 1) return "أمس";
        if ($days == 2) return "منذ يومين";
        return "منذ $days أيام";
    } else {
        return date('Y-m-d', $time_ago);
    }
}