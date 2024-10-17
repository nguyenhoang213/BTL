<?php
include("../side_nav.php");

$sql = "SELECT * FROM voucher";
$result = $conn->query($sql);
$search_category = "voucher_id";
?>

<?php
if (isset($_GET["search"])) {
    $search_category = $_GET["search_category"];
    $searh_string = $_GET["search"];
    $sql = "SELECT * From voucher WHERE $search_category like '%$searh_string%'";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý thông tin chương trình khuyến mại</title>
    <link rel="stylesheet" href="/BTL/css/list.css">
</head>

<body>
    <div class="content">
        <h1>Danh sách chương trình khuyến mại</h1>
        <form action="" method="get">
            <label for="search">Tìm kiếm khuyến mại:</label>
            <select name="search_category">
                <option value="voucher_id" <?php if ($search_category == "voucher_id")
                    echo 'selected'; ?>>Mã chương
                    trình
                </option>
                <option value="code" <?php if ($search_category == "code")
                    echo 'selected'; ?>>Mã Code
                </option>
            </select>
            <input type="text" id="search" name="search" placeholder="Nhập từ khóa">
            <button type="submit">Tìm kiếm</button>
        </form>

        <a href="../voucher/voucher_create.php">Thêm khuyến mại</a>

        <table>
            <tr>
                <th>Voucher ID</th>
                <th>Code</th>
                <th>Giá trị KM</th>
                <th>Loại KM</th>
                <th>Giá trị tối thiểu</th>
                <th>Thời gian kết thúc</th>
                <th>Số lần sử dụng</th>
                <th>Trạng thái</th>
                <th>Chỉnh sửa</th>
                <th>Xóa</th>
            </tr>

            <?php
            // Hiển thị danh sách voucher
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['voucher_id'] . "</td>";
                    echo "<td>" . $row['code'] . "</td>";
                    if ($row['discount_value'] > 100) {
                        echo "<td>" . number_format($row['discount_value'], 0, ',', '.') . "</td>";
                    } else {
                        echo "<td>" . number_format($row['discount_value'], 0, ',', '.') . "%</td>";
                    }
                    echo "<td>" . ($row['discount_type'] == 'percent' ? 'Phần trăm' : 'Trực tiếp') . "</td>";
                    echo "<td>" . $row['min_order_value'] . "</td>";
                    if ($row['expiration_date']) {
                        echo "<td>" . $row['expiration_date'] . "</td>";
                    } else {
                        echo "<td> Không có thời hạn</td>";
                    }
                    echo "<td>" . $row['usage_limit'] . "</td>";
                    echo "<td>" . ($row['status'] == 'active' ? 'Kích hoạt' : 'Không kích hoạt') . "</td>";
                    // Nút chỉnh sửa và xóa
                    echo "<td><a href='../voucher/voucher_edit.php?id=" . $row['voucher_id'] . "'>Chỉnh sửa</a></td>";
                    echo "<td><a href='../voucher/voucher_delete.php?id=" . $row['voucher_id'] . "' onclick=\"return confirm('Bạn có chắc chắn muốn xóa chương trình này?');\">Xóa</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>Không có chương trình nào!</td></tr>";
            }

            $conn->close();
            ?>
        </table>
    </div>
</body>

</html>