<?php
include("../side_nav.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm danh mục</title>
    <link rel="stylesheet" href="/BTL/css/create.css">
</head>

<body>
    <div class="content">
        <form action="" method="post" enctype="multipart/form-data">
            <h1>Thêm danh mục</h1>
            <label for="">Mã danh mục</label>
            <input type="text" name="maDM" required> <br>
            <label for="">Tên danh mục</label>
            <input type="text" name="tenDM" required> <br>
            <label for="">Mô tả</label>
            <textarea name="motaDM" rows="5" cols="20" required></textarea> <br>
            <label for="">Hình ảnh</label>
            <input type="file" name="hinhanhDM"> <br>
            <label for="">Danh mục cha</label>
            <select name="DMcha">
                <option value="">Không</option>
                <?php
                $sql = "SELECT * FROM category";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['category_id'] ?>"><?php echo $row['category_name'] ?></option> <?php }
                }
                ?>
            </select> <br>
            <button name="submit">Xác nhận</button>
        </form>
    </div>
</body>

</html>

<?php
// Xử lý khi form thêm sản phẩm được submit
if (isset($_POST['submit'])) {
    $maDM = $_POST['maDM'];
    $tenDM = $_POST['tenDM'];
    $motaDM = $_POST['motaDM'];
    $DMcha = $_POST['DMcha'];
    $hinhanhDM = '';

    // Kiểm tra nếu người dùng upload hình ảnh
    if (!empty($_FILES["hinhanhDM"]["name"])) {
        $target_dir = "../src/assets/uploads/category/";
        $target_file = $target_dir . basename($_FILES["hinhanhDM"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'png', 'jpeg', 'gif'];

        // Kiểm tra file có hợp lệ không
        if (!in_array($imageFileType, $allowedTypes)) {
            echo "<script>alert('Chỉ chấp nhận các định dạng file: JPG, JPEG, PNG, GIF!');</script>";
        } elseif ($_FILES["hinhanhDM"]["size"] > 5000000) {
            echo "<script>alert('File ảnh có kích thước quá lớn! Tối đa là 5MB.');</script>";
        } elseif (!move_uploaded_file($_FILES["hinhanhDM"]["tmp_name"], $target_file)) {
            echo "<script>alert('Có lỗi khi upload hình ảnh. Vui lòng thử lại!');</script>";
        } else {
            $hinhanhSP = basename($_FILES["hinhanhDM"]["name"]);
        }
    }

    // Thêm sản phẩm mới vào cơ sở dữ liệu
    if ($DMcha == NULL) {
        $sql = "INSERT INTO category(category_id, category_name, description, image, parent) 
                VALUES ('$maDM',' $tenDM','$motaDM','$hinhanhDM',NULL)";
    } else {
        $sql = "INSERT INTO category(category_id, category_name, description, image, parent) 
                VALUES ('$maDM',' $tenDM','$motaDM','$hinhanhDM', '$DMcha')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "
            <script>
                alert('Danh mục mới đã được thêm thành công!');
                window.location.href = '../category/category_list.php';
            </script>
            ";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>