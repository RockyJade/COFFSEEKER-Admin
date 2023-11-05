<?php

require_once("../../../db_connect.php");

if(!isset($_POST["id"])){
    $data=[
        "status"=>0,
        "message"=>"無ID參數"
    ];
    echo json_encode($data);
    exit;
}
$id=$_POST["id"];
$sql="DELETE FROM course WHERE course_id =$id";

if ($conn->query($sql) === TRUE) {
    $data=[
        "status"=>1,
        "message"=>"刪除課程成功，即將跳轉頁面"
    ];
    echo json_encode($data);

} else {
    // echo "新增資料錯誤: " . $conn->error;
    $data=[
        "status"=>0,
        "message"=>"刪除資料錯誤: " .$conn->error
    ];
    echo json_encode($data);

}
$conn->close();