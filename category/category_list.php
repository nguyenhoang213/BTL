<?php


include("../side_nav.php");
// Truy vấn SQL để lấy danh sách danh mục và tên danh mục cha
$sql = "SELECT c1.category_id, c1.category_name, c1.description, c1.image, c1.parent, c2.category_name AS parent_name 
            FROM Category c1 
            LEFT JOIN Category c2 ON c1.parent = c2.category_id
            ORDER BY c1.parent, c1.category_id";
$result = $conn->query($sql);

// Xử lý tìm kiếm nếu có yêu cầu tìm kiếm
if (isset($_GET["search"])) {
    $search_category = $_GET["search_category"];
    $search_string = $_GET["search"];

    // Kiểm tra xem người dùng có nhập từ khóa tìm kiếm không
    if (!empty($search_string)) {
        // Truy vấn tìm kiếm theo danh mục
        $sql = "SELECT c1.category_id, c1.category_name, c1.description, c1.image, c1.parent, c2.category_name AS parent_name 
                    FROM Category c1 
                    LEFT JOIN Category c2 ON c1.parent = c2.category_id 
                    WHERE $search_category LIKE '%$search_string%'
                    ORDER BY c1.parent, c1.category_id";
        $result = $conn->query($sql);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý danh mục</title>
    <link rel="stylesheet" href="/BTL/css/list.css">
</head>

<body>
    <div class="content">
        <h1>Danh sách danh mục </h1>

        <!-- Form tìm kiếm -->
        <form action="" method="get">
            <label for="search">Tìm kiếm danh mục:</label>
            <select name="search_category">
                <option value="c1.category_id" <?php if (isset($search_category) && $search_category == "c1.category_id")
                    echo 'selected'; ?>>Mã
                    danh
                    mục</option>
                <option value="c1.category_name" <?php if (isset($search_category) && $search_category == "c1.category_name")
                    echo 'selected'; ?>>Tên
                    danh mục</option>
                <option value="c2.category_name" <?php if (isset($search_category) && $search_category == "c2.category_name")
                    echo 'selected'; ?>>
                    Danh
                    mục cha</option>
            </select>
            <input type="text" id="search" name="search" placeholder="Nhập từ khóa"
                value="<?php echo isset($search_string) ? $search_string : ''; ?>">
            <button type="submit">Tìm kiếm</button>
        </form>

        <a href="../category/category_create.php">Thêm danh mục</a>

        <table>
            <tr>
                <th>Mã danh mục</th>
                <th>Tên danh mục</th>
                <th>Hình ảnh</th>
                <th>Mô tả</th>
                <th>Danh mục cha</th>
                <th>Chỉnh sửa</th>
                <th>Xóa</th>
            </tr>

            <?php
            // Hiển thị danh sách danh mục
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['category_id'] . "</td>";
                    echo "<td><a href='../category/category_product.php?danhMuc=" . $row['category_id'] . "'>" . $row['category_name'] . "</a></td>";

                    // Kiểm tra xem có hình ảnh không
                    if (!empty($row['image'])) {
                        echo "<td><img src='../src/assets/uploads/category/" . $row['image'] . "' width='100'></td>";
                    } else {
                        echo "<td>Không có hình ảnh</td>";
                    }

                    echo "<td>" . $row['description'] . "</td>";

                    // Hiển thị tên danh mục cha (nếu có)
                    if ($row['parent_name'] == NULL) {
                        echo "<td>Không có</td>";
                    } else {
                        echo "<td>" . $row['parent_name'] . "</td>";
                    }

                    // Nút chỉnh sửa và xóa
                    echo "<td><a href='../category/category_edit.php?id=" . $row['category_id'] . "'>Chỉnh sửa</a></td>";
                    echo "<td><a href='../category/category_delete.php?id=" . $row['category_id'] . "' onclick=\"return confirm('Bạn có chắc chắn muốn xóa danh mục này?');\">Xóa</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Không có danh mục nào!</td></tr>";
            }

            // Đóng kết nối
            $conn->close();
            ?>
    </div>
    </table>
</body>

</html>