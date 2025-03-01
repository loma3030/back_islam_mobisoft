<?php
$dsn = "mysql:host=localhost;dbname=zahra_store";  // تعديل من localhost إلى IP ثابت إذا لزم الأمر
$user = "root";  // اسم المستخدم
$pass = "";  // كلمة المرور
$option = array(
   PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
);
$countrowinpage = 9;

try {
   $con = new PDO($dsn, $user, $pass, $option);
   $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
   // إضافة رؤوس CORS للسماح بالوصول من التطبيقات الخارجية
   header("Access-Control-Allow-Origin: *");
   header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Access-Control-Allow-Origin");
   header("Access-Control-Allow-Methods: POST, OPTIONS , GET");

   include "functions.php";
   
   if (!isset($notAuth)) {
      // checkAuthenticate();
   }

   // استعلام لجلب جميع الصور من جدول ads2
   $query = "SELECT * FROM ads2";  // استخدام الجدول ads2
   $stmt = $con->prepare($query);
   $stmt->execute();

   // التحقق من وجود بيانات
   $ads = array();
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       $ads[] = $row['image_url']; // إضافة رابط الصورة إلى المصفوفة
   }

   // إرجاع البيانات بصيغة JSON
   echo json_encode($ads);

} catch (PDOException $e) {
   echo $e->getMessage();
}
?>
