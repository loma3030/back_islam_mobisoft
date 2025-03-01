<?php
// تضمين ملف الاتصال
include 'connect.php'; // تأكد من أن اسم الملف صحيح حسب موقعه

header('Content-Type: application/json');

// استعلام لجلب البيانات من جدول ordersdetailsview
try {
    $sql = "SELECT * FROM ordersdetailsview";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    $orders = [];
    if ($stmt->rowCount() > 0) {
        // تخزين البيانات في مصفوفة
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $orders[] = $row;
        }
    }

    // إرجاع البيانات بصيغة JSON
    echo json_encode($orders);
} catch (PDOException $e) {
    // في حالة حدوث خطأ
    echo json_encode(['error' => $e->getMessage()]);
}
?>
