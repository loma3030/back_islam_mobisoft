<?php
include "connect.php"  ;


try {

   // استعلام للتحقق من حالة لوحة التحكم
   $sql = "SELECT expiration_date, status FROM control_panel_status WHERE id = 1"; // افترض أن لديك سجل واحد
   $stmt = $con->prepare($sql);
   $stmt->execute();
   $result = $stmt->fetch(PDO::FETCH_ASSOC);

   if ($result) {
       $expiration_date = $result['expiration_date'];
       $status = $result['status'];

       // التحقق من حالة اللوحة
       if ($status == 'inactive' || strtotime($expiration_date) < time()) {
           echo json_encode(array("status" => "inactive", "message" => "من فضلك قم بسداد رسوم الاشتراك الشهري حتي تتمكن من ادارة تطبيقك "));
       } else {
           echo json_encode(array("status" => "active", "message" => "مرحبًا بك في لوحة التحكم."));
       }
   } else {
       echo json_encode(array("status" => "error", "message" => "لا توجد معلومات حول لوحة التحكم."));
   }
} catch (PDOException $e) {
   echo $e->getMessage();
}
