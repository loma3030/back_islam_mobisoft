<?php
include "connect.php";

// استلام email من الطلب
$email = isset($_GET['email']) ? $_GET['email'] : null;

// التأكد من وجود email
if ($email) {
    // حذف المستخدم من الجدول users باستخدام استعلام محضر
    $stmt = $con->prepare("DELETE FROM users WHERE users_email = :email");
    $stmt->bindValue(':email', $email, PDO::PARAM_STR); // الربط مع email كسلسلة نصية
    
    if ($stmt->execute()) {
        echo json_encode(array("status" => "success", "message" => "تم حذف المستخدم بنجاح."));
    } else {
        echo json_encode(array("status" => "error", "message" => "فشل في حذف المستخدم."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "البريد الإلكتروني غير موجود."));
}
?>
