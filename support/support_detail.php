<?php
include("../side_nav.php");

// Lấy support_id từ GET request
$support_id = isset($_GET['support_id']) ? intval($_GET['support_id']) : 0;
$user_id = $_SESSION['user_id'];

// Kiểm tra yêu cầu hỗ trợ tồn tại
$sql = "SELECT * FROM support WHERE support_id = '$support_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Yêu cầu hỗ trợ không tồn tại.";
    exit();
}

// Lấy thông tin yêu cầu hỗ trợ
$support = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/BTL/css/list.css">
    <title>Chi Tiết Yêu Cầu Hỗ Trợ</title>

</head>

<body>
    <div class="content">
        <h1>Chi Tiết Yêu Cầu Hỗ Trợ #<?php echo $support['support_id']; ?></h1>

        <!-- Hiển thị thông tin yêu cầu hỗ trợ -->
        <ul class="list-group">
            <li class="list-group-item">Mã đơn hàng:
                <?php echo $support['order_id'] ? '#' . $support['order_id'] : 'Không có'; ?>
            </li>
            <li class="list-group-item">Nội dung hỗ trợ: <?php echo htmlspecialchars($support['message']); ?></li>
            <li class="list-group-item">Trạng thái: <?php echo htmlspecialchars($support['status']); ?></li>
            <li class="list-group-item">Thời gian gửi: <?php echo date('d-m-Y H:i:s', strtotime($support['time'])); ?>
            </li>
        </ul>

        <!-- Phản hồi từ admin (nếu có) -->
        <h2>Phản Hồi Từ Admin</h2>
        <?php if (!empty($support['admin_response'])): ?>
            <div class="list-group">
                <div class="list-group-item">
                    <strong>Admin:</strong> <?php echo htmlspecialchars($support['admin_response']); ?> <br>
                    <small><i>Thời gian phản hồi:
                            <?php echo date('d-m-Y H:i:s', strtotime($support['time'])); ?></i></small>
                </div>
            </div>
        <?php else: ?>
            <p>Hiện tại chưa có phản hồi từ admin.</p>
        <?php endif; ?>

        <!-- Form để gửi phản hồi từ người dùng -->
        <h3 class="mt-3">Gửi Phản Hồi</h3>
        <form action="support_detail.php?support_id=<?php echo $support['support_id']; ?>" method="POST">
            <div class="mb-3">
                <label for="response_message" class="form-label">Nội dung phản hồi từ bạn</label>
                <textarea class="form-control" id="response_message" name="response_message" rows="5"
                    required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Gửi phản hồi</button>
        </form>
        <!-- Xử lý gửi phản hồi -->

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $response_message = trim($_POST['response_message']);

            if (!empty($response_message)) {
                // Cập nhật phản hồi từ admin vào bảng support
                $update_response_sql = "UPDATE support SET admin_response = ?, time = NOW() WHERE support_id = ?";
                $update_response_stmt = $conn->prepare($update_response_sql);
                $update_response_stmt->bind_param("si", $response_message, $support_id);

                if ($update_response_stmt->execute()) {
                    echo "<div class='alert alert-success mt-3'>Phản hồi của bạn đã được gửi thành công.</div>";
                } else {
                    echo "<div class='alert alert-danger mt-3'>Đã có lỗi khi gửi phản hồi. Vui lòng thử lại.</div>";
                }
            }
        }
        ?>
    </div>


</body>

</html>