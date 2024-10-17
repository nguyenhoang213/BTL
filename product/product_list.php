<?php


include("../side_nav.php");
// get sql
$sql = "SELECT * FROM Product";
$result = $conn->query($sql);
$search_category = "product_id";
?>

<?php
if (isset($_GET["search"])) {
    $search_category = $_GET["search_category"];
    $searh_string = $_GET["search"];
    $sql = "SELECT * From Product WHERE $search_category like '%$searh_string%'";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/BTL/css/list.css">
    <title>Quản lý thông tin sản phẩm</title>
</head>

<body>
    <div class="content">
        <h1>Danh sách sản phẩm</h1>
        <form action="" method="get">
            <label for="search">Tìm kiếm sản phẩm:</label>
            <select name="search_category">
                <option value="product_id" <?php if ($search_category == "product_id")
                    echo 'selected'; ?>>Mã sản phẩm
                </option>
                <option value="product_name" <?php if ($search_category == "product_name")
                    echo 'selected'; ?>>Tên sản
                    phẩm
                </option>
                <option value="status" <?php if ($search_category == "status")
                    echo 'selected'; ?>>Tình trạng</option>
            </select>
            <input type="text" id="search" name="search" placeholder="Nhập từ khóa">
            <button type="submit">Tìm kiếm</button>
        </form>

        <a href="../product/product_create.php">Thêm sản phẩm</a>

        <div class="product_list">
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
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['product_id'] . "</td>";
                        echo "<td> <a href ='./product_detail.php?id=" . $row['product_id'] . "'>" . $row['product_name'] . "</a> </td>";
                        if (!empty($row['image'])) {
                            echo "<td><img src='/BTL/src/assets/uploads/product/" . $row['image'] . "' width='100'></td>";
                        } else {
                            echo "<td>Không có hình ảnh</td>";
                        }
                        echo "<td>" . nl2br($row['description']) . "</td>";
                        echo "<td>" . number_format($row['price'], 0, ',', '.') . "</td>";
                        echo "<td>" . $row['stock'] . "</td>";
                        if ($row['status'] == 0) {
                            echo "<td  style = 'color: red'> Ngừng bán </td>";
                        } else {
                            echo "<td> Đang bán </td>";
                        }
                        // Nút chỉnh sửa và xóa
                        echo "<td><a href='/BTL/product/product_edit.php?id=" . $row['product_id'] . "'>Chỉnh sửa</a></td>";
                        echo "<td><a href='/BTL/product/product_delete.php?id=" . $row['product_id'] . "' onclick=\"return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');\">Xóa</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>Không có sản phẩm nào!</td></tr>";
                }

                $conn->close();
                ?>
            </table>
        </div>
    </div>
</body>

</html>