<?php

if(!isset($_GET["id"])){
    die("無法作業");
}

require_once("../../../db_connect.php");

$id = $_GET["id"];

$sql = "UPDATE categories SET valid=0 WHERE categories_id = '$id'";

if ($conn->query($sql) === TRUE) {
    header("Location: ../../category.php");  
    //echo "123";
    exit;

} else {
    echo "刪除資料錯誤" . $conn->error;
}


?>