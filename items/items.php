<?php

include "../connect.php";

$categoryid = filterRequest("id"); // تصفية المعرف الخاص بالقسم
$userid = filterRequest("usersid"); // تصفية المعرف الخاص بالمستخدم

try {
    // الاستعلام لاسترجاع المنتجات المفضلة
    $stmt = $con->prepare("
        SELECT items1view.*,
               1 as favorite,
               (items_price - (items_price * items_discount / 100)) as itemspricedisount
        FROM items1view
        INNER JOIN favorite
        ON favorite.favorite_itemsid = items1view.items_id
        AND favorite.favorite_usersid = :userid
        WHERE categories_id = :categoryid

        UNION ALL

        SELECT items1view.*,
               0 as favorite,
               (items_price - (items_price * items_discount / 100)) as itemspricedisount
        FROM items1view
        WHERE categories_id = :categoryid
          AND items_id NOT IN (
              SELECT items1view.items_id
              FROM items1view
              INNER JOIN favorite
              ON favorite.favorite_itemsid = items1view.items_id
              AND favorite.favorite_usersid = :userid
          )
    ");

    // تنفيذ الاستعلام مع القيم
    $stmt->execute([
        ':userid' => $userid,
        ':categoryid' => $categoryid
    ]);

    // استرجاع البيانات وعدد النتائج
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();

    // إرسال النتيجة كاستجابة JSON
    if ($count > 0) {
        echo json_encode(["status" => "success", "data" => $data]);
    } else {
        echo json_encode(["status" => "failure"]);
    }
} catch (PDOException $e) {
    // تسجيل الخطأ وإرسال رسالة مناسبة
    error_log("Error fetching items: " . $e->getMessage());
    echo json_encode(["status" => "error", "message" => "Failed to fetch items."]);
    exit();
}
