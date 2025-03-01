<?php 

include '../connect.php';

$table = "address";

$usersid    = filterRequest("usersid");
$name       = filterRequest("name");
$city       = filterRequest("city");
$street     = filterRequest("street");
$phone        = filterRequest("phone");


$data = array(  
"address_city" => $city,
"address_usersid" => $usersid,
"address_name"   => $name,
"address_street" => $street,
"address_phone" => $phone,
);

insertData($table , $data);