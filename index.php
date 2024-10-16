<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nhóm 6</title>
    <link rel="stylesheet" href="css/index.css" />
    <link rel="stylesheet" href="css/footer.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<body>

    <?php
    include("connection.php");
    include("header.php");
    ?>
    <!-- body -->
    <div class="head-body">
        <div class="head-item">
            <p>DANH MỤC SẢN PHẨM</p>
        </div>
        <div class="main-item">
            <ul class="ul-head">
                <li class="li-head">
                    <a href="">
                        <img src="/BTL/src/assets/images/save-money-2.png" alt="" />
                        <div style="color: black"><b>CAM KẾT</b> <br />Giá Tốt Nhất</div>
                    </a>
                </li>
                <li class="li-head">
                    <a href="">
                        <img src="/BTL/src/assets/images/present.png" alt="" />
                        <div style="color: black"><b>MIỄN PHÍ</b> <br />Vận Chuyển</div>
                    </a>
                </li>
                <li class="li-head">
                    <a href="">
                        <img src="/BTL/src/assets/images/buy.png" alt="" />
                        <div style="color: black">
                            <b>THANH TOÁN</b> <br />Khi Nhận Hàng
                        </div>
                    </a>
                </li>
                <li class="li-head">
                    <a href="">
                        <img src="/BTL/src/assets/images/reload.png" alt="" />
                        <div style="color: black">
                            <b>ĐỔI TRẢ HÀNG</b> <br />Trong 3 Ngày
                        </div>
                    </a>
                </li>
                <li class="li-head">
                    <a href="">
                        <img src="/BTL/src/assets/images/repair-garage.png" alt="" />
                        <div style="color: black">
                            <b>BẢO HÀNH</b> <br />Tại Nơi Sử Dụng
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main">
        <div class="main-bd">
            <ul id="mega_menu" class="menu">
                <li id="menu-item-403">
                    <a href="/BTL/find_product.php?keyword=&category=DT"><img width="24" height="24"
                            src="https://mauweb.monamedia.net/hanoicomputer/wp-content/uploads/2019/03/cate1_icon-24x24.png" />
                        <span>Điện thoại</span></a>
                    <ul class="sub-menu">
                        <li id="menu-item-404">
                            <a href="/BTL/find_product.php?keyword=&category=Apple">
                                <span>Apple</span></a>
                        </li>
                        <li id="menu-item-408">
                            <a href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/dien-thoai/samsung/">
                                <span>Samsung</span></a>
                        </li>
                        <li id="menu-item-405">
                            <a
                                href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/dien-thoai/blackberry/">
                                <span>BlackBerry</span></a>
                        </li>
                        <li id="menu-item-406">
                            <a href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/dien-thoai/motorola/">
                                <span>Motorola</span></a>
                        </li>
                        <li id="menu-item-407">
                            <a href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/dien-thoai/nokia/">
                                <span>Nokia</span></a>
                        </li>
                    </ul>
                </li>
                <li id="menu-item-409">
                    <a href="/BTL/find_product.php?keyword=&category=LT"><img width="24" height="24"
                            src="https://mauweb.monamedia.net/hanoicomputer/wp-content/uploads/2017/12/laptop-1.png" />
                        <span>Laptop</span></a>
                    <ul class="sub-menu">
                        <li id="menu-item-414"><a
                                href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/laptop/macbook/"><span>Macbook</span></a>
                        </li>
                        <li id="menu-item-410"><a
                                href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/laptop/laptop-asus/"><span>Laptop
                                    Asus</span></a>
                        </li>
                        <li id="menu-item-411"><a
                                href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/laptop/laptop-dell/"><span>Laptop
                                    Dell</span></a>
                        </li>
                        <li id="menu-item-412"><a
                                href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/laptop/laptop-hp/"><span>Laptop
                                    HP</span></a></li>
                    </ul>
                </li>
                <li id="menu-item-421">
                    <a href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/tablet/"><img width="24"
                            height="24"
                            src="https://mauweb.monamedia.net/hanoicomputer/wp-content/uploads/2017/12/tablet-outline-in-horizontal-position.png"
                            class="menu-image menu-image-title-after" alt="" /><span>Tablet</span></a>
                    <ul class="sub-menu">
                        <li id="menu-item-425"><a
                                href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/tablet/tablet-ipad/"><span>Tablet
                                    Ipad</span></a>
                        </li>
                        <li id="menu-item-422"><a
                                href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/tablet/tablet-beneve/"><span>Tablet
                                    Beneve</span></a>
                        </li>
                        <li id="menu-item-426"><a
                                href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/tablet/tablet-itel/"><span>Tablet
                                    Itel</span></a>
                        </li>
                        <li id="menu-item-427"><a
                                href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/tablet/tablet-kindle/"><span>Tablet
                                    Kindle</span></a>
                        </li>
                        <li id="menu-item-428"><a
                                href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/tablet/tablet-mobell/"><span>Tablet
                                    Mobell</span></a>
                        </li>
                        <li id="menu-item-429"><a
                                href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/tablet/tablet-samsung/"><span>Tablet
                                    Samsung</span></a>
                        </li>
                    </ul>
                </li>
                <li id="menu-item-415">
                    <a href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/phu-kien/"><img width="24"
                            height="24"
                            src="https://mauweb.monamedia.net/hanoicomputer/wp-content/uploads/2017/12/headset.png"
                            class="menu-image menu-image-title-after" alt="" /><span>Phụ
                            kiện</span></a>
                    <ul class="sub-menu">
                        <li id="menu-item-416"><a
                                href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/phu-kien/bao-da-op-lung-dan-man-hinh/"><span>Bao
                                    da, Ốp lưng, Dán màn hình</span></a></li>
                        <li id="menu-item-417"><a
                                href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/phu-kien/loa/"><span>Loa</span></a>
                        </li>
                        <li id="menu-item-418"><a
                                href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/phu-kien/may-nghe-nhac/"><span>Máy
                                    nghe nhạc</span></a>
                        </li>
                        <li id="menu-item-419"><a
                                href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/phu-kien/phu-kien-am-thanh/"><span>Phụ
                                    kiện âm
                                    thanh</span></a>
                        </li>
                    </ul>
                </li>
                <li id="menu-item-1564"><a
                        href=" https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/smartwatch/"><img width="24"
                            height="24"
                            src="https://mauweb.monamedia.net/hanoicomputer/wp-content/uploads/2019/03/cate2_icon-24x24.png"
                            class="menu-image menu-image-title-after" alt="" /><span>SmartWatch</span></a></li>
                <li id="menu-item-1563"><a
                        href=" https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/apple-watch/"><img
                            width="24" height="24"
                            src="https://mauweb.monamedia.net/hanoicomputer/wp-content/uploads/2017/12/smartphone.png"
                            class="menu-image menu-image-title-after" alt="" /><span>Apple
                            Watch</span></a></li>
                <li id="menu-item-433" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-433"><a
                        href="#"><img width="24" height="24"
                            src="https://mauweb.monamedia.net/hanoicomputer/wp-content/uploads/2017/12/printer.png"
                            class="menu-image menu-image-title-after" alt="" /><span>Thiết bị
                            máy
                            in</span></a></li>
                <li id="menu-item-434" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-434"><a
                        href="#"><img width="24" height="24"
                            src="https://mauweb.monamedia.net/hanoicomputer/wp-content/uploads/2019/06/ssd-24x24.png"
                            class="menu-image menu-image-title-after" alt="" /><span>Máy tính
                            bộ,
                            màn hình</span></a></li>
                <li id="menu-item-420">
                    <a href="https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/phu-kien/tai-nghe/"><img
                            width="24" height="24"
                            src="https://mauweb.monamedia.net/hanoicomputer/wp-content/uploads/2019/06/cloud-computing-24x24.png"
                            class="menu-image menu-image-title-after" alt="" /><span>Tai
                            nghe</span></a>
                </li>
                <li id="menu-item-2041"><a
                        href=" https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/camera/"><img width="24"
                            height="24"
                            src="https://mauweb.monamedia.net/hanoicomputer/wp-content/uploads/2019/06/processor-24x24.png"
                            class="menu-image menu-image-title-after" alt="" /><span>Camera</span></a></li>
                <li id="menu-item-2042"><a
                        href=" https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/linh-kien-may-tinh/"><img
                            width="24" height="24"
                            src="https://mauweb.monamedia.net/hanoicomputer/wp-content/uploads/2019/06/flash-disk-24x24.png"
                            class="menu-image menu-image-title-after" alt="" /><span>Linh kiện
                            máy
                            tính</span></a></li>
                <li id="menu-item-2043"><a
                        href=" https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/phu-kien/ban-phim/"><img
                            width="24" height="24"
                            src="https://mauweb.monamedia.net/hanoicomputer/wp-content/uploads/2019/06/database-24x24.png"
                            class="menu-image menu-image-title-after" alt="" /><span>Bàn
                            phím</span></a></li>
                <li id="menu-item-2044"><a
                        href=" https://mauweb.monamedia.net/hanoicomputer/danh-muc-san-pham/may-tinh-van-phong/"><img
                            width="24" height="24"
                            src="https://mauweb.monamedia.net/hanoicomputer/wp-content/uploads/2019/06/pay-per-click-24x24.png"
                            class="menu-image menu-image-title-after" alt="" /><span>Máy tính
                            văn
                            phòng</span></a></li>
            </ul>
        </div>
        <!-- slider -->
        <div id="carouselExampleIndicators" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div style="width: 910px; height: 570px" class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://mauweb.monamedia.net/hanoicomputer/wp-content/uploads/2019/06/28_Mayf1d8cb54a857e1fbef4e30412cfe2411.jpg"
                        class="d-block w-100" alt="..." />
                </div>
                <div class="carousel-item">
                    <img src="https://mauweb.monamedia.net/hanoicomputer/wp-content/uploads/2019/06/26_May19b7f7c0d8d0401061a18ee3900d92f8.jpg"
                        class="d-block w-100" alt="..." />
                </div>
                <div class="carousel-item">
                    <img src="https://mauweb.monamedia.net/hanoicomputer/wp-content/uploads/2019/06/04_Jun54996437df548ee7736b9ec3939ffc2b.jpg"
                        class="d-block w-100" alt="..." />
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!-- end slider -->
    </div>
    <!-- product -->
    <div class="container">
        <div class="menu-product">
            <button class="main-title">SẢN PHẨM BÁN CHẠY</button>
        </div>
        <div class="products">
            <?php
            $sql_hot = "SELECT ph.product_id, count(*) as COUNT, p.image, p.product_name, p.price
                FROM user_product_history ph JOIN product p ON ph.product_id = p.product_id
                GROUP BY ph.product_id 
                Order by COUNT(*)
                LIMIT 8";
            $result_hot = $conn->query($sql_hot);
            if ($result_hot->num_rows > 0) {
                while ($row_hot = $result_hot->fetch_assoc()) {
                    echo '
                    <div class="product-item">
                        <a href="/BTL/product/product_detail.php?id=' . $row_hot['product_id'] . '">
                        <img style="width: 170px; height: 170px" src="' . $row_hot['image'] . '">
                        <p>' . $row_hot['product_name'] . '</p>
                        <span>' . number_format($row_hot['price'], 0, ',', '.') . ' VNĐ </span>
                        </a>    
                    </div>
                    ';
                }
            }
            ?>
        </div>
    </div>
    <!-- Điện thoại -->
    <div class="container">
        <div class="menu1-product">
            <button class="main-title" value="DT">Điện thoại</button>
            <button class="active-product" value="apple">Apple</button>
            <button class="active-product" value="samsung">Samsung</button>
            <button class="active-product" value="blackberry">BlackBerry</button>
            <button class="active-product" value="motorola">Motorola</button>
            <button class="active-product" value="nokia">Nokia</button>
        </div>
        <div class="products" id="product-list-dt"></div>
    </div>

    <!-- Laptop -->
    <div class="container">
        <div class="menu2-product">
            <button class="main-title" value="LT">Laptop</button>
            <button class="active-product" value="macbook">Macbook</button>
            <button class="active-product" value="ltasus">Laptop Asus</button>
            <button class="active-product" value="ltdell">Laptop Dell</button>
            <button class="active-product" value="lthp">Laptop HP</button>
        </div>
        <div class="products" id="product-list-lt"></div>
    </div>

    <script>
        // Điện thoại
        document.querySelectorAll('.menu1-product button').forEach(button => {
            button.addEventListener('click', function () {
                const category = this.value;
                fetchProductsDT(category); // Gọi hàm lấy sản phẩm Điện thoại
            });
        });

        function fetchProductsDT(category) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_product.php', true); // Gửi yêu cầu tới file PHP xử lý
            document.getElementById('product-list-dt').innerHTML = ''; // Xóa sản phẩm cũ
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('category=' + category); // Gửi dữ liệu category

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('product-list-dt').innerHTML = xhr.responseText;
                }
            };
        }

        // Laptop
        document.querySelectorAll('.menu2-product button').forEach(button => {
            button.addEventListener('click', function () {
                const category = this.value;
                fetchProductsLT(category); // Gọi hàm lấy sản phẩm Laptop
            });
        });

        function fetchProductsLT(category) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_product.php', true); // Gửi yêu cầu tới file PHP xử lý
            document.getElementById('product-list-lt').innerHTML = ''; // Xóa sản phẩm cũ
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('category=' + category); // Gửi dữ liệu category

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('product-list-lt').innerHTML = xhr.responseText;
                }
            };
        }

        // Mặc định hiển thị sản phẩm Điện thoại khi trang tải
        window.onload = function () {
            fetchProductsDT('DT'); // Hiển thị sản phẩm Điện thoại mặc định
            fetchProductsLT('LT');
        };
    </script>

    <?php
    include("footer.php")
        ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
</body>

</html>