<?php
require_once("../db_connect.php");

$select=$_GET["select"];
$keyword=$_GET["keyword"];

// 給預設值的縮寫法 同等於if判斷式 如果$_GET["page" 有值帶值 沒有值則帶入 1 (設定預設值)
$page = $_GET["page"] ?? 1;

$sqlTotal = "SELECT order_id FROM orders";
$resultTotal = $conn->query($sqlTotal);
$totalUser = $resultTotal->num_rows;


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
$toSql = "SELECT orders.* ,

order_states.states FROM orders 

JOIN order_states ON order_states.states_valid = orders.order_state

WHERE $select LIKE '%$keyword%'";

$selectedOrder = $conn->query($toSql);
$totalOrder = $selectedOrder->num_rows;


$perPage=10;
$totalPage=ceil($totalUser/$perPage);
$startItem = ($page - 1) * $perPage;

$ordersql = "SELECT orders.* ,

order_states.states FROM orders 

JOIN order_states ON order_states.states_valid = orders.order_state

WHERE $select LIKE '%$keyword%' ORDER BY $select $ADESC  LIMIT $startItem, $perPage";

$getOrder = $conn->query($ordersql);
$orders = $getOrder->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Order-List</title>

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

                <div class="container-fluid">

                    <h1 class="text-center py-4">訂單搜尋</h1>

                    <div class="pb-2">
                        <form action="order-search.php" method="get">
                            <div class="row gx-2">
                            <div class="col-auto">
                                    <a class="btn btn-warning" href="order-list.php"><i class="fa-solid fa-reply"></i></a>
                                </div>
                                <div class="col-auto">
                                    <select class="form-select form-control" aria-label="Grade" name="select" id="select">
                                        <option value="order_id" <?php if($select == 'order_id') echo "selected"; ?>>訂單編號</option>
                                        <option value="order_products"<?php if($select == 'order_products') echo "selected"; ?>>購買商品</option>
                                        <option value="order_created_at"<?php if($select == 'order_created_at') echo "selected"; ?>>訂單成立時間</option>
                                        <option value="order_state" <?php if($select == 'order_state') echo "selected"; ?>>訂單狀態</option>
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
                                <a href="order-search.php?page=<?= $page ?>&type=1&select=<?= $select ?>&keyword=<?=$keyword?>" class="btn btn-warning <?php
                                if($type==1)echo "active";
                                ?>"><i class="fa-solid fa-arrow-down-short-wide"></i></a>
                                <a href="order-search.php?page=<?= $page ?>&type=2&select=<?= $select ?>&keyword=<?=$keyword?>" class="btn btn-warning <?php
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
                                        <a class="page-link border-0 bg-warning" href="order-search.php?page=<?php if($prevPage == 0){echo 1;}else{echo $prevPage;} ?>&type=<?= $type ?>&select=<?= $select ?>&keyword=<?=$keyword?>">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php
                                    // 計算顯示的頁碼範圍
                                    $startPage = max($page - 4, 1);
                                    $endPage = min($startPage + 4, $totalPage);?>
                                    
                                    <?php for ($i = $startPage; $i <= $endPage; $i++) : ?>
                                        <li class="page-item <?php if ($i == $page) echo "active";?>">
                                            <a class="page-link text-warning border-0" href="order-search.php?page=<?= $i ?>&type=<?= $type ?>&select=<?= $select ?>&keyword=<?=$keyword?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    
                            
                                    <li class="page-item">
                                        <a class="page-link border-0 bg-warning" href="order-search.php?page=<?php if($nextPage > $totalPage){echo $nextPage-1;}else{echo $nextPage;} ?>&type=<?= $type ?>&select=<?= $select ?>&keyword=<?=$keyword?>">
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
                                <th class="col-1">訂單編號</th>
                                <th class="col-4">購買商品</th>
                                <th class="col-1">訂單總價</th>
                                <th class="col-1">購買人</th>
                                <th class="col-2">成立時間</th>
                                <th class="col-1">訂單狀態</th>
                                <th class="col-2"></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($orders as $order) : ?>
                                <tr>
                                    <td>
                                        <?= $order["order_id"]; ?>
                                    </td>
                                    <td>
                                        <?= $order["order_products"]; ?>
                                    </td>
                                    <td>
                                        <?= $order["order_price"]; ?>
                                    </td>
                                    <td>
                                        <?= $order["order_user"]; ?>
                                    </td>
                                    <td>
                                        <?= $order["order_created_at"]; ?>
                                    </td>
                                    <td>
                                        <?= $order["states"]; ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-warning" href="order-detail-Edit.php?order_id=<?= $order["order_id"] ?>">訂單明細與狀態更新</a>
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
                                        <a class="page-link border-0 bg-warning" href="order-search.php?page=<?php if($prevPage == 0){echo 1;}else{echo $prevPage;} ?>&type=<?= $type ?>&select=<?= $select ?>&keyword=<?=$keyword?>">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php
                                    // 計算顯示的頁碼範圍
                                    $startPage = max($page - 4, 1);
                                    $endPage = min($startPage + 4, $totalPage);?>
                                    
                                    <?php for ($i = $startPage; $i <= $endPage; $i++) : ?>
                                        <li class="page-item <?php if ($i == $page) echo "active";?>">
                                            <a class="page-link text-warning border-0" href="order-search.php?page=<?= $i ?>&type=<?= $type ?>&select=<?= $select ?>&keyword=<?=$keyword?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    
                            
                                    <li class="page-item">
                                        <a class="page-link border-0 bg-warning" href="order-search.php?page=<?php if($nextPage > $totalPage){echo $nextPage-1;}else{echo $nextPage;} ?>&type=<?= $type ?>&select=<?= $select ?>&keyword=<?=$keyword?>">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
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
            let selectedUrl = `order-search.php?select=${select.value}&keyword=`
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