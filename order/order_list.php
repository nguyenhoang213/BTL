<?php
include("../side_nav.php");

$sql = "SELECT * FROM orders WHERE 1";
$result = $conn->query($sql);
$search_category = "order_id";

$json_data = file_get_contents('../src/json/don_vi_hanh_chinh.json');
$locations = json_decode($json_data, true); // Chuyển JSON thành mảng PHP

// Hàm tìm tên tỉnh
function getProvinceName($province_id, $locations)
{
    foreach ($locations['province'] as $province) {
        if ($province['id'] == $province_id) {
            return $province['name'];
        }
    }
    return 'Unknown Province'; // Nếu không tìm thấy
}

// Hàm tìm tên huyện
function getDistrictName($district_id, $locations)
{
    foreach ($locations['district'] as $district) {
        if ($district['id'] == $district_id) {
            return $district['name'];
        }
    }
    return 'Unknown District'; // Nếu không tìm thấy
}

// Hàm tìm tên xã
function getWardName($ward_id, $locations)
{
    foreach ($locations['ward'] as $ward) {
        if ($ward['id'] == $ward_id) {
            return $ward['name'];
        }
    }
    return 'Unknown Ward'; // Nếu không tìm thấy
}

?>

<?php
if (isset($_GET["search"])) {
    $search_category = $_GET["search_category"];
    $search_string = $_GET["search"];
    $sql = "SELECT * FROM orders WHERE $search_category LIKE '%$search_string%'";
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="/BTL/css/list.css">
    <style>
    table {
        margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <div class="content" style="width: 110vw">
        <h1>Danh sách đơn hàng</h1>
        <form action="" method="get">
            <label for="search">Tìm kiếm đơn hàng:</label>
            <select name="search_category">
                <option value="order_id" <?php if ($search_category == "order_id")
                    echo 'selected'; ?>>Mã đơn hàng
                </option>
                <option value="full_name" <?php if ($search_category == "full_name")
                    echo 'selected'; ?>>Tên khách
                    hàng
                </option>
                <option value="phone" <?php if ($search_category == "phone")
                    echo 'selected'; ?>>Số điện thoại
                </option>
            </select>
            <input type="text" id="search" name="search" placeholder="Nhập từ khóa">
            <button type="submit">Tìm kiếm</button>
        </form>
        <h2>Đơn hàng đang chờ</h2>
        <table>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Họ tên</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Tổng tiền</th>
                <th>Giảm giá</th>
                <th>Thu thực</th>
                <th>Phương thức thanh toán</th>
                <th>Trạng thái đơn hàng</th>
                <th>Thời gian đặt hàng</th>
                <th style="width: 60px">Xử lý</th>
            </tr>

            <?php
            // Hiển thị danh sách đơn hàng
            $sql1 = $sql . " and order_status='Đang chờ'";
            $result = $conn->query($sql1);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $province_name = getProvinceName($row['province'], $locations);
                    $district_name = getDistrictName($row['district'], $locations);
                    $ward_name = getWardName($row['ward'], $locations);
                    echo "<tr>";
                    echo "<td>" . $row['order_id'] . "</td>";
                    echo "<td>" . $row['full_name'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $province_name . ' - ' . $district_name . ' - ' . $ward_name . ' - ' . htmlspecialchars($row['address']) . "</td>";
                    echo "<td>" . number_format($row['total'], 0, ',', '.') . " VND</td>";
                    echo "<td>" . number_format($row['discount_amount'], 0, ',', '.') . " VND</td>";
                    echo "<td>" . number_format($row['total'] - $row['discount_amount'], 0, ',', '.') . " VND</td>";
                    echo "<td>" . $row['payment_method'] . "</td>";
                    echo "<td> <span style='color:red; font-weight: bold'>" . $row['order_status'] . "</td>";
                    echo "<td>" . $row['order_time'] . "</td>";
                    echo "<td><a href='../order/order_detail.php?id=" . $row['order_id'] . "'>Xử lý</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='14'>Không có đơn hàng nào!</td></tr>";
            }
            ?>
        </table>
        <h2>Đơn hàng đang xử lý</h2>
        <table>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Họ tên</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Tổng tiền</th>
                <th>Giảm giá</th>
                <th>Thu thực</th>
                <th>Phương thức thanh toán</th>
                <th>Trạng thái đơn hàng</th>
                <th>Thời gian đặt hàng</th>
                <th style="width: 60px">Xử lý</th>
            </tr>

            <?php
            $sql2 = $sql . " and order_status='Đã xác nhận'";
            $result = $conn->query($sql2);
            // Hiển thị danh sách đơn hàng
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $province_name = getProvinceName($row['province'], $locations);
                    $district_name = getDistrictName($row['district'], $locations);
                    $ward_name = getWardName($row['ward'], $locations);
                    echo "<tr>";
                    echo "<td>" . $row['order_id'] . "</td>";
                    echo "<td>" . $row['full_name'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $province_name . ' - ' . $district_name . ' - ' . $ward_name . ' - ' . htmlspecialchars($row['address']) . "</td>";
                    echo "<td>" . number_format($row['total'], 0, ',', '.') . " VND</td>";
                    echo "<td>" . number_format($row['discount_amount'], 0, ',', '.') . " VND</td>";
                    echo "<td>" . number_format($row['total'] - $row['discount_amount'], 0, ',', '.') . " VND</td>";
                    echo "<td>" . $row['payment_method'] . "</td>";
                    echo "<td> <span style='color:red; font-weight: bold'>" . $row['order_status'] . "</td>";
                    echo "<td>" . $row['order_time'] . "</td>";
                    echo "<td><a href='../order/order_detail.php?id=" . $row['order_id'] . "'>Xử lý</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='14'>Không có đơn hàng nào!</td></tr>";
            }
            ?>
        </table>
        <h2>Đơn hàng đã hoàn thành</h2>
        <table>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Họ tên</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Tổng tiền</th>
                <th>Giảm giá</th>
                <th>Thu thực</th>
                <th>Phương thức thanh toán</th>
                <th>Trạng thái đơn hàng</th>
                <th>Thời gian đặt hàng</th>
                <th style="width: 60px">Xử lý</th>
            </tr>

            <?php
            $sql3 = $sql . " and order_status='Đã hoàn thành'";
            $result = $conn->query($sql3);
            // Hiển thị danh sách đơn hàng
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $province_name = getProvinceName($row['province'], $locations);
                    $district_name = getDistrictName($row['district'], $locations);
                    $ward_name = getWardName($row['ward'], $locations);
                    echo "<tr>";
                    echo "<td>" . $row['order_id'] . "</td>";
                    echo "<td>" . $row['full_name'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $province_name . ' - ' . $district_name . ' - ' . $ward_name . ' - ' . htmlspecialchars($row['address']) . "</td>";
                    echo "<td>" . number_format($row['total'], 0, ',', '.') . " VND</td>";
                    echo "<td>" . number_format($row['discount_amount'], 0, ',', '.') . " VND</td>";
                    echo "<td>" . number_format($row['total'] - $row['discount_amount'], 0, ',', '.') . " VND</td>";
                    echo "<td>" . $row['payment_method'] . "</td>";
                    echo "<td> <span style='color:red; font-weight: bold'>" . $row['order_status'] . "</td>";
                    echo "<td>" . $row['order_time'] . "</td>";
                    echo "<td><a href='../order/order_detail.php?id=" . $row['order_id'] . "'>Xử lý</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='14'>Không có đơn hàng nào!</td></tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>