<?php

$id = $_POST["id"];
$icon = $_FILES["icon"]["name"];
$targetPath = "../../img/user-icon/" . $icon;
require_once("../../../db_connect.php");

if ($_FILES["icon"]["error"] == 0) {
    if (file_exists($targetPath)) {
        $coffsql = "UPDATE users SET user_icon='$icon' WHERE id=$id";
        if ($conn->query($coffsql) === TRUE) {
            header("location: ../../user-edit.php?id=" . $id);
        } else {
            echo "新增資料錯誤: " . $conn->error;
        }
    } else {
        move_uploaded_file($_FILES["icon"]["tmp_name"], $targetPath);
        $coffsql = "UPDATE users SET user_icon='$icon' WHERE id=$id";
        if ($conn->query($coffsql) === TRUE) {
            header("location: ../../user-edit.php?id=" . $id);
        } else {
            echo "新增資料錯誤: " . $conn->error;
        }
    }
} else {
    var_dump($_FILES["icon"]["error"]);
}

$conn->close();

?>