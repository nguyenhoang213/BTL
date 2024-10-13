<?php
    include("./connection.php");
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    $category = isset($_GET['category']) ? $_GET['category'] : 'Tất cả';
    $price_range = isset($_GET['price-range']) ? $_GET['price-range'] : 10000000;
    $rating = isset($_GET['rating']) ? $_GET['rating'] : 'Tất cả';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
    
    $sql = "SELECT * FROM product WHERE product_name like '$keyword'";

    if ($category !== 'Tất cả') {
        $sql .= " AND product_id IN (SELECT product_id FROM product_category WHERE category_id in (SELECT category_id FROM category WHERE category_name like '%$category%'))";
    }

    if (!empty($price_range)) {
        $sql .= " AND price <= $price_range";
    }

    if ($rating !== 'Tất cả') {
        $sql .= " AND rating >= " . (int)$rating;
    }

     if (!empty($sort)) {
        if ($sort === 'price-asc') {
            $sql .= " ORDER BY price ASC"; // Giá tăng dần
        } elseif ($sort === 'price-desc') {
            $sql .= " ORDER BY price DESC"; // Giá giảm dần
        } elseif ($sort === 'name-asc') {
            $sql .= " ORDER BY name ASC"; // Tên sản phẩm từ A đến Z
        } elseif ($sort === 'name-desc') {
            $sql .= " ORDER BY name DESC"; // Tên sản phẩm từ Z đến A
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nhóm 6</title>
    <link rel="stylesheet" href="css/index.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<body>
    <?php
        include("header.php");
    ?>
    <!-- end header -->

    <div class="main-body">
        <div style="border-radius: 0px; border-left: 1px solid #d5cfcf;">
            <div style="display: flex;" class="btn-group">
                <button class="btn btn-lg dropdown-toggle bg-light" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false" style="width: 232px; height: 50px;">
                    Điện thoại
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#">Separated link</a></li>
                </ul>
            </div>
            <div style="display: flex;" class="btn-group">
                <button class="btn btn-lg dropdown-toggle bg-light" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false" style="width: 232px; height: 50px;">
                    Laptop</button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#">Separated link</a></li>
                </ul>
            </div>
            <div style="display: flex;" class="btn-group">
                <button class="btn btn-lg dropdown-toggle bg-light" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false" style="width: 232px; height: 50px;">
                    Table
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#">Separated link</a></li>
                </ul>
            </div>
            <div style="display: flex;" class="btn-group">
                <button class="btn btn-lg dropdown-toggle bg-light" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false" style="width: 232px; height: 50px;">
                    Tai nghe
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#">Separated link</a></li>
                </ul>
            </div>
            <div style="display: flex;" class="btn-group">
                <button class="btn btn-lg dropdown-toggle bg-light" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false" style="width: 232px; height: 50px;">
                    Chuột máy tính
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#">Separated link</a></li>
                </ul>
            </div>
            <div style="display: flex;" class="btn-group">
                <button class="btn btn-lg dropdown-toggle bg-light" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false" style="width: 232px; height: 50px;">
                    PC
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#">Separated link</a></li>
                </ul>
            </div>
            <div style="display: flex;" class="btn-group">
                <button class="btn btn-lg dropdown-toggle bg-light" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false" style="width: 232px; height: 50px;">
                    Dây sạc
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#">Separated link</a></li>
                </ul>
            </div>

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
            <div style="width: 910px; height: 370px" class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./src/assets/images/slider 1.avif" class="d-block w-100" alt="..." />
                </div>
                <div class="carousel-item">
                    <img src="./src/assets/images/slider 2.jpg" class="d-block w-100" alt="..." />
                </div>
                <div class="carousel-item">
                    <img src="./src/assets/images/slider 3.jpeg" class="d-block w-100" alt="..." />
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
        <!-- end slider -->
    </div>
    <!-- product -->
    <h1 style="margin: 10px 0 10px 200px">Kết quả tìm kiếm</h1>

    <script>
    function price_range_display() {
        var price = document.getElementById('price-range').value;
        document.getElementById('price_display').textContent = parseInt(price).toLocaleString('vi-VN') + " VNĐ";

    }
    </script>

    <form action="" method="GET">
        <div class="filter-container">
            <div class="filter-item">
                <input type="hidden" name="keyword" value="<?php echo $keyword ?>">
                <label for="category">Danh mục</label>
                <select name="category">
                    <option <?php if ($category == 'Tất cả') echo 'selected'; ?>>Tất cả</option>
                    <option <?php if ($category == 'Điện thoại') echo 'selected'; ?>>Điện thoại</option>
                    <option <?php if ($category == 'Laptop') echo 'selected'; ?>>Laptop</option>
                    <option <?php if ($category == 'Table') echo 'selected'; ?>>Table</option>
                    <option <?php if ($category == 'Tai nghe') echo 'selected'; ?>>Tai nghe</option>
                    <option <?php if ($category == 'Chuột máy tính') echo 'selected'; ?>>Chuột máy tính</option>
                    <option <?php if ($category == 'PC') echo 'selected'; ?>>PC</option>
                    <option <?php if ($category == 'Dây sạc') echo 'selected'; ?>>Dây sạc</option>
                </select>
            </div>

            <div class="filter-item">
                <label for="price-range">Khoảng giá</label>
                <input type="range" name="price-range" id="price-range" min="0" max="100000000" step="50"
                    value="<?php echo $price_range; ?>" onchange="price_range_display()" />
                <span id="price_display" style=" color: #e74c3c; font-weight: bold; margin-top: 5px; color: #e74c3c;">
                    <?php echo number_format($price_range, 0, '.', '.') . ' VNĐ'; ?></span>
            </div>

            <div class="filter-item">
                <label>Đánh giá</label>
                <select>
                    <option <?php if ($rating == 'Tất cả') echo 'selected'; ?>>Tất cả</option>
                    <option value="4" <?php if ($rating == '4') echo 'selected'; ?>>4 sao trở lên</option>
                    <option value="3" <?php if ($rating == '3') echo 'selected'; ?>>3 sao trở lên</option>
                    <option value="2" <?php if ($rating == '2') echo 'selected'; ?>>2 sao trở lên</option>
                </select>
            </div>

            <div class="filter-item">
                <label for="sort">Sắp xếp theo</label>
                <select name="sort">
                    <option value="">Mặc định</option>
                    <option value="price-asc" <?php if ($sort == 'price-asc') echo 'selected'; ?>>Giá tăng dần</option>
                    <option value="price-desc" <?php if ($sort == 'price-desc') echo 'selected'; ?>>Giá giảm dần
                    </option>
                    <option value="name-asc" <?php if ($sort == 'name-asc') echo 'selected'; ?>>Tên A-Z</option>
                    <option value="name-desc" <?php if ($sort == 'name-desc') echo 'selected'; ?>>Tên Z-A</option>
                </select>
            </div>
            <button class="filter-button">lọc</button>
        </div>
    </form>
    <div class="container">
        <div id="message"></div>
        <div class="row mt-2 pb-3">
            <?php
                $result = $conn->query($sql);
                if($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo ' <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                        <div class="list-product">
                            <a href="./product/product_detail.php?id=' . $row['product_id'] . '">
                            <div>
                                <img src="/BTL/src/assets/uploads/product/'. $row['image'] . '" class="card-img-top" height="250">
                                <div class="card-body p-1">
                                    <h4 class="card-title text-center text-info"> '. $row['product_name'] . ' </h4>
                                    <h5 class="card-text text-center text-danger"> '. number_format($row['price']) .' VNĐ</h5>
                                </div>
                            </a>
                            </div>
                        </div>
                    </div>';
                    }
                } else {
                    echo 'Không có sản phẩm nào';
                }
                    ?>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/0236bf0649.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>