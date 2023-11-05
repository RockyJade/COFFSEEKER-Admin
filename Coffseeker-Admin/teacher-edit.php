<?php

$id = $_GET["teacher_id"];

require_once("../db_connect.php");



$sql = "SELECT * FROM coffseeker_teachers WHERE teacher_id=$id";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

// print_r($rows);



?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Teacher-Edit</title>

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

                

                <!-- modal start -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="mb-3">
                                        <h4>確定要刪除嗎?</h4>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                                <a href="action/teacher/doDelete.php?teacher_id=<?= $id ?>" class="btn btn-danger">刪除教師</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal end -->
                <div class="container my-5">
                <h1 class="text-center">編輯教師資訊</h1>
                    <form action="action/teacher/doEdit.php" class="form" method="post" enctype="multipart/form-data">
                        <table class="table table-bordered">
                            <?php foreach ($rows as $row) : ?>
                                <tr>
                                    <th>頭像</th>
                                    <td class="">
                                        <img class="object-fit-cover mw-100 overflow-hidden w-25 mb-3" id="replaceImg" src="action/teacher/teacher-img/<?= $row["teacher_img"] ?>" alt="">

                                        <input type="file" name="teacher_img" id="imageUpload" accept="image/jpeg, image/png, image/gif, image/webp">
                                        <!-- <div>
                                            <img type="file"  src="" alt="your image" >
                                        </div> -->

                                    </td>
                                </tr>
                                <tr>
                                    <input type="hidden" name="teacher_id" value="<?= $row["teacher_id"] ?>">
                                </tr>

                                <tr>
                                    <th>姓名</th>
                                    <td><input id="name" class="form-control" name="teacher_name" value="<?= $row["teacher_name"] ?>"></td>
                                </tr>
                                <tr>
                                    <th>性別</th>
                                    <td><span id="name" name="teacher_gender" value="<?= $row["teacher_gender"] ?>"><?= $row["teacher_gender"] ?>
                                        </span>
                                        <input type="hidden" name="teacher_gender" value="<?= $row["teacher_gender"] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><input id="email" class="form-control" name="teacher_mail" value="<?= $row["teacher_mail"] ?>"></td>
                                </tr>
                                <tr>
                                    <th>電話號碼</th>
                                    <td><input id="phone" class="form-control" name="teacher_phone" value="<?= $row["teacher_phone"] ?>"></td>
                                </tr>
                                <tr>
                                    <th>教師資格</th>
                                    <td><input id="teacher_qualification" class="form-control" name="teacher_qualification" value="<?= $row["teacher_qualification"] ?>"></td>
                                </tr>
                                <tr>
                                    <th>教師年資</th>
                                    <td><input id="teacher_experience" class="form-control" name="teacher_experience" value="<?= $row["teacher_experience"] ?>"></td>
                                </tr>
                                <tr>
                                    <th>教師專長</th>
                                    <td><input id="teacher_specialty" class="form-control" name="teacher_specialty" value="<?= $row["teacher_specialty"] ?>"></td>
                                </tr>
                            <?php endforeach; ?>

                        </table>
                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="submit" class="btn btn-warning">送出</button>
                                <a href="teacher-list.php" class="btn btn-warning">回到教師清單</a>
                            </div>

                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">刪除教師</button>
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
    <script>
        const imageUpload = document.getElementById("imageUpload");
        const replaceImg = document.getElementById("replaceImg");

        imageUpload.addEventListener("change", function() {
            // console.log('123');
            const reader = new FileReader();
            reader.onload = function() {
                replaceImg.src = reader.result;
            }
            reader.readAsDataURL(this.files[0]);
        });
    </script>

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