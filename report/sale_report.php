<?php
include("../side_nav.php");
// Kiểm tra quyền truy cập (chỉ admin có thể truy cập)
if (!isset($_SESSION['role'])) {
    echo "<script>
            alert('Không có quyền truy cập vào trang này. Bạn sẽ được chuyển tới trang chủ');
            window.location.href = 'http://localhost/BTL';
          </script>";
    exit();
}



$first_day_of_month = date('Y-m-01');
$today = date('Y-m-d');

// Nhận dữ liệu ngày bắt đầu và ngày kết thúc từ form
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : $first_day_of_month;
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : $today;

// Kiểm tra nếu đã chọn ngày bắt đầu và kết thúc
if ($start_date && $end_date) {
    // Truy vấn doanh thu theo ngày trong khoảng thời gian được chọn
    $sql_sale = "SELECT DATE(complete_time) AS date, 
                            SUM(total) - SUM(discount_amount) AS daily_revenue, 
                            COUNT(order_id) as order_count
                        FROM Orders 
                        WHERE order_status = 'Đã hoàn thành'
                        AND complete_time BETWEEN '$start_date' AND DATE_ADD('$end_date', INTERVAL 1 DAY)
                        GROUP BY DATE(complete_time)";
} else {
    // Nếu không có ngày cụ thể, hiển thị dữ liệu cho tất cả các ngày
    $sql_sale = "SELECT DATE(complete_time) AS date, 
                            SUM(total) - SUM(discount_amount) AS daily_revenue, 
                            COUNT(order_id) as order_count
                        FROM Orders 
                        WHERE order_status = 'Đã hoàn thành'
                        GROUP BY DATE(complete_time)";
}

$result_sale = $conn->query($sql_sale);

// Mảng lưu trữ dữ liệu
$dates = [];
$revenues = [];
$orders = [];


if ($result_sale->num_rows > 0) {
    while ($row = $result_sale->fetch_assoc()) {
        $dates[] = $row['date']; // Lấy ngày
        $revenues[] = $row['daily_revenue']; // Doanh thu trong ngày
        $orders[] = $row['order_count']; // Số lượng đơn hàng trong ngày
    }
}

// Truy vấn các số liệu thống kê
// 1. Tổng doanh thu
$sql_total_revenue = "SELECT SUM(total) - SUM(discount_amount) AS total_revenue 
                            FROM Orders 
                            WHERE order_status = 'Đã hoàn thành'";
if ($start_date && $end_date) {
    $sql_total_revenue .= " AND complete_time BETWEEN '$start_date' AND '$end_date'";
}
$result_total_revenue = $conn->query($sql_total_revenue);
$total_revenue = $result_total_revenue->fetch_assoc()['total_revenue'];

// 2. Tổng số đơn hàng
$sql_total_orders = "SELECT COUNT(order_id) AS total_orders 
                            FROM Orders 
                            WHERE order_status = 'Đã hoàn thành'";
if ($start_date && $end_date) {
    $sql_total_orders .= " AND complete_time BETWEEN '$start_date' AND '$end_date'";
}
$result_total_orders = $conn->query($sql_total_orders);
$total_orders = $result_total_orders->fetch_assoc()['total_orders'];
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/BTL/css/dashboard.css">
    <title>Trang quản lý Admin</title>
    <!-- Thêm thư viện Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="content">
        <h2>Báo cáo doanh thu theo ngày</h2>
        <!-- Form chọn ngày bắt đầu và kết thúc -->
        <form method="GET" action="">
            <label for="start_date">Chọn ngày bắt đầu:</label>
            <input type="date" id="start_date" name="start_date"
                value="<?php echo isset($start_date) ? $start_date : ''; ?>" required>

            <label for="end_date">Chọn ngày kết thúc:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo isset($end_date) ? $end_date : ''; ?>"
                required>

            <button type="submit">Lọc</button>
        </form>

        <canvas id="revenueChart" width="250%" height="100%"></canvas>


        <!-- Hiển thị các thống kê -->
        <div class="statistics">
            <h3>Thống kê</h3>
            <p><strong>Tổng doanh thu:</strong> <?php echo number_format($total_revenue, 0, ',', '.'); ?> VND</p>
            <p><strong>Tổng số đơn hàng:</strong> <?php echo $total_orders; ?> đơn hàng</p>
        </div>

        <script>
            // Lấy dữ liệu từ PHP
            var dates = <?php echo json_encode($dates); ?>;
            var revenues = <?php echo json_encode($revenues); ?>;

            // Vẽ biểu đồ doanh thu
            var ctx = document.getElementById('revenueChart').getContext('2d');
            var revenueChart = new Chart(ctx, {
                type: 'bar', // Kiểu biểu đồ: cột
                data: {
                    labels: dates, // Ngày (labels)
                    datasets: [{
                        label: 'Doanh thu (VND)',
                        data: revenues, // Doanh thu theo ngày
                        backgroundColor: 'rgba(54, 162, 235, 0.6)', // Màu nền
                        borderColor: 'rgba(54, 162, 235, 1)', // Màu viền
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true // Bắt đầu từ 0 trên trục y
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Biểu đồ doanh thu hàng ngày'
                        }
                    }
                }
            });
        </script>

    </div>
</body>

</html>

<?php
$conn->close(); // Đóng kết nối cơ sở dữ liệu
?>