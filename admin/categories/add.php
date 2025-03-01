<?php 

include '../../connect.php';

$msgError = array();
$table = "categories";

// الحصول على البيانات من المستخدم باستخدام دالة filterRequest
$name = filterRequest("name");
$namear = filterRequest("namear");

// دالة رفع الصورة إلى Folderit
function uploadFileToFolderit($filePath) {
    $url = 'https://my.folderit.com/api/upload'; 
    $apiKey = 'cc373XOezxgVS0PE67kPucbTcPn7a-h6'; 
    $apiSecret = '9bu6Nywq8c6VLD7PqQbpjst060Z3fIp9'; 

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'file' => new CURLFile($filePath),
    ]);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Basic ' . base64_encode("$apiKey:$apiSecret"),
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// رفع الصورة إذا تم اختيارها
if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
    $filePath = $_FILES['image']['tmp_name'];
    $uploadResponse = uploadFileToFolderit($filePath);

    if (isset($uploadResponse['url'])) {
        $imagename = $uploadResponse['url']; // رابط الصورة
    } else {
        $msgError[] = "فشل رفع الصورة: " . $uploadResponse['message'];
        $imagename = null;
    }
} else {
    $msgError[] = "يرجى اختيار صورة.";
}

// إعداد البيانات للإدخال في قاعدة البيانات
if (empty($msgError) && $imagename != null) {
    $data = array( 
        "categories_name_en" => $name,
        "categories_name_ar" => $namear,
        "categories_image" => $imagename,
    );

    // استدعاء دالة insertData لإدخال البيانات
    insertData($table, $data);
    echo json_encode(["status" => "success", "message" => "تم إضافة القسم بنجاح"]);
} else {
    echo json_encode(["status" => "fail", "message" => implode(", ", $msgError)]);
}

?>
