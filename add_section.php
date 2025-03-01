<?php
include "connect.php"; // استيراد ملف الاتصال بقاعدة البيانات

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $arabic_name = $_POST['arabic_name'] ?? '';
    $english_name = $_POST['english_name'] ?? '';
    $section_image = $_POST['section_image'] ?? '';

    if (!empty($arabic_name) && !empty($english_name) && !empty($section_image)) {
        // إعداد استعلام لإضافة قسم جديد إلى قاعدة البيانات
        $query = "INSERT INTO categories (categories_name_ar, categories_name_en, categories_image) VALUES (?, ?, ?)";
        
        // إعداد العبارات
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $arabic_name);
        $stmt->bindParam(2, $english_name);
        $stmt->bindParam(3, $section_image);

        // تنفيذ الاستعلام والتحقق من النتيجة
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'تم إضافة القسم بنجاح']);
        } else {
            echo json_encode(['status' => 'failure', 'message' => 'حدث خطأ في إضافة القسم']);
        }
    } else {
        echo json_encode(['status' => 'failure', 'message' => 'معلومات مفقودة.']);
    }
} else {
    echo json_encode(['status' => 'failure', 'message' => 'طلب غير صالح.']);
}
?>
