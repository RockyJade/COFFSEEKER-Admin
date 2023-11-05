<?php

$id=$_POST["id"]; //這邊的id代表前面name的id
$name=$_POST["name"];

require_once("../../../db_connect.php");

$sql="UPDATE categories SET categories_name='$name' WHERE categories_id=$id";

if($conn->query($sql) === TRUE){
    header("location: ../../category.php?id=$id");
}else {
    echo "更新資料失敗: " . $conn->error;
}


?>