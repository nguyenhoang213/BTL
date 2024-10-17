<?php
include("../connection.php");
include("user_header.php");

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

$user_id = $_SESSION['user_id']; // Lấy user_id từ session

// Truy vấn danh sách yêu thích của người dùng
$sql = "SELECT p.product_id, p.product_name, p.image, p.price, time
        FROM user_favorites uf
        JOIN product p ON uf.product_id = p.product_id 
        WHERE uf.user_id = ?
        ORDER BY uf.time DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Yêu thích</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/BTL/css/index.css">

    <style>
        /* Side Navigation */
        .sidenav {
            height: 100vh;
            width: 250px;
            position: fixed;
            z-index: 1;
            background-color: #FFFFFF;
            /* Màu nền đậm hơn */
            padding-top: 20px;
            border-right: 1px solid #dee2e6;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            /* Hiệu ứng đổ bóng */
            color: #fff;
            /* Màu chữ trắng */
        }

        .sidenav h3 {
            color: black;
            /* Màu chữ của tiêu đề */
            padding-bottom: 20px;
            border-bottom: 1px solid #dee2e6;
            /* Đường ngăn cách phía dưới tiêu đề */
            margin-bottom: 20px;
        }

        .sidenav a {
            padding: 12px 20px;
            text-decoration: none;
            font-size: 16px;
            color: black;
            /* Màu chữ nhạt hơn cho side nav */
            display: block;
            transition: all 0.3s ease;
            border-radius: 4px;
            margin: 5px 10px;
        }

        .sidenav a:hover {
            background-color: #495057;
            /* Hiệu ứng nền khi hover */
            color: #f8f9fa;
        }

        .content {
            margin-left: 260px;
            padding: 20px;
        }

        table th,
        table td {
            text-align: center;
            vertical-align: middle;
        }

        table th {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>

    <!-- Main Content -->
    <div class="content">
        <h2>Danh sách Yêu thích</h2>

        <!-- Kiểm tra nếu có sản phẩm yêu thích -->
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Mã sản phẩm</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Giá</th>
                        <th>Thời Gian Thêm</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($favorite = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($favorite['product_id']); ?></td>
                            <td><a
                                    href="/BTL/product/product_detail.php?id=<?php echo $favorite['product_id'] ?>"><?php echo htmlspecialchars($favorite['product_name']); ?></a>
                            </td>
                            <td><img src="/BTL/src/assets/uploads/product/<?php echo htmlspecialchars($favorite['image']); ?>"
                                    alt="Hình ảnh sản phẩm" width="100"></td>
                            <td><?php echo number_format($favorite['price'], 0, ',', '.'); ?> VND</td>
                            <td><?php echo date('d-m-Y H:i:s', strtotime($favorite['time'])); ?></td>
                            <td>
                                <form action="remove_from_wishlist.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $favorite['product_id']; ?>">
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Hiện tại bạn chưa có sản phẩm nào trong danh sách yêu thích.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>