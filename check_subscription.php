<?php
include "connect.php"  ;



try {
    // إنشاء اتصال بقاعدة البيانات
  

    // استعلام لجلب حالة الاشتراك
    $stmt = $con->prepare("SELECT is_paid, last_checked FROM subscription WHERE id = 1"); // استخدام id = 1 لصف الاشتراك الأول
    $stmt->execute();
    $subscription = $stmt->fetch(PDO::FETCH_ASSOC);

    // إرسال البيانات بتنسيق JSON
    echo json_encode($subscription);
} catch (PDOException $e) {
    // إرسال رسالة خطأ بتنسيق JSON
    echo json_encode(['error' => $e->getMessage()]);
}
?>
