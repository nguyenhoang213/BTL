<?php
include("../connection.php");
include("../header.php");

date_default_timezone_set('Asia/Ho_Chi_Minh');
if (!isset($_SESSION["user_id"])) {
    echo "
    <script>
        window.location.href = '../login/login.php';
    </script>
    ";
}

$user_id = $_SESSION["user_id"];

$sql_cart = "SELECT cart_id FROM cart WHERE user_id = '$user_id'";
$result_cart = $conn->query($sql_cart);
if ($result_cart->num_rows > 0) {
    while ($row_cart = $result_cart->fetch_assoc()) {
        $cart_id = $row_cart["cart_id"];
        $_SESSION['cart_id'] = $cart_id;
    }
}

if (isset($_POST['apply_voucher'])) {
    $voucher_code = $_POST['voucher'];  // Lấy mã giảm giá từ form
    $total = $_POST['total'];           // Tổng giá trị đơn hàng
    $discount_amount = 0;               // Giá trị giảm giá ban đầu là 0

    // Lấy thông tin voucher từ cơ sở dữ liệu
    $sql_voucher = "SELECT * FROM voucher WHERE code = '$voucher_code' AND status = 'active' AND expiration_date >= NOW() AND usage_limit > 0";
    $result_voucher = $conn->query($sql_voucher);

    if ($result_voucher->num_rows > 0) {
        $row_voucher = $result_voucher->fetch_assoc();
        $voucher_id = $row_voucher['voucher_id'];
        $discount_value = $row_voucher['discount_value'];    // Giá trị giảm giá
        $discount_type = $row_voucher['discount_type'];      // Loại giảm giá (fixed hoặc percent)
        $min_order_value = $row_voucher['min_order_value'];  // Giá trị đơn hàng tối thiểu để áp dụng voucher
        $usage_limit = $row_voucher['usage_limit'];

        $sql_time_use = "SELECT COUNT(*) as SL FROM user_voucher WHERE user_id = '$user_id' and voucher_id = '$voucher_id'";
        $result_time_use = $conn->query($sql_time_use);
        if ($result_time_use->num_rows > 0) {
            while ($row_time_use = $result_time_use->fetch_assoc()) {
                $time_use = $row_time_use["SL"];
            }
        }

        if ($time_use < $usage_limit) {
            // Kiểm tra xem tổng đơn hàng có đủ điều kiện áp dụng không
            if ($total >= $min_order_value) {
                if ($discount_type == 'fixed') {
                    $discount_amount = $discount_value; // Giảm giá cố định
                } else if ($discount_type == 'percent') {
                    $discount_amount = ($total * $discount_value) / 100; // Giảm giá theo phần trăm
                }

                // Đảm bảo giảm giá không vượt quá tổng giá trị đơn hàng
                if ($discount_amount > $total) {
                    $discount_amount = $total;
                }

                // Cập nhật số lượng sử dụng của voucher

                echo "<script>alert('Áp dụng mã giảm giá thành công! Bạn được giảm $discount_amount VNĐ.');</script>";
            } else {
                echo "<script>alert('Đơn hàng của bạn chưa đủ điều kiện để áp dụng mã giảm giá.');</script>";
            }
        } else {
            echo "<script>alert('Mã giảm giá đã quá số lần sử dụng.');</script>";
        }
    } else {
        echo "<script>alert('Mã giảm giá không hợp lệ hoặc đã hết hạn.');</script>";
    }
}

if (isset($_POST['acp'])) {
    // Lấy thông tin từ form
    $full_name = $_POST['full_name']; // Họ tên
    $phone = $_POST['phone'];         // Số điện thoại
    $email = $_POST['email'];         // Email
    $province = $_POST['province'];   // Tỉnh/Thành phố
    $district = $_POST['district'];   // Quận/Huyện
    $ward = $_POST['ward'];           // Phường/Xã
    $address = $_POST['address'];     // Địa chỉ cụ thể
    $payment_method = $_POST['payment_method']; // Phương thức thanh toán
    $discount_amount = $_POST['discount_amount'];     // Tiền giảm
    $user_id = $_SESSION['user_id'];  // ID người dùng từ session
    $order_status = 'Đang chờ';
    $order_time = date('Y-m-d H:i:s');

    // Lấy thông tin giỏ hàng
    $sql = "SELECT p.product_id, cp.stock, p.price 
                FROM cart_product cp
                JOIN Product p ON cp.product_id = p.product_id
                WHERE cp.cart_id = '$cart_id'";
    $result = $conn->query($sql);
    $total = 0;
    if ($result->num_rows > 0) {
        // Tính tổng tiền
        while ($row = $result->fetch_assoc()) {
            $total += $row['price'] * $row['stock'];
        }

        // Thêm đơn hàng vào bảng orders
        $sql_order = "INSERT INTO orders(full_name, phone, email, province, district, ward, address, total, payment_method, discount_amount, order_status, order_time, user_id) 
            VALUES ('$full_name', '$phone', '$email', '$province', '$district', '$ward', '$address', $total, '$payment_method', $discount_amount, '$order_status', '$order_time', '$user_id')";
        $conn->query($sql_order);
        // Lấy order_id của đơn hàng vừa tạo
        $order_id = $conn->insert_id;

        $notification_title = "Đơn hàng mới từ $full_name";
        $notification_type = "Order";
        $notification_time = date('Y-m-d H:i:s');

        $sql_notification = "INSERT INTO admin_notification (title, order_id, type, time)
    VALUES ('$notification_title', '$order_id', '$notification_type', '$notification_time')";

        $conn->query($sql_notification);

        // Thêm sản phẩm vào bảng order_items
        $result->data_seek(0); // Đặt lại con trỏ result để duyệt lại từ đầu
        while ($row = $result->fetch_assoc()) {
            $product_id = $row['product_id'];
            $stock = $row['stock'];
            $price = $row['price'];

            $sql_update_stock = "UPDATE product SET stock = stock - $stock WHERE product_id = '$product_id'";
            $conn->query($sql_update_stock);

            $sql_order_item = "INSERT INTO order_product (order_id, product_id, stock, price)
                                    VALUES ($order_id , '$product_id', $stock, '$price')";
            $conn->query($sql_order_item);

            $sql_item_history = "INSERT INTO user_product_history (user_id, product_id, time, type)
                                    VALUES ('$user_id' , '$product_id', '$order_time', 1)";
            $conn->query($sql_item_history);
        }

        // Lưu mã người dùng đã dùng
        if (isset($_POST['voucher']) && $discount_amount > 0) {
            $voucher_id = $_POST['voucher'];
            $sql_insert = "INSERT INTO user_voucher (user_id, voucher_id, time)
                            VALUES ('$user_id' , '$voucher_id', '$order_time')";
            $conn->query($sql_insert);
        }

        // Xóa giỏ hàng sau khi đặt hàng thành công`
        $sql_clear_cart = "DELETE FROM cart_product WHERE cart_id = ?";
        $stmt_clear = $conn->prepare($sql_clear_cart);
        $stmt_clear->bind_param('i', $cart_id);
        $stmt_clear->execute();

        // Commit transaction
        $conn->commit();
        echo "<script>alert('Đặt hàng thành công!'); window.location.href = 'order_success.php?id=" . $order_id . "';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="/BTL/css/index.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    .mb-3 {
        margin-left: 40px;
        margin-bottom: 1rem;
    }

    .baner-header img {
        width: 100%;
        height: auto;
    }

    .header-wrapper {
        background-color: #f8f9fa;
        padding: 1rem;
    }

    .container-custom {
        margin-top: 30px;
    }


    .form-control,
    .form-select {
        margin-bottom: 1rem;
    }
    </style>
</head>

<body>


    <div class="container container-custom">
        <div class="row">
            <div class="col-lg-6">
                <h3 class="mb-4">Giỏ hàng của bạn</h3>
                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT p.product_id, cp.stock, p.product_name, p.price FROM cart_product cp
                                    JOIN Product p ON cp.product_id = p.product_id
                                    WHERE cp.cart_id = '$cart_id'";
                        $result = $conn->query($sql);
                        $total = 0;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $item_total = $row['price'] * $row['stock'];
                                $total += $item_total;
                                echo '
                                    <tr>
                                        <td>' . $row['product_name'] . '</td>
                                        <td>' . $row['stock'] . '</td>
                                        <td>' . number_format($row['price'], 0, ',', '.') . ' VNĐ</td>
                                        <td>' . number_format($item_total, 0, ',', '.') . ' VNĐ</td>
                                    </tr>';
                            }
                        } else {
                            echo "<script>
                                alert('Giỏ hàng trống');
                                window.location.href = '../cart/cart.php';
                            </script>";
                        }
                        ?>
                    </tbody>
                </table>
                <h4 class="text-end">Tổng cộng: <span id="total_price"
                        class="total-price"><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</span></h4>
                <?php
                if (isset($discount_amount) && $discount_amount > 0) {
                    echo '<h5 class="text-end" style ="color: red">Giảm giá Voucher: ' . number_format($discount_amount, 0, ',', '.') . ' VNĐ';
                    echo '<h4 class="text-end" style ="color: red">Tổng: ' . number_format($total - $discount_amount, 0, ',', '.') . ' VNĐ';
                }
                ?>
                <h3 class="mb-4">Thông tin thanh toán</h3>
                <form action="" method="POST">
                    <div class="mb-3">
                        <input type="hidden" value="<?php echo $total ?>" name="total">
                        <label for="voucher" class="form-label">Mã giảm giá</label>
                        <input type="text" class="form-control" id="voucher_code" name="voucher" required>
                        <button type="submit" name="apply_voucher" class="btn btn-primary">Áp dụng
                    </div>
                </form>
                <form action="" method="POST">
                    <?php
                    if (isset($discount_amount) && $discount_amount > 0) {
                        echo '<input type="hidden" name="discount_amount" value="' . $discount_amount . '">';
                    } else {
                        echo '<input type="hidden" name="discount_amount" value="0">';
                    }
                    if (isset($voucher_code) && $discount_amount > 0) {
                        echo '<input type="hidden" name="voucher" value="' . $voucher_id . '">';
                    }
                    ?>
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Phương thức thanh toán</label>
                        <select class="form-select" id="payment_method" name="payment_method" required>
                            <option value="cod">Thanh toán khi nhận hàng</option>
                            <option value="qr">Chuyển khoản</option>
                        </select>
                    </div>

                    <!-- Mã QR sẽ ẩn ban đầu và hiện ra khi chọn "Chuyển khoản" -->
                    <div id="qr_code_section" style="display:none; text-align:center; margin: 20px 0;">

                        <h5 style="color: red">Techombank: 19035842255014</h5>
                        <h5>Nguyễn Như Hoàng</h5>
                        <p>Quét mã QR để thanh toán:</p>
                        <img src="/BTL/src/assets/images/qr-code-image.png" alt="QR Code" width="200">
                    </div>

                    <div style="text-align: center">
                        <button type="submit" name="acp" class="btn btn-primary">Đặt hàng</button>
                    </div>

            </div>

            <div class="col-lg-6">

                <?php
                $user_id = $_SESSION['user_id'];
                $sql_user = "SELECT * FROM user WHERE user_id = '$user_id'";
                $result = $conn->query($sql_user);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<h3>Thông tin người nhận hàng</h3>
                <div class="mb-3">
                    <label for="full_name" class="form-label">Họ tên</label>
                    <input type="text" class="form-control" id="full_name" value = "' . $row['first_name'] . " " . $row['last_name'] . '" name="full_name" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">SĐT</label>
                    <input type="text" class="form-control" id="phone" name="phone" value = "' . $row['phone'] . '" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value = "' . $row['email'] . '" required>
                </div>
                <div class="mb-3">
                    <label for="province" class="form-label">Tỉnh/Thành phố</label>
                    <select class="form-select" id="province" name="province" required></select>
                </div>
                <div class="mb-3">
                    <label for="district" class="form-label">Quận/Huyện</label>
                    <select class="form-select" id="district" name="district" required></select>
                </div>
                <div class="mb-3">
                    <label for="ward" class="form-label">Phường/Xã</label>
                    <select class="form-select" id="ward" name="ward" required></select>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                </form>';
                    }
                }
                ?>

            </div>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/0236bf0649.js" crossorigin="anonymous"></script>

</body>

</html>
<script>
// Hàm tải dữ liệu từ tệp JSON
async function fetchData() {
    try {
        const response = await fetch('/BTL/src/json/don_vi_hanh_chinh.json'); // Đường dẫn tới file JSON
        const data = await response.json();
        console.log(data); // In ra dữ liệu để kiểm tra
        return data; // Trả về dữ liệu JSON
    } catch (error) {
        console.error('Error fetching JSON data:', error);
    }
}

// Hàm để lấy danh sách tỉnh/thành phố từ dữ liệu ward
function extractProvinces(data) {
    // Tạo một mảng chứa các tỉnh/thành phố từ provinceId
    const provinceMap = new Map();
    data.province.forEach(province => {
        if (!provinceMap.has(province.id)) {
            provinceMap.set(province.id, {
                id: province.id,
                name: province.name
            });
        }
    });

    return Array.from(provinceMap.values()); // Trả về danh sách tỉnh/thành phố
}

// Hàm điền dữ liệu vào dropdown tỉnh/thành phố
function populateProvinces(provinces) {
    const provinceSelect = document.getElementById("province");

    // Kiểm tra nếu provinces là mảng hợp lệ
    if (Array.isArray(provinces)) {
        provinces.forEach(province => {
            let option = document.createElement("option");
            option.value = province.id;
            option.text = province.name;
            provinceSelect.add(option);
        });
    } else {
        console.error("Provinces data is not an array:", provinces);
    }
}

// Hàm lấy danh sách quận/huyện từ provinceId
function extractDistricts(data, selectedProvinceId) {
    const districtMap = new Map();
    data.district.forEach(district => {
        if (district.provinceId === selectedProvinceId && !districtMap.has(district.id)) {
            districtMap.set(district.id, {
                id: district.id,
                name: district.name
            }); // Đặt tên tùy ý
        }
    });

    return Array.from(districtMap.values()); // Trả về danh sách quận/huyện
}

// Hàm điền dữ liệu vào dropdown quận/huyện dựa trên tỉnh/thành phố được chọn
function populateDistricts(districts, selectedProvinceId) {
    const districtSelect = document.getElementById("district");
    districtSelect.innerHTML = ''; // Xóa các lựa chọn trước đó

    // Kiểm tra nếu districts là mảng hợp lệ
    if (Array.isArray(districts)) {
        districts.forEach(district => {
            let option = document.createElement("option");
            option.value = district.id;
            option.text = district.name;
            districtSelect.add(option);
        });
    } else {
        console.error("Districts data is not an array:", districts);
    }

    populateWards([]);
}

// Hàm điền dữ liệu vào dropdown phường/xã dựa trên quận/huyện được chọn
function populateWards(wards, selectedDistrictId) {
    const wardSelect = document.getElementById("ward");
    wardSelect.innerHTML = '';

    // Kiểm tra nếu wards là mảng hợp lệ
    if (Array.isArray(wards)) {
        wards.forEach(ward => {
            if (ward.districtId === selectedDistrictId) {
                let option = document.createElement("option");
                option.value = ward.id;
                option.text = ward.name;
                wardSelect.add(option);
            }
        });
    } else {
        console.error("Wards data is not an array:", wards);
    }
}

// Khi người dùng chọn tỉnh/thành phố
document.getElementById("province").addEventListener('change', function() {
    const selectedProvinceId = this.value;
    fetchData().then(data => {
        if (data) {
            const districts = extractDistricts(data, selectedProvinceId);
            populateDistricts(districts, selectedProvinceId); // Điền quận/huyện theo tỉnh đã chọn
        }
    });
});

// Khi người dùng chọn quận/huyện
document.getElementById("district").addEventListener('change', function() {
    const selectedDistrictId = this.value;
    fetchData().then(data => {
        if (data) {
            populateWards(data.ward, selectedDistrictId); // Điền phường/xã theo quận/huyện đã chọn
        }
    });
});

// Tải dữ liệu khi trang được tải
window.onload = function() {
    fetchData().then(data => {
        if (data) {
            const provinces = extractProvinces(data);
            populateProvinces(provinces); // Điền tỉnh/thành phố khi trang vừa tải
        }
    });
};
</script>

<script>
// Lắng nghe sự thay đổi của phương thức thanh toán
document.getElementById('payment_method').addEventListener('change', function() {
    var paymentMethod = this.value;
    var qrSection = document.getElementById('qr_code_section');

    // Nếu chọn phương thức "Chuyển khoản", hiện mã QR
    if (paymentMethod === 'qr') {
        qrSection.style.display = 'block';
    } else {
        qrSection.style.display = 'none';
    }
});
</script>