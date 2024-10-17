<?php


include("../side_nav.php");
if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
    echo "<script>
                alert('Không thể thực hiện hành động này');
                // Quay lại trang trước
                window.location.href = '" . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'http://localhost/BTL/admin.php') . "';
            </script>";

}
// Truy vấn mặc định để lấy tất cả tài khoản Admin
$sql = "SELECT * FROM Admin_account";
$result = $conn->query($sql);
$search_category = "admin_id";  // Mặc định tìm kiếm theo ID admin
?>

<?php
// Xử lý chức năng tìm kiếm
if (isset($_GET["search"])) {
    $search_category = $_GET["search_category"];
    $search_string = $_GET["search"];
    // Truy vấn tìm kiếm trên bảng Admin_account thay vì Product
    $sql = "SELECT * FROM Admin_account WHERE $search_category LIKE '%$search_string%'";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/BTL/css/list.css">
    <title>Quản lý thông tin tài khoản Admin</title>
</head>

<body>
    <div class="content">
        <h1>Quản lý thông tin tài khoản Admin</h1>
        <form action="" method="get">
            <label for="search">Tìm kiếm tài khoản:</label>
            <select name="search_category">
                <option value="admin_id" <?php if ($search_category == "admin_id")
                    echo 'selected'; ?>>ID tài khoản
                </option>
                <option value="admin_name" <?php if ($search_category == "admin_name")
                    echo 'selected'; ?>>Tên tài khoản
                </option>
            </select>
            <input type="text" id="search" name="search" placeholder="Nhập từ khóa">
            <button type="submit">Tìm kiếm</button>
        </form>

        <a href="../account/admin_account_create.php">Thêm tài khoản</a>

        <table>
            <tr>
                <th>ID</th>
                <th>Tên admin</th>
                <th>Mật khẩu</th>
                <th>Quyền</th>
                <th>Cập nhật</th>
                <th>Xóa</th>
            </tr>

            <?php
            // Hiển thị thông tin tài khoản Admin
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['admin_id'] . "</td>";
                    echo "<td>" . $row['admin_name'] . "</td>";
                    echo "<td>" . $row['password'] . "</td>";
                    echo "<td>" . ($row['role'] == 1 ? 'Admin' : 'Super Admin') . "</td>";
                    // Nút chỉnh sửa và xóa
                    echo "<td><a href='/BTL/account/admin_account_update.php?id=" . $row['admin_id'] . "'>Chỉnh sửa</a></td>";
                    echo "<td><a href='/BTL/account/admin_account_delete.php?id=" . $row['admin_id'] . "' onclick=\"return confirm('Bạn có chắc chắn muốn xóa tài khoản này?');\">Xóa</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Không có tài khoản nào!</td></tr>";
            }

            // Đóng kết nối
            $conn->close();
            ?>
        </table>
    </div>
</body>

</html>