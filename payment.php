<?php
include "connect.php";


try {

   // استلام البيانات من التطبيق (مثل الدفع)
   $data = json_decode(file_get_contents("php://input"), true);

   $order_id = $data['order_id'];
   $user_id = $data['user_id'];
   $payment_method = $data['payment_method'];
   $payment_status = $data['payment_status'];
   $payment_amount = $data['payment_amount'];

   // إدخال البيانات في جدول المدفوعات
   $stmt = $con->prepare("INSERT INTO payments (order_id, user_id, payment_method, payment_status, payment_amount) 
                          VALUES (:order_id, :user_id, :payment_method, :payment_status, :payment_amount)");

   $stmt->bindParam(':order_id', $order_id);
   $stmt->bindParam(':user_id', $user_id);
   $stmt->bindParam(':payment_method', $payment_method);
   $stmt->bindParam(':payment_status', $payment_status);
   $stmt->bindParam(':payment_amount', $payment_amount);

   if ($stmt->execute()) {
       echo json_encode(['status' => 'success', 'message' => 'Payment recorded successfully']);
   } else {
       echo json_encode(['status' => 'error', 'message' => 'Failed to record payment']);
   }

} catch (PDOException $e) {
   echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
