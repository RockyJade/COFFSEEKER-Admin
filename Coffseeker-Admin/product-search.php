<?php
if (isset($_GET["name"]) && !empty(trim($_GET["name"]))) {
    $name = $_GET["name"];
    $product_name = $_GET["name"];
    require_once("../db_connect.php");

    $sql = "SELECT product_id, product_name, product_brand, product_category, product_price, product_image, product_valid, product_description, updated_at,product_amount FROM product WHERE (product_name LIKE '%$name%' OR product_brand LIKE '%$name%' OR product_category LIKE '%$name%') AND product_valid = 1";

    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $product_count = $result->num_rows;
} else {
    $product_count = 0;
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

    <title>Product-Search</title>

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

                <h1 class="text-center">商品搜尋</h1>
                <div class="container">
                    <div class="py-2">
                        <a class="btn btn-warning" href="product-list.php">回商品列表</a>
                    </div>
                    <?php if (isset($_GET["name"]) && !empty(trim($_GET["name"]))) : ?>
                        <div class="py-2 d-flex justify-content-between align-items-center">
                            <div class="mb-2">
                                搜尋 <span class="fw-bold text-danger mb-2"><?= $name ?></span> 的結果, 共有 <span class="fw-bold text-danger"><?= $product_count ?></span> 筆符合的資料
                            </div>
                        </div>
                        <?php if ($product_count != 0) : ?>
                            <table class="table table-bordered border-end align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap text-center">編號</th>
                                        <th>圖片</th>
                                        <th class="text-nowrap text-center">商品名稱</th>
                                        <th class="text-nowrap text-center">品牌</th>
                                        <th class="text-nowrap text-center">數量</th>
                                        <th class="text-nowrap text-center">價格</th>
                                        <th class="text-nowrap text-center">最後更新時間</th>
                                        <th class="text-nowrap text-center">狀態</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $row) : ?>
                                        <?php
                                        $product_valid = $row["product_valid"];
                                        $status = $product_valid == 1 ? '上架' : '下架';
                                        ?>

                                        <tr>
                                            <td class="text-center"><?= $row["product_id"] ?></td>
                                            <td><img src="<?= $row["product_image"] ?>" alt="" style="width: 60px;"></td>
                                            <td>
                                                <span class="fw-bold product_name text-center"><?= $row["product_name"] ?></span>
                                                <ul class="product_description mt-2 text-left">
                                                    <li><i class="fa-regular fa-message me-2"></i><?= $row["product_description"] ?></li>
                                                </ul>
                                            </td>
                                            <td class="text-nowrap text-center"><?= $row["product_brand"] ?></td>
                                            <td class="text-nowrap text-center"><?= $row["product_amount"] ?></td>
                                            <td class="text-nowrap text-center">$<?= $row["product_price"] ?></td>
                                            <td class="text-nowrap text-center"><?= $row["updated_at"] ?></td>
                                            <td class="text-nowrap text-center"><?= $status ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <div class="py-2">
                                沒有符合搜尋條件的產品
                            </div>
                        <?php endif; ?>

                    <?php else : ?>
                        <div class="py-2">
                            請輸入關鍵字以搜尋商品
                        </div>
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


    <!-- j-query -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous">
    </script>



</body>

</html>