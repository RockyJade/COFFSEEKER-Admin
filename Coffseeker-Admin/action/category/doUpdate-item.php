<?php
$big_id=$_POST["big_id"];
$id=$_POST["id"]; //這邊的id代表前面name的id
$name=$_POST["name"];


require_once("../../../db_connect.php");

$sql="UPDATE categories_item SET items_name='$name' WHERE items_id=$id";

if($conn->query($sql) === TRUE){
    header("location: ../../category-item.php?id=$big_id");
}else {
    echo "更新資料失敗: " . $conn->error;
}


?>