<!-- php &SQL 語法開始 -->
<?php
require_once("../db_connect.php");

$whereClause = "WHERE ";


//顯示下架課程
if (isset($_GET["valid"])) {
    $valid = $_GET["valid"];
    $whereClause .= " course.course_valid = 2";
} else {
    $valid = 1;
    $whereClause .= " course.course_valid = 1";
}
//狀態篩選
if(isset($_GET["status"])){
    $now = date("Y-m-d");
    $status =$_GET["status"];
    switch ($status) {
        case "signOff":
            $whereClause .= "  AND sign_start_date > '$now' ";
            break;
        case "signing":
            $whereClause .= "  AND sign_start_date <= '$now' AND sign_end_date >= '$now'";
            break;
        case "courseOn":
            $whereClause .= " AND course_start_date <= '$now' AND course_end_date >= '$now'";
            break;
        case 'courseOff':
            $whereClause .= " AND course_end_date < '$now'";
            break;
        default:
            break;
    }
}



//篩選
//關鍵字
if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $whereClause .= " AND course.course_name LIKE '%$search%'";
}
//課程類型
if (isset($_GET["type"])) {
    $type = $_GET["type"];
    $whereClause .= " AND course.course_type_id = $type";
}
//課程難度
if (isset($_GET["level"])) {
    $level = $_GET["level"];
    $whereClause .= " AND course.course_level_id = $level";
}
//課程地點
if (isset($_GET["location"])) {
    $location = $_GET["location"];
    $whereClause .= " AND course.course_location_id = $location";
}

//開課日期
if (isset($_GET["dateFrom"]) && isset($_GET["dateTo"])) {
    $dateFrom = $_GET["dateFrom"];
    $dateTo = $_GET["dateTo"];
    $whereClause .= " AND course.course_start_date >= '$dateFrom' AND course.course_start_date <= '$dateTo'";
} elseif (isset($_GET["dateFrom"]) && $_GET["dateFrom"] != "") {
    $dateFrom = $_GET["dateFrom"];
    $whereClause .= " AND course.course_start_date >= '$dateFrom'";
} elseif (isset($_GET["dateTo"]) && $_GET["dateTo"] != "") {
    $dateTo = $_GET["dateTo"];
    $whereClause .= " AND course.course_start_date <= '$dateTo'";
}

// 排序
$orderClause = "ORDER BY ";
if (isset($_GET["orderby"])) {
    $orderby = $_GET["orderby"];

    switch ($orderby) {
        case 1:
            $orderClause .= " course_created_at DESC";
            break;
        case 2:
            $orderClause .= "sign_start_date DESC";
            break;
        case 3:
            $orderClause .= "sign_start_date ASC";
            break;
        case 4:
            $orderClause .= "course_start_date DESC";
            break;
        case 5:
            $orderClause .= "course_start_date ASC";
            break;

        default:
            $orderClause .= " course_created_at DESC";
            break;
    }
} else {
    $orderClause .= " course_created_at DESC";
}
//無篩選資料計算
$sqlAll = "SELECT * FROM course WHERE course_valid=$valid";
$resultAll = $conn->query($sqlAll);
$countAll = $resultAll->num_rows;
$now = date("Y-m-d");
//報名未開始
$sqlSignOff = "SELECT * FROM course WHERE course_valid=$valid AND sign_start_date > '$now'";
$resultSignOff = $conn->query($sqlSignOff);
$countSignOff = $resultSignOff->num_rows;

//報名開放中
$sqlSigning = "SELECT * FROM course WHERE course_valid=$valid AND sign_start_date <= '$now' AND sign_end_date >= '$now'";
$resultSigning = $conn->query($sqlSigning);
$countSigning = $resultSigning->num_rows;
//課程進行中
$sqlCoursing = "SELECT * FROM course WHERE course_valid=$valid AND course_start_date <= '$now' AND course_end_date >= '$now'";
$resultCoursing = $conn->query($sqlCoursing);
$countCoursing = $resultCoursing->num_rows;
//已結束課程
$sqlCourseEnd = "SELECT * FROM course WHERE course_valid=$valid AND course_end_date < '$now'";
$resultCourseEnd = $conn->query($sqlCourseEnd);
$countCourseEnd = $resultCourseEnd->num_rows;



// 總筆數
$sqlTotal = "SELECT * FROM course 
LEFT JOIN course_type ON  course_type.course_type_id=course.course_type_id 
LEFT JOIN course_level ON  course_level.course_level_id=course.course_level_id 
LEFT JOIN course_location ON course.course_location_id = course_location.course_location_id
LEFT JOIN coffseeker_teachers ON coffseeker_teachers.teacher_id = course.teacher_id

$whereClause 
$orderClause
";

// 分頁定義
$page = $_GET["page"] ?? 1;

if (isset($_GET["perPage"])) {
    $perPage = $_GET["perPage"];
} else {

    $perPage = 5;
}

$startItem = ($page - 1) * $perPage;

$resultTotal = $conn->query($sqlTotal);
$rowsTotal = $resultTotal->fetch_all(MYSQLI_ASSOC);

//計算總筆數
$totalResult = $resultTotal->num_rows;
//計算總頁數
$totalPage = ceil($totalResult / $perPage);
$limitClause = "LIMIT $startItem, $perPage";


$sql = "SELECT * FROM course 
LEFT JOIN course_type ON  course_type.course_type_id=course.course_type_id 
LEFT JOIN course_level ON  course_level.course_level_id=course.course_level_id 
LEFT JOIN course_location ON course.course_location_id = course_location.course_location_id
LEFT JOIN coffseeker_teachers ON coffseeker_teachers.teacher_id = course.teacher_id
$whereClause 
$orderClause
$limitClause
";

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

// JOIN的資料表們query出來
$sqlType = "SELECT * FROM course_type ";
$resultType = $conn->query($sqlType);
$typeRows = $resultType->fetch_all(MYSQLI_ASSOC);

$sqlLevel = "SELECT * FROM course_level ";
$resultLevel = $conn->query($sqlLevel);
$levelRows = $resultLevel->fetch_all(MYSQLI_ASSOC);

$sqlLocation = "SELECT * FROM course_location";
$resultLocation = $conn->query($sqlLocation);
$locationRows = $resultLocation->fetch_all(MYSQLI_ASSOC);

$sqlTeacher = "SELECT * FROM  coffseeker_teachers WHERE valid='1'";
$resultTeacher = $conn->query($sqlTeacher);
$teacherRows = $resultTeacher->fetch_all(MYSQLI_ASSOC);

//統整網址GET參數
$allGet = [
    'search' => isset($_GET["search"]) ? $_GET["search"] : null,
    'type' => isset($_GET["type"]) ? $_GET["type"] : null,
    'level' => isset($_GET["level"]) ? $_GET["level"] : null,
    'location' => isset($_GET["location"]) ? $_GET["location"] : null,
    'valid' => isset($_GET["valid"]) ? $_GET["valid"] : null,
    'orderby' => isset($_GET["orderby"]) ? $_GET["orderby"] : null,
    'dateFrom' => isset($_GET["dateFrom"]) ? $_GET["dateFrom"] : null,
    'dateTo' => isset($_GET["dateTo"]) ? $_GET["dateTo"] : null,
    'perPage' => isset($_GET["perPage"]) ? $_GET["perPage"] : null,
    'status' => isset($_GET["status"]) ? $_GET["status"] : null,

];

$allGetString = http_build_query(array_filter($allGet));
// var_dump($allGetString);

$allGetXV = [
    'search' => isset($_GET["search"]) ? $_GET["search"] : null,
    'type' => isset($_GET["type"]) ? $_GET["type"] : null,
    'level' => isset($_GET["level"]) ? $_GET["level"] : null,
    'location' => isset($_GET["location"]) ? $_GET["location"] : null,
    'orderby' => isset($_GET["orderby"]) ? $_GET["orderby"] : null,
    'dateFrom' => isset($_GET["dateFrom"]) ? $_GET["dateFrom"] : null,
    'dateTo' => isset($_GET["dateTo"]) ? $_GET["dateTo"] : null,
    'perPage' => isset($_GET["perPage"]) ? $_GET["perPage"] : null,
    'status' => isset($_GET["status"]) ? $_GET["status"] : null,

];

$allGetStringXV = http_build_query(array_filter($allGetXV));
// var_dump($allGetStringXV);
?>

<!-- php &SQL 語法結束 -->
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= isset($_GET["valid"]) ? "【已下架】" : "" ?>課程列表</title>
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/favicon.ico">

    <!-- 外包的CSS在這邊 -->
    <?php include("course_css.php") ?>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include("modal/sidebar.php") ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include("modal/topbar.php") ?>

                <h1 class="text-center text-secondary"><?= isset($_GET["valid"]) ? "【已下架】" : "" ?>課程列表</h1>
                <!-- ↓↓放置內容↓↓-->
                <!-- 本體開始 -->
                <div>
                    <!-- container 開始  -->
                    <div class="container">
                        <!-- 警告視窗 modal -->
                        <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModal" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="modal-title " id="">訊息</div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="" id="modalError"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">關閉</button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- 警告視窗 modal end-->
                        <!-- 標題區 -->
                        <div class="py-2">
                            <div class="d-flex  my-3">
                                <!-- 課程狀態 -->
                                <div class="">
                                    <a class="btn btn-outline-secondary rounded-pill me-2 <?= $countAll== $totalResult ? "active" : "" ?> " href="course_list.php<?= isset($_GET["valid"]) ? "?valid=".$_GET["valid"] : "" ?>">全部課程<span class="badge rounded-pill text-bg-light ms-2 "><?= $countAll ?></span></a>

                                    <a class="btn btn-outline-secondary rounded-pill me-2 <?=isset($_GET["status"]) && $_GET["status"]=="signOff"?"active":""?>" href="course_list.php?status=signOff<?= isset($_GET["valid"]) ? "&valid=".$_GET["valid"] : "" ?>" >報名未開放<span class="badge rounded-pill text-bg-light ms-2 "><?= $countSignOff ?></span></a>
                                    <a class="btn btn-outline-secondary rounded-pill me-2 <?=isset($_GET["status"]) && $_GET["status"]=="signing"?"active":""?>" href="course_list.php?status=signing<?= isset($_GET["valid"]) ? "&valid=".$_GET["valid"] : "" ?>" >報名開放中<span class="badge rounded-pill text-bg-light ms-2 "><?= $countSigning ?></span></a>
                                    <a class="btn btn-outline-secondary rounded-pill me-2 <?=isset($_GET["status"]) && $_GET["status"]=="courseOn" ? "active":""?>" href="course_list.php?status=courseOn<?= isset($_GET["valid"]) ? "&valid=".$_GET["valid"] : "" ?>" >課程進行中<span class="badge rounded-pill text-bg-light ms-2 "><?= $countCoursing ?></span></a>
                                    <a class="btn btn-outline-secondary rounded-pill me-2 <?=isset($_GET["status"]) && $_GET["status"]=="courseOff"?"active":""?>" href="course_list.php?status=courseOff<?= isset($_GET["valid"]) ? "&valid=".$_GET["valid"] : "" ?>" >已結束課程<span class="badge rounded-pill text-bg-light ms-2 "><?= $countCourseEnd ?></span></a>

                                </div>
                                <?php

                                ?>
                                <?php if ($allGetStringXV != "") : ?>
                                    <a name="" id="" class="btn btn-secondary btn-sm align-self-center ms-3" href="course_list.php<?= isset($_GET["valid"]) ? "?valid=".$_GET["valid"] : "" ?>" role="button"><i class="fa-solid fa-arrow-rotate-left"></i>重置所有篩選</a>
                                <?php endif; ?>
                                <button name="" id="" class="btn btn-warning ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddCrouse"><i class="fa-regular fa-square-plus me-2"></i>新增課程</button>
                            </div>
                        </div>
                        <div class="row  align-items-start ">
                            <div class=" d-flex align-items-center w-auto ms-0">
                                <!-- 每頁筆數 -->
                                <div class="input-group w-auto h-auto me-auto">
                                    <label class="input-group-text text-secondary" for="inputGroupSelect01">每頁筆數</label>
                                    <select class="form-select " id="coursePerPageSelect">
                                        <?php for ($i = 0; $i <= ($totalResult / 5) && $i <= 19; $i++) : ?>
                                            <option value="<?= ($i + 1) * 5 ?>" <?= $perPage == ($i + 1) * 5 ? "selected" : "" ?>><?= ($i + 1) * 5 ?></option>
                                        <?php endfor; ?>
                                    </select>

                                </div>
                                <div class="w-auto ms-3">
                                    <p class="text-center text-secondary m-0">
                                        共 <?= $totalResult ?> 筆，第 <?= $page ?> 頁，共 <?= $totalPage ?> 頁
                                    </p>
                                </div>
                            </div>
                            <div class="row w-auto ms-auto">
                                <!-- 日期搜尋 -->


                                <div class=" w-auto align-items-center">
                                    <form method="GET" action="course_list.php" class="col input-group p-0 ">
                                        <span class="input-group-text text-secondary"><i class="fa-solid fa-filter me-2 "></i>開課日期</span>
                                        <input type="date" aria-label="First name" class="form-control " id="dateFrom">
                                        <span class="input-group-text text-secondary">to</span>
                                        <input type="date" aria-label="Last name" class="form-control" id="dateTo">
                                    </form>
                                </div>
                                <!-- 關鍵字搜尋 -->
                                <div class="ms-auto w-auto align-items-center">
                                    <form method="GET" action="course_list.php" class="col input-group p-0 ">
                                        <?php if(isset($_GET["valid"])): ?>
                                            <input type="number" class="form-control d-none" name="valid" value="<?=$_GET["valid"]?>"> 
                                            <?php endif;?>   
                                            <div class="col input-group mb-3 pe-0">
                                            <input type="text" class="form-control" name="search" placeholder="關鍵字搜尋" value="<?= isset($_GET["search"]) ?  $_GET["search"] : "" ?>">
                                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- 篩選區 -->
                        <div class="mb-3 row g-3 align-bottom">

                            <!-- 類別篩選 -->
                            <div class="col-auto btn-group ">

                                <a href="course_list.php?<?= preg_replace('/type=\d+/', '', $allGetString) ?>" class="btn btn-outline-secondary btn <?= isset($_GET["type"]) ? "" : "active" ?>" aria-current="page">全部</a>
                                <?php foreach ($typeRows as $type) : ?>
                                    <a href="course_list.php?<?= isset($_GET["type"]) ? preg_replace('/type=\d+/', 'type=' . $type["course_type_id"], $allGetString) : $allGetString . '&type=' . $type["course_type_id"] ?>" class="btn btn-outline-secondary btn <?= isset($_GET["type"]) && $_GET["type"] == $type["course_type_id"] ? "active" : "" ?>"><?= $type["course_type_name"] ?></a>
                                <?php endforeach; ?>

                            </div>
                            <!-- 難度篩選 -->
                            <div class="col-auto btn-group">

                                <a href="course_list.php?<?= preg_replace('/level=\d+/', '', $allGetString) ?>" class="btn btn-outline-secondary btn <?= isset($_GET["level"]) ? "" : "active" ?>" aria-current="page">全部</a>
                                <?php foreach ($levelRows as $level) : ?>
                                    <a href="course_list.php?<?= isset($_GET["level"]) ? preg_replace('/level=\d+/', 'level=' . $level["course_level_id"], $allGetString) : $allGetString . '&level=' . $level["course_level_id"] ?>" class="btn btn-outline-secondary btn 
                                    <?= isset($_GET["level"]) && $_GET["level"] == $level["course_level_id"] ? "active" : "" ?>"><?= $level["course_level_name"] ?></a>
                                <?php endforeach; ?>

                            </div>
                            <!-- 地區篩選 -->
                            <div class="col-auto btn-group">

                                <a href="course_list.php?<?= preg_replace('/location=\d+/', '', $allGetString) ?>" class="btn btn-outline-secondary btn <?= isset($_GET["location"]) ? "" : "active" ?>" aria-current="page">全部</a>
                                <?php foreach ($locationRows as $location) : ?>
                                    <a href="course_list.php?<?= isset($_GET["location"]) ? preg_replace('/location=\d+/', 'location=' . $location["course_location_id"], $allGetString) : $allGetString . '&location=' . $location["course_location_id"] ?>" class="btn btn-outline-secondary btn 
                    <?php if (isset($_GET["location"]) && $_GET["location"] == $location["course_location_id"]) echo "active"; ?>"><?= $location["course_location_name"] ?></a>
                                <?php endforeach; ?>
                            </div>
                            <!-- 排序 -->
                            <div class="input-group w-auto h-auto ms-auto">
                                <label class="input-group-text text-secondary" for="inputGroupSelect01"><i class="fa-solid fa-arrows-up-down"></i></label>
                                <select class="form-select" id="courseOrderSelect">
                                    <option value="1" <?= (!isset($_GET["orderby"]) || $_GET["orderby"] == 1) ? "selected" : "" ?>>最近新增優先</option>
                                    <option value="2" <?= (isset($_GET["orderby"]) && $_GET["orderby"] == 2) ? "selected" : "" ?>>報名日期：新→舊</option>
                                    <option value="3" <?= (isset($_GET["orderby"]) && $_GET["orderby"] == 3) ? "selected" : "" ?>>報名日期：舊→新</option>
                                    <option value="4" <?= (isset($_GET["orderby"]) && $_GET["orderby"] == 4) ? "selected" : "" ?>>開課日期：新→舊</option>
                                    <option value="5" <?= (isset($_GET["orderby"]) && $_GET["orderby"] == 5) ? "selected" : "" ?>>開課日期：舊→新</option>
                                </select>
                            </div>

                        </div>


                        <?php if ($totalResult == 0) : ?>
                            <h2 class="text-center mt-5">查無資料，請重新設定篩選條件</h2>
                        <?php else : ?>
                            <div class=""><!-- 課程list -->

                                <table class="table  table-hover  text-center align-middle" id="courseTable">
                                    <thead class="table-secondary align-middle">
                                        <tr>
                                            <th>圖片</th>
                                            <th>名稱</th>
                                            <th>狀態</th>
                                            <th>類型</th>
                                            <th>難度</th>
                                            <th>老師</th>
                                            <th>價格</th>
                                            <th>人數</th>
                                            <th>地點</th>
                                            <th>報名日期</th>
                                            <th>課程日期</th>
                                            <th>編輯</th>
                                            <th><?= isset($_GET["valid"]) ? "上架" : "下架" ?></th>
                                            <?php if (isset($_GET["valid"])) : ?>
                                                <th>刪除</th>
                                            <?php endif ?>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php foreach ($rows as $course) : ?>

                                            <tr>
                                                <td class="p-0">
                                                    <figure class="ratio ratio-1x1 m-0">

                                                        <img class="object-fit-cover card-img-top img-fluid" src="course_image/<?php if ($course["course_image"] != "") : ?><?= $course["course_image"] ?><?php else : ?>example.png
                    <?php endif; ?> " alt="<?= $course["course_name"] ?>">

                                                    </figure>
                                                </td>
                                                <td><?= $course["course_name"] ?></td>
                                                <td><?php
                                                    if ($course["sign_start_date"] == "0000-00-00") {
                                                        echo "日期<br>待定";
                                                    } elseif ($course["course_start_date"] <= date("Y-m-d") && $course["course_end_date"] >= date("Y-m-d")) {
                                                        echo "課程<br>進行中";
                                                    } elseif ($course["sign_start_date"] <= date("Y-m-d") && $course["sign_end_date"] >= date("Y-m-d")) {
                                                        echo "報名<br>開放中";
                                                    } elseif ($course["sign_start_date"] > date("Y-m-d")) {
                                                        echo "報名<br>未開始";
                                                    } elseif ($course["course_end_date"] < date("Y-m-d")) {
                                                        echo "課程<br>已結束";
                                                    } else if($course["sign_end_date"] < date("Y-m-d")) {
                                                        echo "報名<br>已截止";
                                                    }

                                                    ?></td>
                                                <td><?= isset($course["course_type_name"]) ? $course["course_type_name"] : "待定" ?></td>
                                                <td><?= isset($course["course_level_name"]) ? $course["course_level_name"] : "待定" ?></td>
                                                <td><?= isset($course["teacher_id"]) ? $course["teacher_name"] : "待定" ?></td>
                                                <td><i class="fa-solid fa-dollar-sign me-1 text-secondary"></i><?= isset($course["course_price"]) && $course["course_price"] != 0 ? $course["course_price"] : "待定" ?></td>
                                                <td><?= isset($course["course_capacity"]) && $course["course_capacity"] != 0 ? $course["course_capacity"] : "待定" ?> 人</td>
                                                <td><?= isset($course["course_location_name"]) ? $course["course_location_name"] : "待定" ?></td>
                                                <td><?= isset($course["sign_start_date"]) && $course["sign_start_date"] != "0000-00-00" ? $course["sign_start_date"] : "待定" ?><br>
                                                    <?= isset($course["sign_end_date"]) && $course["sign_end_date"] != "0000-00-00" ? $course["sign_end_date"] : "待定" ?></td>
                                                <td><?= isset($course["course_start_date"]) && $course["course_start_date"] != "0000-00-00" ? $course["course_start_date"] : "待定" ?><br>
                                                    <?= isset($course["course_end_date"]) && $course["course_end_date"] != "0000-00-00" ? $course["course_end_date"] : "待定" ?></td>

                                                <td>
                                                    <!-- 編輯按鈕 -->
                                                    <button class="editCourseBtn btn btn-outline-dark border-0 " data-id="<?= $course["course_id"] ?>" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEditCrouse" title="編輯">
                                                        <i class="fa-solid fa-pen-to-square"></i></button>
                                                </td>
                                                <td>
                                                    <!-- 上/下架按鈕 -->
                                                    <button data-id="<?= $course["course_id"] ?>" data-valid=<?= $course["course_valid"] ?> class="btn btn-outline-dark border-0 editCourseValid" title="<?= isset($_GET["valid"]) ? "上架" : "下架" ?>"><i class=" <?= isset($_GET["valid"]) ? "fa-solid fa-reply" : " fa-solid fa-arrow-up-from-bracket fa-rotate-180" ?>"></i></button>
                                                </td>
                                                <?php if (isset($_GET["valid"])) : ?>
                                                    <!-- 刪除按鈕 -->
                                                    <td>
                                                        <button data-id="<?= $course["course_id"] ?>" class="deleteCourseBtn btn btn-outline-danger border-0  " title="刪除">
                                                            <i class=" fa-solid fa-trash-can"></i></button>
                                                    </td>
                                                <?php endif ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <div class="">
                                    <p class="text-center text-secondary">
                                        共 <?= $totalResult ?> 筆，第 <?= $page ?> 頁，共 <?= $totalPage ?> 頁
                                    </p>
                                </div>

                            </div><!-- 課程list end-->

                            <!-- 頁碼 -->
                            <div class="mb-3">
                                <nav aria-label="Page-navigation" class=" d-flex justify-content-center">
                                    <div class="btn-group  ">


                                        <a type="button" class="btn btn-outline-secondary    <?php if ($page < 2) echo "disabled" ?>" href="course_list.php?<?= $allGetString . "&" ?>page=<?= $page - 1 ?>"><i class="fa-solid fa-caret-left"></i></a>


                                        <?php for ($i = 1; $i <= $totalPage; $i++) : ?>

                                            <a class="btn btn-outline-secondary <?= ($i == $page) ? "active" : "" ?>" href="course_list.php?<?= $allGetString . "&" ?>page=<?= $i ?>"><?= $i ?></a>

                                        <?php endfor; ?>


                                        <a type="button" class="btn btn-outline-secondary    <?php if ($page >= $totalPage) echo "disabled" ?>" href="course_list.php?<?= $allGetString . "&" ?>page=<?= $page + 1 ?>"><i class="fa-solid fa-caret-right"></i></a>



                                    </div>
                                </nav>
                            </div>
                        <?php endif; ?>
                    </div><!-- container 結束  -->


                    <!-- 下面是點擊才會彈出來的 -->
                    <!-- 編輯課程offcanvas -->
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditCrouse">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title"><i class="fa-solid fa-pen-to-square me-2"></i>編輯課程</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                        </div>
                        <div class="offcanvas-body">
                            <form class="needs-validation " id="editCourseForm" novalidate>
                                <div class="mb-3 w-100  position-relative">
                                    <figure class="upload-container  ratio ratio-16x9 m-0">
                                        <img id="edit_course_img" src="course_image/example.png" alt="" class="object-fit-cover card-img-top">
                                    </figure>
                                    <input type="file" multiple="multiple" name="file" id="edit_course_file" style="display: none;">
                                    <div>
                                        <button class="position-absolute bottom-0 end-0 w-100 btn btn-light rounded-0 opacity-75" type="button" id="edit_course_imgBtn"><i class="fa-solid fa-camera"></i></button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="course_name" class="form-label">課程名稱</label>
                                    <input type="text" class="form-control" id="edit_course_name" name="course_name" value="" required>
                                    <div class="invalid-feedback">請輸入課程名稱。</div>
                                </div>
                                <div class="row">

                                    <div class="mb-3 col ">
                                        <label for="course_type_name" class="form-label">課程類別</label>
                                        <select class="form-select" id="edit_course_type_id" name="edit_course_type_id" required>
                                            <option value="">請選擇</option>
                                            <?php foreach ($typeRows as $type) : ?>
                                                <option value="<?= $type["course_type_id"] ?>"><?= $type["course_type_name"] ?></option>
                                            <?php endforeach ?>
                                        </select>

                                    </div>

                                    <div class="mb-3 col">
                                        <label for="course_level_name" class="form-label">課程難度</label>
                                        <select class="form-select" id="edit_course_level_id" name="edit_course_level_id" required>
                                            <option value="">請選擇</option>
                                            <?php foreach ($levelRows as $level) : ?>
                                                <option value="<?= $level["course_level_id"] ?>"><?= $level["course_level_name"] ?></option>
                                            <?php endforeach ?>
                                        </select>

                                    </div>



                                    <div class="mb-3 col">
                                        <label for="course_teacher_name" class="form-label">授課老師</label>
                                        <select class="form-select" id="edit_course_teacher_id" name="edit_course_teacher_id">
                                            <option value="">請選擇</option>
                                            <?php foreach ($teacherRows as $teacher) : ?>
                                                <option value="<?= $teacher["teacher_id"] ?>"><?= $teacher["teacher_name"] ?></option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col">
                                        <label for="course_location_name" class="form-label">授課地點</label>
                                        <select class="form-select" id="edit_course_location_id" name="edit_course_location_id" required>
                                            <option value="">請選擇</option>
                                            <?php foreach ($locationRows as $location) : ?>
                                                <option value="<?= $location["course_location_id"] ?>"><?= $location["course_location_name"] ?></option>
                                            <?php endforeach ?>
                                        </select>

                                    </div>

                                    <div class="mb-3 col">
                                        <label for="course_price" class="form-label">價格</label>
                                        <input type="number" class="form-control" id="edit_course_price" name="course_price" required>
                                        <div class="invalid-feedback">請輸入價格。</div>
                                    </div>
                                    <div class="mb-3 col">
                                        <label for="edit_course_capacity" class="form-label">人數</label>
                                        <input type="number" class="form-control" id="edit_course_capacity" name="course_capacity" required>
                                        <div class="invalid-feedback">請輸入人數。</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <label for="sign_start_date" class="form-label">報名開始</label>
                                        <input type="date" class="form-control" id="edit_sign_start_date" name="sign_start_date" required>
                                        <div class="invalid-feedback col-6">請選擇報名開始日期。</div>
                                    </div>

                                    <div class="mb-3 col-6">
                                        <label for="sign_end_date" class="form-label">報名結束</label>
                                        <input type="date" class="form-control" id="edit_sign_end_date" name="sign_end_date" required>
                                        <div class="invalid-feedback col-6">請選擇報名結束日期。</div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="mb-3 col-6">
                                        <label for="course_start_date" class="form-label">課程開始</label>
                                        <input type="date" class="form-control" id="edit_course_start_date" name="course_start_date" required>
                                        <div class="invalid-feedback col-6">請選擇課程開始日期。</div>
                                    </div>

                                    <div class="mb-3 col-6">
                                        <label for="course_end_date" class="form-label">課程結束</label>
                                        <input type="date" class="form-control" id="edit_course_end_date" name="course_end_date" required>
                                        <div class="invalid-feedback col-6">請選擇課程結束日期。</div>
                                    </div>
                                </div>



                                <div class="mb-3">
                                    <label for="course_description" class="form-label">簡介</label>
                                    <textarea class="form-control" id="edit_course_description" name="course_description " rows="5" style="resize:none"></textarea>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-warning" id="sendEditCourse" type="button"><i class="fa-solid fa-pen-to-square me-2"></i>送出修改</button>

                                </div>
                            </form>

                        </div>
                    </div><!-- 編輯課程offcanvas end-->

                    <!-- 新增課程offcanvas -->
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddCrouse">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title"><i class="fa-regular fa-square-plus me-2"></i>新增課程</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                        </div>
                        <div class="offcanvas-body">
                            <form class="needs-validation " id="addCourseForm" enctype="multipart/form-data" novalidate>
                                <div class="mb-3 w-100  position-relative">
                                    <figure class="upload-container  ratio ratio-16x9 m-0">
                                        <img id="add_course_img" src="course_image/example.png" alt="" class="object-fit-cover card-img-top">
                                    </figure>
                                    <input type="file" name="file" id="add_course_file" style="display: none;">
                                    <div>
                                        <div class="position-absolute bottom-0 end-0 w-100 btn btn-light rounded-0 opacity-75" id="add_course_imgBtn"><i class="fa-solid fa-camera"></i></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="course_name" class="form-label">課程名稱</label>
                                    <input type="text" class="form-control" id="add_course_name" name="course_name" required>
                                    <div class="invalid-feedback">請輸入課程名稱。</div>
                                </div>
                                <div class="row">

                                    <div class="mb-3 col ">
                                        <label for="course_type_name" class="form-label">課程類別</label>
                                        <select class="form-select" id="add_course_type_id" name="add_course_type_id" required>
                                            <option value="">請選擇</option>
                                            <?php foreach ($typeRows as $type) : ?>
                                                <option value="<?= $type["course_type_id"] ?>"><?= $type["course_type_name"] ?></option>
                                            <?php endforeach ?>
                                        </select>

                                    </div>

                                    <div class="mb-3 col">
                                        <label for="course_level_name" class="form-label">課程難度</label>
                                        <select class="form-select" id="add_course_level_id" name="add_course_level_id" required>
                                            <option value="">請選擇</option>
                                            <?php foreach ($levelRows as $level) : ?>
                                                <option value="<?= $level["course_level_id"] ?>"><?= $level["course_level_name"] ?></option>
                                            <?php endforeach ?>
                                        </select>

                                    </div>
                                    <div class="mb-3 col">
                                        <label for="course_teacher_name" class="form-label">授課老師</label>
                                        <select class="form-select" id="add_course_teacher_id" name="add_course_teacher_id">
                                            <option value="">請選擇</option>
                                            <?php foreach ($teacherRows as $teacher) : ?>
                                                <option value="<?= $teacher["teacher_id"] ?>"><?= $teacher["teacher_name"] ?></option>
                                            <?php endforeach; ?>


                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col">
                                        <label for="course_location_name" class="form-label">授課地點</label>
                                        <select class="form-select" id="add_course_location_id" name="add_course_location_id" required>
                                            <option value="">請選擇</option>
                                            <?php foreach ($locationRows as $location) : ?>
                                                <option value="<?= $location["course_location_id"] ?>"><?= $location["course_location_name"] ?></option>
                                            <?php endforeach ?>
                                        </select>

                                    </div>

                                    <div class="mb-3 col">
                                        <label for="course_price" class="form-label">價格</label>
                                        <input type="number" class="form-control" id="add_course_price" name="course_price" required>
                                        <div class="invalid-feedback">請輸入價格。</div>
                                    </div>
                                    <div class="mb-3 col">
                                        <label for="add_course_capacity" class="form-label">人數</label>
                                        <input type="number" class="form-control" id="add_course_capacity" name="course_capacity" required>
                                        <div class="invalid-feedback">請輸入人數。</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <label for="sign_start_date" class="form-label">報名開始</label>
                                        <input type="date" class="form-control" id="add_sign_start_date" name="sign_start_date" required>
                                        <div class="invalid-feedback col-6">請選擇報名開始日期。</div>
                                    </div>

                                    <div class="mb-3 col-6">
                                        <label for="sign_end_date" class="form-label">報名結束</label>
                                        <input type="date" class="form-control" id="add_sign_end_date" name="sign_end_date" required>
                                        <div class="invalid-feedback col-6">請選擇報名結束日期。</div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="mb-3 col-6">
                                        <label for="course_start_date" class="form-label">課程開始</label>
                                        <input type="date" class="form-control" id="add_course_start_date" name="course_start_date" required>
                                        <div class="invalid-feedback col-6">請選擇課程開始日期。</div>
                                    </div>

                                    <div class="mb-3 col-6">
                                        <label for="course_end_date" class="form-label">課程結束</label>
                                        <input type="date" class="form-control" id="add_course_end_date" name="course_end_date" required>
                                        <div class="invalid-feedback col-6">請選擇課程結束日期。</div>
                                    </div>
                                </div>



                                <div class="mb-3">
                                    <label for="course_description" class="form-label">簡介</label>
                                    <textarea class="form-control" id="add_course_description" name="course_description " rows="5" style="resize:none"></textarea>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-secondary" id="resetAddCourse" type="button">清除</button>
                                    <button class="btn btn-warning" id="sendAddCourse" type="button"><i class="fa-regular fa-square-plus me-2"></i>新增課程</button>

                                </div>
                            </form>

                        </div>
                    </div><!-- 新增程offcanvas end-->
                </div>
            </div>
            <!-- 本體結束 -->
            <?php include("modal/footer.php") ?>

            <!-- JavaScript一坨坨程式碼開始 -->
            <!-- 外包的JS -->
            <?php include("course_js.php") ?>
            <!--  警告視窗 -->
            <script>
                const infoModal = new bootstrap.Modal("#infoModal");
                const modalError = document.querySelector("#modalError")
            </script>
            <!-- 筆數變更自動前往 -->
            <script>
                const coursePerPageSelect = document.querySelector("#coursePerPageSelect")
                coursePerPageSelect.addEventListener("change", function() {
                    let coursePerPageSelectValue = coursePerPageSelect.value
                    let redirectUrl = `course_list.php?<?= isset($_GET["perPage"]) ? preg_replace('/perPage=\d+/', "", $allGetString) : $allGetString ?>&perPage=${coursePerPageSelectValue}`
                    window.location.href = redirectUrl;
                })
            </script>
            <!-- 排序變更自動前往 -->
            <script>
                const courseOrderSelect = document.querySelector("#courseOrderSelect")
                courseOrderSelect.addEventListener("change", function() {
                    let courseOrderSelectValue = courseOrderSelect.value
                    let redirectUrl = `course_list.php?<?= isset($_GET["orderby"]) ? preg_replace('/orderby=\d+/', "", $allGetString) : $allGetString ?>&orderby=${courseOrderSelectValue}`
                    window.location.href = redirectUrl;
                })
            </script>

            <!-- 日期輸入自動前往 -->
            <script>
                const dateFrom = document.querySelector("#dateFrom")
                const dateTo = document.querySelector("#dateTo")
                let urlParams = new URLSearchParams(window.location.search)
                //預設顯示
                if (urlParams.get('dateFrom')) {
                    dateFrom.value = urlParams.get('dateFrom');

                }
                if (urlParams.get('dateTo')) {
                    dateTo.value = urlParams.get('dateTo');
                }

                dateFrom.addEventListener('change', dateSent);
                dateTo.addEventListener('change', dateSent);

                function dateSent() {
                    let dateFromValue = dateFrom.value
                    let dateToValue = dateTo.value
                    let redirectUrl
                    if (dateFromValue && dateToValue) {
                        <?php $allGetStringNoDate = preg_replace('/(dateFrom=[^&]+)/', '', $allGetString);
                        $allGetStringNoDate = preg_replace('/(dateTo=[^&]+)/', '', $allGetStringNoDate)
                        ?>
                        redirectUrl = `course_list.php?<?= $allGetStringNoDate ?>&dateFrom=${dateFromValue}&dateTo=${dateToValue}`;

                    } else if (dateFromValue) {
                        redirectUrl = `course_list.php?<?= preg_replace('/(dateFrom=[^&]+)/', '', $allGetString) ?>&dateFrom=${dateFromValue}`;
                    } else if (dateToValue) {
                        redirectUrl = `course_list.php?<?= preg_replace('/(dateTo=[^&]+)/', '', $allGetStringNoDate) ?>&dateTo=${dateToValue}`
                    }
                    window.location.href = redirectUrl;

                }
            </script>
            <!-- JS新增課程 -->
            <script>
                //新增課程表單清除
                const addCourseForm = document.querySelector("#addCourseForm")
                const resetAddCourse = document.querySelector("#resetAddCourse")
                resetAddCourse.addEventListener("click", function() {
                    addCourseForm.reset();
                    addCourseForm.classList.remove('was-validated');
                    addCourseImg.src = "course_image/example.png";
                })

                // 新增課程驗證
                const sendAddCourse = document.querySelector("#sendAddCourse")

                //圖片預覽
                const addCourseImgBtn = document.querySelector("#add_course_imgBtn")
                const addCourseFile = document.querySelector("#add_course_file")
                const addCourseImg = document.querySelector("#add_course_img");
                addCourseImgBtn.addEventListener('click', () => {
                    addCourseFile.click();
                });
                addCourseFile.addEventListener('change', function() {
                    const reader = new FileReader();
                    reader.onload = function() {
                        addCourseImg.src = reader.result;
                    }
                    reader.readAsDataURL(this.files[0]);

                });

                // 將新增課程表單用ajax傳到addCourse.php
                const addCourseName = document.querySelector("#add_course_name");
                const addCourseTypeId = document.querySelector("#add_course_type_id");
                const addCourseLevelId = document.querySelector("#add_course_level_id");
                const addCoursePrice = document.querySelector("#add_course_price");
                const addCourseCapacity = document.querySelector("#add_course_capacity");
                const addCourseTeacherId = document.querySelector("#add_course_teacher_id");
                const addCourseLocationId = document.querySelector("#add_course_location_id");
                const addSignStartDate = document.querySelector("#add_sign_start_date");
                const addSignEndDate = document.querySelector("#add_sign_end_date");
                const addCourseStartDate = document.querySelector("#add_course_start_date");
                const addCourseEndDate = document.querySelector("#add_course_end_date");
                const addCourseDescription = document.querySelector("#add_course_description");

                sendAddCourse.addEventListener("click", function() {
                    // 上傳課程
                    let addCourseNameValue = addCourseName.value
                    let addCourseTypeIdValue = addCourseTypeId.value
                    let addCourseLevelIdValue = addCourseLevelId.value
                    let addCoursePriceValue = addCoursePrice.value
                    let addCourseCapacityValue = addCourseCapacity.value
                    let addCourseTeacherIdValue = addCourseTeacherId.value
                    let addCourseLocationIdValue = addCourseLocationId.value
                    let addSignStartDateValue = addSignStartDate.value
                    let addSignEndDateValue = addSignEndDate.value
                    let addCourseStartDateValue = addCourseStartDate.value
                    let addCourseEndDateValue = addCourseEndDate.value
                    let addCourseDescriptionValue = addCourseDescription.value
                    // 檢查file有無
                    let addCourseFileName = "";
                    if (addCourseFile.files[0]) {
                        addCourseFileName = addCourseFile.files[0].name
                    } else {
                        addCourseFileName = "example.png"
                    };

                    $.ajax({
                            method: "POST",
                            url: "action/course/doAddCourse.php",
                            dataType: "json",
                            data: {
                                courseName: addCourseNameValue,
                                courseTypeId: addCourseTypeIdValue,
                                courseLevelId: addCourseLevelIdValue,
                                coursePrice: addCoursePriceValue,
                                courseCapacity: addCourseCapacityValue,
                                courseTeacherId: addCourseTeacherIdValue,
                                courseLocationId: addCourseLocationIdValue,
                                signStartDate: addSignStartDateValue,
                                signEndDate: addSignEndDateValue,
                                courseStartDate: addCourseStartDateValue,
                                courseEndDate: addCourseEndDateValue,
                                courseDescription: addCourseDescriptionValue,
                                courseImage: addCourseFileName
                            }

                        })
                        .done(function(response) {
                            // console.log(response)

                            let status = response.status;
                            // console.log(status)
                            if (status == 0) { //新增課程失敗
                                // error.innerText=response.message;
                                modalError.innerText = response.message;
                                infoModal.show();
                            } else { //新增課程成功
                                // 先判斷input有無圖片
                                modalError.innerText = response.message;
                                if (!addCourseFile.files[0]) {
                                    //無圖片，不複製圖片，但顯示新增課程成功，然後刷新頁面
                                    // console.log("noPIC");
                                    infoModal.show();
                                    setTimeout(function() {
                                        location.href = "course_list.php";
                                    }, 3000);
                                } else {
                                    //有圖片將input圖片複製到course_image資料夾
                                    const file = addCourseFile.files[0];
                                    const formData = new FormData();
                                    formData.append('file', file);
                                    $.ajax({
                                            method: "POST",
                                            url: "action/course/doCopyCoursePic.php",
                                            dataType: "json",
                                            data: formData,
                                            processData: false,
                                            contentType: false,

                                        })
                                        .done(function(response) {
                                            let status = response.status;
                                            // console.log(status)
                                            if (status == 0) { //複製失敗
                                                // error.innerText=response.message;
                                                modalError.innerText = response.message;
                                                infoModal.show();
                                            } else {
                                                //複製成功
                                                infoModal.show();
                                                setTimeout(function() {
                                                    location.href = "course_list.php";
                                                }, 2000);
                                            }
                                        }).fail(function(jqXHR, textStatus) {
                                            console.log("PicRequest failed: " + textStatus);
                                        });
                                }
                            }

                        }).fail(function(jqXHR, textStatus) {
                            console.log("courseRequest failed: " + textStatus);
                        });

                });
            </script>

            <!-- JS編輯課程 -->
            <script>
                //圖片預覽
                const editCourseImgBtn = document.querySelector("#edit_course_imgBtn")
                const editCourseFile = document.querySelector("#edit_course_file")
                const editCourseImg = document.querySelector("#edit_course_img");
                editCourseImgBtn.addEventListener('click', () => {
                    editCourseFile.click();
                });
                editCourseFile.addEventListener('change', function() {
                    const reader = new FileReader();
                    reader.onload = function() {
                        editCourseImg.src = reader.result;
                    }
                    reader.readAsDataURL(this.files[0]);

                });

                const editCourseName = document.querySelector("#edit_course_name");
                const editCourseTypeId = document.querySelector("#edit_course_type_id");
                const editCourseLevelId = document.querySelector("#edit_course_level_id");
                const editCoursePrice = document.querySelector("#edit_course_price");
                const editCourseCapacity = document.querySelector("#edit_course_capacity");
                const editCourseTeacherId = document.querySelector("#edit_course_teacher_id");
                const editCourseLocationId = document.querySelector("#edit_course_location_id");
                const editSignStartDate = document.querySelector("#edit_sign_start_date");
                const editSignEndDate = document.querySelector("#edit_sign_end_date");
                const editCourseStartDate = document.querySelector("#edit_course_start_date");
                const editCourseEndDate = document.querySelector("#edit_course_end_date");
                const editCourseDescription = document.querySelector("#edit_course_description");



                const editCourseBtns = document.querySelectorAll(".editCourseBtn");
                const sendEditCourse = document.querySelector("#sendEditCourse")
                //編輯視窗預設顯示該筆資料
                for (let i = 0; i < editCourseBtns.length; i++) {
                    editCourseBtns[i].addEventListener("click", function() {
                        let id = this.dataset.id
                        sendEditCourse.setAttribute("data-id", id);

                        $.ajax({
                                method: "POST", //or GET
                                url: "action/course/getCourse.php",
                                dataType: "json",
                                data: {
                                    id: id
                                } //如果需要
                            })
                            .done(function(response) {
                                let status = response.status;

                                // console.log(response)

                                if (status == 1) {
                                    editCourseName.value = response.crouse.course_name;
                                    editCourseTypeId.value = response.crouse.course_type_id;
                                    editCourseLevelId.value = response.crouse.course_level_id;
                                    editCoursePrice.value = response.crouse.course_price;
                                    editCourseCapacity.value = response.crouse.course_capacity;
                                    editCourseTeacherId.value = response.crouse.teacher_id;
                                    editCourseLocationId.value = response.crouse.course_location_id;
                                    editSignStartDate.value = response.crouse.sign_start_date;
                                    editSignEndDate.value = response.crouse.sign_end_date;
                                    editCourseStartDate.value = response.crouse.course_start_date;
                                    editCourseEndDate.value = response.crouse.course_end_date;
                                    editCourseDescription.value = response.crouse.course_description;



                                    if (response.crouse.course_image) {
                                        editCourseImg.src = "course_image/" + response.crouse.course_image
                                    } else {
                                        editCourseImg.src = "course_image/example.png"
                                    }



                                } else {
                                    //無資料或參數錯誤
                                    alert(status.message)
                                }
                                // console.log(response)
                            }).fail(function(jqXHR, textStatus) {
                                console.log("Request failed: " + textStatus);
                            });


                    })



                    //送出修改後資料
                }
                // 送出編輯課程資料
                sendEditCourse.addEventListener("click", function() {
                    let editCourseNameValue = editCourseName.value
                    let editCourseTypeIdValue = editCourseTypeId.value
                    let editCourseLevelIdValue = editCourseLevelId.value
                    let editCoursePriceValue = editCoursePrice.value
                    let editCourseCapacityValue = editCourseCapacity.value
                    let editCourseTeacherIdValue = editCourseTeacherId.value
                    let editCourseLocationIdValue = editCourseLocationId.value
                    let editSignStartDateValue = editSignStartDate.value
                    let editSignEndDateValue = editSignEndDate.value
                    let editCourseStartDateValue = editCourseStartDate.value
                    let editCourseEndDateValue = editCourseEndDate.value
                    let editCourseDescriptionValue = editCourseDescription.value
                    let id = this.dataset.id
                    // 檢查file有無
                    let editCourseFileName = "";
                    if (editCourseFile.files[0]) {
                        editCourseFileName = editCourseFile.files[0].name
                    } else {
                        editCourseFileName = "noChange"
                    };
                    $.ajax({
                            method: "POST",
                            url: "action/course/doUpdateCourse.php",
                            dataType: "json",
                            data: {
                                id: id,
                                courseName: editCourseNameValue,
                                courseTypeId: editCourseTypeIdValue,
                                courseLevelId: editCourseLevelIdValue,
                                coursePrice: editCoursePriceValue,
                                courseCapacity: editCourseCapacityValue,
                                courseTeacherId: editCourseTeacherIdValue,
                                courseLocationId: editCourseLocationIdValue,
                                signStartDate: editSignStartDateValue,
                                signEndDate: editSignEndDateValue,
                                courseStartDate: editCourseStartDateValue,
                                courseEndDate: editCourseEndDateValue,
                                courseDescription: editCourseDescriptionValue,
                                courseImage: editCourseFileName
                            }

                        })
                        .done(function(response) {

                            // console.log(response)

                            let status = response.status;
                            // console.log(status)
                            if (status == 0) { //編輯課程失敗
                                // error.innerText=response.message;
                                modalError.innerText = response.message;
                                infoModal.show();
                            } else { //編輯課程成功
                                modalError.innerText = response.message;
                                // 先判斷圖片input有無
                                if (!editCourseFile.files[0]) {
                                    //無圖片，不複製圖片，但顯示更新課程成功，然後刷新頁面
                                    infoModal.show();
                                    setTimeout(function() {
                                        location.href = "course_list.php<?= isset($_GET["valid"]) ? "?valid=".$_GET["valid"] : "" ?>";
                                    }, 3000);
                                } else {
                                    //有圖片將input圖片複製到course_image資料夾
                                    const file = editCourseFile.files[0];
                                    const formData = new FormData();
                                    formData.append('file', file);
                                    $.ajax({
                                            method: "POST",
                                            url: "action/course/doCopyCoursePic.php",
                                            dataType: "json",
                                            data: formData,
                                            processData: false,
                                            contentType: false,

                                        })
                                        .done(function(response) {
                                            let status = response.status;
                                            // console.log(status)
                                            if (status == 0) { //複製失敗
                                                // error.innerText=response.message;
                                                modalError.innerText = response.message;
                                                infoModal.show();
                                            } else {
                                                //複製成功
                                                infoModal.show();
                                                setTimeout(function() {
                                                    location.href = "course_list.php<?= isset($_GET["valid"]) ? "?valid=".$_GET["valid"] : "" ?>";
                                                }, 2000);
                                            }
                                        }).fail(function(jqXHR, textStatus) {
                                            console.log("PicRequest failed: " + textStatus);
                                        });
                                }

                                infoModal.show();
                                setTimeout(function() {
                                    location.href = "course_list.php<?= isset($_GET["valid"]) ? "?valid=2" : "" ?>";
                                }, 2000);
                            }

                            // console.log(response)

                            // console.log(response)
                        }).fail(function(jqXHR, textStatus) {
                            console.log("Request failed: " + textStatus);
                        });

                })
            </script>

            <!-- JS上下架課程 -->
            <script>
                const editCourseValidBtns = document.querySelectorAll(".editCourseValid")
                for (let i = 0; i < editCourseValidBtns.length; i++) {
                    editCourseValidBtns[i].addEventListener("click", function() {
                        let id = this.dataset.id
                        let valid = this.dataset.valid
                        $.ajax({
                                method: "POST", //or GET
                                url: "action/course/doUpdateCourseValid.php",
                                dataType: "json",
                                data: {
                                    id: id,
                                    valid: valid
                                }
                            })
                            .done(function(response) {
                                // console.log(response)

                                let status = response.status;
                                // console.log(status)
                                if (status == 0) { //失敗
                                    // error.innerText=response.message;
                                    modalError.innerText = response.message;
                                    infoModal.show();
                                } else { //成功
                                    modalError.innerText = response.message;
                                    infoModal.show();
                                    setTimeout(function() {
                                        location.href = "course_list.php";
                                    }, 2000);
                                }

                                // console.log(response)

                                // console.log(response)
                            }).fail(function(jqXHR, textStatus) {
                                console.log("Request failed: " + textStatus);
                            });
                    })
                }
            </script>

            <!-- JS刪除課程 -->
            <script>
                const deleteCourseBtns = document.querySelectorAll(".deleteCourseBtn")
                for (let i = 0; i < deleteCourseBtns.length; i++) {
                    deleteCourseBtns[i].addEventListener("click", function() {
                        let id = this.dataset.id
                        $.ajax({
                                method: "POST", //or GET
                                url: "action/course/doDeleteCourse.php",
                                dataType: "json",
                                data: {
                                    id: id
                                }
                            })
                            .done(function(response) {
                                // console.log(response)

                                let status = response.status;
                                // console.log(status)
                                if (status == 0) { //失敗
                                    // error.innerText=response.message;
                                    modalError.innerText = response.message;
                                    infoModal.show();
                                } else { //成功
                                    modalError.innerText = response.message;
                                    infoModal.show();
                                    setTimeout(function() {
                                        location.href = "course_list.php<?= isset($_GET["valid"]) ? "?valid=".$_GET["valid"] : "" ?>";
                                    }, 2000);
                                }

                                // console.log(response)

                                // console.log(response)
                            }).fail(function(jqXHR, textStatus) {
                                console.log("Request failed: " + textStatus);
                            });
                    })
                }
            </script>
            <!-- JavaScript一坨坨程式碼結束 -->

            <!-- ↑↑放置內容↑↑ -->
        </div>
        <!-- End of Main Content -->



    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>