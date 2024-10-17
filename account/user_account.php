<?php
include("../side_nav.php");
if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
    echo "<script>
                alert('Không thể thực hiện hành động này');
                // Quay lại trang trước
                window.location.href = '" . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'http://localhost/BTL/admin.php') . "';
            </script>";
}
?>
<?php
// Truy vấn mặc định để lấy tất cả tài khoản user
$sql = "SELECT * FROM user";
$result = $conn->query($sql);
$search_category = "user_id";  // Mặc định tìm kiếm theo ID user

// Xử lý chức năng tìm kiếm
if (isset($_GET["search"])) {
    $search_category = $_GET["search_category"];
    $search_string = $_GET["search"];
    // Truy vấn tìm kiếm trên bảng Admin_account thay vì Product
    $sql = "SELECT * FROM user WHERE $search_category LIKE '%$search_string%'";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/BTL/css/list.css">
    <title>Quản lý thông tin tài khoản User</title>
</head>

<body>
    <div class="content">
        <h1>Quản lý thông tin tài khoản User</h1>
        <form action="" method="get">
            <label for="search">Tìm kiếm tài khoản:</label>
            <select name="search_category">
                <option value="user_id" <?php if ($search_category == "user_id")
                    echo 'selected'; ?>>ID tài khoản
                </option>
                <option value="email" <?php if ($search_category == "email")
                    echo 'selected'; ?>>Tên tài khoản
                </option>
            </select>
            <input type="text" id="search" name="search" placeholder="Nhập từ khóa">
            <button type="submit">Tìm kiếm</button>
        </form>

        <!-- <a href="../account/user_account_create.php">Thêm tài khoản</a> -->

        <table>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Tên</th>
                <th>Xóa</th>
            </tr>

            <?php
            // Hiển thị thông tin tài khoản user
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['user_id'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>{$row['first_name']} {$row['last_name']}</td>";
                    // Nút chỉnh sửa và xóa
                    echo "<td><a href='/BTL/account/user_account_delete.php?id=" . $row['user_id'] . "' onclick=\"return confirm('Bạn có chắc chắn muốn xóa tài khoản của user này?');\">Xóa</a></td>";
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