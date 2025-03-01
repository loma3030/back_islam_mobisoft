<?php
include '../connect.php';
include_once '../functions.php'; // استخدام include_once

// الحصول على userId و videoId
$userId = filterRequest("user_id");
$videoId = filterRequest("video_id");

// التأكد من أن المستخدم و الفيديو موجودين
if ($userId === null || $videoId === null) {
    echo json_encode(array("status" => "failure", "message" => "Missing user_id or video_id"));
    exit;
}

// تحقق من حالة الفيديو
$video = getAllData("videos", "video_id = ?", array($videoId));

// التأكد من أن الفيديو موجود
if (empty($video)) {
    echo json_encode(array("status" => "failure", "message" => "Video not found"));
    exit;
}

// تحقق إذا كان الفيديو معتمد
if ($video[0]['video_approve'] == 1) {
    // تحقق إذا كان المستخدم قد دفع للاشتراك في الفيديو
    $subscription = getAllData("video_subscriptions", "user_id = ? AND video_id = ?", array($userId, $videoId));
    
    if (!empty($subscription)) {
        echo json_encode(array("status" => "success", "message" => "Access granted"));
    } else {
        echo json_encode(array("status" => "failure", "message" => "Access denied"));
    }
} else {
    echo json_encode(array("status" => "success", "message" => "Free access"));
}
?>
