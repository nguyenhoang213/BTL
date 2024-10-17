<?php
include("../connection.php");
include("user_header.php");

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit();
}

$support_id = isset($_GET['support_id']) ? intval($_GET['support_id']) : 0;

// Truy vấn chi tiết yêu cầu hỗ trợ và phản hồi của admin (nếu có)
$sql = "SELECT support_id, order_id, message, status, time, admin_response FROM support WHERE support_id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $support_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Yêu cầu hỗ trợ không tồn tại.";
    exit();
}

$support = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Hỗ Trợ</title>
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

        .content {
            margin-left: 260px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="content">
        <h2>Chi Tiết Yêu Cầu Hỗ Trợ #<?php echo $support['support_id']; ?></h2>
        <ul class="list-group">
            <li class="list-group-item">Mã đơn hàng:
                <?php echo $support['order_id'] ? '#' . $support['order_id'] : 'Không có'; ?>
            </li>
            <li class="list-group-item">Nội dung hỗ trợ: <?php echo htmlspecialchars($support['message']); ?></li>
            <li class="list-group-item">Trạng thái: <?php echo htmlspecialchars($support['status']); ?></li>
            <li class="list-group-item">Thời gian gửi: <?php echo date('d-m-Y H:i:s', strtotime($support['time'])); ?>
            </li>

            <!-- Hiển thị phản hồi của admin -->
            <li class="list-group-item">
                Phản hồi từ Admin:
                <?php if (!empty($support['admin_response'])): ?>
                    <p><?php echo htmlspecialchars($support['admin_response']); ?></p>
                <?php else: ?>
                    <p>Chưa có phản hồi từ admin.</p>
                <?php endif; ?>
            </li>
        </ul>
        <a href="support.php" class="btn btn-primary mt-3">Quay lại</a>
    </div>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>