<?php
include("../connection.php"); // Kết nối cơ sở dữ liệu
include("../side_nav.php"); // Giao diện điều hướng

// Kiểm tra quyền truy cập (admin)
if (!isset($_SESSION['role'])) {
    echo "<script>
            alert('Bạn không có quyền truy cập vào trang này.');
            window.location.href = 'http://localhost/BTL';
          </script>";
    exit();
}

// Truy vấn sản phẩm được xem nhiều nhất (bao gồm ảnh)
$sql_viewed = "SELECT p.product_id, p.product_name, p.image, COUNT(uph.product_id) AS view_count
               FROM user_product_history uph
               JOIN Product p ON uph.product_id = p.product_id
               WHERE uph.type = 0
               GROUP BY uph.product_id
               ORDER BY view_count DESC
               LIMIT 10"; // Giới hạn lấy 10 sản phẩm được xem nhiều nhất
$result_viewed = $conn->query($sql_viewed);

// Truy vấn sản phẩm được mua nhiều nhất (bao gồm ảnh)
$sql_purchased = "SELECT p.product_id, p.product_name, p.image, COUNT(uph.product_id) AS purchase_count
                  FROM user_product_history uph
                  JOIN Product p ON uph.product_id = p.product_id
                  WHERE uph.type = 1
                  GROUP BY uph.product_id
                  ORDER BY purchase_count DESC
                  LIMIT 10"; // Giới hạn lấy 10 sản phẩm được mua nhiều nhất
$result_purchased = $conn->query($sql_purchased);

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo sản phẩm</title>
    <link rel="stylesheet" href="/BTL/css/dashboard.css">
    <style>
    /* Thêm CSS để chỉnh sửa bảng và ảnh */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    table th,
    table td {
        padding: 10px;
        text-align: center;
        border: 1px solid #ddd;
    }

    table th {
        background-color: #007bff;
        color: black;
    }

    table img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
    }
    </style>
</head>

<body>
    <div class="content">
        <h2>Báo cáo sản phẩm</h2>

        <!-- Hiển thị sản phẩm được xem nhiều nhất -->
        <h3>Sản phẩm được xem nhiều nhất</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Số lần xem</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_viewed->num_rows > 0) {
                    $index = 1;
                    while ($row = $result_viewed->fetch_assoc()) {
                        echo "<tr>
                                <td>{$index}</td>
                                <td>{$row['product_id']}</td>
                                <td><img src='/BTL/src/assets/uploads/product/{$row['image']}' alt='{$row['product_name']}'></td>
                                <td>{$row['product_name']}</td>
                                <td>{$row['view_count']}</td>
                              </tr>";
                        $index++;
                    }
                } else {
                    echo "<tr><td colspan='4'>Không có dữ liệu</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Hiển thị sản phẩm được mua nhiều nhất -->
        <h3>Sản phẩm được mua nhiều nhất</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Số lần mua</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_purchased->num_rows > 0) {
                    $index = 1;
                    while ($row = $result_purchased->fetch_assoc()) {
                        echo "<tr>
                                <td>{$index}</td>
                                <td>{$row['product_id']}</td>
                                <td><img src='/BTL/src/assets/uploads/product/{$row['image']}' alt='{$row['product_name']}'></td>
                                <td>{$row['product_name']}</td>
                                <td>{$row['purchase_count']}</td>
                              </tr>";
                        $index++;
                    }
                } else {
                    echo "<tr><td colspan='4'>Không có dữ liệu</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
$conn->close(); // Đóng kết nối cơ sở dữ liệu
?>