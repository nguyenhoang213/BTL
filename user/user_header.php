<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    </style>
</head>

<body>
    <div class="baner-header">
        <img src="/BTL/src/assets/images/banner-header.jpg" alt="" />
    </div>
    <!-- End banner header -->
    <!-- Header -->
    <div class="header-wrapper">
        <div class="box-header">
            <a href="/BTL/index.php"><img src="/BTL/src/assets/images/logo-01.png" alt=""></a>
            <form action="./find_product.php" method="GET" style="width:30vw">
                <div class="share-header">
                    <input name="keyword" type="text" placeholder="Gõ từ khóa tìm kiếm..." />
                    <button style="border:none; background-color: inherit"><i
                            class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
            <div class="btn-header">
                <div class="btn-hotline">
                    <button class="btn-phone">
                        <i class="fa-solid fa-phone"></i>
                    </button>
                    <button class="btn-number"> Mua hàng Online <br />
                        <b>1900.636.648</b>
                    </button>
                    <!-- Nút kích hoạt Modal -->
                    <?php
                    if (isset($_SESSION["user_id"])) {
                        $user_id = $_SESSION["user_id"];
                        $sql_user = "SELECT * FROM user WHERE user_id = '$user_id'";
                        $result_user = $conn->query($sql_user);
                        if ($result_user->num_rows > 0) {
                            while ($row_user = $result_user->fetch_assoc()) {
                                echo '
                            <div class="user-dropdown">
                                <button class="user-button">Xin chào, ' . $row_user['first_name'] . ' ' . $row_user['last_name'] . '</button>
                                <div class="dropdown-content">
                                    <a href="/BTL/user/user_info.php">Thông tin cá nhân</a>
                                    <a href="/BTL/login/logout.php">Đăng xuất</a>
                                </div>
                            </div>';
                            }
                        }
                    } else {
                        ?>
                    <button class="button-custom" type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#authModal" onclick="window.location.href='/BTL/login/login.php'">
                        Đăng Ký/Đăng Nhập <i class="fa-solid fa-user"></i>
                    </button>
                    <?php
                    }
                    ?>
                    <button class="btn-shopping">
                        <a class="nav-link" href="/BTL/cart/cart.php"><i class="fas fa-shopping-cart"></i><span
                                id="cart-item" class="badge badge-danger"></span></a>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- end header -->

    <!-- Side Navigation -->
    <div class="sidenav">
        <h3 class="text-center">Trang cá nhân</h3>
        <a href="/BTL/user/user_info.php">Thông tin khách hàng</a>
        <a href="/BTL/user/order_history.php">Đơn hàng đã mua</a>
        <a href="/BTL/user/product_history.php">Sản phẩm đã xem</a>
        <a href="/BTL/login/change_password.php">Đổi mật khẩu</a>
        <a href="/BTL/user/wishlist.php">Sản phẩm yêu thích</a>
        <a href="/BTL/user/support.php">Hỗ trợ khách hàng</a>
        <a href="/BTL/login/logout.php">Đăng xuất</a>
    </div>

    <script src="https://kit.fontawesome.com/0236bf0649.js" crossorigin="anonymous"></script>
</body>

</html>