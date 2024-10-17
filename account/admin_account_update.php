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

    // Truy vấn thông tin tài khoản admin theo admin_id
    $sql = "SELECT * FROM Admin_account WHERE admin_id = '$admin_id'";
    $result = $conn->query($sql);

    // Kiểm tra nếu tài khoản admin tồn tại
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
    } else {
        echo "Tài khoản không tồn tại!";
        exit();
    }
}

// Xử lý khi form cập nhật được submit
if (isset($_POST['update'])) {
    $admin_name = $_POST['admin_name'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Cập nhật thông tin tài khoản admin trong cơ sở dữ liệu
    $sql = "UPDATE Admin_account 
                SET admin_name='$admin_name', password='$password', role='$role' 
                WHERE admin_id='$admin_id'";

    if ($conn->query($sql) === TRUE) {
        echo "
            <script>
                alert('Cập nhật thông tin tài khoản thành công!');
                window.location.href = '../account/admin_account.php';
            </script>
            ";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/BTL/css/create.css">
    <title>Chỉnh sửa tài khoản Admin</title>
</head>

<body>
    <div class="content">
        <h1>Chỉnh sửa tài khoản Admin</h1>

        <form action="" method="post">
            <label for="admin_name">Tên tài khoản</label>
            <input type="text" name="admin_name" value="<?php echo $admin['admin_name']; ?>" required> <br>

            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" value="<?php echo $admin['password']; ?>" required>
            <br>

            <label for="confirm_password">Xác nhận mật khẩu</label>
            <input type="password" id="confirm_password" name="confirm_password"
                value="<?php echo $admin['password']; ?>" required> <br>

            <!-- Checkbox hiển thị mật khẩu -->
            <input type="checkbox" id="show_password"> Hiển thị mật khẩu <br>

            <label for="role">Quyền</label>
            <select name="role" required>
                <option value="1" <?php if ($admin['role'] == '1')
                    echo 'selected'; ?>>Admin</option>
                <option value="0" <?php if ($admin['role'] == '0')
                    echo 'selected'; ?>>Super Admin
                </option>
            </select> <br>

            <button name="update">Cập nhật</button>
        </form>
    </div>

    <script>
        // Hiển thị/ẩn mật khẩu
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        const showPassword = document.getElementById('show_password');

        showPassword.addEventListener('change', function () {
            const type = this.checked ? 'text' : 'password';
            password.type = type;
            confirmPassword.type = type;
        });

        // Kiểm tra mật khẩu xác nhận trước khi submit form
        const form = document.querySelector('form');
        form.addEventListener('submit', function (e) {
            if (password.value !== confirmPassword.value) {
                e.preventDefault(); // Ngăn không cho gửi form
                alert('Mật khẩu và mật khẩu xác nhận không khớp!');
            }
        });
    </script>
</body>

</html>