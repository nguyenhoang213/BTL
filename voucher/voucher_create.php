<?php
include("../side_nav.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm chương trình khuyến mại</title>
    <link rel="stylesheet" href="/BTL/css/create.css">
</head>

<body>
    <div class="content">
        <form action="" method="post">
            <h1>Thêm chương trình</h1>
            <label for="">Code</label>
            <input type="text" name="code" required><br>
            <label for="">Giá trị KM</label>
            <input type="number" name="discount_value" required><br>
            <label for="">Loại KM</label>
            <Select name="discount_type">
                <option value="fixed">Giảm trực tiếp</option>
                <option value="percent">Giảm theo phần trăm</option>
            </Select>
            <label for="">Giá trị tối thiểu </label>
            <input type="number" name="min_order_value" required><br>
            <label for="">Thời gian kết thúc </label>
            <input type="date" name="expiration_date"><br>
            <label for="">Số lần sử dụng </label>
            <input type="number" name="usage_limit" required><br>
            <label for="">Trạng thái </label>
            <Select name="status">
                <option value="active">Active</option>
                <option value="expired">Expired</option>
                <option value="disabled">Disabled</option>
            </Select>
            <button name="submit">Xác nhận</button>
        </form>
    </div>
</body>

</html>
<?php

// Xử lý khi form thêm sản phẩm được submit
if (isset($_POST['submit'])) {
    $code = $_POST['code'];
    $discount_value = $_POST['discount_value'];
    $discount_type = $_POST['discount_type'];
    $min_order_value = $_POST['min_order_value'];
    $expiration_date = !empty($_POST['expiration_date']) ? $_POST['expiration_date'] : NULL;
    $usage_limit = $_POST['usage_limit'];
    $status = $_POST['status'];

    // Thêm sản phẩm mới vào cơ sở dữ liệu
    if ($expiration_date) {
        $sql = "INSERT INTO voucher(code, discount_value, discount_type, min_order_value, expiration_date, usage_limit, status)
                    VALUES ('$code','$discount_value','$discount_type','$min_order_value','$expiration_date','$usage_limit','$status')";

    } else {
        $sql = "INSERT INTO voucher(code, discount_value, discount_type, min_order_value, expiration_date, usage_limit, status)
                    VALUES ('$code','$discount_value','$discount_type','$min_order_value',NULL,'$usage_limit','$status')";
    }
    if ($conn->query($sql) === TRUE) {
        echo "
            <script>alert('Chương trình khuyến mại đã được thêm thành công!');
            window.location.href='../voucher/voucher_list.php';
            </script>";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>