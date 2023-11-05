<?php
$product_id = $_GET["id"];

if (!isset($_GET["id"])) {
    header("location: /404.php");
    exit();
}

require_once("../db_connect.php");

$product_id = $_GET["id"];

$sql = "SELECT * FROM product WHERE product_id = '$product_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if (!$row) {
    header("location: /404.php");
    exit();
}

$product_name = $row['product_name'];
$product_brand = $row['product_brand'];
$product_amount = $row['product_amount'];
$product_price = $row['product_price'];
$product_description = $row['product_description'];
$product_image = $row['product_image'];
$product_valid = $row['product_valid'];

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

    <title>Product-Edit</title>

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

                <div class="container my-5" style="width:500px">
                    <h1 class="text-center">商品編輯</h1>
                    <div class="py-2">
                        <a class="btn btn-warning mb-3" href="product-list.php">回商品列表</a>
                    </div>
                    <form action="action/product/doUpdate.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <input type="hidden" name="product_id" value="<?= $product_id ?>">

                            <label for="product-name" class="form-label">商品名稱</label>
                            <input type="text" class="form-control" id="product-name" name="product_name" required value="<?= $product_name ?>">
                        </div>
                        <div class="mb-3">
                            <label for="product-brand" class="form-label">商品品牌</label>
                            <input type="text" class="form-control" id="product-brand" name="product_brand" required value="<?= $product_brand ?>">
                        </div>
                        <div class="mb-3">
                            <label for="product-amount" class="form-label">商品數量</label>
                            <input type="number" class="form-control" id="product-amount" name="product_amount" required value="<?= $product_amount ?>">
                        </div>
                        <div class="mb-3">
                            <label for="product-price" class="form-label">商品價格</label>
                            <input type="number" class="form-control" id="product-price" name="product_price" required value="<?= $product_price ?>">
                        </div>
                        <div class="mb-3">
                            <label for="product-description" class="form-label">商品描述</label>
                            <textarea class="form-control" id="product-description" name="product_description" required rows="3" cols="30" style="resize: none"><?= $product_description ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="product-image" class="form-label">商品圖片</label>
                            <img id="preview-image" src="<?= $product_image ?>" alt="" style="max-width: 200px; max-height:200px">
                            <input type="file" class="form-control mt-3" id="product-image" name="product_image">
                        </div>
                        <div class="mb-3">
                            <label for="product-valid" class="form-label">商品上架</label>
                            <select class="form-select" id="product-valid" name="product_valid" required>
                                <option value="1" <?= ($product_valid == '1') ? 'selected' : '' ?>>上架</option>
                                <option value="0" <?= ($product_valid == '0') ? 'selected' : '' ?>>下架</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-warning mb-3">編輯</button>
                        </div>
                    </form>
                </div>

                <script>
                    var fileInput = document.getElementById('product-image');

                    fileInput.addEventListener('change', function(event) {
                        var file = event.target.files[0];

                        if (file) {
                            var reader = new FileReader();
                            reader.onload = function() {
                                var preview = document.getElementById('preview-image');
                                preview.src = reader.result;
                            }
                            reader.readAsDataURL(file);
                        }
                    });
                </script>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-DLqX+VvzlZa3jnvqDd2f0l68sm7idtJAgqs2TV3pH0x5cToJir8w5MCEqAzhKw3y" crossorigin="anonymous"></script>


</body>

</html>