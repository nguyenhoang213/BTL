<?php
include "connection.php";
if (!isset($_SESSION['admin_name'])) {
    header('Location: /BTL/admin/login_admin.php');
    exit();
}
?>


<head>
    <link rel="stylesheet" href="/BTL/css/side_nav.css" />
    <script src="https://kit.fontawesome.com/8fcd74b091.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
    a {
        text-decoration: none;

    }

    li {
        list-style: none;
    }

    .icon {
        position: relative;
        display: inline-block;
    }

    .icon_item {
        position: relative;
        cursor: pointer;
    }

    .icon_item i {
        color: white;
    }

    .icon_item span {
        position: absolute;
        top: -10px;
        right: -10px;
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 5px 8px;
        font-size: 12px;
    }

    .notifi {
        display: none;
        /* Ẩn thông báo ban đầu */
        position: absolute;
        top: 30px;
        right: 0;
        background-color: white;
        width: 300px;
        border: 1px solid #ddd;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }

    .notifi header {
        padding: 10px;
        background-color: #f4f4f4;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }

    .notifi ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .notifi ul li {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        cursor: pointer;
    }

    .notifi ul li:last-child {
        border-bottom: none;
    }

    .icon_item:hover .notifi {
        display: block;
        /* Hiển thị thông báo khi hover vào chuông */
    }
    </style>
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

                        <?php
                        // Lấy số lượng thông báo chưa đọc
                        $sql_count = "SELECT COUNT(*) as unread_count FROM admin_notification WHERE status = 'unread'"; // 0 cho chưa đọc
                        $result_count = $conn->query($sql_count);
                        $row_count = $result_count->fetch_assoc();
                        $unread_count = $row_count['unread_count'];
                        ?>

                        <!-- Hiển thị số lượng thông báo chưa đọc -->
                        <span><?php echo $unread_count; ?></span>
                    </div>

                    <?php
                    // Lấy các thông báo từ cơ sở dữ liệu
                    $sql = "SELECT id, title, order_id, type, time, status FROM admin_notification ORDER BY time DESC";
                    $result = $conn->query($sql);
                    ?>

                    <!-- Hiển thị danh sách thông báo -->
                    <div class="notifi">
                        <header>
                            <h3>Thông báo mới nhận</h3>
                        </header>
                        <ul>
                            <?php
                            if ($result->num_rows > 0) {
                                // Duyệt qua các thông báo và hiển thị từng thông báo
                                while ($row = $result->fetch_assoc()) {
                                    $order_id = $row["order_id"];
                                    $status = $row["status"];

                                    // Hiển thị mỗi thông báo dưới dạng liên kết đến chi tiết hóa đơn
                            
                                    if ($row['status'] == "unread") {
                                        echo '<li>';
                                        echo '<a style ="color: red" href="/BTL/readed.php?notification_id=' . $row['id'] . '&id=' . $order_id . '">';  // Link đến trang chi tiết hóa đơn
                                    } else {
                                        echo '<li style="background-color: #d7d7d7">';
                                        echo '<a href="/BTL/readed.php?notification_id=' . $row['id'] . '&id=' . $order_id . '">';  // Link đến trang chi tiết hóa đơn
                                    }
                                    echo '<strong>' . $row["title"] . '</strong> - ';  // Hiển thị tiêu đề thông báo
                                    echo 'Loại: ' . $row["type"] . ' - ';             // Hiển thị loại thông báo
                                    echo 'Thời gian: ' . $row["time"];                // Hiển thị thời gian thông báo
                                    echo '</a>';
                                    echo '</li>';
                                }
                            } else {
                                echo '<li>Không có thông báo nào</li>';
                            }
                            ?>
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
                    <li><a href="/BTL/report/product_report.php">Thống kê sản phẩm</a></li>
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

<script>
document.querySelector('.icon_item').addEventListener('click', function() {
    var notifiBox = document.querySelector('.notifi');
    if (notifiBox.style.display === 'block') {
        notifiBox.style.display = 'none';
    } else {
        notifiBox.style.display = 'block';
    }
});
</script>