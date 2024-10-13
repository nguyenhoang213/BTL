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
</head>

<body>
    <div class="content">
        <h1>Trang quản lý tổng quát Admin</h1>

        <!-- Thông tin tổng quan (có thể hiển thị số lượng tài khoản, sản phẩm, đơn hàng, v.v.) -->
        <div class="overview">
            <div class="overview-item">
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
                <a href="/BTL/account/admin_account.php">Quản lý tài khoản Admin</a>
            </div>

            <div class="overview-item">
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
                <a href="/BTL/product/product_list.php">Quản lý sản phẩm</a>
            </div>

            <div class="overview-item">
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
                <a href="/BTL/order/order_list.php">Quản lý đơn hàng</a>
            </div>

            <div class="overview-item">
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
                <a href="/BTL/account/user_account.php">Quản lý người dùng</a>
            </div>
        </div>

        <!-- Báo cáo doanh thu -->
        <div class="admin-salereport">
            <h2>Báo cáo doanh thu</h2>
            <?php
            $sql = "SELECT COUNT(*) FROM orders";
            ?>
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