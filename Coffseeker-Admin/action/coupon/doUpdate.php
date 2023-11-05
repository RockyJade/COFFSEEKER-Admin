<?php
if (!isset($_POST["coupon_name"])) {
    header("location: ../../404.php");
}

require_once("../../../db_connect.php");

$id = $_POST["coupon_id"];
$name = $_POST["coupon_name"];
$type = $_POST["discount_type"];
$valid = $_POST["coupon_valid"];
$value = $_POST["discount_value"];
$max = $_POST["max_usage"];
$now = date('Y-m-d H:i:s');
$expires = $_POST["expires_at"];
$restrict = $_POST["usage_restriction"];
$start = $_POST["start_at"];
$min = $_POST["price_min"];

$description = "";

if ($valid == 1) {
    $description = "可使用";
} else if ($valid == -1) {
    $description = "已停用";
} else if ($valid == 0) {
    $description = "已刪除";
}


$sql = "UPDATE coupon SET coupon_name='$name',coupon_valid='$valid', discount_type='$type', discount_value='$value', max_usage='$max', expires_at='$expires' ,updated_at='$now',usage_restriction='$restrict', valid_description='$description',start_at='$start',price_min='$min'  WHERE coupon_id=$id";

if ($conn->query($sql) === TRUE) {
    header("location: ../../Coupon.php?coupon_id=$id");
} else {
    echo "修改增資料錯誤: " . $conn->error;
}
