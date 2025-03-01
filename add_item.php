<?php
include "connect.php"  ;


try {
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }

    // الحصول على البيانات من الطلب
    $data = json_decode(file_get_contents("php://input"));

    // التحقق من البيانات المرسلة
    if (!isset($data->items_name_en) || !isset($data->items_name_ar) || 
        !isset($data->items_desc_en) || !isset($data->items_desc_ar) || 
        !isset($data->items_price) || !isset($data->items_count) || 
        !isset($data->items_discount) || !isset($data->items_cat) || 
        !isset($data->items_image)) {
        echo json_encode(['error' => 'Missing required fields']);
        exit();
    }

    // الحصول على البيانات
    $item_name_en = $data->items_name_en;
    $item_name_ar = $data->items_name_ar;
    $item_desc_en = $data->items_desc_en;
    $item_desc_ar = $data->items_desc_ar;
    $item_price = $data->items_price;
    $item_count = $data->items_count;
    $item_discount = $data->items_discount;
    $item_cat = $data->items_cat;
    $item_image = $data->items_image;

    // مسار رفع الصور
    $uploadDir = 'C:/xampp/htdocs/Zahra_store/zahra/uploud/items/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // معالجة الصورة
    $image_name = uniqid() . '.jpg';
    $image_data = base64_decode($item_image);
    $imagePath = $uploadDir . $image_name;
    file_put_contents($imagePath, $image_data);

    // استعلام الإدخال
    $stmt = $con->prepare("INSERT INTO items (
        items_name_en, items_name_ar, items_desc_en, items_desc_ar, 
        items_price, items_count, items_discount, items_cat, items_image
    ) VALUES (
        :items_name_en, :items_name_ar, :items_desc_en, :items_desc_ar, 
        :items_price, :items_count, :items_discount, :items_cat, :items_image
    )");

    // ربط القيم
    $stmt->bindParam(':items_name_en', $item_name_en);
    $stmt->bindParam(':items_name_ar', $item_name_ar);
    $stmt->bindParam(':items_desc_en', $item_desc_en);
    $stmt->bindParam(':items_desc_ar', $item_desc_ar);
    $stmt->bindParam(':items_price', $item_price);
    $stmt->bindParam(':items_count', $item_count);
    $stmt->bindParam(':items_discount', $item_discount);
    $stmt->bindParam(':items_cat', $item_cat);
    $stmt->bindParam(':items_image', $image_name);

    // تنفيذ الاستعلام
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Product added successfully']);
    } else {
        echo json_encode(['error' => 'Failed to add product']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
