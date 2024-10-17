<?php
include("../side_nav.php");

if (isset($_GET["danhMuc"])) {
    $danhmuc_id = $_GET["danhMuc"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý các sản phẩm trong danh mục</title>
    <link rel="stylesheet" href="/BTL/css/list.css">
</head>

<body>
    <div class="content">
        <h1>Quản lý sản phẩm trong danh mục</h1>

        <form action="" method="GET">
            <label for="">Danh mục</label>
            <select name="danhMuc" onchange="this.form.submit()">
                <option value="">-Chọn danh mục-</option>
                <?php
                $sql_dm = "SELECT * FROM category";
                $result = $conn->query($sql_dm);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $selected = ($row['category_id'] == $danhmuc_id) ? 'selected' : '';
                        echo "<option value='" . $row['category_id'] . "' $selected>" . $row['category_name'] . "</option>";
                    }
                }
                ?>
            </select>
        </form>

        <?php
        if (isset($_GET["danhMuc"])) {
            $sql_tdm = "SELECT category_name FROM category WHERE category_id = '$danhmuc_id'";
            $row = mysqli_fetch_array(mysqli_query($conn, $sql_tdm));
            echo "<h2>Danh sách sản phẩm thuộc danh mục: " . $row["category_name"] . "</h2>";
            echo "<a href='../category/category_product_add.php?id=" . $danhmuc_id . "'>Thêm sản phẩm vào danh mục</a>";
            ?>
            <table>
                <tr>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Mô tả</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tình trạng</th>
                    <th>Chỉnh sửa</th>
                    <th>Xóa</th>
                </tr>

                <?php
                // hiển thị sản phẩm
                $sql = "SELECT p.product_id, product_name, description, image, price, stock, status, category_id 
                    FROM product p join product_category pc on p.product_id = pc.product_id
                    WHERE pc.category_id = '$danhmuc_id'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['product_id'] . "</td>";
                        echo "<td> <a href ='/BTL/product/product_detail.php?id=" . $row['product_id'] . "'>" . $row['product_name'] . "</a> </td>";
                        if (!empty($row['image'])) {
                            echo "<td><img src='../src/assets/uploads/product/" . $row['image'] . "' width='100'></td>";
                        } else {
                            echo "<td>Không có hình ảnh</td>";
                        }
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['price'] . "</td>";
                        echo "<td>" . $row['stock'] . "</td>";
                        if ($row['status'] == 0) {
                            echo "<td  style = 'color: red'> Ngừng bán </td>";
                        } else {
                            echo "<td> Đang bán </td>";
                        }
                        // Nút chỉnh sửa và xóa
                        echo "<td><a href='../product/product_edit.php?id=" . $row['product_id'] . "'>Chỉnh sửa</a></td>";
                        echo "<td><a href='../category/category_product_delete.php?product=" . $row['product_id'] . "&category=" . $danhmuc_id . "' onclick=\"return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');\">Xóa</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>Không có sản phẩm nào!</td></tr>";
                }

                $conn->close();
                ?>
            </table>
            <?php
        }
        ?>
    </div>
</body>

</html>