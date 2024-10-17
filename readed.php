<?php
// Kết nối cơ sở dữ liệu
include("connection.php");

// Lấy notification_id và order_id từ URL
if (isset($_GET['notification_id']) && isset($_GET['id'])) {
    $notification_id = $_GET['notification_id'];
    $order_id = $_GET['id'];

    // Truy vấn cập nhật trạng thái thông báo thành đã đọc
    $sql_update = "UPDATE admin_notification SET status = 1 WHERE id = $notification_id";  // 1 là đã đọc
    if ($conn->query($sql_update) === TRUE) {
        // Sau khi cập nhật, chuyển hướng đến trang chi tiết hóa đơn
        echo '<script> window.location.href = "/BTL/order/order_detail.php?id=' . $order_id . '" </script>';
    } else {
        echo "Lỗi khi cập nhật trạng thái: " . $conn->error;
    }
} else {
    echo "Dữ liệu không hợp lệ";
}
?>