<?php
include("../connection.php");

// Kiểm tra nếu có ID được truyền qua URL
if (isset($_GET['id'])) {
    $voucher_id = $_GET['id'];

    // Xóa voucher theo ID
    $sql = "DELETE FROM voucher WHERE voucher_id = ?";

    // Chuẩn bị câu truy vấn
    if ($stmt = $conn->prepare($sql)) {
        // Gán giá trị cho biến
        $stmt->bind_param("i", $voucher_id);

        // Thực thi câu truy vấn
        if ($stmt->execute()) {
            // Nếu xóa thành công, chuyển hướng về trang danh sách
            echo "<script>alert('Xóa chương trình khuyến mại thành công.'); window.location.href = '/BTL/voucher/voucher_list.php';</script>";
        } else {
            // Nếu xảy ra lỗi
            echo "<script>alert('Lỗi trong quá trình xóa chương trình. Vui lòng thử lại sau.'); window.location.href = '/BTL/voucher/voucher_list.php';</script>";
        }

        // Đóng truy vấn
        $stmt->close();
    } else {
        echo "Lỗi chuẩn bị câu truy vấn: " . $conn->error;
    }
} else {
    // Nếu không có ID, chuyển hướng về trang danh sách
    echo "<script>alert('Không tìm thấy ID của chương trình.'); window.location.href = '/BTL/voucher/voucher_list.php';</script>";
}

// Đóng kết nối
$conn->close();
?>