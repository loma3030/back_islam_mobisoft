<?php
include "connect.php"; // الاتصال بقاعدة البيانات
include 'toggleVisibility.php';  // استدعاء ملف toggleVisibility

// دالة لتبديل حالة المنتج بين الإظهار والإخفاء
function toggleItemVisibility($itemId) {
    // استدعاء دالة toggleVisibility
    return toggleVisibility($itemId);  
}
?>
