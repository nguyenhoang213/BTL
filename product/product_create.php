<?php
include("../side_nav.php");
$sql = "SELECT * FROM category";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
    <link rel="stylesheet" href="/BTL/css/create.css">
</head>

<body>
    <div class="content">
        <h1>Thêm sản phẩm</h1>

        <form action="" method="post" enctype="multipart/form-data">
            <label for="category">Chọn danh mục</label>
            <select name="category_id" required>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?= $row['category_id'] ?>"><?= $row['category_name'] ?></option>
                <?php endwhile; ?>
            </select> <br>
            <label for="">Mã sản phẩm</label>
            <input type="text" name="maSP" required> <br>
            <label for="">Tên sản phẩm</label>
            <input type="text" name="tenSP" required> <br>
            <label for="">Mô tả</label>
            <textarea name="motaSP" rows="5" cols="20" required></textarea> <br>
            <label for="giaSP">Giá</label>
            <input type="text" id="giaSP" name="giaSP" required> <br>
            <label for="">hình ảnh</label>
            <input type="file" name="hinhanhSP"> <br>
            <label for="">số lượng</label>
            <input type="number" name="soluongSP"> <br>
            <button name="submit">Xác nhận</button>
        </form>
    </div>
</body>

</html>

<?php
if (isset($_POST['submit'])) {
    $maSP = $_POST['maSP'];
    $tenSP = $_POST['tenSP'];
    $motaSP = $_POST['motaSP'];
    $giaSP = $_POST['giaSP'];
    $soluongSP = $_POST['soluongSP'];
    $category_id = $_POST['category_id'];  // Lấy category_id từ form
    $hinhanhSP = '';

    // Kiểm tra và xử lý ảnh (nếu có)
    if (!empty($_FILES["hinhanhSP"]["name"])) {
        $target_dir = "../src/assets/uploads/product/";
        $target_file = $target_dir . basename($_FILES["hinhanhSP"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'png', 'jpeg', 'gif'];

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

    // Chèn sản phẩm vào bảng Product
    $sql = "INSERT INTO Product (product_id, product_name, description, price, image, stock) 
                VALUES ('$maSP', '$tenSP', '$motaSP', '$giaSP', '$hinhanhSP', '$soluongSP')";

    if ($conn->query($sql) === TRUE) {
        $sql_category = "INSERT INTO product_category (product_id, category_id) VALUES ('$maSP', '$category_id')";
        
        if ($conn->query($sql_category) === TRUE) {
            echo "
                <script>
                    alert('Sản phẩm mới đã được thêm thành công!');
                    window.location.href = '../product/product_list.php';
                </script>
                ";
        } else {
            echo "Lỗi khi thêm vào bảng product_category: " . $conn->error;
        }
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

?>


<script>
const inputGiaSP = document.getElementById('giaSP');

inputGiaSP.addEventListener('input', function(e) {
    // Xóa các ký tự không phải là số
    let value = e.target.value.replace(/\D/g, '');

    // Thêm dấu chấm mỗi 3 số
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    // Hiển thị giá trị đã định dạng
    e.target.value = value;
});

// Khi gửi form, loại bỏ dấu chấm trước khi gửi giá trị
const form = document.querySelector('form');
form.addEventListener('submit', function() {
    inputGiaSP.value = inputGiaSP.value.replace(/\./g, '');
});
</script>