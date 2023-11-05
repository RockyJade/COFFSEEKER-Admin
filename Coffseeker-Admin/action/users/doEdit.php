<?php

$name=$_POST["name"];
$gender=$_POST["gender"];
$phone=$_POST["phone"];
$email=$_POST["email"];
$birthday=$_POST["birthday"];
$grade=$_POST["grade"];
$id=$_POST["id"];
require_once("../../../db_connect.php");

$coffsql="UPDATE users SET user_name='$name' , user_gender='$gender' , user_phone='$phone' , user_email='$email' , user_birthday='$birthday' ,user_grade_id='$grade' WHERE id=$id";

if ($conn->query($coffsql) === TRUE) {

    $latestId=$conn->insert_id;
    // echo "修改資料完成";
    header("location: ../../user-detail.php?id=".$id);

} else {
    echo "修改資料錯誤: " . $conn->error;
}

$conn->close();

?>