<?php

if($_FILES["file"]["error"] !== 0){
    $data=[
        "status"=>0,
        "message"=>"圖片格式有誤".$_FILES["file"]["error"]
    ];
    echo json_encode($data);
    exit;
}


if (move_uploaded_file($_FILES["file"]["tmp_name"], "../../course_image/" . $_FILES["file"]["name"])) {
    $data=[
        "status"=>1,
        "message"=>"新增成功，即將跳轉頁面"
    ];
    echo json_encode($data);
    exit;
} else {
    // echo "新增資料錯誤: " . $conn->error;
    $data=[
        "status"=>0,
        "message"=>"新增圖片錯誤"
    ];
    echo json_encode($data);
    exit;
}
