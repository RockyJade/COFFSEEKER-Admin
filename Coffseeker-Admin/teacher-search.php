<?php

if (isset($_GET["name"])) {
    $name = $_GET["name"];
    require_once("../db_connect.php");

    if (!empty($_GET["name"])) {
        $sql = "SELECT * FROM coffseeker_teachers WHERE valid=1 AND teacher_name LIKE '%$name%'";
        $result = $conn->query($sql);
        $filteredAll = $result->num_rows;
        $filterEach = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $filteredAll = 0;
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

    <title>Teacher-Search</title>

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
                    <h1 class="text-center">搜尋教師</h1>
                    <div class="py-2">
                        <a class="btn btn-warning" href="teacher-list.php">回使用者列表</a>
                    </div>
                    <div class="py-2">
                        <form action="teacher-search.php">
                            <div class="row gx-2">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="搜尋使用者" name="name">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-warning" type="submit">搜尋姓名</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="py-2 d-flex justify-content-between align-items-center">
                        <?php if (isset($_GET["name"])) : ?>
                            <div>
                                搜尋 <?= $name ?> 的結果, 共有 <?= $filteredAll ?> 筆符合的資料
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if ($filteredAll != 0) : ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>姓名</th>
                                    <th>電話</th>
                                    <th>性別</th>
                                    <th>email</th>
                                    <th>教師資格</th>
                                    <th>教師年資</th>
                                    <th>教師專長</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($filterEach as $row) : ?>
                                    <tr>
                                        <td><?= $row["teacher_id"] ?></td>
                                        <td><?= $row["teacher_name"] ?></td>
                                        <td><?= $row["teacher_phone"] ?></td>
                                        <td><?= $row["teacher_gender"] ?></td>
                                        <td><?= $row["teacher_mail"] ?></td>
                                        <td><?= $row["teacher_qualification"] ?></td>
                                        <td><?= $row["teacher_experience"] ?></td>
                                        <td><?= $row["teacher_specialty"] ?></td>
                                        <td>
                                            <a href="teacher-detail.php?teacher_id=<?= $row["teacher_id"] ?>" class="btn btn-warning">顯示</a>
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



</body>

</html>