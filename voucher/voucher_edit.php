<?php
    
    include("../side_nav.php");
    // Lấy category_id từ URL
    if (isset($_GET['id'])) {
        $voucher_id = $_GET['id'];

        // Truy vấn danh mục theo category_id
        $sql = "SELECT * FROM voucher WHERE voucher_id = '$voucher_id'";
        $result = $conn->query($sql);

        // Kiểm tra nếu có danh mục được trả về
        if ($result->num_rows > 0) {
            $voucher = $result->fetch_assoc();
        } else {
            echo "Chương trình không tồn tại!";
            exit();
        }
    }

    // Xử lý khi form cập nhật được submit
    if (isset($_POST['update'])) {
        $code = $_POST['code'];
        $discount_value = $_POST['discount_value'];
        $discount_type = $_POST['discount_type'];
        $min_order_value = $_POST['min_order_value'];
        $expiration_date = !empty($_POST['expiration_date']) ? $_POST['expiration_date'] : NULL;
        $usage_limit = $_POST['usage_limit'];
        $status = $_POST['status'];

        if($expiration_date) {
        $sql = "UPDATE voucher 
            SET code = '$code', discount_value = '$discount_value', discount_type = '$discount_type', min_order_value = '$min_order_value', expiration_date = '$expiration_date', usage_limit = '$usage_limit', status = '$status' 
            WHERE voucher_id = '$voucher_id'";
        } else {
            $sql = "UPDATE voucher 
            SET code = '$code', discount_value = '$discount_value', discount_type = '$discount_type', min_order_value = '$min_order_value', expiration_date = NULL, usage_limit = '$usage_limit', status = '$status' 
            WHERE voucher_id = '$voucher_id'";
        }
       
        if ($conn->query($sql) === TRUE) {
            echo "
            <script>
                alert('Cập nhật thông tin danh mục thành công!');
                window.location.href = '../voucher/voucher_list.php';
            </script>
            ";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa danh mục</title>
    <link rel="stylesheet" href="/BTL/css/create.css">
</head>

<body>
    <div class="content">
        <form action="" method="post">
            <h1>Chỉnh sửa chương trình khuyến mại</h1>

            <label for="code">Mã khuyến mại</label>
            <input type="text" name="code" value="<?php echo $voucher['code']; ?>" required>

            <label for="discount_value">Giá trị khuyến mại</label>
            <input type="number" name="discount_value" value="<?php echo $voucher['discount_value']; ?>" required>

            <label for="discount_type">Loại khuyến mại</label>
            <select name="discount_type" required>
                <option value="fixed" <?php if($voucher['discount_type'] == 'fixed') echo 'selected'; ?>>Giảm trực tiếp
                </option>
                <option value="percent" <?php if($voucher['discount_type'] == 'percent') echo 'selected'; ?>>Giảm theo
                    phần trăm</option>
            </select>

            <label for="min_order_value">Giá trị đơn hàng tối thiểu</label>
            <input type="number" name="min_order_value" value="<?php echo $voucher['min_order_value']; ?>" required>

            <label for="expiration_date">Thời gian kết thúc</label>
            <input type="date" name="expiration_date" value="<?php echo $voucher['expiration_date']; ?>">

            <label for="usage_limit">Số lần sử dụng</label>
            <input type="number" name="usage_limit" value="<?php echo $voucher['usage_limit']; ?>" required>

            <label for="status">Trạng thái</label>
            <select name="status" required>
                <option value="active" <?php if($voucher['status'] == 'active') echo 'selected'; ?>>Active</option>
                <option value="expired" <?php if($voucher['status'] == 'expired') echo 'selected'; ?>>Expired</option>
                <option value="disabled" <?php if($voucher['status'] == 'disabled') echo 'selected'; ?>>Disabled
                </option>
            </select>

            <button type="submit" name="update">Cập nhật</button>
        </form>
    </div>
</body>

</html>