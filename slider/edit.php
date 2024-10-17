<?php
include("../side_nav.php");

if (isset($_GET['edit'])) {
    $slider_id = $_GET['edit'];
    $sql = "SELECT * FROM slider WHERE slider_id = $slider_id";
    $result = $conn->query($sql);
    $slider = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slider_name = $_POST['slider_name'];
    $target_file = $slider['slider_image'];

    if (isset($_FILES['slider_image']) && $_FILES['slider_image']['error'] == 0) {
        $target_dir = "uploads.php";
        $target_file = $target_dir . basename($_FILES["slider_image"]["name"]);
        move_uploaded_file($_FILES["slider_image"]["tmp_name"], $target_file);
    }

    $sql = "UPDATE slider SET slider_name='$slider_name', slider_image='$target_file' WHERE slider_id=$slider_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Slider đã được cập nhật!'); window.location = 'slider.php';</script>";
    } else {
        echo "Error updating slider: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Slider</title>
    <style>
    .edit_slider {
        margin-top: 70px;
        margin-left: 300px;
        background: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    /* Tiêu đề */
    h1 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 2.5rem;
        color: #444;
    }

    /* Form container giống bảng quản lý slider */
    .form-container {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    .form-container h2 {
        text-align: center;
        font-size: 1.8rem;
        color: #333;
        margin-bottom: 20px;
    }

    /* Form styling */
    form {
        display: flex;
        flex-direction: column;
    }

    form label {
        margin-bottom: 10px;
        font-weight: bold;
        color: #555;
    }

    form input[type="text"],
    form input[type="file"] {
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1.1rem;
        width: 100%;
        /* Đảm bảo các trường input chiếm hết chiều rộng */
    }

    form img {
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    form button {
        padding: 10px 20px;
        background-color: #28a745;
        color: white;
        border: none;
        font-size: 1.2rem;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    form button:hover {
        background-color: #218838;
    }

    /* Nút Quay lại */
    .btn-back {
        display: inline-block;
        margin-top: 20px;
        text-decoration: none;
        color: #007bff;
        font-size: 1rem;
    }

    .btn-back:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>

    <div class="edit_slider">
        <h1>Sửa Slider</h1>

        <form method="POST" action="" enctype="multipart/form-data">
            Tên Slider: <input type="text" name="slider_name" value="<?php echo $slider['slider_name']; ?>"
                required><br>
            Hình ảnh: <input type="file" name="slider_image"><br>
            <img src="<?php echo $slider['slider_image']; ?>" width="100"><br>
            <button type="submit">Cập nhật</button>
        </form>

        <a href="slider.php" class="btn-back">Quay lại</a>
    </div>

</body>

</html>