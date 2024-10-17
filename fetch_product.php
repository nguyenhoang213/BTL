<?php
include("connection.php");

if (isset($_POST['category'])) {
    $category = $_POST['category'];

    // Truy vấn sản phẩm theo category
    $sql = "SELECT p.image, p.product_name, p.price, p.product_id
            FROM product p 
            JOIN product_category pc ON p.product_id = pc.product_id 
            WHERE pc.category_id = ?  ORDER BY RAND()
            LIMIT 8";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra và hiển thị sản phẩm
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '
            <div class="product-item">
                <a href="/BTL/product/product_detail.php?id=' . $row['product_id'] . '">
                <img style="width: 170px; height: 170px" src="/BTL/src/assets/uploads/product/' . $row['image'] . '">
                <p>' . $row['product_name'] . '</p>
                <span>' . number_format($row['price'], 0, ',', '.') . ' VNĐ</span>
                </a>
            </div>';
        }
    } else {
        echo '<p>Không có sản phẩm nào.</p>';
    }
}
?>