<?php
$servername = "localhost";
$username = "admin";
$password = "12345";
$dbname = "coffseeker_db";

try{
    // echo "資料庫連線成功";
    $db_host=new PDO(
        "mysql:
        host={$servername};
        dbname={$dbname};
        charset=utf8" , 
        $username , $password
    );

}catch(PDOException ){
    echo "資料庫連線失敗";
    echo "Error:" . $e->getMessage();
    $db_host=null;
}




