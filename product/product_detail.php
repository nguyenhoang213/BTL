<?php
include('../connection.php');
include("../header.php");

date_default_timezone_set('Asia/Ho_Chi_Minh');

if (isset($_GET["id"])) {
    $product_id = $_GET["id"];
} else {

}

//lưu thông tin người dùng
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $order_time = date('Y-m-d H:i:s');
    $sql_insert = "INSERT INTO user_product_history(user_id, product_id, time, type) VALUES ('$user_id','$product_id','$order_time',0)";
    $conn->query($sql_insert);
}


if (isset($_POST['toggle-favorite'])) {
    if (!isset($_SESSION['user_id'])) {
        echo '<script>alert("Vui lòng đăng nhập để thêm vào yêu thích!")</script>';
    } else {
        // Kiểm tra xem sản phẩm đã có trong danh sách yêu thích chưa
        $sql_check_fav = "SELECT * FROM user_favorites WHERE user_id = '$user_id' AND product_id = '$product_id'";
        $result_check_fav = $conn->query($sql_check_fav);

        if ($result_check_fav->num_rows > 0) {
            // Nếu đã có, xóa khỏi danh sách yêu thích
            $sql_delete_fav = "DELETE FROM user_favorites WHERE user_id = '$user_id' AND product_id = '$product_id'";
            if ($conn->query($sql_delete_fav) === TRUE) {
                echo '<script>alert("Đã xóa sản phẩm khỏi danh sách yêu thích!");</script>';
            } else {
                echo "Lỗi: " . $sql_delete_fav . "<br>" . $conn->error;
            }
        } else {
            // Nếu chưa có, thêm vào danh sách yêu thích
            $sql_insert_fav = "INSERT INTO user_favorites (user_id, product_id) VALUES ('$user_id', '$product_id')";
            if ($conn->query($sql_insert_fav) === TRUE) {
                echo '<script>alert("Đã thêm sản phẩm vào danh sách yêu thích!");</script>';
            } else {
                echo "Lỗi: " . $sql_insert_fav . "<br>" . $conn->error;
            }
        }
    }
}

// Kiểm tra xem sản phẩm có trong danh sách yêu thích của người dùng hay không
$is_favorited = false;
if (isset($_SESSION['user_id'])) {
    $sql_check_fav = "SELECT * FROM user_favorites WHERE user_id = '$user_id' AND product_id = '$product_id'";
    $result_check_fav = $conn->query($sql_check_fav);
    if ($result_check_fav->num_rows > 0) {
        $is_favorited = true;
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Thông tin sản phẩm</title>
    <link rel="stylesheet" href="/BTL/css/index.css" />
    <link rel="stylesheet" href="/BTL/css/product_detail.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    .toggle-favorite {
        width: 50px !important;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 24px;
    }

    .toggle-favorite i {
        transition: color 0.3s ease;
    }

    .toggle-favorite i:hover {
        color: #ff6666;
        /* Màu khi hover */
    }

    .icon {
        font-size: 20px
    }
    </style>

<body>
    <?php
    ?>

    <?php
    if (isset($_POST['add-to-cart'])) {
        if (!isset($_SESSION['user_id'])) {
            echo '<script>alert("Vui lòng đăng nhập")</script>';
        } else {
            //Lấy card id
            $sql_cart = "SELECT cart_id FROM cart WHERE user_id = '$user_id'";
            $result_cart = $conn->query($sql_cart);
            if ($result_cart->num_rows > 0) {
                while ($row_cart = $result_cart->fetch_assoc()) {
                    $cart_id = $row_cart["cart_id"];
                }
            }
            $product_id = $_GET['id'];
            $stock = $_POST['count'];

            //Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
            $sql_check = "SELECT stock FROM cart_product WHERE cart_id = '$cart_id' AND product_id = '$product_id'";
            $result_check = $conn->query($sql_check);

            if ($result_check->num_rows > 0) {
                // Sản phẩm đã tồn tại, cập nhật số lượng
                $row_check = $result_check->fetch_assoc();
                $new_stock = $row_check['stock'] + $stock; // Cộng dồn số lượng
                $sql_update = "UPDATE cart_product SET stock = '$new_stock' WHERE cart_id = '$cart_id' AND product_id = '$product_id'";

                if ($conn->query($sql_update) === TRUE) {
                    echo "
                <script>
                    alert('Sản phẩm đã được cập nhật số lượng trong giỏ hàng thành công!');
                </script>
                ";
                } else {
                    echo "Lỗi: " . $sql_update . "<br>" . $conn->error;
                }
            } else {
                // Sản phẩm chưa tồn tại, thêm mới vào giỏ hàng
                $sql_insert = "INSERT INTO cart_product (cart_id, product_id, stock) VALUES ('$cart_id', '$product_id', '$stock')";

                if ($conn->query($sql_insert) === TRUE) {
                    echo "
                <script>
                    alert('Sản phẩm mới đã được thêm vào giỏ hàng thành công!');
                </script>
                ";
                } else {
                    echo "Lỗi: " . $sql_insert . "<br>" . $conn->error;
                }
            }
        }

    }
    ?>

    <!-- product -->
    <h1 style="text-align:center; margin: 25px">Thông Tin Sản phẩm</h1>
    <div class="content">
        <form action="" method="POST">
            <div class="product_detail">
                <?php
                $sql = 'SELECT * FROM Product WHERE product_id = "' . $product_id . '"';
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo '
                        <div class="product_image">
                            <img src="/BTL/src/assets/uploads/product/' . $row['image'] . '" alt="">
                        </div>
                        <div class="product_info">
                        <h1>' . $row['product_name'] . '</h1>
                        <p style ="color: red; font-weight: bold; font-size: 24px">' . number_format($row['price'], 0, ',', '.') . ' VNĐ</p>
                        <h2>Mô tả sản phẩm</h2>';
                    echo nl2br($row['description']);
                    echo '<h2>Tình trạng: ' . ($row['status'] == 0 ? "dừng bán" : "đang bán") . '</h2>';
                    echo '<div class="count">
                        <button type="button"  onclick="des()">-</button>
                        <input type="number" value="1" name="count" id="count">
                        <button type="button"  onclick="inc()">+</button></div>';
                    echo '<div class = "buy_btn">';
                    echo '<button method = "submit" class="add-to-cart" name ="add-to-cart"><i class="fa-solid fa-cart-shopping"></i> Thêm vào giỏ hàng</button>';
                    echo '<button class="buy-now"><i class="fa-solid fa-credit-card"></i> Mua ngay</button>';
                    ?>
                <button type="submit" class="toggle-favorite" name="toggle-favorite">
                    <i class="fa-solid fa-heart icon" style="color: <?= $is_favorited ? 'red' : 'black' ?>;"></i>
                </button>

                <?php
                    echo ' </div>
    </div>';
                }
                ?>
            </div>
        </form>

    </div>


    <script src="https://kit.fontawesome.com/0236bf0649.js" crossorigin="anonymous"></script>
</body>

</html>

<script>
function inc() {
    var count = document.getElementById('count');
    count.value = parseInt(count.value) + 1;
}

function des() {
    var count = document.getElementById('count');
    if (count.value > 1) {
        count.value = parseInt(count.value) - 1;
    }
}

document.querySelector('.toggle-favorite').addEventListener('click', function(event) {
    event.preventDefault();

    var productId = <?= $product_id ?>;
    var userId = <?= $user_id ?>;

    fetch('/toggle_favorite.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'product_id=' + productId + '&user_id=' + userId
        })
        .then(response => response.text())
        .then(data => {
            const icon = document.querySelector('.toggle-favorite i');
            if (icon.style.color === 'black') {
                icon.style.color = 'red';
            } else {
                icon.style.color = 'black';
            }
        })
        .catch(error => console.error('Lỗi:', error));
});
</script>