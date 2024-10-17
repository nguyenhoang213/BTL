<?php
include("../connection.php");
include("user_header.php");

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

$user_id = $_SESSION['user_id']; // Lấy user_id từ session
$error_message = '';
$success_message = '';

// Lấy danh sách đơn hàng của người dùng (nếu có) để người dùng chọn đơn hàng trong form
$order_sql = "SELECT order_id FROM orders WHERE user_id = ?";
$order_stmt = $conn->prepare($order_sql);
$order_stmt->bind_param("s", $user_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();

// Xử lý form khi người dùng gửi yêu cầu hỗ trợ
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = !empty($_POST['order_id']) ? $_POST['order_id'] : null; // Đơn hàng có thể là null nếu không có đơn hàng cụ thể
    $message = trim($_POST['message']);

    // Kiểm tra nếu message không được để trống
    if (empty($message)) {
        $error_message = 'Vui lòng nhập nội dung hỗ trợ.';
    } else {
        // Chèn yêu cầu hỗ trợ vào cơ sở dữ liệu
        $sql = "INSERT INTO support (user_id, order_id, message, status) VALUES ('$user_id', '$order_id', '$message', 'Đang xử lý')";

        if ($result = $conn->query($sql)) {
            $success_message = 'Yêu cầu hỗ trợ của bạn đã được gửi thành công.';
        } else {
            $error_message = 'Đã xảy ra lỗi khi gửi yêu cầu. Vui lòng thử lại.';
        }
    }
}

// Truy vấn các yêu cầu hỗ trợ đã gửi của người dùng
$support_sql = "SELECT support_id, order_id, message, status, time FROM support WHERE user_id = ? ORDER BY time DESC";
$support_stmt = $conn->prepare($support_sql);
$support_stmt->bind_param("s", $user_id);
$support_stmt->execute();
$support_result = $support_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yêu Cầu Hỗ Trợ</title>
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

    <!-- Main Content -->
    <div class="content">
        <h2>Yêu Cầu Hỗ Trợ</h2>

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

        <!-- Form yêu cầu hỗ trợ -->
        <form action="support.php" method="POST">
            <div class="mb-3">
                <label for="order_id" class="form-label">Chọn Đơn Hàng (tùy chọn)</label>
                <select class="form-select" id="order_id" name="order_id">
                    <option value="">-- Không chọn đơn hàng cụ thể --</option>
                    <?php while ($order = $order_result->fetch_assoc()): ?>
                        <option value="<?php echo $order['order_id']; ?>">
                            Đơn hàng #<?php echo $order['order_id']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Nội dung hỗ trợ</label>
                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
        </form>

        <!-- Phần hiển thị các yêu cầu hỗ trợ đã gửi -->
        <h3 class="mt-5">Các Yêu Cầu Hỗ Trợ Đã Gửi</h3>

        <?php if ($support_result->num_rows > 0): ?>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Mã Hỗ Trợ</th>
                        <th>Mã Đơn Hàng</th>
                        <th>Nội Dung</th>
                        <th>Trạng Thái</th>
                        <th>Thời Gian Gửi</th>
                        <th>Xem chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($support = $support_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo '#' . htmlspecialchars($support['support_id']); ?></td>
                            <td><?php echo $support['order_id'] ? '#' . $support['order_id'] : 'Không có'; ?></td>
                            <td><?php echo htmlspecialchars($support['message']); ?></td>
                            <td><?php echo htmlspecialchars($support['status']); ?></td>
                            <td><?php echo date('d-m-Y H:i:s', strtotime($support['time'])); ?></td>
                            <td><a href="support_detail.php?support_id=<?php echo $support['support_id']; ?>"
                                    class="btn btn-info btn-sm">Xem chi
                                    tiết</a></td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Bạn chưa gửi yêu cầu hỗ trợ nào.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$support_stmt->close();
$order_stmt->close();
$conn->close();
?>