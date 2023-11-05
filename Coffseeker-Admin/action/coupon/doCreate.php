<?php
if (!isset($_POST["coupon_name"])) {
    header("location: ../../404.php");
}

require_once("../../../db_connect.php");

$name = $_POST["coupon_name"];
$code = $_POST["coupon_code"];
$type = $_POST["discount_type"];
$valid = $_POST["coupon_valid"];
$value = $_POST["discount_value"];
$max = $_POST["max_usage"];
$times = $_POST["used_times"];
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

if (strtotime($start) < strtotime($now)) {
    $valid = -1;
    $description = "已停用";
} else {
    $valid = 1; 
    $description = "可使用";
}


$sql = "INSERT INTO coupon (coupon_name,coupon_code,discount_type,discount_value,coupon_valid,created_at,expires_at,start_at,updated_at,max_usage,used_times,usage_restriction,valid_description,price_min) VALUES ('$name', '$code', '$type','$value','$valid','$now','$expires','$start','$now','$max', 0, '$restrict','$description','$min')";


if ($conn->query($sql) === TRUE) {
    $latestId = $conn->insert_id;
    header("location: ../../coupon.php?coupon_id=" . $latestId);
} else {
    echo "新增資料錯誤: " . $conn->error;
}
$conn->close();
