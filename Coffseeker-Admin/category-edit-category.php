<?php

if(!isset($_GET["id"])){
    header("location: 404php");
}

$id=$_GET["id"];

require_once("../db_connect.php");
$sql="SELECT * FROM categories WHERE categories_id=$id";
$result= $conn->query($sql);
$row= $result->fetch_assoc();


?> 
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit-Category</title>

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
            <h1 class="text-center" >編輯分類</h1>
            <form action="action/category/doUpdate.php" method="post">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>分類編號</th>
                            <td>
                                <input type="text" readonly class="form-control-plaintext"  value="<?= $row["categories_id"]?>" name="id">
                            </td>

                        </tr>
                        <tr>
                            <th>分類名稱</th>
                            <td>
                                <input type="text" class="form-control" value="<?= $row["categories_name"]?>" name="name">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    <div>
                        <a class="btn btn-secondary" href="category.php?id=<?= $row["categories_id"]?>" >取消</a>
                        <button class="btn btn-warning" type="submit">確認</button>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

</body>

</html>