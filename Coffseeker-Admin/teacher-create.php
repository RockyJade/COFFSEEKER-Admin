<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Teacher-Create</title>

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
                    <h1 class="text-center">新增教師</h1>
                    <form action="action/teacher/doCreate.php" method="post" class="col-4 mx-auto bordered mt-5" enctype="multipart/form-data">
                        <div class="mb-2">
                            <label for="name" class="fw-bold">姓名</label>
                            <input type="text" id="name" class="form-control" name="teacher_name" minlength="2" required>

                        </div>
                        <div class="mb-2">
                            <label for="phone" class="fw-bold">電話號碼</label>
                            <input id="phone" class="form-control" name="teacher_phone" pattern="\d{10}" required>
                        </div>
                        <div class="mb-2">
                            <label for="mail" class="fw-bold">電子郵件</label>
                            <input type="email" id="mail" class="form-control" name="teacher_mail" placeholder="" pattern="/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/" required>
                        </div>
                        <div class="mb-2" class="fw-bold">
                            <label for="" class="fw-bold">性別</label>
                            <div class="form-check">
                                <input id="male" class="form-check-input" type="radio" name="teacher_gender" value="男" required>
                                <label class="form-check-label" for="male">男性</label>
                            </div>
                            <div class="form-check">
                                <input id="female" class="form-check-input" type="radio" name="teacher_gender" value="女" required>
                                <label class="form-check-label" for="female">女性</label>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="" class="fw-bold">教師資格</label>
                            <br>
                            <!-- <input type="text" class="form-control" name="teacher_qualification" placeholder=""> -->
                            <input type="checkbox" id="option1" name="teacher_qualification[]" value="咖啡師證照">
                            <label for="option1">咖啡師證照</label>

                            <input type="checkbox" id="option2" name="teacher_qualification[]" value="咖啡品鑑師">
                            <label for="option2">咖啡品鑑師</label>

                            <input type="checkbox" id="option3" name="teacher_qualification[]" value="咖啡萃取師">
                            <label for="option3">咖啡萃取師</label>
                            <input type="checkbox" id="option4" name="teacher_qualification[]" value="咖啡烘焙師">
                            <label for="option4">咖啡烘焙師</label>
                            <br>
                            <label for="option5" class="mt-3">其他:</label>
                            <br>
                            <input name="teacher_qualification[]" id="option6" class="form-control"></input>

                        </div>
                        <div class="mb-2">
                            <label for="qualification" class="fw-bold">教學年資(單位:年)</label>
                            <div>
                                <input id="qualification" type="number" class="form-control " name="teacher_experience" min="0" required style="">
                            </div>

                        </div>

                        <div class="mb-2">
                            <label for="specialty" class="fw-bold">教師專長</label>
                            <input type="text" id="specialty" class="form-control" name="teacher_specialty" placeholder="" required>
                        </div>
                        <div class="mb-2">
                            <label for="teacher_img" class="fw-bold">選擇頭像</label>
                            <input type="file" class="form-control " id="imageUpload" name="teacher_img" accept="image/jpeg, image/png, image/gif, image/webp">
                            <div class="mt-3 d-flex justify-content-center mw-100">
                                <!-- <i class="fa-solid fa-camera" class="camera"></i> -->
                                <img src="" class="border shadow object-fit-cover overflow-hidden" alt="" id="createImg">
                            </div>

                        </div>
                        <div class="d-flex justify-content-around mt-4">
                            <button class="btn btn-warning" type="submit">送出</button>
                            <a class="btn btn-danger ms-5" href="teacher-list.php">取消</a>
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
        const createImg = document.getElementById("createImg");
        const camera=document.querySelector(".camera");

        imageUpload.addEventListener("change", function() {
            // camera.style.display=none;
            const reader = new FileReader();
            reader.onload = function() {
                createImg.src = reader.result;
            }
            reader.readAsDataURL(this.files[0]);
        });
    </script>


    <!-- j-query -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous">
    </script>



</body>

</html>