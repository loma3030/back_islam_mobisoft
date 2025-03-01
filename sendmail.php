<?php
// sendmail.php

// تحديد عنوان البريد الإلكتروني المرسل إليه والمرسل وعنوان الموضوع ومحتوى الرسالة
$to = 'eashr35@gmail.com';  // تغيير العنوان إلى العنوان الذي تريد الإرسال إليه
$subject = 'اختبار إرسال البريد الإلكتروني';
$message = 'هذه رسالة اختبار لإرسال البريد الإلكتروني باستخدام sendmail.';
$headers = 'From: emtkatof@gmail.com' . "\r\n" .
           'Reply-To: emtkatof@gmail.com' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();

// استخدام دالة mail() لإرسال البريد الإلكتروني
if (mail($to, $subject, $message, $headers)) {
    echo 'تم إرسال البريد الإلكتروني بنجاح!';
} else {
    echo 'فشل في إرسال البريد الإلكتروني.';
}
?>
