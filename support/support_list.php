<?php
include("../side_nav.php");

// Truy vấn mặc định để lấy tất cả yêu cầu hỗ trợ
$sql = "SELECT * FROM support";
$result = $conn->query($sql);
$search_category = "support_id";  // Mặc định tìm kiếm theo ID yêu cầu hỗ trợ
?>

<?php
// Xử lý chức năng tìm kiếm
if (isset($_GET["search"])) {
    $search_category = $_GET["search_category"];
    $search_string = $_GET["search"];
    // Truy vấn tìm kiếm trên bảng support
    $sql = "SELECT * FROM support WHERE $search_category LIKE '%$search_string%'";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/BTL/css/list.css">
    <title>Quản lý yêu cầu hỗ trợ</title>

</head>

<body>
    <div class="content">
        <h1>Quản lý yêu cầu hỗ trợ</h1>

        <!-- Form tìm kiếm -->
        <form action="" method="get">
            <label for="search">Tìm kiếm yêu cầu hỗ trợ:</label>
            <select name="search_category">
                <option value="support_id" <?php if ($search_category == "support_id")
                    echo 'selected'; ?>>ID yêu cầu hỗ
                    trợ</option>
                <option value="order_id" <?php if ($search_category == "order_id")
                    echo 'selected'; ?>>Mã đơn hàng
                </option>
                <option value="status" <?php if ($search_category == "status")
                    echo 'selected'; ?>>Trạng thái</option>
            </select>
            <input type="text" id="search" name="search" placeholder="Nhập từ khóa">
            <button type="submit">Tìm kiếm</button>
        </form>

        <!-- Hiển thị danh sách yêu cầu hỗ trợ -->
        <table>
            <tr>
                <th>ID</th>
                <th>Mã đơn hàng</th>
                <th>Nội dung</th>
                <th>Trạng thái</th>
                <th>Thời gian gửi</th>
                <th>Xem chi tiết</th>
                <th>Xóa</th>
            </tr>

            <?php
            // Hiển thị danh sách yêu cầu hỗ trợ
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['support_id'] . "</td>";
                    echo "<td>" . ($row['order_id'] ? '#' . $row['order_id'] : 'Không có') . "</td>";
                    echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                    echo "<td>" . date('d-m-Y H:i:s', strtotime($row['time'])) . "</td>";
                    // Nút xem chi tiết và xóa
                    echo "<td><a href='/BTL/support/support_detail.php?support_id=" . $row['support_id'] . "'>Xem chi tiết</a></td>";
                    echo "<td><a href='/BTL/support/support_delete.php?support_id=" . $row['support_id'] . "' onclick=\"return confirm('Bạn có chắc chắn muốn xóa yêu cầu này?');\">Xóa</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Không có yêu cầu hỗ trợ nào!</td></tr>";
            }

            // Đóng kết nối
            $conn->close();
            ?>
        </table>
    </div>
</body>

</html>