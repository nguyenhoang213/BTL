<?php


include("../side_nav.php");
// Lấy product_id từ URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Truy vấn sản phẩm theo product_id
    $sql = "SELECT * FROM Product WHERE product_id = '$product_id'";
    $result = $conn->query($sql);

    // Kiểm tra nếu có sản phẩm được trả về
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Sản phẩm không tồn tại!";
        exit();
    }
}

// Xử lý khi form cập nhật được submit
if (isset($_POST['update'])) {
    $tenSP = $_POST['tenSP'];
    $motaSP = $_POST['motaSP'];
    $giaSP = $_POST['giaSP'];
    $soluongSP = $_POST['soluongSP'];
    $hinhanhSP = $product['image'];  // Giữ hình ảnh cũ nếu không upload ảnh mới

    // Kiểm tra nếu người dùng upload hình ảnh mới
    if (!empty($_FILES["hinhanhSP"]["name"])) {
        $target_dir = "../src/assets/uploads/product/";
        $target_file = $target_dir . basename($_FILES["hinhanhSP"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'png', 'jpeg', 'gif'];

        // Kiểm tra file có hợp lệ không
        if (!in_array($imageFileType, $allowedTypes)) {
            echo "<script>alert('Chỉ chấp nhận các định dạng file: JPG, JPEG, PNG, GIF!');</script>";
        } elseif ($_FILES["hinhanhSP"]["size"] > 5000000) {
            echo "<script>alert('File ảnh có kích thước quá lớn! Tối đa là 5MB.');</script>";
        } elseif (!move_uploaded_file($_FILES["hinhanhSP"]["tmp_name"], $target_file)) {
            echo "<script>alert('Có lỗi khi upload hình ảnh. Vui lòng thử lại!');</script>";
        } else {
            $hinhanhSP = basename($_FILES["hinhanhSP"]["name"]);
        }
    }

    // Cập nhật thông tin sản phẩm trong cơ sở dữ liệu
    $sql = "UPDATE Product 
                SET product_name='$tenSP', description='$motaSP', price='$giaSP', image='$hinhanhSP', stock='$soluongSP' 
                WHERE product_id='$product_id'";

    if ($conn->query($sql) === TRUE) {
        echo "
            <script>
                alert('Cập nhật thông tin sản phẩm thành công!');
                window.location.href = '../product/product_list.php';
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
    <link rel="stylesheet" href="/BTL/css/create.css">
    <title>Chỉnh sửa sản phẩm</title>
</head>

<body>
    <div class="content">
        <h1>Chỉnh sửa sản phẩm</h1>

        <form action="" method="post" enctype="multipart/form-data">
            <label for="">Tên sản phẩm</label>
            <input type="text" name="tenSP" value="<?php echo $product['product_name']; ?>" required> <br>

            <label for="">Mô tả</label>
            <textarea name="motaSP" rows="5" cols="20" required><?php echo $product['description']; ?></textarea> <br>

            <label for="giaSP">Giá</label>
            <input type="text" id="giaSP" name="giaSP" required value="<?php echo $product['price']; ?>"> <br>

            <label for="">Số lượng</label>
            <input type="number" name="soluongSP" value="<?php echo $product['stock']; ?>" required> <br>

            <label for="">Tình trạng</label>
            <select name="tinhtrangSP">
                <option value="1" <?php if ($product['status'] == 1)
                    echo 'selected'; ?>>Đang bán</option>
                <option value="0" <?php if ($product['status'] == 0)
                    echo 'selected'; ?>>Ngừng bán</option>
            </select>

            <label for="">Hình ảnh hiện tại</label><br>
            <?php
            if (!empty($product['image'])) {
                ?> <img src="../src/assets/uploads/product/<?php echo $product['image']; ?>" width="100"><br> <?php
            } else {
                echo "Không có hình ảnh";
            } ?>
            <br>

            <label for="">Cập nhật hình ảnh mới</label>
            <input type="file" name="hinhanhSP"> <br>

            <button name="update">Cập nhật</button>
        </form>
    </div>
</body>

</html>


<script>
    const inputGiaSP = document.getElementById('giaSP');

    inputGiaSP.addEventListener('input', function (e) {
        // Xóa các ký tự không phải là số
        let value = e.target.value.replace(/\D/g, '');

        // Thêm dấu chấm mỗi 3 số
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        // Hiển thị giá trị đã định dạng
        e.target.value = value;
    });

    // Khi gửi form, loại bỏ dấu chấm trước khi gửi giá trị
    const form = document.querySelector('form');
    form.addEventListener('submit', function () {
        inputGiaSP.value = inputGiaSP.value.replace(/\./g, '');
    });
</script>