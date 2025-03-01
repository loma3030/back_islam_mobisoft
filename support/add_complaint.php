<?php
// إعدادات الاتصال بقاعدة البيانات
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

    // الحصول على البيانات من الطلب عبر GET
    $user_name = $_GET['user_name'] ?? null;
    $user_phone = $_GET['user_phone'] ?? null;
    $user_email = $_GET['user_email'] ?? null;
    $complaint_description = $_GET['complaint_description'] ?? null;

    // التحقق من البيانات المطلوبة
    if ($user_name && $user_phone && $user_email && $complaint_description) {
        $stmt = $con->prepare("INSERT INTO complaints (user_name, user_phone, user_email, complaint_description) VALUES (:user_name, :user_phone, :user_email, :complaint_description)");
        
        $stmt->bindParam(':user_name', $user_name);
        $stmt->bindParam(':user_phone', $user_phone);
        $stmt->bindParam(':user_email', $user_email);
        $stmt->bindParam(':complaint_description', $complaint_description);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Complaint submitted successfully']);
        } else {
            echo json_encode(['error' => 'Failed to submit complaint']);
        }
    } else {
        echo json_encode(['error' => 'All fields are required']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
