<?php

if($_GET["name"] == ""){
    $name= "";
    $count= 0;
}else{
    $name=$_GET["name"];
    require_once("../db_connect.php");

    $sql="SELECT categories_id,categories_name FROM categories  WHERE categories_name LIKE '%$name%' AND valid=1";

    $result= $conn->query($sql);
    $rows= $result->fetch_all(MYSQLI_ASSOC);
    $count=$result->num_rows;
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

    <title>Search-Category</title>

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
                <h1 class="text-center" >搜尋大分類</h1>
        <div class="py-2">
            
            <a class="btn btn-warning" href="category.php"><i class="fa-solid fa-arrow-left-long" style="color: #000000;"></i></a>
        </div>
        <!-- search bar -->
        <div class="py-2">
            <form action="category-search.php">
                <div class="row gx-2">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="輸入關鍵字" name="name">
                        <input  type="number" class="form-control d-none" name="id" value="<?=$id?>">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-warning" type="submit">搜尋</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- 搜尋結果文字 -->
        <div class="py-2 d-flex justify-content-between align-items-center">
            <?php //if(isset($_GET["name"])): ?>
                <div class="py-2">
                    搜尋 <?= $name?> 結果, 總共 <?= $count?> 個符合
                </div>
            <?php //endif; ?>
        </div>
        <!-- 結果表單 -->
        <?php if($count!= 0): ?>
            <table class="table table-striped text-center table-hover table-bordered">
                        <thead class="table-secondary">
                    <tr>
                        <th>編號</th>
                        <th>名稱</th>
                        <th>編輯</th>
                        <th>查看</th>
                        <th>刪除</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $detail) : ?>
                        <!-- Modal -->
                        <div class="modal fade" id="deleteModal<?= $detail["categories_id"]?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel"> Confirm delete</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure to delete?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <a href="action/category/doDelete.php?id=<?= $detail["categories_id"] ?>" class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--main table -->
                        <tr>
                            <td><?= $detail["categories_id"] ?></td>
                            <td><?= $detail["categories_name"] ?></td>
                            <td>
                                <a class="btn btn-warning" href="category-edit-category.php?id=<?= $detail["categories_id"] ?>"><i class="fa-solid fa-pen-to-square" style="color: #000000;"></i></a>
                            </td>
                            <td>
                                <a class="btn btn-warning" href="category-item.php?id=<?= $detail["categories_id"] ?>"><i class="fa-solid fa-bars" style="color: #000000;"></i></a>
                            </td>
                            <td>
                                <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $detail["categories_id"] ?>"><i class="fa-solid fa-trash-can" style="color: #ffffff;"></i></button>
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


    <!-- j-query -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous">
    </script>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

</body>

</html>