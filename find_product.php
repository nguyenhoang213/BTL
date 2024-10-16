<?php
include("./connection.php");
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : 'Tất cả';
$price_range = isset($_GET['price-range']) ? $_GET['price-range'] : 10000000;
$rating = isset($_GET['rating']) ? $_GET['rating'] : 'Tất cả';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

$sql = "SELECT * FROM product WHERE product_name like '%$keyword%'";

if ($category !== 'Tất cả') {
    $sql .= " AND product_id IN (SELECT product_id FROM product_category WHERE category_id in (SELECT category_id FROM category WHERE category_name like '%$category%'))";
}

if (!$price_range) {
    $sql .= " AND price <= $price_range";
}

if ($rating !== 'Tất cả') {
    $sql .= " AND rating >= " . (int) $rating;
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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        a {
            text-decoration: none;
        }

        body {
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            padding: 20px;
        }

        .filter-section {
            width: 250px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-left: 31px;
        }

        .filter-section h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .filter-group {
            margin-bottom: 20px;
        }

        .filter-group label {
            font-size: 16px;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .filter-group select,
        .filter-group input[type="range"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .filter-group input[type="checkbox"] {
            margin-right: 10px;
        }

        .apply-filter-btn {
            width: 100%;
            padding: 10px;
            background-color: #ee9a00;
            border: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .apply-filter-btn:hover {
            background-color: orange;
        }

        .product-section {
            flex: 1;
            margin-left: 20px;
        }

        .product-section h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .products {
            display: flex;
            justify-content: center;
        }

        .product-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 230px;
        }
    </style>

<body>
    <?php
    include("header.php");
    ?>

    <!-- kết quả tìm kiếm -->

    <div class="container">
        <form action="">
            <div class="filter-section">
                <h2>Bộ lọc sản phẩm</h2>
                <input type="hidden" name="keyword" value="<?php echo $keyword ?>">

                <div class="filter-group">
                    <label for="category">Danh mục</label>
                    <select id="category">
                        <option <?php if ($category == 'Tất cả')
                            echo 'selected'; ?>>Tất cả</option>
                        <option <?php if ($category == 'Điện thoại')
                            echo 'selected'; ?>>Điện thoại</option>
                        <option <?php if ($category == 'Laptop')
                            echo 'selected'; ?>>Laptop</option>
                        <option <?php if ($category == 'Table')
                            echo 'selected'; ?>>Table</option>
                        <option <?php if ($category == 'Tai nghe')
                            echo 'selected'; ?>>Tai nghe</option>
                        <option <?php if ($category == 'Chuột máy tính')
                            echo 'selected'; ?>>Chuột máy tính</option>
                        <option <?php if ($category == 'PC')
                            echo 'selected'; ?>>PC</option>
                        <option <?php if ($category == 'Dây sạc')
                            echo 'selected'; ?>>Dây sạc</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="price-range">Khoảng giá</label>
                    <input type="range" name="price-range" id="price-range" min="10000" max="100000000" step="10000"
                        value="<?php echo $price_range; ?>" onchange="price_range_display()" />
                    <span id="price_display"
                        style=" color: #e74c3c; font-weight: bold; margin-top: 5px; color: #e74c3c;">
                        <?php echo number_format($price_range, 0, '.', '.') . ' VNĐ'; ?></span>
                </div>

                <div class="filter-group">
                    <label for="sort">Sắp xếp theo</label>
                    <select name="sort">
                        <option value="">Mặc định</option>
                        <option value="price-asc" <?php if ($sort == 'price-asc')
                            echo 'selected'; ?>>Giá tăng dần
                        </option>
                        <option value="price-desc" <?php if ($sort == 'price-desc')
                            echo 'selected'; ?>>Giá giảm dần
                        </option>
                        <option value="name-asc" <?php if ($sort == 'name-asc')
                            echo 'selected'; ?>>Tên A-Z</option>
                        <option value="name-desc" <?php if ($sort == 'name-desc')
                            echo 'selected'; ?>>Tên Z-A</option>
                    </select>
                </div>

                <button class="apply-filter-btn">Áp dụng bộ lọc</button>
            </div>
        </form>

        <div class="product-section">
            <h2 style="margin: 10px 0 20px 53px">Kết quả tìm kiếm cho từ khóa "..."</h2>
            <div class="products">
                <?php
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '
                            <div class="product-card">
                                <a href="/BTL/product/product_detail.php?id=' . $row['product_id'] . '">
                                <img style="width: 170px; height: 170px"
                                    src="' . $row['image'] . '">
                                <p>' . $row['product_name'] . '</p>
                                <span>' . number_format($row['price'], 0, ',', '.') . ' VNĐ</span>
                                </a>
                            </div>
                            ';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    </div>

    <script src="https://kit.fontawesome.com/0236bf0649.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
</body>

</html>


<script>
    function price_range_display() {
        var price = document.getElementById('price-range').value;
        document.getElementById('price_display').textContent = parseInt(price).toLocaleString('vi-VN') + " VNĐ";

    }
</script>