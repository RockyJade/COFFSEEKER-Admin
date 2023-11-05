<?php

require_once("../db_connect.php");

$type = $_GET["type"] ?? 1;

if (isset($_GET["coupon_name"])) {
    $name = $_GET["coupon_name"];

    if (!empty($_GET["coupon_name"])) {
        if ($type == 1) {
            $orderBy = "AND coupon_valid";
        } elseif ($type == 2) {
            $orderBy = "AND coupon_valid = 1";
        } elseif ($type == 3) {
            $orderBy = "AND coupon_valid = -1";
        } else {
            header("location: 404.php");
        }
        $sql1 = "SELECT coupon_id, coupon_name, coupon_code, coupon_valid, discount_type, discount_value, created_at, expires_at, updated_at, max_usage, usage_restriction, valid_description,start_at,price_min FROM coupon WHERE coupon_name LIKE '%$name%' $orderBy AND coupon_valid";
        $sql2 = "SELECT coupon_id, coupon_name, coupon_code, coupon_valid, discount_type, discount_value, created_at, expires_at, updated_at, max_usage, usage_restriction, valid_description,start_at,price_min FROM coupon WHERE coupon_name LIKE '%$name%' $orderBy AND coupon_valid";
        $sql = "$sql1 UNION $sql2";

        $result = $conn->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $coupon_count = $result->num_rows;
    } else {
        $coupon_count = 0;
    }
} else {
    $coupon_count = 0;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>搜尋優惠卷</title>

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
                <!-- ↓↓放置內容↓↓-->

                <div class="container-fluid my-5">
                    <h1 class="text-center">搜尋優惠卷</h1>
                    <div class="py-2 mb-2">
                        <a class="btn btn-warning" href="coupon-list.php">回優惠卷列表</a>
                    </div>
                    <div class="py-2">
                        <form action="coupon-search.php">
                            <div class="row gx-2">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="請輸入優惠卷名稱" name="coupon_name">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-warning" type="submit">搜尋</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="py-2 d-flex justify-content-between align-items-center">
                        <?php if (isset($_GET["coupon_name"])) : ?>
                            <div>
                                搜尋 <?= $name ?> 的結果, 共有 <?= $coupon_count ?> 筆符合的資料
                            </div>
                        <?php endif; ?>
                        <div class="py-2 d-flex justify-content-end">
                            <div class="">優惠卷狀態為：
                                <a href="Coupon-search.php?coupon_name=<?= $name ?>&type=1" class="btn btn-warning 
                        <?php
                        if ($type == 1) echo "active fw-bolder";
                        ?>">所有項目</a>
                                <a href="Coupon-search.php?coupon_name=<?= $name ?>&type=2" class="btn btn-warning 
                        <?php
                        if ($type == 2) echo "active fw-bolder";
                        ?>">可使用</a>
                                <a href="Coupon-search.php?coupon_name=<?= $name ?>&type=3" class="btn btn-warning 
                        <?php
                        if ($type == 3) echo "active fw-bolder";
                        ?>">已停用</a>
                            </div>
                        </div>
                    </div>
                    <?php if ($coupon_count != 0) : ?>
                        <table class="table table-striped text-center table-hover table-bordered">
                        <thead class="table-secondary">
                                <tr>
                                    <th>ID</th>
                                    <th>優惠卷名稱</th>
                                    <th>優惠卷代碼</th>
                                    <th>優惠卷狀態</th>
                                    <th>優惠卷種類</th>
                                    <th>優惠卷面額</th>
                                    <th>登錄時間</th>
                                    <th>到期日</th>
                                    <th>最後更新</th>
                                    <th>可使用次數</th>
                                    <th>優惠卷使用條件</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows as $row) : ?>
                                    <tr>
                                        <td><?= $row["coupon_id"] ?></td>
                                        <td><?= $row["coupon_name"] ?></td>
                                        <td><?= $row["coupon_code"] ?></td>
                                        <td><?= $row["valid_description"] ?></td>
                                        <td><?= $row["discount_type"] ?></td>
                                        <td><?= $row["discount_value"] ?></td>
                                        <td><?= $row["start_at"] ?></td>
                                        <td><?= $row["expires_at"] ?></td>
                                        <td><?= $row["max_usage"] ?></td>
                                        <td><?= $row["price_min"] ?></td>
                                        <td><?= $row["usage_restriction"] ?></td>
                                        <td>
                                            <a href="Coupon.php?coupon_id=<?= $row["coupon_id"] ?>" class="btn btn-warning">顯示</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
                <!-- ↑↑放置內容↑↑ -->
            </div>
            <!-- End of Main Content -->
            <?php include("modal/footer.php") ?>
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