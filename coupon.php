<?php

include "connect.php"; // تأكد من أن الاتصال بقاعدة البيانات سليم

// استعلام لجلب القسائم
$stmt = $con->prepare("SELECT coupon_code FROM coupons");
$stmt->execute();

// تحقق من وجود أي نتائج
if ($stmt->rowCount() > 0) {
    $coupons = $stmt->fetchAll(PDO::FETCH_ASSOC); // جلب كل القسائم
    echo json_encode(array("status" => "success", "coupons" => $coupons));
} else {
    echo json_encode(array("status" => "failure", "message" => "No coupons found."));
}

// لا حاجة لاستخدام close() في PDO، حيث يتم إغلاق الاتصال تلقائياً عند انتهاء السكربت.
