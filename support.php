<?php

include "connect.php"; // الاتصال بقاعدة البيانات

$user_id = filterRequest("user_id"); // تصفية معرف المستخدم
$complaint = filterRequest("complaint"); // تصفية الشكوى

// التحقق من صحة البيانات
if ($user_id == null || $complaint == null) {
    echo json_encode(["message" => "يرجى تقديم جميع البيانات المطلوبة"]);
    exit(); // الخروج من الكود إذا كانت البيانات ناقصة
}

// إدخال الشكوى في الجدول
$data = array(
    "user_id" => $user_id,
    "complaint" => $complaint
);

insertData("support", $data); // إدخال الشكوى في قاعدة البيانات
echo json_encode(["message" => "تم إرسال الشكوى بنجاح"]);
?>
