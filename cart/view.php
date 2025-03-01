<?php

include "../connect.php";

// الحصول على قيمة usersid من الطلب سواء كان GET أو POST
$userid = filterRequest("usersid");

// طباعة قيمة $userid للتحقق
error_log("Received user ID: " . $userid);

if ($userid !== null && is_numeric($userid)) {
    // استدعاء البيانات من الجدول cartview باستخدام usersid
    $data  = getAllData("cartview", "cart_usersid = $userid", null, false);

    // إعداد استعلام لحساب مجموع الأسعار وعدد المنتجات
    $stmt = $con->prepare("SELECT SUM(items_price) as totalprice, count(countitems) as totalcount 
                           FROM `cartview` 
                           WHERE cartview.cart_usersid = :userid 
                           GROUP BY cart_usersid");

    // ربط قيمة userid في الاستعلام
    $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);

    // تنفيذ الاستعلام
    $stmt->execute();

    // الحصول على النتائج
    $datacountprice = $stmt->fetch(PDO::FETCH_ASSOC);

    // إعادة النتائج كـ JSON
    echo json_encode(array(
        "status" => "success",
        "countprice" => $datacountprice,
        "datacart" => $data,
    ));
} else {
    // إرسال رسالة خطأ إذا كانت usersid مفقودة أو غير صحيحة
    echo json_encode(array(
        "status" => "error",
        "message" => "User ID is missing or invalid."
    ));
}

