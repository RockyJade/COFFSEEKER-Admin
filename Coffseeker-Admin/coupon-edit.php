<?php
if (!isset($_GET["coupon_id"])) {
    header("location: 404.php");
}
$id = $_GET["coupon_id"];

require_once("../db_connect.php");
$sql = "SELECT * FROM coupon WHERE coupon_id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

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

    <title>編輯優惠券</title>

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

                <!-- Modal start -->
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id=""><?= $row["coupon_name"] ?></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                確認刪除？
                            </div>
                            <div class="modal-footer">
                                <a href="action/coupon/doDelete.php?coupon_id=<?= $id ?>" class="btn btn-danger">確認</a>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal end -->

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
                    <h1 class="text-center">編輯優惠券</h1>
                    <div class="m-2">
                        <form action="action/coupon/doUpdate.php" method="post" onsubmit="return checkForm()">
                            <table class="table table-bordered ">
                                <input type="hidden" name="coupon_id" value="<?= $row["coupon_id"] ?>">
                                <tr>
                                    <th>優惠卷ID</th>
                                    <td>
                                        <?= $row["coupon_id"] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>優惠卷名稱</th>
                                    <td>
                                        <input type="text" class="form-control" value="<?= $row["coupon_name"] ?>" name="coupon_name">
                                    </td>
                                </tr>
                                <tr>
                                    <th>優惠卷狀態</th>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="coupon_valid" value="1" <?php if ($row["coupon_valid"] == 1) echo 'checked'; ?>>
                                            <label class="form-check-label">
                                                可使用
                                            </label>
                                            <input type="hidden" name="valid_description" value="可使用" <?php if ($row["valid_description"] == "可使用") echo 'checked'; ?>>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="coupon_valid" value="-1" <?php if ($row["coupon_valid"] == -1) echo 'checked'; ?>>
                                            <label class="form-check-label">
                                                停用
                                            </label>
                                            <input type="hidden" name="valid_description" value="已停用" <?php if ($row["valid_description"] == "已停用") echo 'checked'; ?>>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>優惠卷類型</th>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="discount_type" id="discount_type1" value="百分比" <?php if ($row["discount_type"] == "百分比") echo 'checked'; ?>>
                                            <label class="form-check-label" for="exampleRadios1">
                                                依售價百分比折價
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="discount_type" id="discount_type2" value="金額" <?php if ($row["discount_type"] == "金額") echo 'checked'; ?>>
                                            <label class="form-check-label" for="exampleRadios2">
                                                依優惠金額折價
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>優惠卷折價百分比 / 優惠卷面額大小</th>
                                    <td>
                                        <input type="text" class="form-control" value="<?= $row["discount_value"] ?>" name="discount_value">
                                    </td>
                                </tr>
                                <tr>
                                    <th>可使用次數</th>
                                    <td>
                                        <input type="text" class="form-control" value="<?= $row["max_usage"] ?>" name="max_usage">
                                    </td>
                                </tr>
                                <tr>
                                    <th>優惠卷開始日期</th>
                                    <td>
                                        <input type="date" value="<?= $row["start_at"] ?>" name="start_at">
                                    </td>
                                </tr>
                                <tr>
                                    <th>優惠卷到期日期</th>
                                    <td>
                                        <input type="date" value="<?= $row["expires_at"] ?>" name="expires_at">
                                    </td>
                                </tr>
                                <tr>
                                    <th>最低消費金額</th>
                                    <td>
                                        <input type="text" class="form-control" value="<?= $row["price_min"] ?>" name="price_min">
                                    </td>
                                </tr>
                                <tr>
                                    <th>優惠卷使用條件</th>
                                    <td>
                                        <select name="usage_restriction" class="form-control">
                                            <option value="" disabled>請選擇可用的品牌名稱</option>
                                            <?php
                                            while ($brandRow = $result->fetch_assoc()) {
                                                $productBrand = $brandRow["product_brand"];
                                                $selected = ($productBrand === $row["usage_restriction"]) ? "selected" : "";
                                                echo "<option value=\"$productBrand\" $selected>$productBrand</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <div class="py-2 d-flex justify-content-between">
                                <div>
                                    <button class="btn btn-warning" type="submit" data-bs-toggle="modal" data-bs-target="#errorModal">儲存</button>
                                    <a class="btn btn-warning" href="coupon.php?coupon_id=<?= $row["coupon_id"] ?>">取消</a>
                                </div>
                                <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal">刪除</button>
                            </div>
                        </form>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">



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


    <script>
        function checkForm() {
            var startDateString = document.querySelector('input[name="start_at"]').value;
            var endDateString = document.querySelector('input[name="expires_at"]').value;

            var startDate = new Date(Date.parse(startDateString));
            var endDate = new Date(Date.parse(endDateString));

            if (startDate > endDate) {
                var errorModal = document.getElementById('errorModal');
                errorModal.classList.add('show');
                errorModal.style.display = 'block';
                return false; // 驗證失敗，阻止表單提交
            } else {
                return true; // 驗證通過，允許表單提交
            }


        }
    </script>
</body>

</html>