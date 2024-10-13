<?php
session_start();
include("./connection.php");

if (!isset($_SESSION['role'])) {
    echo "<script>
            alert('Không có quyền truy cập vào trang này. Bạn sẽ được chuyển tới trang chủ');
            window.location.href = 'http://localhost/BTL';
          </script>";
}

include("side_nav.php");
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
        <h1>Trang quản lý tổng quát Admin</h1>

        <!-- Thông tin tổng quan -->
        <div class="overview">
            <!-- Hiển thị tổng quan về tài khoản Admin, Sản phẩm, Đơn hàng, Người dùng -->
            <div class="overview-item">
                <h3>Tài khoản Admin</h3>
                <p>
                    <?php
                    $sql = "SELECT COUNT(*) as count FROM Admin_account";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    echo $row['count'];
                    ?>
                </p>
                <a href="/BTL/account/admin_account.php">Quản lý tài khoản Admin</a>
            </div>

            <div class="overview-item">
                <h3>Sản phẩm</h3>
                <p>
                    <?php
                    $sql = "SELECT COUNT(*) as count FROM Product";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    echo $row['count'];
                    ?>
                </p>
                <a href="/BTL/product/product_list.php">Quản lý sản phẩm</a>
            </div>

            <div class="overview-item">
                <h3>Đơn hàng</h3>
                <p>
                    <?php
                    $sql = "SELECT COUNT(*) as count FROM Orders";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    echo $row['count'];
                    ?>
                </p>
                <a href="/BTL/order/order_list.php">Quản lý đơn hàng</a>
            </div>

            <div class="overview-item">
                <h3>Người dùng</h3>
                <p>
                    <?php
                    $sql = "SELECT COUNT(*) as count FROM User";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    echo $row['count'];
                    ?>
                </p>
                <a href="/BTL/account/user_account.php">Quản lý người dùng</a>
            </div>
        </div>

        <!-- Báo cáo doanh thu -->
        <div class="admin-salereport">
            <h2>Báo cáo doanh thu</h2>
            <canvas id="revenueChart" width="400" height="150"></canvas>

            <?php
            // Truy vấn doanh thu và số lượng đơn hàng theo tháng
            $sql_sale = "SELECT MONTH(order_time) AS month, SUM(total) - SUM(discount_amount) AS monthly_revenue, COUNT(order_id) AS order_count 
                         FROM Orders 
                         WHERE order_status = 'Đã hoàn thành' 
                         GROUP BY MONTH(order_time)";
            $result_sale = $conn->query($sql_sale);

            // Tạo mảng để lưu dữ liệu
            $months = [];
            $revenues = [];
            $order_counts = []; // Số lượng đơn hàng
            
            if ($result_sale->num_rows > 0) {
                while ($row = $result_sale->fetch_assoc()) {
                    $months[] = $row['month']; // Tháng
                    $revenues[] = $row['monthly_revenue']; // Doanh thu trong tháng
                    $order_counts[] = $row['order_count']; // Số lượng đơn hàng trong tháng
                }
            }
            ?>

            <script>
                // Lấy dữ liệu từ PHP
                var months = <?php echo json_encode($months); ?>;
                var revenues = <?php echo json_encode($revenues); ?>;
                var orderCounts = <?php echo json_encode($order_counts); ?>;

                // Vẽ biểu đồ doanh thu và số lượng đơn hàng
                var ctx = document.getElementById('revenueChart').getContext('2d');
                var revenueChart = new Chart(ctx, {
                    type: 'bar', // Kiểu biểu đồ: cột
                    data: {
                        labels: months, // Tháng
                        datasets: [
                            {
                                label: 'Doanh thu (VND)',
                                data: revenues, // Dữ liệu doanh thu
                                backgroundColor: 'rgba(54, 162, 235, 0.6)', // Màu nền
                                borderColor: 'rgba(54, 162, 235, 1)', // Màu viền
                                borderWidth: 1,
                                yAxisID: 'y1' // Trục Y cho doanh thu
                            },
                            {
                                label: 'Số lượng đơn hàng',
                                data: orderCounts, // Dữ liệu số lượng đơn hàng
                                backgroundColor: 'rgba(255, 99, 132, 0.6)', // Màu nền
                                borderColor: 'rgba(255, 99, 132, 1)', // Màu viền
                                borderWidth: 1,
                                type: 'line', // Biểu đồ đường cho số lượng đơn hàng
                                yAxisID: 'y2' // Trục Y cho số lượng đơn hàng
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y1: {
                                beginAtZero: true, // Bắt đầu từ 0 trên trục y1 (doanh thu)
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Doanh thu (VND)'
                                }
                            },
                            y2: {
                                beginAtZero: true, // Bắt đầu từ 0 trên trục y2 (số lượng đơn hàng)
                                position: 'right',
                                title: {
                                    display: true,
                                    text: 'Số lượng đơn hàng'
                                },
                                grid: {
                                    drawOnChartArea: false // Tắt đường lưới cho trục y2
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Biểu đồ doanh thu và số lượng đơn hàng hàng tháng'
                            }
                        }
                    }
                });
            </script>
        </div>

        <!-- Các chức năng chính -->
        <div class="admin-functions">
            <h2>Các chức năng quản lý</h2>
            <ul>
                <li><a href="/BTL/account/admin_account.php">Quản lý tài khoản Admin</a></li>
                <li><a href="/BTL/product/product_list.php">Quản lý sản phẩm</a></li>
                <li><a href="/BTL/order/order_list.php">Quản lý đơn hàng</a></li>
                <li><a href="/BTL/account/user_account.php">Quản lý người dùng</a></li>
                <li><a href="/BTL/reports/sales_report.php">Báo cáo doanh thu</a></li>
                <li><a href="/BTL/settings/settings.php">Cài đặt hệ thống</a></li>
            </ul>
        </div>
    </div>
</body>

</html>

<?php
$conn->close(); // Đóng kết nối cơ sở dữ liệu
?>