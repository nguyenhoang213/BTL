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

$first_day_of_month = date('Y-m-01'); // Ngày đầu tháng
$today = date('Y-m-d'); // Ngày hôm nay

// Nhận dữ liệu ngày bắt đầu và ngày kết thúc từ form
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : $first_day_of_month;
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : $today;

// Truy vấn số lượng đơn hàng theo từng ngày và từng trạng thái
$sql_orders_by_status = "SELECT DATE(complete_time) AS date,
                                SUM(CASE WHEN order_status = 'Đang chờ xử lý' THEN 1 ELSE 0 END) AS pending_orders,
                                SUM(CASE WHEN order_status = 'Đã xác nhận' THEN 1 ELSE 0 END) AS confirmed_orders,
                                SUM(CASE WHEN order_status = 'Đã hoàn thành' THEN 1 ELSE 0 END) AS completed_orders
                        FROM Orders
                        WHERE complete_time BETWEEN '$start_date' AND DATE_ADD('$end_date', INTERVAL 1 DAY)
                        GROUP BY DATE(complete_time)";
$result_orders_by_status = $conn->query($sql_orders_by_status);

// Mảng lưu trữ dữ liệu
$dates = [];
$pending_orders_data = [];
$confirmed_orders_data = [];
$completed_orders_data = [];

if ($result_orders_by_status->num_rows > 0) {
    while ($row = $result_orders_by_status->fetch_assoc()) {
        $dates[] = $row['date']; // Lấy ngày
        $pending_orders_data[] = $row['pending_orders']; // Đơn hàng đang chờ xử lý
        $confirmed_orders_data[] = $row['confirmed_orders']; // Đơn hàng đã xác nhận
        $completed_orders_data[] = $row['completed_orders']; // Đơn hàng đã hoàn thành
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/BTL/css/dashboard.css">
    <title>Trang quản lý Admin - Báo cáo đơn hàng</title>
    <!-- Thêm thư viện Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="content">
        <h2>Báo cáo đơn hàng theo trạng thái</h2>
        <!-- Form chọn ngày bắt đầu và kết thúc -->
        <form method="GET" action="order_report.php">
            <label for="start_date">Chọn ngày bắt đầu:</label>
            <input type="date" id="start_date" name="start_date"
                value="<?php echo isset($start_date) ? $start_date : ''; ?>" required>

            <label for="end_date">Chọn ngày kết thúc:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo isset($end_date) ? $end_date : ''; ?>"
                required>

            <button type="submit">Lọc</button>
        </form>

        <canvas id="orderStatusChart" width="250%" height="100%"></canvas>

        <script>
            // Lấy dữ liệu từ PHP cho biểu đồ đơn hàng
            var dates = <?php echo json_encode($dates); ?>;
            var pendingOrdersData = <?php echo json_encode($pending_orders_data); ?>;
            var confirmedOrdersData = <?php echo json_encode($confirmed_orders_data); ?>;
            var completedOrdersData = <?php echo json_encode($completed_orders_data); ?>;

            // Vẽ biểu đồ đơn hàng theo trạng thái, với 3 cột cạnh nhau
            var ctx = document.getElementById('orderStatusChart').getContext('2d');
            var orderStatusChart = new Chart(ctx, {
                type: 'bar', // Kiểu biểu đồ: cột
                data: {
                    labels: dates, // Các ngày
                    datasets: [{
                        label: 'Đang chờ xử lý',
                        data: pendingOrdersData, // Số lượng đơn hàng đang chờ xử lý theo ngày
                        backgroundColor: 'rgba(255, 99, 132, 0.6)', // Màu nền cho Đang chờ xử lý
                        borderColor: 'rgba(255, 99, 132, 1)', // Màu viền
                        borderWidth: 1
                    },
                    {
                        label: 'Đã xác nhận',
                        data: confirmedOrdersData, // Số lượng đơn hàng đã xác nhận theo ngày
                        backgroundColor: 'rgba(54, 162, 235, 0.6)', // Màu nền cho Đã xác nhận
                        borderColor: 'rgba(54, 162, 235, 1)', // Màu viền
                        borderWidth: 1
                    },
                    {
                        label: 'Đã hoàn thành',
                        data: completedOrdersData, // Số lượng đơn hàng đã hoàn thành theo ngày
                        backgroundColor: 'rgba(75, 192, 192, 0.6)', // Màu nền cho Đã hoàn thành
                        borderColor: 'rgba(75, 192, 192, 1)', // Màu viền
                        borderWidth: 1
                    }
                    ]
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
                            text: 'Biểu đồ số lượng đơn hàng theo trạng thái và ngày'
                        }
                    },
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    barPercentage: 0.8, // Tỷ lệ kích thước cột
                    categoryPercentage: 0.7 // Tỷ lệ khoảng cách giữa các cột
                }
            });
        </script>

    </div>
</body>

</html>

<?php
$conn->close(); // Đóng kết nối cơ sở dữ liệu
?>