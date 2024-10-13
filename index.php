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
    include("connection.php");
    include("header.php");
    ?>
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
    <h1 style="margin: 10px 0 10px 200px">Sản phẩm</h1>
    <div class="filter-container">
        <div class="filter-item">
            <label for="category">Danh mục</label>
            <select>
                <option>Tất cả</option>
                <option>Điện thoại</option>
                <option>Laptop</option>
                <option>Table</option>
                <option>Tai nghe</option>
                <option>Chuột máy tính</option>
                <option>PC</option>
                <option>Dây sạc</option>
            </select>
        </div>

        <div class="filter-item">
            <label for="price-range">Khoảng giá</label>
            <input type="range" id="price-range" min="0" max="1000" step="50" />
            <span style=" color: #e74c3c; font-weight: bold; margin-top: 5px; color: #e74c3c;">$500</span>
        </div>

        <div class="filter-item">
            <label>Đánh giá</label>
            <select>
                <option>Tất cả</option>
                <option>4 sao trở lên</option>
                <option>3 sao trở lên</option>
                <option>2 sao trở lên</option>
            </select>
        </div>
        <button class="filter-button">lọc</button>
    </div>
    <div class="container">
        <div id="message"></div>
        <div class="row mt-2 pb-3">
            <?php
            $stmt = $conn->prepare('SELECT * FROM Product');
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo ' <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                        <div class="list-product">
                            <a href="./product/product_detail.php?id=' . $row['product_id'] . '">
                            <div>
                                <img src="/BTL/src/assets/uploads/product/' . $row['image'] . '" class="card-img-top" height="250">
                                <div class="card-body p-1">
                                    <h4 class="card-title text-center text-info"> ' . $row['product_name'] . ' </h4>
                                    <h5 class="card-text text-center text-danger"> ' . number_format($row['price']) . ' VNĐ</h5>
                                </div>
                            </a>
                            </div>
                        </div>
                    </div>';
            } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
</body>

</html>