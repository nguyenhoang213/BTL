<?php
include("../connection.php");
include("user_header.php");

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

$user_id = $_SESSION['user_id'];

// Lấy thông tin người dùng từ cơ sở dữ liệu
$query = "SELECT first_name, last_name, email, phone, address FROM user WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Cập nhật thông tin người dùng
if (isset($_POST['update'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Cập nhật thông tin trong cơ sở dữ liệu
    $update_query = "UPDATE user SET first_name = ?, last_name = ?, email = ?, phone = ?, address = ? WHERE user_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param('ssssss', $first_name, $last_name, $email, $phone, $address, $user_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Cập nhật thông tin thành công');</script>";
        echo "<script>window.location.href = 'user_info.php';</script>";
    } else {
        echo "<script>alert('Cập nhật thông tin thất bại');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa thông tin cá nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/BTL/css/index.css">
    <style>
    .content {
        margin-left: 270px;
        /* Khoảng cách cho phù hợp với độ rộng của side nav */
        padding: 30px;

    }

    /* Side Navigation */
    .sidenav {
        height: 100vh;
        width: 250px;
        position: fixed;
        z-index: 1;
        background-color: #FFFFFF;
        /* Màu nền đậm hơn */
        padding-top: 20px;
        border-right: 1px solid #dee2e6;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        /* Hiệu ứng đổ bóng */
        color: #fff;
        /* Màu chữ trắng */
    }

    .sidenav h3 {
        color: black;
        /* Màu chữ của tiêu đề */
        padding-bottom: 20px;
        border-bottom: 1px solid #dee2e6;
        /* Đường ngăn cách phía dưới tiêu đề */
        margin-bottom: 20px;
    }

    .sidenav a {
        padding: 12px 20px;
        text-decoration: none;
        font-size: 16px;
        color: black;
        /* Màu chữ nhạt hơn cho side nav */
        display: block;
        transition: all 0.3s ease;
        border-radius: 4px;
        margin: 5px 10px;
    }

    .sidenav a:hover {
        background-color: #495057;
        /* Hiệu ứng nền khi hover */
        color: #f8f9fa;
    }
    </style>
</head>

<body>
    <!-- Main Content -->
    <div class="content">
        <h2>Chỉnh sửa thông tin cá nhân</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="first_name" class="form-label">Họ</label>
                <input type="text" class="form-control" id="first_name" name="first_name"
                    value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Tên</label>
                <input type="text" class="form-control" id="last_name" name="last_name"
                    value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="phone" name="phone"
                    value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Địa chỉ</label>
                <input type="text" class="form-control" id="address" name="address"
                    value="<?php echo htmlspecialchars($user['address']); ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Cập nhật</button>
            <a href="user_info.php" class="btn btn-secondary">Hủy</a>
        </form>
    </div>

</body>

</html>