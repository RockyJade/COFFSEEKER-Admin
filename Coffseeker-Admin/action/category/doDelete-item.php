<?php

if(!isset($_GET["id"])){
    die("無法作業");
}

require_once("../../../db_connect.php");

$id = $_GET["id"];
$big_id= $_GET["categories_id"];
//var_dump($big_id);

$sql = "UPDATE categories_item SET valid=0 WHERE items_id = '$id'";


if ($conn->query($sql) === TRUE) {
    header("location: ../../category-item.php?id=$big_id"); 
    exit;

} else {
    echo "刪除資料錯誤" . $conn->error;
}


?>