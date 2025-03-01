<?php
// الاتصال بقاعدة البيانات
include "connect.php";

// استعلام SQL لجلب الكميات وتحليلها
try {
    $query = "SELECT 
                items_name_ar AS product_name, 
                items_count AS quantity, 
                CASE
                    WHEN items_count = 0 THEN 'نفدت الكمية'
                    WHEN items_count <= 5 THEN 'كمية قليلة'
                    ELSE 'كمية كافية'
                END AS quantity_status
              FROM items";
    
    $stmt = $con->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // تحويل البيانات إلى JSON
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
