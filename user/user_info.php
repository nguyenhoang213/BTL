<?php
include("../connection.php"); // Kết nối đến cơ sở dữ liệu
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
$stmt->bind_param("s", $user_id);
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
        /* Content Area */
        .content {
            margin-left: 270px;
            /* Khoảng cách cho phù hợp với độ rộng của side nav */
            padding: 30px;

        }

        .content h2 {
            font-size: 28px;
            color: #343a40;
            margin-bottom: 20px;
            border-bottom: 2px solid #6c757d;
            padding-bottom: 10px;
        }

        /* Table Styling */
        table {
            width: 100%;
            background-color: #fff;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Hiệu ứng đổ bóng cho bảng */
        }

        table th,
        table td {
            padding: 15px;
            text-align: left;
            border: 1px solid #dee2e6;
            font-size: 16px;
            color: #343a40;
        }

        table th {
            background-color: #6c757d;
            /* Màu nền cho tiêu đề của bảng */
            color: #f8f9fa;
            /* Màu chữ sáng */
        }

        /* Button Styling */
        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
            /* Màu nền khi hover */
            color: #fff;
        }

        .text-center {
            text-align: center;
        }

        .mt-3 {
            margin-top: 20px;
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