<?php
include "connect.php"  ;



try {

   // استعلام لجلب كل البيانات من جدول users
   $stmt = $con->prepare("SELECT * FROM ads");
   $stmt->execute();

   // جلب البيانات كصفوف
   $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

   // إرسال البيانات بتنسيق JSON
   echo json_encode($users);
} catch (PDOException $e) {
   echo json_encode(['error' => $e->getMessage()]);
}
?>
