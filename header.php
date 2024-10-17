<!-- Banner header -->
<div class="baner-header">
    <img src="/BTL/src/assets/images/banner-header.jpg" alt="" />
</div>
<!-- End banner header -->
<!-- Header -->
<div class="header-wrapper">
    <div class="box-header">
        <div class="box-header-logo">
            <a href="/BTL/index.php">
                <img src="/BTL/src/assets/images/logo-01.png" alt="">
            </a>
        </div>
        <form action="/BTL/find_product.php" method="GET" style="width:450px">
            <div class="share-header">
                <input name="keyword" type="text" placeholder="Gõ từ khóa tìm kiếm..." />
                <button style="border:none; background-color: inherit"><i
                        class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>

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
                <a class="nav-link" href="/BTL/cart/cart.php"><i class="fas fa-shopping-cart"></i><span id="cart-item"
                        class="badge badge-danger"></span></a>
            </button>
        </div>
    </div>
</div>
<!-- end header -->


<script src="https://kit.fontawesome.com/0236bf0649.js" crossorigin="anonymous"></script>