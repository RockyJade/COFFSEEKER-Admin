<?php
require_once("../pdo_connect.php");


// 給預設值的縮寫法 同等於if判斷式 如果$_GET["page" 有值帶值 沒有值則帶入 1 (設定預設值)
$page = $_GET["page"] ?? 1;



$sqlTotal = $db_host->prepare("SELECT id FROM users WHERE user_valid=1");
try{
    $sqlTotal->execute();
    $resultTotal = $sqlTotal->fetchAll();
    $totalUser = $sqlTotal->rowCount();
    

}catch(PDOException $e){
    echo "預處理陳述式執行失敗! <br/>";
    echo "Error:" . $e->getMessage() ."<br/>";
    $db_host = NULL;
    exit;
}

// $sqlTotal = "SELECT id FROM users WHERE user_valid=1";

// $resultTotal = $conn->query($sqlTotal);
// $totalUser = $resultTotal->num_rows;


$perPage=10;
$totalPage=ceil($totalUser/$perPage);
// ================================

$type=$_GET["type"] ?? 1;

if($type==1){ 
    $ADESC="ASC";
}elseif($type==2){
    $ADESC="DESC";
}else{
    header("location: ../404.php");
}


// ================================

$startItem = ($page - 1) * $perPage;

$coffsql = $db_host->prepare("SELECT users.* ,

user_grade.grade AS user_grade FROM users 

JOIN user_grade ON user_grade.grade_id = users.user_grade_id

WHERE user_valid = 1 ORDER BY id $ADESC  LIMIT $startItem, $perPage"); 


try{
    $coffsql -> execute(); 
    

}catch(PDOException ){
    echo "預處理陳述式執行失敗! <br/>";
    echo "Error:" . $e->getMessage() ."<br/>";
    $db_host = NULL;
    exit;
}

// $coffsql = $db_host->prepare("SELECT users.* ,

// user_grade.grade AS user_grade FROM users 

// JOIN user_grade ON user_grade.grade_id = users.user_grade_id

// WHERE user_valid = 1 ORDER BY id $ADESC  LIMIT $startItem, $perPage"); 

// $getuser = $conn->query($coffsql);
// $coffusers = $getuser->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>User-List</title>

    <?php include("modal/template.php") ?>
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

                <div class="container-fluid my-5">

                    <h1 class="text-center py-4">會員列表</h1>

                    <div class="pb-2">
                        <form action="user-search.php" method="get">
                            <div class="row gx-2">
                                <div class="col-1">
                                    <select class="form-select form-control" aria-label="Grade" name="select" id="select">
                                        <option value="id" selected>ID</option>
                                        <option value="user_name">名稱</option>
                                        <option value="user_grade_id">等級</option>
                                        <option value="user_email">信箱</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="搜尋關鍵字" name="keyword">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-warning" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>搜尋
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--  -->
                    <div class="pb-2 d-flex justify-content-between align-items-center">
                        <div>
                        全部的資料 共 <?= $totalUser ?> 筆
                        </div>
                    
                        <!-- 升降冪條件 -->
                        <div class="py-2 d-flex justify-content-end">
                            <div class="btn-group">
                                <a href="user-list.php?page=<?= $page ?>&type=1" class="btn btn-warning <?php
                                if($type==1)echo "active";
                                ?>"><i class="fa-solid fa-arrow-down-short-wide"></i></a>
                                <a href="user-list.php?page=<?= $page ?>&type=2" class="btn btn-warning <?php
                                if($type==2)echo "active";
                                ?>"><i class="fa-solid fa-arrow-down-wide-short"></i></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- 頁數 -->
                    <div class="d-flex justify-content-center">
                            <nav aria-label="Page navigation example">
                                <?php
                                $prevPage = $page - 1;
                                $nextPage = $page + 1;
                                ?>
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link border-0 bg-warning" href="user-list.php?page=<?php if($prevPage == 0){echo 1;}else{echo $prevPage;} ?>&type=<?= $type ?>">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php
                                    // 計算顯示的頁碼範圍
                                    $startPage = max($page - 4, 1);
                                    $endPage = min($startPage + 4, $totalPage);?>
                                    
                                    <?php for ($i = $startPage; $i <= $endPage; $i++) : ?>
                                        <li class="page-item <?php if ($i == $page) echo "active";?>">
                                            <a class="page-link text-warning border-0" href="user-list.php?page=<?= $i ?>&type=<?= $type ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    
                            
                                    <li class="page-item">
                                        <a class="page-link border-0 bg-warning" href="user-list.php?page=<?php if($nextPage > $totalPage){echo $nextPage-1;}else{echo $nextPage;} ?>&type=<?= $type ?>">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>



                    <!--  -->
                    <table class="table table-striped text-center table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th>ID</th>
                                <th>名稱</th>
                                <th>性別</th>
                                <th>電話</th>
                                <th>信箱</th>
                                <th>生日</th>
                                <th>加入日期</th>
                                <th>會員等級</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ( $coffsql->fetchAll(PDO::FETCH_ASSOC) as $user ) : ?>
                                <tr>
                                    <td>
                                        <?= $user["id"]; ?>
                                    </td>
                                    <td>
                                        <?= $user["user_name"]; ?>
                                    </td>
                                    <td>
                                        <?= $user["user_gender"]; ?>
                                    </td>
                                    <td>
                                        <?= $user["user_phone"]; ?>
                                    </td>
                                    <td>
                                        <?= $user["user_email"]; ?>
                                    </td>
                                    <td>
                                        <?= $user["user_birthday"]; ?>
                                    </td>
                                    <td>
                                        <?= $user["user_created_at"]; ?>
                                    </td>
                                    <td>
                                        <?= $user["user_grade"]; ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-warning" href="user-detail.php?id=<?= $user["id"] ?>">詳細</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-warning" href="user-list-edit.php?id=<?= $user["id"] ?>">編輯</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                        <!-- 頁數 -->
                        <div class="d-flex justify-content-center">
                            <nav aria-label="Page navigation example">
                                <?php
                                $prevPage = $page - 1;
                                $nextPage = $page + 1;
                                ?>
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link border-0 bg-warning" href="user-list.php?page=<?php if($prevPage == 0){echo 1;}else{echo $prevPage;} ?>&type=<?= $type ?>">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php
                                    // 計算顯示的頁碼範圍
                                    $startPage = max($page - 4, 1);
                                    $endPage = min($startPage + 4, $totalPage);?>
                                    
                                    <?php for ($i = $startPage; $i <= $endPage; $i++) : ?>
                                        <li class="page-item <?php if ($i == $page) echo "active";?>">
                                            <a class="page-link text-warning border-0" href="user-list.php?page=<?= $i ?>&type=<?= $type ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    
                            
                                    <li class="page-item">
                                        <a class="page-link border-0 bg-warning" href="user-list.php?page=<?php if($nextPage > $totalPage){echo $nextPage-1;}else{echo $nextPage;} ?>&type=<?= $type ?>">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="d-flex justify-content-center">
                        共<?=$totalPage?>頁
                    </div>
                </div>
                    
            </div>
            <!-- End of Main Content -->

            <?php include("modal/footer.php") ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

                                    


    <script>
        const select = document.querySelector("#select")

        select.addEventListener("change" , function(){
            let selectedUrl = `user-search.php?select=${select.value}&keyword=`
            window.location.href = selectedUrl;
        })
        // user-search.php?select=user_name&keyword=
    </script>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>