<?php
include "connect.php";

try {
   // استعلام لجلب كل البيانات من جدول users
   $stmt = $con->prepare("SELECT users_id, users_name, users_phone, users_email, users_password, users_verfiycode, users_approve FROM users");
   $stmt->execute();

   // جلب البيانات كصفوف
   $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

   // إرسال البيانات بتنسيق JSON
   echo json_encode($users);
} catch (PDOException $e) {
   echo json_encode(['error' => $e->getMessage()]);
}
?>
