<?php
require_once("../../coffseeker_db.php");


$name=$_POST["name"];
$password=$_POST["password"];
$repassword=$_POST["repassword"];
$gender=$_POST["gender"];
$email=$_POST["email"];
$phone=$_POST["phone"];
$birthday=$_POST["birthday"];
$now=date('Y-m-d H:i:s');

if(!isset($_POST["name"])){
    header("location: ../register.php");
}

if(empty($_POST["name"])){
    die("請輸入姓名");
}

if(empty($_POST["password"])){
    die("請輸入密碼");
}

if($password!=$repassword){
    die("密碼不一致");
}

if(empty($_POST["gender"])){
    die("請選擇性別");
}

if(empty($_POST["phone"])){
    die("請輸入電話號碼");
}

if(empty($_POST["email"])){
    die("請輸入信箱");
}

if(empty($_POST["birthday"])){
    die("請選擇生日日期");
}

// $password=md5($password);
// echo "$name, $phone ,$email";

$coffsql="INSERT INTO users (user_name , user_password , user_gender , user_phone , user_email , user_birthday , user_icon , user_created_at , user_grade_id , user_valid) VALUES ('$name' , '$password' , '$gender' , '$phone' , '$email' , '$birthday' , 'preset-icon.png' , '$now' , 3 , 1 )";

// echo $coffsql;

if ($conn->query($coffsql) === TRUE) {

    // $latestId=$conn->insert_id;
    // echo "修改資料完成";
    header("location: ../../user-list.php");

} else {
    echo "修改資料錯誤: " . $conn->error;
}

$conn->close();