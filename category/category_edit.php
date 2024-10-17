<?php


include("../side_nav.php");
// Lấy category_id từ URL
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    // Truy vấn danh mục theo category_id
    $sql = "SELECT * FROM Category WHERE category_id = '$category_id'";
    $result = $conn->query($sql);

    // Kiểm tra nếu có danh mục được trả về
    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc();
    } else {
        echo "Danh mục không tồn tại!";
        exit();
    }
}

// Xử lý khi form cập nhật được submit
if (isset($_POST['update'])) {
    $tenDM = $_POST['tenDM'];
    $motaDM = $_POST['motaDM'];
    $DMcha = $_POST['DMcha'];
    $hinhanhDM = $category['image'];  // Giữ hình ảnh cũ nếu không upload ảnh mới

    // Kiểm tra nếu người dùng upload hình ảnh mới
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
            $hinhanhDM = basename($_FILES["hinhanhDM"]["name"]);  // Cập nhật hình ảnh mới
        }
    }

    // Cập nhật thông tin danh mục trong cơ sở dữ liệu
    if ($DMcha == "") {
        $sql = "UPDATE Category 
                SET category_name='$tenDM', description='$motaDM', image='$hinhanhDM', parent= NULL
                WHERE category_id='$category_id'";
    } else {
        $sql = "UPDATE Category 
                SET category_name='$tenDM', description='$motaDM', image='$hinhanhDM', parent='$DMcha' 
                WHERE category_id='$category_id'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "
            <script>
                alert('Cập nhật thông tin danh mục thành công!');
                window.location.href = '../category/category_list.php';
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
        <h1>Chỉnh sửa danh mục</h1>

        <form action="" method="post" enctype="multipart/form-data">
            <label for="">Tên danh mục</label>
            <input type="text" name="tenDM" value="<?php echo $category['category_name']; ?>" required> <br>

            <label for="">Mô tả</label>
            <textarea name="motaDM" rows="5" cols="20" required><?php echo $category['description']; ?></textarea> <br>

            <label for="">Danh mục cha</label>
            <select name="DMcha">
                <option value="">Không</option>
                <?php
                include("../connection.php");

                $sql_parrent = "SELECT * FROM category";
                $result_parrent = $conn->query($sql_parrent);
                if ($result_parrent->num_rows > 0) {
                    while ($row = $result_parrent->fetch_assoc()) {
                        $selected = ($row['category_id'] == $category['parent']) ? 'selected' : '';
                        echo "<option value='" . $row['category_id'] . "' $selected>" . $row['category_name'] . "</option>";
                    }
                }
                ?>
            </select> <br>

            <label for="">Hình ảnh hiện tại</label><br>
            <?php
            if (!empty($category['image'])) {
                ?> <img src="../src/assets/uploads/category/<?php echo $category['image']; ?>" width="100"><br> <?php
            } else {
                echo "Không có hình ảnh";
            } ?>
            <br>

            <label for="">Cập nhật hình ảnh mới</label>
            <input type="file" name="hinhanhDM"> <br>

            <button name="update">Cập nhật</button>
        </form>
    </div>
</body>

</html>