<?php
include("../side_nav.php");

// Kiểm tra xem id của đơn hàng đã được truyền vào chưa
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}

// Truy vấn chi tiết đơn hàng
$sql = "SELECT * FROM orders WHERE order_id = '$id'";
$result = $conn->query($sql);

// Đọc dữ liệu đơn vị hành chính từ file JSON
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

// Xử lý xác nhận đơn hàng
if (isset($_POST['accept'])) {
    // Truy vấn lấy trạng thái hiện tại của đơn hàng
    $sql_status = "SELECT order_status FROM orders WHERE order_id = '$id'";
    $result_status = $conn->query($sql_status);
    $row_status = $result_status->fetch_assoc();

    // Kiểm tra trạng thái đơn hàng
    if ($row_status['order_status'] == 'Đã xác nhận') {
        // Nếu đơn hàng đã được xác nhận, chuyển sang "Đã hoàn thành"
        $date = date('Y-m-d H:i:s');
        $sql_complete = "UPDATE orders SET order_status = 'Đã hoàn thành', complete_time = '$date' WHERE order_id = '$id'";
        if ($conn->query($sql_complete) === TRUE) {
            echo '<script> alert("Đơn hàng đã được hoàn thành!"); 
                   window.location.href = "../order/order_list.php";
                   </script>';
        } else {
            echo '<script> alert("Không thể cập nhật trạng thái đơn hàng."); </script>';
        }
    } else {
        // Nếu chưa được xác nhận, chuyển sang "Đã xác nhận"
        $sql_accept = "UPDATE orders SET order_status = 'Đã xác nhận' WHERE order_id = '$id'";
        if ($conn->query($sql_accept) === TRUE) {
            echo '<script> alert("Đã xác nhận đơn hàng!"); 
                   window.location.href = "../order/order_list.php";
                   </script>';
        } else {
            echo '<script> alert("Không thể xác nhận đơn hàng."); </script>';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xử lý đơn hàng</title>
    <link rel="stylesheet" href="/BTL/css/list.css">
    <style>
        .user {
            display: flex;
            justify-content: space-between;
        }

        .user>div {
            margin: 20px 15px 15px 0px;
            padding: 15px 20px;
            border-radius: 10px;
            width: 35%;
            background-color: rgb(209 232 247);
            border: solid;
        }

        table {
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table thead {
            background-color: #2980b9;
            color: #fff;
        }

        table th,
        table td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tbody tr:hover {
            background-color: #e1f5fe;
        }
    </style>
</head>

<body>
    <div class="content">
        <center>
            <h1>Thông tin đơn hàng #<?php echo $id ?></h1>
        </center>
        <form method="POST">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    //Lấy địa chỉ
                    $province_name = getProvinceName($row['province'], $locations);
                    $district_name = getDistrictName($row['district'], $locations);
                    $ward_name = getWardName($row['ward'], $locations);

                    //Lấy thông tin người đặt
                    $user_id = $row["user_id"];
                    $sql_user = "SELECT * FROM user WHERE user_id = '$user_id'";
                    $result_user = $conn->query($sql_user);
                    $row_user = $result_user->fetch_assoc();

                    // Thông tin người đặt
                    echo '<div class = "user"> <div>
                    <h4>Thông tin khách hàng: </h4>
                    <p>Mã khách hàng: ' . $row['user_id'] . '</p>
                    <p>Tên khách hàng: ' . $row_user['first_name'] . ' ' . $row_user['last_name'] . '</p>
                    <p>SĐT: ' . $row_user['phone'] . '</p>
                    <p>Email: ' . $row_user['email'] . '</p> 
                    <p> Phương thức thanh toán: ' . $row['payment_method'] . '</p>
                    </div>
                    ';

                    // Thông tin người nhận
                    echo ' <div>
                    <h4> Thông tin người nhận: </h4>
                    <p>Tên người nhận: ' . $row['full_name'] . '</p>
                    <p>SĐT: ' . $row['phone'] . '</p>
                    <p>Email: ' . $row['email'] . '</p>
                    <p>Địa chỉ: ' . $province_name . ' - ' . $district_name . ' - ' . $ward_name . ' - ' . htmlspecialchars($row['address']) . '</p> </div> 
                    ';

                    //Thông tin đơn hàng
                    echo ' <div>
                    <h4> Chi tiết đơn hàng </h4>
                    <p> Thời gian đặt hàng: ' . $row['order_time'] . '</p>
                    <p> Tổng đơn hàng: ' . number_format($row['total'], 0, ',', '.') . ' VND</p>
                    <p> Giảm giá: ' . number_format($row['discount_amount'], 0, ',', '.') . ' VND</p>
                    <p> Tổng tiền: ' . number_format($row['total'] - $row['discount_amount'], 0, ',', '.') . ' VND</p>
                    <p> Tình trạng: <span style="color:red;font-weight: bold">' . $row['order_status'] . '</p> </div> </div>
                    ';

                    // Truy vấn thông tin sản phẩm trong đơn hàng
                    $sql_products = "SELECT op.product_id, p.product_name, op.stock, op.price
                                     FROM order_product op
                                     JOIN product p ON op.product_id = p.product_id
                                     WHERE op.order_id = '$id'";
                    $result_products = $conn->query($sql_products);

                    if ($result_products->num_rows > 0) {
                        echo '
                        <center> <h2> Thông tin sản phẩm </h2> </center>
                        <table>
                                <tr>
                                    <th>Mã Sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá tiền</th>
                                    <th>Tổng tiền</th>
                                </tr>';

                        // Hiển thị từng sản phẩm trong đơn hàng
                        while ($product = $result_products->fetch_assoc()) {
                            $total_price = $product['stock'] * $product['price'];
                            echo '<tr>
                                    <td>' . $product['product_id'] . '</td>
                                    <td>' . $product['product_name'] . '</td>
                                    <td>' . $product['stock'] . '</td>
                                    <td>' . number_format($product['price'], 0, ',', '.') . ' VND</td>
                                    <td>' . number_format($total_price, 0, ',', '.') . ' VND</td>
                                  </tr>';
                        }
                        echo '<tr> <td colspan = "4" style="text-align: right"> Tổng: </td> 
                        <td>' . number_format($row['total'], 0, ',', '.') . ' VND' . '</td></tr>';
                        echo '</table>';
                    } else {
                        echo '<p>Không có sản phẩm trong đơn hàng.</p>';
                    }

                }
            } else {
                echo '<p>Không tìm thấy đơn hàng.</p>';
            }
            $sql_status = "SELECT order_status FROM orders WHERE order_id = '$id'";
            $result_status = $conn->query($sql_status);
            $row_status = $result_status->fetch_assoc();
            if ($row_status['order_status'] == "Đang chờ") {
                echo "
                    <center> <button name='accept'>Xác nhận đơn hàng</button>
                </center>";
            } else
                if ($row_status['order_status'] == "Đã xác nhận") {
                    echo "
                    <center> <button name='accept'>Hoàn thành đơn hàng</button>
                </center>";
                }
            ?>

        </form>
    </div>
</body>

</html>