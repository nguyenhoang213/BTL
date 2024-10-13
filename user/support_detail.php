<?php
session_start();
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
$stmt->bind_param("ii", $support_id, $_SESSION['user_id']);
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
    .sidenav {
        height: 100vh;
        width: 250px;
        position: fixed;
        z-index: 1;
        background-color: #f8f9fa;
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