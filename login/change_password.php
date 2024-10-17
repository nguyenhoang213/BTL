<?php

include("../connection.php");
include("../user/user_header.php");

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

$user_id = $_SESSION['user_id']; // Lấy user_id từ session
$error_message = '';
$success_message = '';

// Kiểm tra nếu người dùng đã submit form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra nếu các trường không được để trống
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error_message = 'Vui lòng điền đầy đủ thông tin.';
    } else {
        // Lấy mật khẩu đã băm từ cơ sở dữ liệu
        $sql = "SELECT password FROM user_account WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->bind_result($stored_password);
        $stmt->fetch();
        $stmt->close();

        // Kiểm tra mật khẩu hiện tại (so sánh hash)
        if (password_verify($current_password, $stored_password)) {
            // Kiểm tra nếu mật khẩu mới và xác nhận mật khẩu khớp nhau
            if ($new_password === $confirm_password) {
                // Mã hóa mật khẩu mới trước khi cập nhật
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Cập nhật mật khẩu mới vào cơ sở dữ liệu
                $sql_update = "UPDATE user_account SET password = ? WHERE user_id = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("ss", $hashed_new_password, $user_id);
                $stmt_update->execute();

                if ($stmt_update->affected_rows > 0) {
                    $success_message = 'Mật khẩu đã được thay đổi thành công.';
                } else {
                    $error_message = 'Đã xảy ra lỗi khi thay đổi mật khẩu. Vui lòng thử lại.';
                }
                $stmt_update->close();
            } else {
                $error_message = 'Mật khẩu mới và xác nhận mật khẩu không khớp.';
            }
        } else {
            $error_message = 'Mật khẩu hiện tại không đúng.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi mật khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/BTL/css/index.css">
    <style>
        /* Side Navigation */
        .sidenav {
            height: 100vh;
            width: 250px;
            position: fixed;
            z-index: 1;
            background-color: #FFFFFF;
            padding-top: 20px;
            border-right: 1px solid #dee2e6;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            color: #fff;
        }

        .sidenav h3 {
            color: black;
            padding-bottom: 20px;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
        }

        .sidenav a {
            padding: 12px 20px;
            text-decoration: none;
            font-size: 16px;
            color: black;
            display: block;
            transition: all 0.3s ease;
            border-radius: 4px;
            margin: 5px 10px;
        }

        .sidenav a:hover {
            background-color: #495057;
            color: #f8f9fa;
        }

        .content {
            margin-left: 260px;
            padding: 20px;
        }
    </style>
</head>

<body>

    <!-- Main Content -->
    <div class="content">
        <h2>Đổi Mật Khẩu</h2>

        <!-- Hiển thị thông báo lỗi hoặc thành công -->
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>

        <!-- Form đổi mật khẩu -->
        <form action="change_password.php" method="POST">
            <div class="mb-3">
                <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Mật khẩu mới</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>