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

    <title>User-Detail</title>

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
                
                <div class="container-fluid my-5">
                
                <h1 class="text-center py-2">會員詳細資料</h1>

                        <!-- <nav aria-label="breadcrumb ps-0">
                            <ol class="breadcrumb py-3">
                                <li class="breadcrumb-item"><a href="index.php">INDEX</a></li>
                                <li class="breadcrumb-item"><a href="user-list.php"><i class="fa-solid fa-caret-left"></i> 會員清單</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-caret-left"></i> <?= $coffusers["user_name"] ?></li>
                            </ol>
                        </nav> -->
                        <!-- <a href="user-list.php" class="btn btn-warning mt-4 ms-0"><i class="fa-solid fa-caret-left"></i> 返回會員清單</a> -->
                
                    <div class="row justify-content-between align-content-center">
                        
                        <div class="card col-6 my-3 d-flex align-content-center">
                            <div class="user-icon-box overflow-hidden">
                                <img src="img/user-icon/<?= $coffusers["user_icon"] ?>" class="" alt="...">
                            </div>
                        </div>
                        <div class="card col-6 my-3">
                            <div class="card-body">
                                <h1 class="h6 card-title">名稱 </h1>
                                <span class="h3"><?= $coffusers["user_name"] ?></span>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    性別 : <?= $coffusers["user_gender"] ?>
                                </li>
                                <li class="list-group-item">
                                    電話 : <?= $coffusers["user_phone"] ?>
                                </li>
                                <li class="list-group-item">
                                    E-mail : <?= $coffusers["user_email"] ?>
                                </li>
                                <li class="list-group-item">
                                    生日 : <?= $coffusers["user_birthday"] ?>
                                </li>
                                <li class="list-group-item">
                                    會員等級 : <?= $coffusers["user_grade"] ?>
                                </li>
                                <li class="list-group-item">
                                    加入時間 : <?= $coffusers["user_created_at"] ?>
                                </li>
                            </ul>
                            <div class="card-body d-flex justify-content-between">
                                <!-- <a href="user-edit.php?id=<?= $id ?>" class="card-link btn btn-warning">編輯資料</a> -->
                                <!-- <a href="user-list.php" class="btn btn-warning mt-4 ms-0"><i class="fa-solid fa-caret-left"></i> 返回會員清單</a> -->
                                <a href="user-list.php" class="card-link btn btn-warning"><i class="fa-solid fa-caret-left"></i> 返回會員清單</a>
                                <a href="user-edit.php?id=<?= $id ?>" class="card-link btn btn-warning">編輯資料</a>
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

</body>

</html>