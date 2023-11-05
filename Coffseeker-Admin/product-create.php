<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Product-Create</title>

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


                <div class="container-sm" style="width:500px">
                    <h1 class="text-center">新增商品</h1>
                    <div class="py-2">
                        <a class="btn btn-warning mb-3" href="product-list.php">回商品列表</a>
                    </div>
                    <form action="action/product/doCreate.php" method="POST" enctype="multipart/form-data" id="product-form">
                        <div class="mb-3">
                            <label for="product-name" class="form-label">商品名稱</label>
                            <input type="text" class="form-control" id="product-name" name="product-name" required placeholder="請輸入商品名稱">
                        </div>
                        <div class="mb-3">
                            <label for="product-brand" class="form-label">商品品牌</label>
                            <input type="text" class="form-control" id="product-brand" name="product-brand" required placeholder="請輸入商品品牌">
                        </div>
                        <!-- 商品類別 先隱藏了! -->
                        <!-- <div class="mb-3">
                <label for="product-category" class="form-label">商品類別</label><br>
                <input type="checkbox" name="product-category[]" value="1"> 淺焙
                <input type="checkbox" name="product-category[]" value="2"> 中焙
                <input type="checkbox" name="product-category[]" value="3"> 深焙
                <input type="checkbox" name="product-category[]" value="4"> 日曬
                <input type="checkbox" name="product-category[]" value="5"> 水洗
                <input type="checkbox" name="product-category[]" value="6"> 花香
                <input type="checkbox" name="product-category[]" value="7"> 酒香
                <input type="checkbox" name="product-category[]" value="8"> 手沖
                <input type="checkbox" name="product-category[]" value="9"> 濾掛
                <input type="checkbox" name="product-category[]" value="10"> 禮盒
            </div> -->
                        <div class="mb-3">
                            <label for="product-amount" class="form-label">商品數量</label>
                            <input type="number" class="form-control" id="product-amount" name="product-amount" required placeholder="請輸入商品數量">
                        </div>
                        <div class="mb-3">
                            <label for="product-price" class="form-label">商品價格</label>
                            <input type="number" class="form-control" id="product-price" name="product-price" required placeholder="請輸入商品價格">
                        </div>
                        <div class="mb-3">
                            <label for="product-description" class="form-label">商品描述</label>
                            <textarea class="form-control" id="product-description" name="product-description" required rows="3" cols="30" style="resize: none" placeholder="請輸入商品描述"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="product-image" class="form-label">商品圖片</label>
                            <input type="file" class="form-control" id="product-image" name="product-image" required>
                        </div>
                        <div class="mb-3 d-flex align-items-center">
                            <label for="preview-image" class="form-label me-2">預覽圖片</label>
                            <div id="img-preview" class="img-prev">
                                <img id="preview-image" src="#" alt="" style="max-width: 200px; max-height: 200px;">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="product-valid" class="form-label">商品上架</label>
                            <select class="form-select" id="product-valid" name="product-valid" required>
                                <option value="">請選擇狀態</option>
                                <option value="上架">上架</option>
                                <option value="下架">下架</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-warning mb-3">上傳</button>
                        </div>
                    </form>

                </div>

                <script>
                    // 在使用者選擇圖片後，顯示預覽圖片
                    function showPreview() {
                        var fileInput = document.getElementById('product-image');
                        var previewImage = document.getElementById('preview-image');

                        if (fileInput.files && fileInput.files[0]) {
                            var reader = new FileReader();

                            reader.onload = function(e) {
                                previewImage.setAttribute('src', e.target.result);
                            };

                            reader.readAsDataURL(fileInput.files[0]);
                        }
                    }

                    // 監聽圖片選擇事件
                    var fileInput = document.getElementById('product-image');
                    fileInput.addEventListener('change', showPreview);
                </script>
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

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>


    <!-- j-query -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous">
    </script>



</body>

</html>