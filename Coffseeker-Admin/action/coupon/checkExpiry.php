<?php
require_once("../../../db_connect.php");

$sql = "SELECT coupon_id, expires_at FROM coupon";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $coupon_id = $row["coupon_id"];
        $expires_at = $row["expires_at"];

        if (strtotime($expires_at) < strtotime('now')) {
            $update_sql = "UPDATE coupon SET coupon_valid = -1, valid_description = '已停用' WHERE coupon_id = '$coupon_id'";
            $conn->query($update_sql);
        }
    }
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false, "message" => "無優惠卷資料"));
}
