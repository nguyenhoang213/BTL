<?php


include("../connection.php");

    // Lấy product_id từ URL
    if (isset($_GET['product'])) {
        $product_id = $_GET['product'];
        $category_id = $_GET['category'];
        $sql = "Delete FROM product_category WHERE product_id = '$product_id' and category_id = '$category_id'";
        if($conn->query($sql) === TRUE) {
            echo "
            <script>
                alert('Xóa sản phẩm thành công!');
                window.location.href = '../category/category_product.php?danhMuc=".$category_id."';
            </script>";
        } else {
            echo "
            <script>
                alert('Không thể xóa sản phẩm!');
                window.location.href = '../category/category_product?danhMuc=".$category_id.".php';
            </script>";
        }
    }

    $conn->close();
?>