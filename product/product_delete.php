<?php
include("../connection.php");

// Lấy product_id từ URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $sql = "Delete FROM Product WHERE product_id = '$product_id'";
    if ($conn->query($sql) === TRUE) {
        echo "
            <script>
                alert('Xóa sản phẩm thành công!');
                window.location.href = '../product/product_list.php';
            </script>";
    } else {
        echo "
            <script>
                alert('Không thể xóa sản phẩm!');
                window.location.href = '../product/product_list.php';
            </script>";
    }
}

$conn->close();
?>