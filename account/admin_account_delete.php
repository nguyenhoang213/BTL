<?php

include("../side_nav.php");
if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
    echo "<script>
                alert('Không thể thực hiện hành động này');
                // Quay lại trang trước
                window.location.href = '" . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'http://localhost/BTL/admin.php') . "';
            </script>";

}
// Lấy admin_id từ URL
if (isset($_GET['id'])) {
    $admin_id = $_GET['id'];
    if ($_SESSION['admin_id'] !== $admin_id) {
        // Câu lệnh SQL để xóa tài khoản admin theo admin_id
        $sql = "DELETE FROM Admin_account WHERE admin_id = '$admin_id'";
        // Kiểm tra kết quả truy vấn
        if ($conn->query($sql) === TRUE) {
            echo "
                <script>
                    alert('Xóa tài khoản Admin thành công!');
                    window.location.href = '../account/admin_account.php'; // Điều hướng về danh sách tài khoản admin
                </script>";
        } else {
            echo "
                <script>
                    alert('Truy vấn lỗi!');
                    window.location.href = '../account/admin_account.php'; // Điều hướng về danh sách tài khoản admin
                </script>";
        }
    } else {
        echo "
            <script>
                alert('Không thể xóa tài khoản Admin!');
                window.location.href = '../account/admin_account.php'; // Điều hướng về danh sách tài khoản admin
            </script>";
    }
} else {
    echo "
        <script>
            alert('Không tìm thấy tài khoản để xóa!');
            window.location.href = '../account/admin_account.php'; // Điều hướng về danh sách tài khoản admin
        </script>";
}

$conn->close();
?>