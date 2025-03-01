<?php
include "connect.php";

// استلام cart_id من الطلب
$cart_id = isset($_GET['cart_id']) ? $_GET['cart_id'] : null;

// التأكد من وجود cart_id
if ($cart_id) {
    // حذف المنتج من السلة باستخدام استعلام محضر
    $stmt = $con->prepare("DELETE FROM cart WHERE cart_id = :cart_id");
    $stmt->bindValue(':cart_id', $cart_id, PDO::PARAM_INT); // الربط مع cart_id كعدد صحيح
    
    if ($stmt->execute()) {
        echo json_encode(array("status" => "success", "message" => "تم حذف المنتج بنجاح."));
    } else {
        echo json_encode(array("status" => "error", "message" => "فشل في حذف المنتج."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "cart_id غير موجود."));
}
?>
