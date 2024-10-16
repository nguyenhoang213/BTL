<?php

include("../connection.php");
if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
    echo "<script>
                alert('Không thể thực hiện hành động này');
                // Quay lại trang trước
                window.location.href = '" . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'http://localhost/BTL/admin.php') . "';
            </script>";

}
// Lấy user_id từ URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Câu lệnh SQL để xóa tài khoản user theo user_id
    $sql_delete_user = "DELETE FROM User WHERE user_id = '$user_id'";
    // Kiểm tra kết quả truy vấn
    // print_r($conn->query($sql_delete_user)?"true":"false");
    if ($conn->query($sql_delete_user) === TRUE) {
        echo "
            <script>
                alert('Xóa tài khoản user thành công!');
                window.location.href = '../account/user_account.php'; // Điều hướng về danh sách tài khoản user
            </script>";
    } else {
        echo "
            <script>
                alert('Không thể xóa tài khoản user!');
                window.location.href = '../account/user_account.php'; // Điều hướng về danh sách tài khoản user
            </script>";
    }
} else {
    echo "
        <script>
            alert('Không tìm thấy tài khoản để xóa!');
            window.location.href = '../account/user_account.php'; // Điều hướng về danh sách tài khoản user
        </script>";
}

$conn->close();
?>