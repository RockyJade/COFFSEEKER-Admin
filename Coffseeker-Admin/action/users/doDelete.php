<?php
if(!isset($_GET["id"])){
    header("location: ../../user-list.php"); 
 }

$id=$_GET["id"];
require_once("../../../db_connect.php");

$coffsql="UPDATE users SET user_valid=0 WHERE id='$id'";

if ($conn->query($coffsql) === TRUE) {

    $latestId=$conn->insert_id;
    echo "修改資料完成";
    header("location: ../../user-list.php");

} else {
    echo "修改資料錯誤: " . $conn->error;
}

$conn->close();

?>