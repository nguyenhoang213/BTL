<?php


include("../connection.php");

// Lấy product_id từ URL
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    $sql = "Delete FROM Category WHERE category_id = '$category_id'";
    if ($conn->query($sql) === TRUE) {
        echo "
            <script>
                alert('Xóa danh mục thành công!');
                window.location.href = '../category/category_list.php';
            </script>";
    } else {
        echo "
            <script>
                alert('Không thể xóa danh mục!');
                window.location.href = '../category/category_list.php';
            </script>";
    }
}

$conn->close();
?>