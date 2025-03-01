<?php
include "connect.php"  ;

$countrowinpage = 9;
try {


   // استعلام الإحصائيات
   $sql = "
      SELECT 
         items.items_name_ar AS product_name, 
         COUNT(favorite.favorite_itemsid) AS interested_users 
      FROM 
         favorite 
      JOIN 
         items 
      ON 
         favorite.favorite_itemsid = items.items_id 
      GROUP BY 
         favorite.favorite_itemsid 
      ORDER BY 
         interested_users DESC
   ";

   $stmt = $con->prepare($sql);
   $stmt->execute();
   $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

   // إرسال البيانات بصيغة JSON
   echo json_encode($data);

} catch (PDOException $e) {
   echo json_encode(["error" => $e->getMessage()]);
}
