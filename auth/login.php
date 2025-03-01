<?php
include "../connect.php";

// استرجاع البريد الإلكتروني وكلمة المرور من الطلب
$email = filterRequest("email");
$password = filterRequest("password");

// سجل البريد الإلكتروني وكلمة المرور للتحقق
error_log("Email: $email, Password Hash: $password");

// إعداد استعلام SQL
$query = "SELECT * FROM users WHERE users_email = ? AND users_password = ? AND users_approve = 1";
$stmt = $con->prepare($query);

// التحقق من تنفيذ الاستعلام
if ($stmt->execute(array($email, $password))) {
    // استرجاع البيانات وعدد الصفوف
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();

    // التحقق من عدد الصفوف
    if ($count > 0) {
        echo json_encode(array("status" => "success", "data" => $data));
    } else {
        // إذا لم يكن هناك تطابق، سجل البيانات المدخلة
        error_log("No matching user found. Email: $email, Password Hash: $password");
        echo json_encode(array("status" => "failure", "message" => "Invalid email or password."));
    }
} else {
    // إذا فشل الاستعلام، سجل الخطأ
    $errorInfo = $stmt->errorInfo();
    error_log("Query execution failed. Error Info: " . print_r($errorInfo, true));
    echo json_encode(array("status" => "error", "message" => "Query execution failed."));
}
?>
