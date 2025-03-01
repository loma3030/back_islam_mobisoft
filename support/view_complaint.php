<?php
// إعداد الاتصال بقاعدة البيانات
$dsn = "mysql:host=localhost;dbname=zahra_store";
$user = "root"; // اسم المستخدم
$pass = ""; // كلمة المرور
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
);

try {
    $con = new PDO($dsn, $user, $pass, $options);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // إعداد الرؤوس للسماح بالاتصال من أي نطاق
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    // استعلام لجلب جميع الشكاوى
    $stmt = $con->prepare("SELECT * FROM complaints");
    $stmt->execute();

    // جلب جميع النتائج كصفوف
    $complaints = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // إرسال النتائج بتنسيق JSON
    echo json_encode($complaints);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
