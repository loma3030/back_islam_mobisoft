<?php
include "../../connect.php";

// استرجاع البريد الإلكتروني وكلمة المرور من الطلب
$email = filterRequest("email");
$password = filterRequest("password");

// سجل البريد الإلكتروني وكلمة المرور للتحقق
error_log("Email: $email");

// إعداد استعلام SQL
$query = "SELECT * FROM `admin` WHERE `admin_email` = ? AND `admin_approve` = 1";
$stmt = $con->prepare($query);

// التحقق من تنفيذ الاستعلام
if ($stmt->execute(array($email))) {
    // استرجاع البيانات وعدد الصفوف
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();

    // التحقق من عدد الصفوف
    if ($count > 0) {
        // التحقق من كلمة المرور إذا كانت مشفرة
        if (password_verify($password, $data['admin_password'])) {
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            // إذا كانت كلمة المرور غير صحيحة
            error_log("Incorrect password for Email: $email");
            echo json_encode(array("status" => "failure", "message" => "Invalid email or password."));
        }
    } else {
        // إذا لم يكن هناك تطابق، سجل البيانات المدخلة
        error_log("No matching user found. Email: $email");
        echo json_encode(array("status" => "failure", "message" => "Invalid email or password."));
    }
} else {
    // إذا فشل الاستعلام، سجل الخطأ
    $errorInfo = $stmt->errorInfo();
    error_log("Query execution failed. Error Info: " . print_r($errorInfo, true));
    echo json_encode(array("status" => "error", "message" => "Query execution failed."));
}
?>
