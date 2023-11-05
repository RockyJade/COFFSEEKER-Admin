<?php

//refer to user/user-list.php

$page = $_GET["page"] ?? 1;
$type = $_GET["type"] ?? 1;  //unfinished orders setting


$sqlSearch = "SELECT teacher_id FROM coffseeker_teachers WHERE valid=1 ";

require_once("../db_connect.php");

if ($type == 1) {
    $order = "ORDER BY teacher_id ASC";
} elseif ($type == 2) {
    $order = "ORDER BY teacher_id DESC";
}

$sql = "SELECT coffseeker_teachers.teacher_id FROM coffseeker_teachers WHERE valid=1";
$resultTotal = $conn->query($sql); //all the types of results selected
$totalUser = $resultTotal->num_rows; //total amount of selected teachers

$idPerPage = 5;
$idPageStart = ($page - 1) * $idPerPage;

$totalPage = ceil($totalUser / $idPerPage);

$idPerPageLimit = "SELECT coffseeker_teachers.* FROM coffseeker_teachers WHERE valid=1 $order LIMIT $idPageStart,$idPerPage";
$result = $conn->query($idPerPageLimit);





//id auto substitution awaiting to be set
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Teacher-List</title>

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
                    <h1 class="text-center">教師清單</h1>
                    <div class="py-2">
                        <form action="teacher-search.php">
                            <div class="row gx-2">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="搜尋使用者" name="name">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-warning" type="submit">搜尋</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- <?php
                            $user_count = $result->num_rows;
                            ?> -->
                    <div class="py-2 d-flex justify-content-between align-items-center">
                        <a class="btn btn-warning" href="teacher-create.php"><i class="fa-solid fa-user-plus"></i>新增教師</a>
                        <div>
                            共 <?= $totalUser ?> 人, 第 <?= $page ?> 頁
                        </div>
                    </div>
                    <div class="py-2 d-flex justify-content-end">
                        <div>
                            <a class="btn btn-warning" href="teacher-list.php?page=<?= $page ?>&type=1"><i class="fa-solid fa-arrow-down-wide-short"></i></a>
                            <a class="btn btn-warning" href="teacher-list.php?page=<?= $page ?>&type=2"><i class="fa-solid fa-arrow-up-short-wide"></i></a>
                        </div>
                    </div>
                    <?php
                    $rows = $result->fetch_all(MYSQLI_ASSOC);
                    // var_dump($rows);
                    // exit;
                    ?>
                    <table class="table table-striped text-center table-hover">
                        <thead class="table-secondary">
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
                            <?php foreach ($rows as $row) : ?>
                                <tr class="hover-bgc">
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
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                                <li class="page-item <?php if ($i == $page) echo "active";?>">
                                    <a class="page-link text-warning border-0" href="teacher-list.php?page=<?= $i ?>&type=<?= $type ?>">
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



</body>

</html>