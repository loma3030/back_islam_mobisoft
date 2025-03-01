<?php
// ملف الاتصال مع قاعدة البيانات
include "connect.php"; // الاتصال بقاعدة البيانات

// دالة لتبديل حالة المنتج بين الإظهار والإخفاء
function toggleVisibility($itemId) {
    global $con;

    try {
        // التحقق أولاً من حالة المنتج (إذا كان ظاهرًا أم مخفيًا)
        $query = "SELECT items_active FROM items WHERE items_id = :item_id";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':item_id', $itemId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // إذا كانت قيمة items_active تساوي 1 (المنتج ظاهر)
        if ($result && $result['items_active'] == 1) {
            // إخفاء المنتج (تغيير القيمة إلى 0)
            $updateQuery = "UPDATE items SET items_active = 0 WHERE items_id = :item_id";
            $updateStmt = $con->prepare($updateQuery);
            $updateStmt->bindParam(':item_id', $itemId, PDO::PARAM_INT);
            $updateStmt->execute();

            return "Product hidden successfully.";
        } else {
            // إظهار المنتج (تغيير القيمة إلى 1)
            $updateQuery = "UPDATE items SET items_active = 1 WHERE items_id = :item_id";
            $updateStmt = $con->prepare($updateQuery);
            $updateStmt->bindParam(':item_id', $itemId, PDO::PARAM_INT);
            $updateStmt->execute();

            return "Product shown successfully.";
        }
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}
?>
