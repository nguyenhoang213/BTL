<?php
include("../connection.php");

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION["user_id"])) {
    echo "
        <script>
            alert('Vui lòng đăng nhập để tiếp tục');
            window.location.href = '../login/login.php';
        </script>
    ";
    exit();
}

// Lấy user_id từ session
$user_id = $_SESSION["user_id"];

// Kiểm tra xem có product_id trong URL không
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Lấy cart_id của người dùng
    $sql_cart = "SELECT cart_id FROM cart WHERE user_id = '$user_id'";
    $result_cart = $conn->query($sql_cart);

    if ($result_cart->num_rows > 0) {
        $row_cart = $result_cart->fetch_assoc();
        $cart_id = $row_cart['cart_id'];

        // Xóa sản phẩm khỏi giỏ hàng
        $sql_remove = "DELETE FROM cart_product WHERE cart_id = '$cart_id' AND product_id = '$product_id'";

        if ($conn->query($sql_remove) === TRUE) {
            // Thành công: Chuyển hướng về trang giỏ hàng
            echo "
                <script>
                    alert('Sản phẩm đã được xóa khỏi giỏ hàng');
                    window.location.href = './cart.php';
                </script>
            ";
        } else {
            // Nếu có lỗi trong quá trình xóa
            echo "
                <script>
                    alert('Có lỗi xảy ra khi xóa sản phẩm');
                    window.location.href = './cart.php';
                </script>
            ";
        }
    } else {
        // Nếu không tìm thấy giỏ hàng
        echo "
            <script>
                alert('Không tìm thấy giỏ hàng');
                window.location.href = './cart.php';
            </script>
        ";
    }
} else {
    // Nếu không có product_id trong URL
    echo "
        <script>
            alert('Không tìm thấy sản phẩm để xóa');
            window.location.href = './cart.php';
        </script>
    ";
}

$conn->close();
?>