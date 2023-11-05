<?php
if (!isset($_GET["order_id"])) {
    // die("資料不存在");
    header("location: 404.php");
}
$id = $_GET["order_id"];

require_once("../db_connect.php");

$ordersql = "SELECT orders.* ,

order_states.states FROM orders 

JOIN order_states ON order_states.states_valid = orders.order_state

WHERE order_id=$id";

$getOrder = $conn->query($ordersql);
$orders = $getOrder->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Order-Detail</title>

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
                

                <!--  -->
                <h1 class="text-center mt-5 py-4">訂單狀態更新</h1>
                <div class="container-fluid d-flex justify-content-center mb-5">
                    <div class="d-flex justify-content-center">
                        <form action="action/orders/doUpdate.php" method="post">
                            <div class="card my-3">
                            <input type="hidden" name="order_id" value="<?= $orders["order_id"]?>">
                                    <div class="card-body">
                                        <h1 class="h6 card-title">訂單編號</h1>
                                        <span class="h3"><?= $orders["order_id"] ?></span>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            購買會員 : <?= $orders["order_user"] ?>
                                        </li>
                                        <li class="list-group-item">
                                            購買商品 : <?= $orders["order_products"] ?>
                                        </li>
                                        <li class="list-group-item">
                                            訂單總價 : <?= $orders["order_price"] ?>
                                        </li>
                                        <li class="list-group-item">
                                            成立時間 : <?= $orders["order_created_at"] ?>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="">
                                                訂單狀態 : 
                                                <select class="form-select form-control" aria-label="Grade" name="states">
                                                    <option value="0" <?php if($orders["order_state"] == 0) echo "selected"; ?>>取消訂單</option>
                                                    <option value="1" <?php if($orders["order_state"] == 1) echo "selected"; ?>>下訂完成</option>
                                                    <option value="2" <?php if($orders["order_state"] == 2) echo "selected"; ?>>確認訂單</option>
                                                    <option value="3" <?php if($orders["order_state"] == 3) echo "selected"; ?>>整貨中</option>
                                                    <option value="4" <?php if($orders["order_state"] == 4) echo "selected"; ?>>已出貨</option>
                                                    <option value="-1" <?php if($orders["order_state"] == -1) echo "selected"; ?>>訂單完成</option>          
                                                </select>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <button class="btn btn-warning" type="submit">更新</button>
                                            <a class="btn btn-warning" href="order-list.php?order_id=<?= $orders["order_id"]; ?>">返回</a>
                                        </li>
                                    </ul>
                            </div>
                        </form>
                    </div>
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