<?php
include '../connect.php';

$userId = filterRequest("user_id");
$videoId = filterRequest("video_id");

// تحقق من وجود اشتراك مسبق
$existingSubscription = getAllData("video_subscriptions", "user_id = ? AND video_id = ?", array($userId, $videoId));

if (!empty($existingSubscription)) {
    echo json_encode(array("status" => "failure", "message" => "Already subscribed"));
    exit;
}

// إضافة اشتراك جديد
$data = array(
    "user_id" => $userId,
    "video_id" => $videoId
);

insertData("video_subscriptions", $data);
echo json_encode(array("status" => "success", "message" => "Subscription added successfully"));
?>
