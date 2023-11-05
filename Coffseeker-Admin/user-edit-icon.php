<?php
if (!isset($_GET["id"])) {
    // die("資料不存在");
    header("location: 404.php");
}
$id = $_GET["id"];

require_once("../db_connect.php");

$coffsql = "SELECT users.* ,

user_grade.grade AS user_grade FROM users 

JOIN user_grade ON user_grade.grade_id = users.user_grade_id

WHERE id=$id AND user_valid = 1 ORDER BY id ASC";

$getuser = $conn->query($coffsql);
$coffusers = $getuser->fetch_assoc();


// $sql="SELECT * FROM users WHERE id=$id AND valid=1";
// $result = $conn->query($sql);
// $row = $result->fetch_assoc();
// // var_dump($row);

// $sqlLike="SELECT user_like.*, product.name AS product_name FROM user_like
// JOIN product ON user_like.product_id = product.id
// WHERE user_like.user_id = $id";
// $resultLike = $conn->query($sqlLike);
// $rowsLike = $resultLike->fetch_all(MYSQLI_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>User-Edit</title>

    <?php include("modal/template.php") ?>
</head>

<body id="page-top">
    <!-- Delete Modal Start-->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center flex-column align-items-center">
                    <h1><i class="fa-solid fa-triangle-exclamation fa-beat" style="color: #ff0000;"></i></h1>
                    <h1 class="modal-title fs-5 text-center text-danger" id="">警告</h1>
                </div>
                <div class="modal-body text-center text-dark">
                    確認刪除?
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">取消</button>
                    <a href="action/users/doDelete.php?id=<?=$id?>" class="btn btn-danger">確認</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Modal End-->





    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include("modal/sidebar.php") ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include("modal/topbar.php") ?>

                <!-- ↓↓放置內容↓↓-->
                <div class="container-fluid my-5">

                <h1 class="text-center py-4">編輯會員資料</h1>
                    <div class="row justify-content-between align-content-center">

                        <div class="card col-6 my-3 d-flex align-content-center">

                            <div class="user-icon-box overflow-hidden">
                                <img src="img/user-icon/<?= $coffusers["user_icon"] ?>" class="object-fit-cover mw-100" alt="...">
                            </div>
                            <form action="action/users/doIconUpload.php" method="post" enctype="multipart/form-data">
                                <div class="d-flex justify-content-center">
                                    <!-- 上傳大頭貼 -->
                                    <input type="hidden" name="id" value="<?= $coffusers["id"] ?>">
                                    <input type="file" name="icon" class="icon-select form-control" required>
                                    <button type="submit" class="icon-upload btn btn-warning">更換</button>
                                </div>
                            </form>
                        </div>
                        <div class="card col-6 my-3">
                            <!-- Form -->
                            <form action="action/users/doEdit.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $coffusers["id"] ?>">
                                <div class="card-body">
                                    <h1 class="h6 card-title">名稱 </h1>
                                    <input class="h3 form-control" value="<?= $coffusers["user_name"] ?>" placeholder="" name="name"></input>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        性別 :
                                        <select class="form-select form-control" aria-label="gender" name="gender">
                                            <option value="Male" <?php if($coffusers["user_gender"] == "Male") echo "selected"; ?> >Male</option>
                                            <option value="Female" <?php if($coffusers["user_gender"] == "Female") echo "selected"; ?>>Female</option>
                                            <option value="LGBTQIA+" <?php if($coffusers["user_gender"] == "LGBTQIA+") echo "selected"; ?>>LGBTQIA+</option>
                                            <option value="Private" <?php if($coffusers["user_gender"] == "Private") echo "selected"; ?>>Private</option>
                                        </select>
                                    </li>
                                    <li class="list-group-item">
                                        電話 :
                                        <input class="form-control" value="<?= $coffusers["user_phone"] ?>" placeholder="" name="phone"></input>
                                    </li>
                                    <li class="list-group-item">
                                        E-mail :
                                        <input class="form-control" value="<?= $coffusers["user_email"] ?>" placeholder="" name="email"></input>
                                    </li>
                                    <li class="list-group-item">
                                        生日 :
                                        <input type="date" class="form-control" value="<?= $coffusers["user_birthday"] ?>" placeholder="" name="birthday"></input>
                                    </li>
                                    <li class="list-group-item">
                                        會員等級 :
                                        <select class="form-select form-control" aria-label="Grade" value="<?= $coffusers["user_grade"] ?>" name="grade">
                                            <option value="1" <?php if($coffusers["user_grade_id"] == 1) echo "selected"; ?>>一般會員</option>
                                            <option value="2" <?php if($coffusers["user_grade_id"] == 2) echo "selected"; ?>>VIP</option>
                                            <option value="3" <?php if($coffusers["user_grade_id"] == 3) echo "selected"; ?>>未認證</option>
                                        </select>
                                    </li>
                                    <li class="list-group-item">
                                        加入時間 : <?= $coffusers["user_created_at"] ?>
                                    </li>
                                    <li class="list-group-item">
                                    </li>
                                </ul>
                                <div class="card-body d-flex justify-content-between">
                                    <div class="">
                                        <a href="user-detail.php?id=<?= $id ?>" class="card-link btn btn-warning">返回</a>
                                        <button type="submit" class="card-link btn btn-warning">儲存</button>
                                    </div>
                                    <button class="card-link btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        刪除
                                    </button>

                                </div>
                            </form>
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
    <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>