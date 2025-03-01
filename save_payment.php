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

   // استلام بيانات الدفع من Flutter أو من PayPal
   $payment_status = $_POST['payment_status']; // 'success' or 'failure'
   $payment_amount = $_POST['payment_amount'];
   $user_id = $_POST['user_id']; // معرف المستخدم الذي دفع
   $order_id = $_POST['order_id']; // معرف الطلب المتعلق بالمعاملة

   // استعلام لإدخال بيانات الدفع
   $stmt = $con->prepare("INSERT INTO payments (payment_status, payment_amount, user_id, order_id, payment_method)
                          VALUES (?, ?, ?, ?, 'PayPal')");
   $stmt->execute([$payment_status, $payment_amount, $user_id, $order_id]);

   echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
   echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
