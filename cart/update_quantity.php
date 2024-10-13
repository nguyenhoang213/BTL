<?php
include("../connection.php");
session_start();

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $cart_id = $_SESSION['cart_id']; // Giả sử bạn đã lưu `cart_id` trong session

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    $sql = "UPDATE cart_product SET stock = ? WHERE product_id = ? AND cart_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $quantity, $product_id, $cart_id);
    $stmt->execute();

}
?>