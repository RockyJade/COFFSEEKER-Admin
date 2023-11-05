<?php

require_once("../db_connect.php");

$id = $_GET["teacher_id"];

$sql = "SELECT * FROM coffseeker_teachers WHERE teacher_id=$id";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

// print_r($rows);

$sqlImages = "SELECT * FROM coffseeker_teachers WHERE teacher_id=$id ";
$resultImages = $conn->query($sqlImages);
$productImages = $resultImages->fetch_all(MYSQLI_ASSOC);


?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Teacher-Detail</title>

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
                    <h1 class="text-center">教師資訊</h1>
                    <div class="py-2">
                        <div class="d-flex mt-5 justify-content-around">
                            <?php foreach ($productImages as $image) : ?>
                                <div class="col-5 overflow-hidden d-flex justify-content-center" style="height:330px">
                                    <img class="object-fit-cover mw-100" src="action/teacher/teacher-img/<?= $image["teacher_img"] ?>" alt="">

                                </div>
                            <?php endforeach; ?>
                            <div class="col-5">
                                <table class="table table-bordered">
                                    <?php foreach ($rows as $row) : ?>
                                        <?php if ($row["teacher_id"]) : ?>
                                            <tr>
                                                <th>ID</th>
                                                <td><span id=""><?= $row["teacher_id"] ?></span></td>
                                            </tr>
                                            <tr>
                                                <th>姓名</th>
                                                <td><span id="name"><?= $row["teacher_name"] ?></span></td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td><span id="email"><?= $row["teacher_mail"] ?></span></td>
                                            </tr>
                                            <tr>
                                                <th>電話號碼</th>
                                                <td><span id="phone"><?= $row["teacher_phone"] ?></span></td>
                                            </tr>
                                            <tr>
                                                <th>性別</th>
                                                <td><span id="phone"><?= $row["teacher_gender"] ?></span></td>
                                            </tr>
                                            <tr>
                                                <th>教師資格</th>
                                                <td><span id="teacher_qualification"><?= $row["teacher_qualification"] ?></span></td>
                                            </tr>
                                            <tr>
                                                <th>教師年資</th>
                                                <td><span id="teacher_experience"><?= $row["teacher_experience"] ?></span></td>
                                            </tr>
                                            <tr>
                                                <th>教師專長</th>
                                                <td><span id="teacher_specialty"><?= $row["teacher_specialty"] ?></span></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                </table>
                                <div class="d-flex justify-content-end">
                                    <div>
                                        <a class="btn btn-warning me-3" href="teacher-list.php">回到教師清單</a>


                                        <a class="btn btn-warning" type="submit" href="teacher-edit.php?teacher_id=<?= $row["teacher_id"] ?>">編輯教師資訊</a>
                                    </div>
                                </div>
                            </div>
                        </div>
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


    <!-- j-query -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous">
    </script>



</body>

</html>