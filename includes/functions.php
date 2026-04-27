<?php
function base_url($path = '') {
    return BASE_URL . ltrim($path, '/');
}

function get_ad_image($user_image, $category_id) {
    if (!empty($user_image) && file_exists("uploads/" . $user_image)) {
        return base_url("uploads/" . $user_image);
    }
    $default_images = [
        1 => 'assets/images/cats/خدمات.jpg',
        2 => 'assets/images/cats/عقارات.jpg',
        3 => 'assets/images/cats/سيارات.jpg'
    ];
    return base_url($default_images[$category_id] ?? 'uploads/default.jpg');
}