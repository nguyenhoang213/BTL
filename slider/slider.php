<?php
include("../side_nav.php");

// Xóa slider nếu có yêu cầu
if (isset($_GET['delete'])) {
    $slider_id = $_GET['delete'];
    $sql = "DELETE FROM slider WHERE slider_id = $slider_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Slider đã được xóa!'); window.location = 'slider.php';</script>";
    } else {
        echo "Error deleting slider: " . $conn->error;
    }
}

// Lấy danh sách slider
$sql = "SELECT * FROM slider";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Slider</title>

    <style>
    .sliders {
        margin-top: 70px;
        margin-left: 300px;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 2.5rem;
        color: #444;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    table th,
    table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    table th {
        background-color: #f4f4f4;
        color: #333;
        font-weight: bold;
    }

    table td {
        vertical-align: middle;
    }

    table img {
        width: 100px;
        border-radius: 8px;
    }

    .btn-edit,
    .btn-delete,
    .btn-add {
        padding: 5px 10px;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 3px;
        text-decoration: none;
        font-size: 1rem;
    }

    .btn-edit {
        background-color: #007bff;
    }

    .btn-edit:hover {
        background-color: #0056b3;
    }

    .btn-delete {
        background-color: #dc3545;
    }

    .btn-delete:hover {
        background-color: #c82333;
    }

    .btn-add {
        display: inline-block;
        padding: 10px 15px;
        background-color: #28a745;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        margin-bottom: 20px;
        cursor: pointer;
    }

    .btn-add:hover {
        background-color: #218838;
    }

    table tr:hover {
        background-color: #f0f0f0;
    }

    .actions {
        display: flex;
        gap: 10px;
    }
    </style>

</head>

<body>

    <div class="sliders">
        <h1>Danh sách Slider</h1>

        <a href="add.php" class="btn-add">Thêm Slider mới</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Slider</th>
                    <th>Hình ảnh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Hiển thị từng hàng slider
                    while ($row = $result->fetch_assoc()) {
                        $image_path = 'image_slider/' . $row['slider_image'];
                        echo "<tr>";
                        echo "<td>" . $row['slider_id'] . "</td>";
                        echo "<td>" . $row['slider_name'] . "</td>";
                        echo "<td><img src='{$row['slider_image']}'  width='100'></td>";
                        echo "<td>";
                        echo "<a href='edit.php?edit=" . $row['slider_id'] . "' class='btn-edit'>Sửa</a> ";
                        echo "<a href='slider.php?delete=" . $row['slider_id'] . "' class='btn-delete' onclick='return confirm(\"Bạn có chắc chắn muốn xóa slider này?\")'>Xóa</a>";
                        echo "</td>";
                        echo "</tr>";

                    }
                } else {
                    echo "<tr><td colspan='4'>Không có slider nào</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    </tbody>
    </table>
    </div>

</body>

</html>