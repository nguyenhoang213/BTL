<?php
include("../connection.php"); // Kết nối đến cơ sở dữ liệu
session_start();

include("user_header.php");

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit;
}

$user_id = $_SESSION['user_id']; // Lấy user_id từ session

// Truy vấn thông tin người dùng từ cơ sở dữ liệu
$sql = "SELECT first_name, last_name, email, phone, address FROM user WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc(); // Lấy thông tin người dùng
} else {
    echo "Không tìm thấy thông tin người dùng.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Cá Nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/BTL/css/index.css">
    <style>
    .sidenav {
        height: 100vh;
        /* Chiều cao đầy đủ màn hình */
        width: 250px;
        /* Độ rộng của side nav */
        position: fixed;
        /* Gắn cố định vào bên trái */
        z-index: 1;
        /* Lớp trên cùng */
        background-color: #f8f9fa;
        /* Màu nền của side nav */
        padding-top: 20px;
        border-right: 1px solid #dee2e6;
    }

    .sidenav a {
        padding: 8px 16px;
        text-decoration: none;
        font-size: 18px;
        color: #333;
        display: block;
    }

    .sidenav a:hover {
        background-color: #ddd;
        color: #000;
    }

    .content {
        margin-left: 260px;
        /* Để nội dung chính không bị side nav che */
        padding: 20px;
    }
    </style>
</head>

<body>


    <!-- Main Content -->
    <div class="content">
        <h2>Thông Tin Cá Nhân</h2>
        <table class="table table-bordered mt-3">
            <tr>
                <th>Họ:</th>
                <td><?php echo htmlspecialchars($user['first_name']); ?></td>
            </tr>
            <tr>
                <th>Tên:</th>
                <td><?php echo htmlspecialchars($user['last_name']); ?></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
            </tr>
            <tr>
                <th>Số điện thoại:</th>
                <td><?php echo htmlspecialchars($user['phone']); ?></td>
            </tr>
            <tr>
                <th>Địa chỉ:</th>
                <td><?php echo htmlspecialchars($user['address']); ?></td>
            </tr>
        </table>

        <div class="text-center mt-3">
            <a href="edit_user_info.php" class="btn btn-primary">Chỉnh sửa thông tin</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>