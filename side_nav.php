<?php
session_start();

if (!isset($_SESSION['admin_name'])) {
    echo "Session không tồn tại. Chuyển hướng về trang đăng nhập...";
    header('Location: /BTL/admin/login_admin.php');
    exit();
} else {
    echo "Session admin_name: " . $_SESSION['admin_name'];
}
?>


<head>
    <link rel="stylesheet" href="/BTL/css/side_nav.css" />
    <script src="https://kit.fontawesome.com/8fcd74b091.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
    <!--  -->
    <div style="position: fixed; top: 0; width: 100vw">
        <div id="user">
            <img src="/BTL/src/assets/images/user.png" alt="User Avatar" class="user-avatar" />
            <span class="user-name">Admin: <?php echo $_SESSION['admin_name']; ?></span>
            <!-- icon -->
            <nav style="position: fixed; right: 30px">
                <div class="icon">
                    <div class="icon_item">
                        <i style="font-size: 25px" class="fas fa-bell"></i>
                        <span>17</span>
                    </div>
                    <div class="notifi">
                        <header>
                            <h3>Thông báo mới nhận</h3>
                        </header>
                        <ul>
                            <li>các thông báo</li>
                            <li>các thông báo</li>
                            <li>các thông báo</li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- end icon -->
        </div>
    </div>
    <div id="side_nav">
        <!-- Side bar -->
        <ul id="side_nav_list">
            <li>
                <a href="/BTL/admin.php"><i class="fa-solid fa-house-chimney"></i> Trang chủ</a>
            </li>
            <li>
                <div class="container">
                    <a href="#"><i class="fa-solid fa-users"></i> Quản lý tài khoản</a>
                    <i class="fa-solid fa-chevron-left icon"></i>
                </div>
                <ul class="dropdown">
                    <li><a href="/BTL/account/admin_account.php">Tài khoản Admin</a></li>
                    <li><a href="/BTL/account/user_account.php">Tài khoản User</a></li>
                    <li><a href="/BTL/account/admin_account_create.php">Thêm tài khoản</a></li>
                </ul>
            </li>
            <li>
                <div class="container">
                    <a href="#"><i class="fa-solid fa-gear"></i> Quản lý nội dung</a><i
                        class="fa-solid fa-chevron-left icon"></i>
                </div>
                <ul class="dropdown">
                    <li><a href="/BTL/slider/slider.php">Quản lý giao diện</a></li>
                </ul>
            </li>
            <li>
                <div class="container">
                    <a href="#"><i class="fa-solid fa-mobile-screen-button"></i> Quản lý sản
                        phẩm</a><i class="fa-solid fa-chevron-left icon"></i>
                </div>
                <ul class="dropdown">
                    <li>
                        <a href="/BTL/product/product_list.php">Danh sách sản phẩm</a>
                    </li>
                    <li><a href="/BTL/product/product_create.php">Thêm sản phẩm</a></li>
                </ul>
            </li>
            <li>
                <div class="container">
                    <a href="#"><i class="fa-solid fa-list"></i> Quản lý danh mục</a><i
                        class="fa-solid fa-chevron-left icon"></i>
                </div>
                <ul class="dropdown">
                    <li>
                        <a href="/BTL/category/category_list.php">Danh sách danh mục</a>
                    </li>
                    <li>
                        <a href="/BTL/category/category_create.php">Tạo danh mục</a>
                    </li>
                </ul>
            </li>
            <li>
                <div class="container">
                    <a href="#"><i class="fa-solid fa-list"></i> Quản lý Voucher</a><i
                        class="fa-solid fa-chevron-left icon"></i>
                </div>
                <ul class="dropdown">
                    <li>
                        <a href="/BTL/voucher/voucher_list.php">Danh sách Voucher</a>
                    </li>
                    <li>
                        <a href="/BTL/voucher/voucher_create.php">Tạo Voucher</a>
                    </li>
                </ul>
            </li>
            <li>
                <div class="container">
                    <a href="#"><i class="fa-solid fa-bag-shopping"></i> Quản lý đơn hàng</a><i
                        class="fa-solid fa-chevron-left icon"></i>
                </div>
                <ul class="dropdown">
                    <li><a href="/BTL/order/order_list.php">Danh sách đơn hàng</a></li>
                </ul>
            </li>
            <li>
                <div class="container">
                    <a href="#"><i class="fa-solid fa-user-shield"></i> Hỗ trợ khách hàng</a><i
                        class="fa-solid fa-chevron-left icon"></i>
                </div>
                <ul class="dropdown">
                    <li><a href="/BTL/support/support_list.php">Danh sách hỗ trợ</a></li>
                </ul>
            </li>
            <li>
                <div class="container">
                    <a href="#"><i class="fa-solid fa-chart-line"></i> Báo cáo thống kê</a>
                    <i class="fa-solid fa-chevron-left icon"></i>
                </div>
                <ul class="dropdown">
                    <li><a href="/BTL/report/order_report.php">Thống kê đơn hàng</a></li>
                    <li><a href="/BTL/report/sale_report.php">Thống kê doanh thu</a></li>
                    <li><a href="/BTL/report/sale_report.php">Thống kê sản phẩm</a></li>
                </ul>
            </li>
            <li>
                <div style="display: flex;align-items: center; padding: 15px;color: #ecf0f1;
                text-decoration: none;font-size: 16px;transition: background 0.3s ease, color 0.3s ease; 
                cursor: pointer;" onclick="logout();"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</div>
            </li>
        </ul>
    </div>
    <script>
        function logout() {
            if (confirm('Bạn có chắc chắn muốn đăng xuất?')) {
                window.location.href = '/BTL/admin/logout_admin.php'; // Chuyển hướng đến trang logout.php
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>