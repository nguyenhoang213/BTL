<?php
include("../connection.php");

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit();
}

$user_id = $_SESSION['user_id']; // Lấy user_id từ session

// Kiểm tra nếu product_id được gửi qua phương thức POST
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Xóa sản phẩm khỏi danh sách yêu thích
    $sql = "DELETE FROM user_favorites WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user_id, $product_id);

    if ($stmt->execute()) {
        echo "<script>alert('Đã xóa sản phẩm khỏi danh sách yêu thích.'); window.location.href = 'wishlist.php';</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra khi xóa sản phẩm.'); window.location.href = 'wishlist.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>