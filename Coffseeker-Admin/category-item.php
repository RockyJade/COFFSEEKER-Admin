<?php
require_once("../db_connect.php");

//用GET全域方式找尋type，page，如果不存在則1 
//意思為顯示 第一種排序、第一頁 
$type = $_GET["type"] ?? 1;
$page = $_GET["page"] ?? 1;
$detail = $_GET["id"] ?? 1;


//抓取sql的分類總數
$sqlTotal = "SELECT * FROM categories_item WHERE valid=1 AND categories_id= '$detail' "; //查詢sql
$resultTotal = $conn->query($sqlTotal); //執行sql
$totalCategory = $resultTotal->num_rows; //結果的總行數
//var_dump($totalCategory);

$perPage = 5; //每頁顯示8筆資料
$starItem = ($page - 1) * $perPage; //（當頁-1）*每頁顯示數量 //當前顯示起始位置
$totalPage = ceil($totalCategory / $perPage); //計算總頁數


if ($type == 1) {
    $orderby = "ORDER BY items_id  ASC";
} elseif ($type == 2) {
    $orderby = "ORDER BY items_id  DESC";
} elseif ($type == 3) {
    $orderby = "ORDER BY items_name ASC ";
} elseif ($type == 4) {
    $orderby = "ORDER BY items_name DESC";
} else {
    header("Location: 404 .php");
    exit;
}

//注意index從0開始！！
//LIMIT 4, 4 (限制 起始index4,顯示4筆資料) 
//LIMIT $starItem,$perPage （0,8）顯示8筆資料
$sql = "SELECT categories_item.*,categories.categories_name AS big_name FROM categories_item
JOIN categories ON categories.categories_id = categories_item.categories_id
WHERE categories_item.valid=1 AND categories.categories_id = '$detail' 
$orderby LIMIT $starItem,$perPage";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC); //fetch_all()查詢所有結果行，以關聯是數組形式處存在rows
//var_dump($rows);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php if (!empty($rows)) : ?>
        <title><?= $rows[0]["big_name"] ?></title>
    <?php endif; ?>

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
                    <h1 class="text-center">細節分類</h1>
                    <div class="py-2 d-flex justify-content-between align-items-center">
                        <?php if (!empty($rows)) : ?>
                            <h2><?= $rows[0]["big_name"] ?></h2>
                        <?php endif; ?>
                        <h5>共<?= $totalCategory ?>筆,第 <?= $page ?> 頁</h5>
                    </div>
                    <!-- searchbar -->
                    <div class="py-2">
                        <form action="category-search-item.php">
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="請輸入文字" name="name">
                                    <input type="hidden" name="id" value="<?= $detail ?>">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-warning" type="submit">搜尋</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="pt-4 pb-3  d-flex justify-content-between">
                        <!-- createvent -->
                        <div>
                            <a class="btn btn-warning" href="category.php"><i class="fa-solid fa-arrow-left-long" style="color: #000000;"></i></a>
                            <a class="btn btn-warning" href="category-create-item.php?id=<?= $detail ?>"> <i class="fa-solid fa-plus" style="color: #000000;"></i> 新增分類</a>
                        </div>
                        <!-- Order -->
                        <div class="cloumn gx-2 me-2">
                            <a class="btn btn-warning <?php if ($type == 1) echo "active" ?>" href="category-item.php?id=<?= $detail ?>&page=<?= $page ?>&type=1">id <i class="fa-solid fa-arrow-down-wide-short"></i> </a>
                            <a class="btn btn-warning <?php if ($type == 2) echo "active" ?>" href="category-item.php?id=<?= $detail ?>&page=<?= $page ?>&type=2">id <i class="fa-solid fa-arrow-up-wide-short"></i></a>
                            <a class="btn btn-warning <?php if ($type == 3) echo "active" ?>" href="category-item.php?id=<?= $detail ?>&page=<?= $page ?>&type=3">name <i class="fa-solid fa-arrow-down-wide-short"></i> </a>
                            <a class="btn btn-warning <?php if ($type == 4) echo "active" ?>" href="category-item.php?id=<?= $detail ?>&page=<?= $page ?>&type=4">name <i class="fa-solid fa-arrow-up-wide-short"></i></a>
                        </div>
                    </div>
                    <!--table content -->
                    <table class="table table-striped text-center table-hover table-bordered">
                        <thead class="table-secondary">
                            <tr>
                                <!-- <th>編號</th> -->
                                <th>名稱</th>
                                <th>編輯</th>
                                <th>刪除</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row) : ?>
                                <!-- Modal -->
                                <div class="modal fade" id="deleteModal<?= $row["items_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-md modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                    確認刪除
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                請問是否確認刪除
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                                <a href="action/category/doDelete-item.php?id=<?= $row["items_id"] ?>&categories_id=<?= $row["categories_id"] ?>" class="btn btn-danger">刪除</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--main table -->
                                <tr>
                                    <!-- <td><?= $row["items_id"] ?></td> -->
                                    <td><?= $row["items_name"] ?></td>
                                    <td>
                                        <a class="btn btn-warning" href="category-edit-item.php?id=<?= $row["items_id"] ?>"> <i class="fa-solid fa-pen-to-square" style="color: #000000;"></i> </a>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row["items_id"] ?>"> <i class="fa-solid fa-trash-can" style="color: #ffffff;"></i> </button>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- page nav -->
                    <nav aria-label="Page navigation example ">
                        <ul class="pagination  pagination-md justify-content-center">

                            <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                                <li class="page-item <?php if ($i == $page) echo "active"; ?>">
                                    <a class="page-link text-warning border-0" href="category-item.php?id=<?= $detail ?>&page=<?= $i ?>&type=<?= $type ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>

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