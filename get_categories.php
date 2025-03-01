<?php
// استيراد الاتصال بقاعدة البيانات
include "connect.php";

try {
    // استعلام SQL لجلب الأقسام
    $sql = "SELECT categories_id, categories_name_en, categories_name_ar, categories_image FROM categories";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    // جلب الأقسام
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // إعادة البيانات كـ JSON
    echo json_encode($categories, JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    echo "خطأ: " . $e->getMessage();
}

// إغلاق الاتصال
$con = null;
?>
