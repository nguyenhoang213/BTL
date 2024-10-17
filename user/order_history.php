<?php
include("../connection.php");
include("user_header.php");

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

$user_id = $_SESSION['user_id']; // Lấy user_id từ session

$json_data = file_get_contents('../src/json/don_vi_hanh_chinh.json');
$locations = json_decode($json_data, true); // Chuyển JSON thành mảng PHP

// Hàm lấy tên tỉnh
function getProvinceName($province_id, $locations)
{
    foreach ($locations['province'] as $province) {
        if ($province['id'] == $province_id) {
            return $province['name'];
        }
    }
    return 'Unknown Province';
}

// Hàm lấy tên huyện
function getDistrictName($district_id, $locations)
{
    foreach ($locations['district'] as $district) {
        if ($district['id'] == $district_id) {
            return $district['name'];
        }
    }
    return 'Unknown District';
}

// Hàm lấy tên xã
function getWardName($ward_id, $locations)
{
    foreach ($locations['ward'] as $ward) {
        if ($ward['id'] == $ward_id) {
            return $ward['name'];
        }
    }
    return 'Unknown Ward';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử đơn hàng</title>
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

        table th,
        table td {
            text-align: center;
            vertical-align: middle;
        }

        table th {
            background-color: #f8f9fa;
        }

        .btn-view {
            background-color: #007bff;
            color: white;
        }

        .btn-view:hover {
            background-color: #0056b3;
            color: white;
        }

        .status-pending {
            color: orange;
        }

        .status-completed {
            color: green;
        }

        .status-cancelled {
            color: red;
        }
    </style>
</head>

<body>

    <!-- Main Content -->
    <div class="content">
        <h2>Lịch sử đơn hàng</h2>
        <h5>Đơn hàng đang chờ</h5>
        <!-- Kiểm tra nếu có đơn hàng -->
        <?php
        $sql = "SELECT * FROM orders WHERE user_id = '$user_id' and order_status != 'Đã hoàn thành' ORDER BY order_time DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0): ?>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Mã Đơn Hàng</th>
                        <th>Họ và Tên</th>
                        <th>Tổng Tiền</th>
                        <th>Giảm Giá</th>
                        <th>Phương Thức Thanh Toán</th>
                        <th>Trạng Thái</th>
                        <th>Thời Gian Đặt</th>
                        <th>Xem Đơn Hàng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $result->fetch_assoc()):
                        // $province_name = getProvinceName($order['province'], $locations);
                        // $district_name = getDistrictName($order['district'], $locations);
                        // $ward_name = getWardName($order['ward'], $locations);
                        $status_class = 'status-' . strtolower(str_replace(' ', '-', $order['order_status'])); ?>
                        <tr>
                            <td><?php echo htmlspecialchars(string: $order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars(string: $order['full_name']); ?></td>
                            <td><?php echo number_format($order['total'], 0, ',', '.'); ?> VND</td>
                            <td><?php echo number_format($order['discount_amount'], 0, ',', '.'); ?> VND</td>
                            <td><?php echo htmlspecialchars($order['payment_method']); ?></td>

                            <td class="<?php echo $status_class; ?>"><?php echo htmlspecialchars($order['order_status']); ?>
                            </td>
                            <td><?php echo date('d-m-Y H:i:s', strtotime($order['order_time'])); ?></td>
                            <td><a href="view_order_details.php?order_id=<?php echo $order['order_id']; ?>"
                                    class="btn btn-view">Xem chi tiết</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Hiện tại bạn chưa có đơn hàng nào.</p>
        <?php endif; ?>
        <h5>Đơn hàng đã hoàn thành</h5>
        <!-- Kiểm tra nếu có đơn hàng -->
        <?php
        $sql = "SELECT * FROM orders WHERE user_id = '$user_id' and order_status = 'Đã hoàn thành' ORDER BY order_time DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0): ?>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Mã Đơn Hàng</th>
                        <th>Họ và Tên</th>
                        <th>Tổng Tiền</th>
                        <th>Giảm Giá</th>
                        <th>Phương Thức Thanh Toán</th>
                        <th>Trạng Thái</th>
                        <th>Thời Gian Đặt</th>
                        <th>Xem Đơn Hàng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $result->fetch_assoc()):
                        $province_name = getProvinceName($order['province'], $locations);
                        $district_name = getDistrictName($order['district'], $locations);
                        $ward_name = getWardName($order['ward'], $locations);
                        $status_class = 'status-' . strtolower(str_replace(' ', '-', $order['order_status'])); ?>
                        <tr>
                            <td><?php echo htmlspecialchars(string: $order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars(string: $order['full_name']); ?></td>
                            <td><?php echo number_format($order['total'], 0, ',', '.'); ?> VND</td>
                            <td><?php echo number_format($order['discount_amount'], 0, ',', '.'); ?> VND</td>
                            <td><?php echo htmlspecialchars($order['payment_method']); ?></td>

                            <td class="<?php echo $status_class; ?>"><?php echo htmlspecialchars($order['order_status']); ?>
                            </td>
                            <td><?php echo date('d-m-Y H:i:s', strtotime($order['order_time'])); ?></td>
                            <td><a href="view_order_details.php?order_id=<?php echo $order['order_id']; ?>"
                                    class="btn btn-view">Xem chi
                                    tiết</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Hiện tại bạn chưa có đơn hàng nào.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>