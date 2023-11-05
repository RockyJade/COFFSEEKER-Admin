<?php
require_once("../../../db_connect.php");

if(!isset($_POST["id"])){
    // echo "請依正常管道進入此頁";
    $data=[
        "status"=>0,
        "message"=>"無有效參數"
    ];
    echo json_encode($data);

    exit;
}
$id=$_POST["id"];
$sql="SELECT * FROM course WHERE course_id= '$id'";
$result=$conn->query($sql);
$course=$result->fetch_assoc();

$data=[
    "status"=>1,
    "crouse"=>$course
];

echo json_encode($data);
$conn->close();