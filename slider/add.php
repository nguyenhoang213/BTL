<?php
ob_start();
include("../side_nav.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slider_name = $_POST['slider_name'];

    if (isset($_FILES['slider_image']) && $_FILES['slider_image']['error'] == 0) {
        $target_dir = "image_slider/";
        $target_file = $target_dir . basename($_FILES["slider_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'png', 'jpeg', 'gif'];

        if (in_array($imageFileType, $allowed_extensions)) {
            if (move_uploaded_file($_FILES["slider_image"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO slider (slider_name, slider_image) VALUES ('$slider_name', '$target_file')";

                if ($conn->query($sql) === TRUE) {
                    header("Location: slider.php");
                    exit;
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
    } else {
        echo "No image uploaded or there was an error uploading the file.";
    }
}

ob_end_flush();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Thêm Slider</title>
    <style>
    body {
        margin-top: 70px;
        font-family: 'Arial', sans-serif;
        background-color: #FFFFFF;
        color: #333;
        line-height: 1.6;
    }

    .form-container {
        margin-left: 300px;
        width: 80%;
        padding: 30px;
        border-radius: 8px;
        background: #fff;
    }

    /* Tiêu đề */
    h1 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 2.5rem;
        color: #444;
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
        font-size: 1.1rem;
    }

    form input[type="text"],
    form input[type="file"] {
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1.1rem;
        width: 100%;
    }

    form button {
        padding: 12px;
        background-color: #28a745;
        color: white;
        border: none;
        font-size: 1.2rem;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 100%;
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
        text-align: center;
    }

    .btn-back:hover {
        text-decoration: underline;
        color: #0056b3;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .form-container {
            padding: 20px;
        }

        h1 {
            font-size: 2rem;
        }

        form label {
            font-size: 1rem;
        }

        form input[type="text"],
        form input[type="file"] {
            font-size: 1rem;
        }

        form button {
            font-size: 1rem;
        }
    }
    </style>
</head>

<body>

    <!-- Form để thêm slider với khả năng upload hình ảnh -->
    <div class="form-container">
        <h1>Thêm Slider</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="slider_name">Tên Slider:</label>
            <input type="text" name="slider_name" id="slider_name" required>

            <label for="slider_image">Hình ảnh:</label>
            <input type="file" name="slider_image" id="slider_image" required>

            <button type="submit">Thêm</button>
        </form>
        <a href="slider.php" class="btn-back">Quay lại</a>
    </div>

</body>

</html>