<?php
include("side_nav.php");
if (!isset($_SESSION['role'])) {
    echo "<script>
            alert('Không có quyền truy cập vào trang này. Bạn sẽ được chuyển tới trang chủ');
            window.location.href = 'http://localhost/BTL';
          </script>";
}


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
        <!-- Thông tin tổng quan (có thể hiển thị số lượng tài khoản, sản phẩm, đơn hàng, v.v.) -->
        <div class="overview">
            <!-- Tổng quan khác như tài khoản Admin, Sản phẩm, Đơn hàng, Người dùng -->
            <div style="background-color: rgb(255 179 144);" class="overview-item">
                <h3>Tài khoản Admin</h3>
                <p>
                    <?php
                    // Đếm số lượng tài khoản admin
                    $sql = "SELECT COUNT(*) as count FROM Admin_account";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    echo $row['count'];
                    ?>
                </p>
                <a  href="/BTL/account/admin_account.php"
                    class="effect">
                    Quản lý tài khoản Admin
                </a>
            </div>

            <div style="background-color: rgb(77, 224, 173);" class="overview-item 2">
                <h3>Sản phẩm</h3>
                <p>
                    <?php
                    // Đếm số lượng sản phẩm
                    $sql = "SELECT COUNT(*) as count FROM Product";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    echo $row['count'];
                    ?>
                </p>
                <a class="effect" href="/BTL/product/product_list.php">Quản lý sản phẩm</a>
            </div>

            <div style="background-color: rgb(246, 154, 165);" class="overview-item 3">
                <h3>Đơn hàng</h3>
                <p>
                    <?php
                    // Đếm số lượng đơn hàng
                    $sql = "SELECT COUNT(*) as count FROM Orders";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    echo $row['count'];
                    ?>
                </p>
                <a class="effect" href="/BTL/order/order_list.php">Quản lý đơn hàng</a>
            </div>

            <div style="background-color: rgb(75, 208, 210);" class="overview-item 4">
                <h3>Người dùng</h3>
                <p>
                    <?php
                    // Đếm số lượng người dùng
                    $sql = "SELECT COUNT(*) as count FROM User";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    echo $row['count'];
                    ?>
                </p>
                <a class="effect" href="/BTL/account/user_account.php">Quản lý người dùng</a>
            </div>
        </div>

        <!-- Báo cáo doanh thu -->
        <div class="admin-salereport">
            <canvas id="revenueChart" width="250%" height="100%"></canvas>

            <?php
            // Truy vấn doanh thu theo tháng
            $sql_sale = "SELECT MONTH(order_time) AS month, SUM(total) - SUM(discount_amount) AS monthly_revenue, COUNT(order_id) as order_count
                         FROM Orders 
                         WHERE order_status = 'Đã hoàn thành' 
                         GROUP BY MONTH(order_time)";
            $result_sale = $conn->query($sql_sale);

            // Tạo mảng để lưu dữ liệu
            $months = [];
            $revenues = [];

            if ($result_sale->num_rows > 0) {
                while ($row = $result_sale->fetch_assoc()) {
                    $months[] = $row['month']; // Tháng
                    $revenues[] = $row['monthly_revenue']; // Doanh thu trong tháng
                }
            }
            ?>

            <script>
                // Lấy dữ liệu từ PHP
                var months = <?php echo json_encode($months); ?>;
                var revenues = <?php echo json_encode($revenues); ?>;

                // Vẽ biểu đồ doanh thu
                var ctx = document.getElementById('revenueChart').getContext('2d');
                var revenueChart = new Chart(ctx, {
                    type: 'bar', // Kiểu biểu đồ: cột
                    data: {
                        labels: months, // Tháng (labels)
                        datasets: [{
                            label: 'Doanh thu (VND)',
                            data: revenues, // Doanh thu theo tháng
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
                                text: 'Biểu đồ doanh thu hàng tháng'
                            }
                        }
                    }
                });
            </script>
        </div>

        <!-- Các chức năng chính -->
        <!-- <div class="admin-functions">
            <h2>Các chức năng quản lý</h2>
            <ul>
                <li><a href="/BTL/account/admin_account.php">Quản lý tài khoản Admin</a></li>
                <li><a href="/BTL/product/product_list.php">Quản lý sản phẩm</a></li>
                <li><a href="/BTL/order/order_list.php">Quản lý đơn hàng</a></li>
                <li><a href="/BTL/account/user_account.php">Quản lý người dùng</a></li>
                <li><a href="">Báo cáo doanh thu</a></li>
                <li><a href="">Cài đặt hệ thống</a></li>
            </ul>
        </div> -->
    </div>
</body>

</html>

<?php
$conn->close(); // Đóng kết nối cơ sở dữ liệu
?>