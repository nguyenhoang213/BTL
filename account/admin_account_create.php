<?php


include("../side_nav.php");
if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
    echo "<script>
                alert('Không thể thực hiện hành động này');
                // Quay lại trang trước
                window.location.href = '" . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'http://localhost/BTL/admin.php') . "';
            </script>";

}
$id = generateUniqueId(12);

function generateUniqueId($length = 8)
{
    return bin2hex(random_bytes($length / 2));
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm tài khoản Admin</title>
    <link rel="stylesheet" href="/BTL/css/create.css">
</head>

<body>
    <div class="content">
        <h1>Thêm tài khoản Admin</h1>

        <form action="" method="post">
            <label for="admin_id">ID tài khoản</label>
            <input type="text" name="admin_id" required value="<?php echo $id ?>"> <br>

            <label for="admin_name">Tên tài khoản</label>
            <input type="text" name="admin_name" required> <br>

            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" required> <br>

            <label for="confirm_password">Xác nhận mật khẩu</label>
            <input type="password" id="confirm_password" name="confirm_password" required> <br>

            <!-- Checkbox hiển thị mật khẩu -->
            <input type="checkbox" id="show_password"> Hiển thị mật khẩu <br>

            <label for="role">Quyền</label>
            <select name="role" required>
                <option value="1">Admin</option>
                <option value="0">Super Admin</option>
            </select> <br>

            <button name="submit">Xác nhận</button>
        </form>
    </div>

    <script>
    // Script hiện/ẩn mật khẩu
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const showPassword = document.getElementById('show_password');

    showPassword.addEventListener('change', function() {
        const type = this.checked ? 'text' : 'password';
        password.type = type;
        confirmPassword.type = type;
    });

    // Script kiểm tra mật khẩu xác nhận trước khi gửi form
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        if (password.value !== confirmPassword.value) {
            e.preventDefault(); // Ngăn không cho gửi form
            alert('Mật khẩu và mật khẩu xác nhận không khớp!');
        }
    });
    </script>
</body>

</html>

<?php

// Xử lý khi form thêm tài khoản admin được submit
if (isset($_POST['submit'])) {
    $admin_id = $_POST['admin_id'];
    $admin_name = $_POST['admin_name'];
    $password = $_POST['password']; // Không mã hóa mật khẩu
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];


    // Kiểm tra mật khẩu xác nhận có khớp không
    if ($password !== $confirm_password) {
        echo "<script>alert('Mật khẩu và mật khẩu xác nhận không khớp!');</script>";
    } else {
        // Thêm tài khoản admin mới vào cơ sở dữ liệu (không mã hóa mật khẩu)
        $sql = "INSERT INTO Admin_account (admin_id, admin_name, password, role) 
                    VALUES ('$admin_id', '$admin_name', '$password', '$role')";

        if ($conn->query($sql) === TRUE) {
            echo "
                <script>
                    alert('Tài khoản Admin mới đã được thêm thành công!');
                    window.location.href = '../account/admin_account.php';
                </script>
                ";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>