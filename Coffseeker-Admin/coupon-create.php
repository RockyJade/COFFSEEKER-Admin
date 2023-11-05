<?php

require_once("../db_connect.php");

$query = "SELECT DISTINCT product_brand FROM product";
$result = $conn->query($query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>建立新優惠卷</title>

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
                <!-- Modal start-->
                <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="errorModalLabel">優惠卷日期有誤</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                請將開始日期與到期日期變更
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal end -->

                <div class="container my-5">
                    <h1 class="text-center">建立新優惠卷</h1>
                    <div class="py-2">
                        <a class="btn btn-warning" href="coupon-list.php">回優惠卷列表</a>
                    </div>
                    <form action="action/coupon/doCreate.php" method="post" onsubmit="return checkForm()">
                        <div class="mb-3">
                            <label for="">優惠卷名稱：</label>
                            <input type="text" class="form-control" name="coupon_name" placeholder="例：炎炎夏日 外送免運卷" Required>
                        </div>
                        <div class="mb-3">
                            <label for="">優惠卷代碼：</label>
                            <input id="randomString" type="text" class="form-control" name="coupon_code" placeholder="例：Eda8F4s87Q" pattern="^[a-zA-Z0-9]{10}$" required>
                            <p>(可自定義10位大小寫英文、數字混雜字元)</p>
                            <button class="btn btn-warning" type="button" onclick="generateCouponCode()">隨機生成一組代碼</button>
                        </div>
                        <div class="mb-3">
                            <label for="">優惠卷狀態：</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="coupon_valid" value="1">
                                <input type="hidden" name="valid_description" value="可使用">
                                <label class="form-check-label" for="exampleRadios1">
                                    可使用
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="coupon_valid" value="-1">
                                <input type="hidden" name="valid_description" value="已停用">
                                <label class="form-check-label" for="exampleRadios2">
                                    停用
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="">優惠卷類型：</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="discount_type" id="discount_type1" value="百分比">
                                <label class="form-check-label" for="exampleRadios1">
                                    依售價百分比折價
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="discount_type" id="discount_type2" value="金額">
                                <label class="form-check-label" for="exampleRadios2">
                                    依優惠金額折價
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="">優惠卷折價百分比 / 優惠卷面額大小：</label>
                            <input type="text" class="form-control" name="discount_value" placeholder="請填入折價% (5%) 或 折價面額 (100)" Required>
                        </div>
                        <div class="mb-3">
                            <label for="">可使用次數：</label>
                            <input type="text" class="form-control" name="max_usage" placeholder="請填入數字" Required>
                        </div>

                        <div class="mb-3">
                            <label for="">優惠卷開始日期：</label>
                            <input type="date" name="start_at" Required>
                            <label for="" class="ms-3">優惠卷到期日期：</label>
                            <input type="date" name="expires_at" Required>
                        </div>

                        <div class="mb-3">
                            <label for="">最低消費金額：</label>
                            <input type="text" class="form-control" name="price_min" placeholder="例：請填入最低金額 (999)" Required>
                        </div>
                        <div class="mb-3">
                            <label for="">優惠卷使用條件：</label>
                            <select name="usage_restriction" class="form-control">
                                <option value="" selected disabled>請選擇可用的品牌名稱</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    $productBrand = $row["product_brand"];
                                    echo "<option value=\"$productBrand\">$productBrand</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <button class="btn btn-warning" type="submit">送出</button>
                    </form>
                </div>
                <script>
                    function checkForm() {
                        var startDateString = document.querySelector('input[name="start_at"]').value;
                        var endDateString = document.querySelector('input[name="expires_at"]').value;

                        var startDate = new Date(Date.parse(startDateString));
                        var endDate = new Date(Date.parse(endDateString));

                        if (startDate > endDate) {
                            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                            errorModal.show();
                            return false; // 驗證失敗，阻止表單提交
                        } else {
                            return true; // 驗證通過，允許表單提交
                        }
                    }

                    function generateCouponCode() {
                        var randomStringInput = document.getElementById('randomString');
                        var characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        var charactersLength = characters.length;
                        var randomString = '';
                        var length = 10;

                        for (var i = 0; i < length; i++) {
                            randomString += characters.charAt(Math.floor(Math.random() * charactersLength));
                        }

                        randomStringInput.value = randomString;
                    }
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
    <!-- Bootstrap core JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>

</html>