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