<?php
include "connect.php";

// استلام cart_id والحالة الجديدة
$cart_id = isset($_GET['cart_id']) ? $_GET['cart_id'] : null;
$orderStatus = isset($_GET['orderStatus']) ? $_GET['orderStatus'] : null;

// التأكد من وجود cart_id والحالة
if ($cart_id && $orderStatus) {
    // تحديث حالة الطلب باستخدام استعلام محضر
    $stmt = $con->prepare("UPDATE cart SET orderStatus = :orderStatus WHERE cart_id = :cart_id");
    $stmt->bindValue(':cart_id', $cart_id, PDO::PARAM_INT); // الربط مع cart_id كعدد صحيح
    $stmt->bindValue(':orderStatus', $orderStatus, PDO::PARAM_STR); // الربط مع orderStatus كعدد صحيح
    
    if ($stmt->execute()) {
        echo json_encode(array("status" => "success", "message" => "تم تحديث حالة الطلب بنجاح."));
    } else {
        echo json_encode(array("status" => "error", "message" => "فشل في تحديث حالة الطلب."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "cart_id أو orderStatus غير موجود."));
}
?>
