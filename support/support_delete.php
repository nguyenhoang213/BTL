<?php
include("../connection.php"); // Kết nối tới cơ sở dữ liệu

// Lấy support_id từ URL
if (isset($_GET['support_id'])) {
    $support_id = $_GET['support_id'];

    // Truy vấn để xóa yêu cầu hỗ trợ dựa trên support_id
    $sql = "DELETE FROM support WHERE support_id = '$support_id'";

    // Thực thi truy vấn
    if ($conn->query($sql) === TRUE) {
        // Hiển thị thông báo thành công và chuyển hướng về trang danh sách yêu cầu hỗ trợ
        echo "
            <script>
                alert('Xóa yêu cầu hỗ trợ thành công!');
                window.location.href = '../support/support_list.php';
            </script>";
    } else {
        // Hiển thị thông báo lỗi và chuyển hướng về trang danh sách yêu cầu hỗ trợ
        echo "
            <script>
                alert('Không thể xóa yêu cầu hỗ trợ!');
                window.location.href = '../support/support_list.php';
            </script>";
    }
}

// Đóng kết nối
$conn->close();
?>