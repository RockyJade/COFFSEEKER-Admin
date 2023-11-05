<?php

require_once("../../../db_connect.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // $product_id=$_POST["product-id"];
    // $product_category = $_POST["product-category"];
    $product_brand = $_POST["product-brand"];
    $product_name = $_POST["product-name"];
    $product_amount = $_POST["product-amount"];
    $product_price = $_POST["product-price"];
    $product_description = $_POST["product-description"];
    $product_valid = $_POST["product-valid"];


    // 處理上傳的圖片
    $target_dir = "../../images/"; // 儲存的資料夾
    $target_path="images/" . $_FILES["product-image"]["name"];
    $target_file = $target_dir . basename($_FILES["product-image"]["name"]); // 取得圖片檔案的路徑
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // 取得圖片的副檔名

    // 將圖片移動到指定的資料夾
    if (!move_uploaded_file($_FILES["product-image"]["tmp_name"], $target_file)) {
        die("圖片上傳失敗。");
    }

    // 將商品類別轉換為字串
    $selectedCategories = implode(', ', (array) $product_category);

    // 取得當前日期和時間
    $currentDateTime = date('Y-m-d H:i:s');

    // 將商品上下架欄位轉換為數字
    $product_valid = ($_POST["product-valid"] == "上架") ? 1 : 0;



    // 將商品資料插入資料庫
    $sql = "INSERT INTO product (product_category, product_brand, product_name, product_amount, product_price, product_description, product_image, created_at, updated_at, product_valid) VALUES ('$selectedCategories', '$product_brand', '$product_name', '$product_amount', '$product_price', '$product_description', '$target_path', '$currentDateTime', '$currentDateTime', '$product_valid')";

    if ($conn->query($sql) === TRUE) {
        $message = "商品上傳成功！";
        header("location: ../../product-list.php");
        // $status = "success";
    } else {
        $message = "商品上傳失敗：" . $conn->error;
        // $status = "danger";
    }
}

// 關閉資料庫連線
$conn->close();
?>

