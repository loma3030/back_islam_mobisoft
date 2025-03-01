<?php 

include "../connect.php" ; 

$search = filterRequest("search") ; 

getAllData("items1view" , "items_name_en LIKE '%$search%' OR items_name_ar  LIKE '%$search%'  ") ; 

?>