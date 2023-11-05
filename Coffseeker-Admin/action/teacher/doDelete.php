<?php

$id=$_GET["teacher_id"];

echo $id;

require_once("../../../db_connect.php");

$sql="UPDATE coffseeker_teachers SET valid=0 WHERE teacher_id='$id'";
// $conn->query($sql);

if($conn->query($sql)===TRUE){
    header("location: ../../teacher-list.php");
}else{
    echo "資料刪除失敗" . $conn->error;
};


$conn->close();

?>

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>