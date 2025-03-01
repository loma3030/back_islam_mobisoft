<?php
$dsn = "mysql:host=localhost;dbname=zahra_store";
$user = "root";
$pass = "";
$option = array(
   PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
);

try {
   $con = new PDO($dsn, $user, $pass, $option);
   $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   header("Access-Control-Allow-Origin: *");
   header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Access-Control-Allow-Origin");
   header("Access-Control-Allow-Methods: GET");

   // استعلام لجلب كل البيانات من جدول users
   $stmt = $con->prepare("SELECT * FROM links");
   $stmt->execute();

   // جلب البيانات كصفوف
   $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

   // إرسال البيانات بتنسيق JSON
   echo json_encode($users);
} catch (PDOException $e) {
   echo json_encode(['error' => $e->getMessage()]);
}
?>
