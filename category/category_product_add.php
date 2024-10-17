<?php
include("../side_nav.php");
if (isset($_GET["id"])) {
    $danhmuc_id = $_GET["id"];
    $sql_tdm = "Select * FROM category WHERE category_id = '$danhmuc_id'";
    $row = mysqli_fetch_array(mysqli_query($conn, $sql_tdm));
    $danhmuc_name = $row["category_name"];
}

$existing_products = [];

// Truy vấn để lấy danh sách các sản phẩm đã có trong danh mục
$sql_existing = "SELECT product_id FROM product_category WHERE category_id = '$danhmuc_id'";
$result_existing = $conn->query($sql_existing);

if ($result_existing->num_rows > 0) {
    while ($row = $result_existing->fetch_assoc()) {
        $existing_products[] = $row['product_id'];
    }
}

if (isset($_POST["maSP"])) {
    $sanpham_id = $_POST['maSP'];
}

if (isset($_POST['submit'])) {
    $sql = "INSERT INTO product_category(product_id, category_id) VALUES ('$sanpham_id','$danhmuc_id')";
    if ($conn->query($sql) === TRUE) {
        echo "
            <script>
                alert('Sản phẩm đã được thêm vào danh mục!');
                window.location.href = '../category/category_product.php?danhMuc=" . $danhmuc_id . "';
            </script>
            ";
    } else {
        echo "
            <script>
                alert('Không thể thêm sản phẩm vào danh mục!');
            </script>
            ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm vào danh mục</title>
    <link rel="stylesheet" href="/BTL/css/create.css">
</head>

<body>
    <div class="content">
        <h1>Thêm sản phẩm vào danh mục <?php echo $danhmuc_name ?></h1>

        <form action="" method="POST">
            <label for="">Mã sản phẩm</label>
            <select name="maSP" onchange="this.form.submit()">
                <option value="">-Chọn sản phẩm-</option>
                <?php
                $sql = "Select * FROM product";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        if (!in_array($row['product_id'], $existing_products)) {
                            $selected = ($row['product_id'] == $sanpham_id) ? 'selected' : '';
                            echo "<option value='" . $row['product_id'] . "' $selected>" . $row['product_id'] . " - " . $row['product_name'] . "</option>";
                        }

                    }
                }
                ?>
            </select>
            <?php
            if (isset($_POST['maSP'])) {
                $sanpham_id = $_POST['maSP'];
                $sanpham = "SELECT * FROM product WHERE product_id = '$sanpham_id'";
                $result = $conn->query($sanpham);
                if ($result->num_rows > 0) {
                    $product = $result->fetch_assoc();
                    ?>
                    <label for="">Tên sản phẩm</label>
                    <input type="text" name="tenSP" readonly value="<?php echo $product['product_name']; ?>" required> <br>

                    <label for="">Mô tả</label>
                    <textarea name="motaSP" rows="5" readonly cols="20"
                        required><?php echo $product['description']; ?></textarea>
                    <br>

                    <label for="giaSP">Giá</label>
                    <input type="text" id="giaSP" readonly name="giaSP" required value="<?php echo $product['price']; ?>"> <br>

                    <label for="">Hình ảnh hiện tại</label><br>
                    <?php
                    if (!empty($product['image'])) {
                        ?> <img src="../src/assets/uploads/product/<?php echo $product['image']; ?>" width="100"><br> <?php
                    } else {
                        echo "Không có hình ảnh";
                    } ?>
                    <br>
                    <?php
                }
                echo "<button name='submit'>Xác nhận</button>";
            } else {
                echo "<a href='../product/product_create.php' style='text-align:right'>Thêm sản phẩm</a>";
            }
            ?>
        </form>
    </div>
</body>

</html>