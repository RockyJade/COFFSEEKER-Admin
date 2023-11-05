<?php

$states=$_POST["states"];
$id=$_POST["order_id"];
require_once("../../../db_connect.php");

$coffsql="UPDATE orders SET order_state = $states WHERE order_id=$id";

if ($conn->query($coffsql) === TRUE) {

    $latestId=$conn->insert_id;
    // echo "修改資料完成";
    header("location: ../../order-list.php");

} else {
    echo "修改資料錯誤: " . $conn->error;
}

$conn->close();

?>