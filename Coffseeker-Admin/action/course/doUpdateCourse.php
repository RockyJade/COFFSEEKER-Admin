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


if(empty($_POST["courseName"])){
    $data=[
        "status"=>0,
        "message"=>"請輸入課程名稱"
    ];
    echo json_encode($data);
    exit;
}
$id=$_POST["id"];
$courseName=$_POST["courseName"];
$courseTypeId=$_POST["courseTypeId"];
$courseLevelId=$_POST["courseLevelId"];
$coursePrice=$_POST["coursePrice"];
$courseCapacity=$_POST["courseCapacity"];
$courseTeacherId=$_POST["courseTeacherId"];
$courseLocationId=$_POST["courseLocationId"];
$signStartDate=$_POST["signStartDate"];
$signEndDate=$_POST["signEndDate"];
$courseStartDate=$_POST["courseStartDate"];
$courseEndDate=$_POST["courseEndDate"];
$courseDescription=$_POST["courseDescription"];
$courseImage=$_POST["courseImage"];

if($courseImage == "noChange"){
$sql="UPDATE course SET course_name='$courseName', course_type_id='$courseTypeId', course_level_id='$courseLevelId',teacher_id='$courseTeacherId',course_price='$coursePrice',sign_start_date='$signStartDate', sign_end_date='$signEndDate', course_start_date='$courseStartDate',course_end_date='$courseEndDate',course_location_id= '$courseLocationId', course_capacity='$courseCapacity', course_description='$courseDescription' WHERE course_id=$id";
}else{
    $sql="UPDATE course SET course_name='$courseName', course_type_id='$courseTypeId', course_level_id='$courseLevelId',teacher_id='$courseTeacherId',course_price='$coursePrice',sign_start_date='$signStartDate', sign_end_date='$signEndDate', course_start_date='$courseStartDate',course_end_date='$courseEndDate',course_location_id= '$courseLocationId', course_capacity='$courseCapacity', course_description='$courseDescription',course_image='$courseImage' WHERE course_id=$id";

}


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
        "message"=>"修改資料錯誤: " .$conn->error
    ];
    echo json_encode($data);

}

// echo json_encode($data);
$conn->close();