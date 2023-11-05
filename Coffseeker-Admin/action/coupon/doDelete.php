<?php
if (!isset($_GET["coupon_id"])) {
    die("無法作業");
}

require_once("../../../db_connect.php");

$id = $_GET["coupon_id"];
$valid = 0;
$description = "已刪除";

$sql = "UPDATE coupon SET coupon_valid = $valid, valid_description = '$description' WHERE coupon_id = $id";

if ($conn->query($sql) === TRUE) {
    header("location: ../../coupon-edit-list.php");
} else {
    echo "更新資料錯誤: " . $conn->error;
}
