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
$valid=$_POST["valid"];
if ($valid==1) {
    $valid=2;
}else{
    $valid=1;
}
$valid= intval($valid);
$sql="UPDATE course SET course_valid=$valid WHERE course_id=$id";

if ($conn->query($sql) === TRUE) {
    $data=[
        "status"=>1,
        "message"=>"修改課程成功，即將刷新頁面"
    ];
    echo json_encode($data);

} else {
    // echo "新增資料錯誤: " . $conn->error;
    $data=[
        "status"=>0,
        "message"=>"新增資料錯誤: " .$conn->error
    ];
    echo json_encode($data);

}
$conn->close();
