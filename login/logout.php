<?php
// Bắt đầu session
include("../connection.php");
// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION['user_id'])) {
    // Hủy bỏ tất cả các session
    session_unset(); // Xóa tất cả các biến session
    session_destroy(); // Hủy session hiện tại

    // Chuyển hướng về trang đăng nhập hoặc trang chính
    echo "<script>alert('Đăng xuất thành công');</script>";
    echo "<script>window.location.href = 'http://localhost/BTL/index.php';</script>";
    exit();
} else {
    // Nếu chưa đăng nhập, chuyển hướng trực tiếp về trang login
    echo "<script>window.location.href = 'http://localhost/BTL/index.php';</script>";
    exit();
}
?>