<?php
include '../connect.php';

$video_name = isset($_GET['videoName']) ? $_GET['videoName'] : null;
$video_description = isset($_GET['videoDescription']) ? $_GET['videoDescription'] : null;
$video_path = isset($_GET['videoPath']) ? $_GET['videoPath'] : null;
$video_approve = isset($_GET['videoApprove']) ? $_GET['videoApprove'] : null;

if ($video_name && $video_description && $video_path && $video_approve) {
    // إدراج البيانات في قاعدة البيانات
    insertData('videos', [
        'video_name' => $video_name,
        'video_description' => $video_description,
        'video_path' => $video_path,
        'video_approve' => $video_approve
    ]);
} else {
    echo json_encode(['status' => 'failure', 'message' => 'Missing fields']);
}
