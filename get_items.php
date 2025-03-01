<?php
include "connect.php";

try {
    // استعلام لجلب جميع البيانات من جدول items
    $stmt = $con->prepare("SELECT items_id, items_name_en, items_name_ar, items_desc_en, items_desc_ar, items_image, items_count, items_active, items_price, items_discount, items_date, items_cat FROM items");
    $stmt->execute();

    // جلب البيانات كصفوف
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // إرسال البيانات بتنسيق JSON
    echo json_encode($items);
} catch (PDOException $e) {
    // إرسال رسالة خطأ بتنسيق JSON
    echo json_encode(['error' => $e->getMessage()]);
}
?>
