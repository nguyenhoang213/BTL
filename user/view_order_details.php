<?php
include("../connection.php");
include("user_header.php");

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

$user_id = $_SESSION['user_id']; // Lấy user_id từ session

// Kiểm tra nếu có order_id trong URL
if (!isset($_GET['order_id'])) {
    echo "<script>alert('Không tìm thấy đơn hàng!');</script>";
    echo "<script>window.location.href = 'order_history.php';</script>";
    exit();
}

$order_id = $_GET['order_id']; // Lấy order_id từ URL

// Truy vấn chi tiết đơn hàng
$sql_order = "SELECT * FROM orders WHERE order_id = ? AND user_id = ?";
$stmt_order = $conn->prepare($sql_order);
$stmt_order->bind_param("is", $order_id, $user_id);
$stmt_order->execute();
$result_order = $stmt_order->get_result();

if ($result_order->num_rows > 0) {
    $order = $result_order->fetch_assoc();
} else {
    echo "<script>alert('Đơn hàng không tồn tại hoặc bạn không có quyền xem đơn hàng này!');</script>";
    echo "<script>window.location.href = 'order_history.php';</script>";
    exit();
}

// Truy vấn chi tiết sản phẩm trong đơn hàng
$sql_order_details = "SELECT op.product_id, p.product_name, op.stock, op.price 
                                     FROM order_product op
                                     JOIN product p ON op.product_id = p.product_id
                                     WHERE op.order_id = ?";
$stmt_order_details = $conn->prepare($sql_order_details);
$stmt_order_details->bind_param("i", $order_id);
$stmt_order_details->execute();
$result_order_details = $stmt_order_details->get_result();

// Đọc dữ liệu đơn vị hành chính từ file JSON
$json_data = file_get_contents('../src/json/don_vi_hanh_chinh.json');
$locations = json_decode($json_data, true); // Chuyển JSON thành mảng PHP

// Hàm tìm tên tỉnh
function getProvinceName($province_id, $locations)
{
    foreach ($locations['province'] as $province) {
        if ($province['id'] == $province_id) {
            return $province['name'];
        }
    }
    return 'Unknown Province'; // Nếu không tìm thấy
}

// Hàm tìm tên huyện
function getDistrictName($district_id, $locations)
{
    foreach ($locations['district'] as $district) {
        if ($district['id'] == $district_id) {
            return $district['name'];
        }
    }
    return 'Unknown District'; // Nếu không tìm thấy
}

// Hàm tìm tên xã
function getWardName($ward_id, $locations)
{
    foreach ($locations['ward'] as $ward) {
        if ($ward['id'] == $ward_id) {
            return $ward['name'];
        }
    }
    return 'Unknown Ward'; // Nếu không tìm thấy
}
$province_name = getProvinceName($order['province'], $locations);
$district_name = getDistrictName($order['district'], $locations);
$ward_name = getWardName($order['ward'], $locations);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
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
        <h2>Chi tiết đơn hàng #<?php echo htmlspecialchars($order['order_id']); ?></h2>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th colspan="2">Thông tin đơn hàng</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Họ và Tên:</th>
                    <td><?php echo htmlspecialchars($order['full_name']); ?></td>
                </tr>
                <tr>
                    <th>Số Điện Thoại:</th>
                    <td><?php echo htmlspecialchars($order['phone']); ?></td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td><?php echo htmlspecialchars($order['email']); ?></td>
                </tr>
                <tr>
                    <th>Địa Chỉ:</th>
                    <td><?php echo htmlspecialchars($province_name) . ' - ' . htmlspecialchars($district_name) . ' - ' . htmlspecialchars($ward_name) . ' - ' . htmlspecialchars($order['address']); ?>
                    </td>
                </tr>
                <tr>
                    <th>Phương Thức Thanh Toán:</th>
                    <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                </tr>
                <tr>
                    <th>Tổng Tiền:</th>
                    <td><?php echo number_format($order['total'], 0, ',', '.'); ?> VND</td>
                </tr>
                <tr>
                    <th>Giảm Giá:</th>
                    <td><?php echo number_format($order['discount_amount'], 0, ',', '.'); ?> VND</td>
                </tr>
                <tr>
                    <th>Trạng Thái:</th>
                    <td><?php echo htmlspecialchars($order['order_status']); ?></td>
                </tr>
                <tr>
                    <th>Thời Gian Đặt:</th>
                    <td><?php echo date('d-m-Y H:i:s', strtotime($order['order_time'])); ?></td>
                </tr>
            </tbody>
        </table>

        <h3>Chi tiết sản phẩm</h3>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số Lượng</th>
                    <th>Đơn Giá</th>
                    <th>Tổng Tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order_detail = $result_order_details->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order_detail['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($order_detail['stock']); ?></td>
                        <td><?php echo number_format($order_detail['price'], 0, ',', '.'); ?> VND</td>
                        <td><?php echo number_format($order_detail['price'] * $order_detail['stock'], 0, ',', '.'); ?> VND
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="order_history.php" class="btn btn-secondary mt-3">Trở lại danh sách đơn hàng</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>