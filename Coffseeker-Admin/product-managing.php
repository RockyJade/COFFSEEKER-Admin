<?php
require_once("../db_connect.php");

$sql = "SELECT COUNT(*) AS total FROM product WHERE product_valid = 0";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if (!$row) {
    header("location: ../../404.php");
    exit();
}

$product_count = $row['total'];

$sql = "SELECT product_id, product_category, product_brand, product_name, product_amount, product_price, product_description, product_image, created_at, updated_at, product_valid FROM product WHERE product_valid = 0";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $updated_name = $_POST["product_name"];
    $updated_brand = $_POST["product_brand"];
    $updated_amount = $_POST["product_amount"];
    $updated_price = $_POST["product_price"];
    $updated_description = $_POST["product_description"];
    $updated_valid = $_POST["product_valid"];

    $current_time = date("Y-m-d H:i:s");

    $update_sql = "UPDATE product SET 
                    product_name = '$updated_name', 
                    product_brand = '$updated_brand', 
                    product_amount = '$updated_amount', 
                    product_price = '$updated_price', 
                    product_description = '$updated_description', 
                    product_valid = '$updated_valid', 
                    updated_at = '$current_time' 
                    WHERE product_id = '$product_id'";

    if ($conn->query($update_sql) === TRUE) {
        header("location: product-list.php");
        exit();
    } else {
        echo "商品更新失敗: " . $conn->error;
    }
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

    <title>Product-Managing</title>

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

                <div class="container my-5">
                    <h1 class="text-center">下架商品管理</h1>
                    <div class="py-2">
                        <a class="btn btn-warning" href="product-list.php">回商品列表</a>
                    </div>
                    <?php if ($product_count != 0) : ?>
                        <table class="table table-bordered border-end align-middle mt-3">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center">編號</th>
                                    <th class="text-center">圖片</th>
                                    <th class="text-nowrap text-center">商品名稱</th>
                                    <th class="text-nowrap text-center">品牌</th>
                                    <!-- <th class="text-nowrap text-center">類別</th> -->
                                    <th class="text-nowrap text-center">價格</th>
                                    <th class="text-nowrap text-center">最後更新時間</th>
                                    <th class="text-nowrap text-center">狀態</th>
                                    <th class="text-nowrap text-center">編輯</th>
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
                                        <td><img src="<?= htmlspecialchars($row["product_image"]) ?>" alt="" style="width: 60px;"></td>
                                        <td>
                                            <span class="fw-bold product_name text-center"><?= $row["product_name"] ?></span>
                                            <ul class="product_description mt-2 text-left">
                                                <li><i class="fa-regular fa-message me-2"></i><?= $row["product_description"] ?></li>
                                            </ul>
                                        </td>
                                        <td class="text-center"><?= $row["product_brand"] ?></td>
                                        <!-- <td class="text-nowrap text-center"><?= $row["product_category"] ?></td> -->
                                        <td class="text-nowrap text-center">$<?= $row["product_price"] ?></td>
                                        <td class="text-center"><?= $row["updated_at"] ?></td>
                                        <td class="text-nowrap text-center"><?= $status ?></td>
                                        <td class="text-center">
                                            <a href="product-edit.php?id=<?= $row['product_id'] ?>">
                                                <button class="btn btn-outline-warning"><i class="fa-solid fa-pencil"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <p class="mt-2">目前沒有下架商品可以管理。</p>
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