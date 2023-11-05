<?php

if (!isset($_GET["id"])) {
    header("location: 404php");
}

$id = $_GET["id"];

require_once("../db_connect.php");

$sqlCategories = "SELECT * FROM categories WHERE valid=1";
$resultCategories = $conn->query($sqlCategories);
$rowsCategories = $resultCategories->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT categories_item.*, categories.categories_name AS big_name
FROM categories_item
JOIN categories ON categories.categories_id=categories_item.categories_id
WHERE items_id=$id ";
$result = $conn->query($sql);
$row = $result->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit-Item</title>

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

                <div class="container pt-2 my-5">
                    <h1 class="text-center">編輯小分類</h1>

                    <form action="action/category/doUpdate-item.php" method="post">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>所屬大分類</th>
                                    <td>
                                        <select class="form-select" aria-label="Default select example" name="categories_id">
                                            <?php foreach ($rowsCategories as $category) : ?>
                                                <option value="<?= $category["categories_id"] ?>" <?php if ($category["categories_id"] == $row["categories_id"]) echo "selected"; ?>>
                                                    <?= $category["categories_name"] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <th>分類名稱</th>
                                    <td>
                                        <input type="text" class="form-control" value="<?= $row["items_name"] ?>" name="name">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <div>
                                <a class="btn btn-secondary" href="category-item.php?id=<?= $row["categories_id"] ?>">取消</a>

                                <!-- 添加隱藏的id 給予大分類id -->
                                <input class="" type="number" name="big_id" value="<?= $row["categories_id"] ?>" hidden>
                                <input class="" type="number" name="id" value="<?= $_GET["id"]?>" hidden>
                                <button class="btn btn-warning" type ="submit ">確認</button>
                            </div>
                        </div>

                    </form>

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

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>

</body>

</html>