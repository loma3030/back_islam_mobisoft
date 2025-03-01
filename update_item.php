<?php
include "connect.php";

try {

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }

    // الحصول على البيانات من الطلب
    $data = json_decode(file_get_contents("php://input"));

    // التحقق من البيانات المرسلة
    if (!isset($data->items_id) || !isset($data->items_name_en) || !isset($data->items_name_ar) || 
        !isset($data->items_desc_en) || !isset($data->items_desc_ar) || !isset($data->items_price) || 
        !isset($data->items_count) || !isset($data->items_discount) || !isset($data->items_cat) ||
        !isset($data->items_active)) {
        echo json_encode(['error' => 'Missing required fields']);
        exit();
    }

    // الحصول على البيانات المطلوبة لتحديث المنتج
    $item_id = $data->items_id;
    $item_name_en = $data->items_name_en;
    $item_name_ar = $data->items_name_ar;
    $item_desc_en = $data->items_desc_en;
    $item_desc_ar = $data->items_desc_ar;
    $item_price = $data->items_price;
    $item_count = $data->items_count;
    $item_discount = $data->items_discount;
    $item_cat = $data->items_cat; // الحصول على فئة المنتج
    $item_image = isset($data->items_image) ? $data->items_image : null; 
    $item_active = $data->items_active; // الحصول على حالة تفعيل المنتج

    // مسار حفظ الصورة داخل السيرفر
    $uploadDir = 'D:/xampp/htdocs/Zahra_store/zahra/uploud/items/';

    // تحقق من وجود المجلد
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // إذا لم يكن المجلد موجودًا، قم بإنشائه
    }

    // إذا كانت قيمة itemsActive 0، حذف المنتج
    if ($item_active == 0) {
        // استعلام لحذف المنتج
        $deleteStmt = $con->prepare("DELETE FROM items WHERE items_id = :items_id");
        $deleteStmt->bindParam(':items_id', $item_id);
        
        if ($deleteStmt->execute()) {
            echo json_encode(['message' => 'Product deleted successfully']);
        } else {
            echo json_encode(['error' => 'Failed to delete product']);
        }
    } else {
        // استعلام لتحديث المنتج إذا كانت itemsActive = 1
        $stmt = $con->prepare("UPDATE items SET 
            items_name_en = :items_name_en, 
            items_name_ar = :items_name_ar, 
            items_desc_en = :items_desc_en, 
            items_desc_ar = :items_desc_ar, 
            items_price = :items_price, 
            items_count = :items_count,
            items_discount = :items_discount,
            items_cat = :items_cat, 
            items_active = :items_active" . 
            ($item_image ? ", items_image = :items_image" : "") . 
            " WHERE items_id = :items_id");

        // ربط القيم
        $stmt->bindParam(':items_id', $item_id);
        $stmt->bindParam(':items_name_en', $item_name_en);
        $stmt->bindParam(':items_name_ar', $item_name_ar);
        $stmt->bindParam(':items_desc_en', $item_desc_en);
        $stmt->bindParam(':items_desc_ar', $item_desc_ar);
        $stmt->bindParam(':items_price', $item_price);
        $stmt->bindParam(':items_count', $item_count);
        $stmt->bindParam(':items_discount', $item_discount);
        $stmt->bindParam(':items_cat', $item_cat); // ربط فئة المنتج
        $stmt->bindParam(':items_active', $item_active); // ربط حالة تفعيل المنتج

        // إذا كان هناك صورة لتحديثها
        if ($item_image !== null) {
            $image_name = uniqid() . '.jpg';
            $image_data = base64_decode($item_image);
            $imagePath = $uploadDir . $image_name;
            file_put_contents($imagePath, $image_data);
            $stmt->bindParam(':items_image', $image_name);
        }

        // تنفيذ الاستعلام
        if ($stmt->execute()) {
            echo json_encode(['message' => 'Product updated successfully']);
        } else {
            echo json_encode(['error' => 'Failed to update product']);
        }
    }

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
