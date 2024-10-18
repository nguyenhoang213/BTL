<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="/BTL/css/index.css" />
    <link rel="stylesheet" href="/BTL/css/footer.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #343a40;
        }

        .container {
            margin-top: 50px;
        }

        h4 {
            font-size: 24px;
            color: #007bff;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .table-responsive {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
            padding: 20px;
            border-radius: 10px;
        }

        /* Table Styles */
        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        thead th {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 12px;
            font-size: 18px;
        }

        tbody td {
            padding: 15px;
            vertical-align: middle;
            font-size: 16px;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
            /* Màu nền xen kẽ */
        }

        /* Styling for Image */
        table img {
            border-radius: 5px;
            object-fit: cover;
            width: 50px;
            height: 50px;
        }

        /* Button Styles */
        .btn {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
            color: white;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Styling for Quantity Controls */
        .count {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .count button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            border-radius: 5px;
        }

        .count button:hover {
            background-color: #0056b3;
        }

        .count input {
            width: 50px;
            height: 40px;
            text-align: center;
            border: 1px solid #ddd;
            margin: 0 10px;
            border-radius: 5px;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
</head>

<body>
    <?php
    include("../connection.php");
    include("../header.php");
    if (!isset($_SESSION["user_id"])) {
        echo "
                <script>
                    window.location.href = '../login/login.php';
                </script>
                ";
    }
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="table-responsive mt-2">
                    <form action="./checkout.php">
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <td colspan="7">
                                        <h4 class="text-center text-info m-0">Giỏ hàng của bạn</h4>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Số thứ tự</th>
                                    <th>Hình ảnh</th>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Kho</th>
                                    <th>Tổng</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //get cart id
                                $sql_cart = "SELECT cart_id FROM cart WHERE user_id = '$user_id'";
                                $result_cart = $conn->query($sql_cart);
                                if ($result_cart->num_rows > 0) {
                                    while ($row_cart = $result_cart->fetch_assoc()) {
                                        $cart_id = $row_cart["cart_id"];
                                        $_SESSION['cart_id'] = $cart_id;
                                    }
                                }

                                $sql = "SELECT p.product_id,cp.stock, p.product_name, p.price, p.image, p.stock as remain FROM cart_product cp
                            JOIN Product p ON cp.product_id = p.product_id
                            WHERE cp.cart_id = '$cart_id'";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    $count = 1; // Đếm số thứ tự
                                    while ($row = $result->fetch_assoc()) {
                                        $total = $row['price'] * $row['stock']; // Tính tổng
                                        echo '<tr>
                                            <form method= "POST">
                                            <td>' . $count . '</td>
                                            <td><img src="/BTL/src/assets/uploads/product/' . $row['image'] . '" alt="" style="width: 50px; height: 50px;"></td>
                                            <td>' . $row['product_name'] . '</td>
                                            <td>' . number_format($row['price'], 0, ',', '.') . ' VNĐ</td>';
                                        ?>
                                        <td>
                                            <div class="count">
                                                <button type="button"
                                                    onclick="des('<?php echo $row['product_id']; ?>', <?php echo $row['price']; ?>)">-</button>
                                                <input type="number" value="<?php echo $row['stock']; ?>" name="count"
                                                    id="quantity-<?php echo $row['product_id']; ?>" style="width: 40px"
                                                    onchange="updatePrice('<?php echo $row['product_id']; ?>', <?php echo $row['price']; ?>)"
                                                    readonly>
                                                <button type="button"
                                                    onclick="inc('<?php echo $row['product_id']; ?>', <?php echo $row['price']; ?>)">+</button>
                                            </div>
                                        </td>
                                        <?php
                                        echo '<td>' . $row['remain'] . ' </td>';
                                        ?>
                                        <input type="hidden" name="remain" value="<?php echo $row['remain']; ?>"
                                            id="remain-<?php echo $row['product_id']; ?>">


                                        <td id="total-<?php echo $row['product_id']; ?>">
                                            <?php echo number_format($total, 0, ',', '.') . ' VNĐ'; ?>
                                        </td>
                                        <?php
                                        echo '
                                        
                                    <td><a href="remove_from_cart.php?id=' . $row['product_id'] . '" class="btn btn-danger">Xóa</a></td>
                                    </tr>
                                    </from>';
                                        $count++;
                                    }
                                } else {
                                    echo '<tr>
                                        <td colspan="7">Giỏ hàng trống</td>
                                    </tr>';
                                }
                                ?>
                                <tr>
                                    <td colspan="5" style="text-align:left">

                                    </td>
                                    <td colspan="2"><button class="btn btn-danger">Thanh toán</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    include("../footer.php")
        ?>
    <script src="https://kit.fontawesome.com/0236bf0649.js" crossorigin="anonymous"></script>
    <script src='https://cdnjs.cloudflare.com/connection/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/connection/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>
</body>

</html>

<script>
    function updateQuantity(product_id) {
        var quantity = document.getElementById("count_" + product_id).value;

        // Gửi AJAX đến server để cập nhật số lượng
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_quantity.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText); // Hiển thị phản hồi từ server
            }
        };
        xhr.send("product_id=" + product_id + "&quantity=" + quantity);

    }

    function inc(productId, pricePerUnit) {
        var count = document.getElementById('quantity-' + productId);
        var remain = document.getElementById('remain-' + productId).value; // Lấy giá trị tồn kho từ input hidden

        if (parseInt(count.value) < parseInt(remain)) {
            count.value = parseInt(count.value) + 1;
            updatePrice(productId, pricePerUnit);
        } else {
            alert("Số lượng đã đạt tối đa tồn kho!"); // Thông báo khi số lượng vượt quá kho
        }
    }

    function des(productId, pricePerUnit) {
        var count = document.getElementById('quantity-' + productId);
        if (count.value > 1) {
            count.value = parseInt(count.value) - 1;
            updatePrice(productId, pricePerUnit);
        }
    }

    function updatePrice(productId, pricePerUnit) {
        var quantity = document.getElementById('quantity-' + productId).value;
        var total = pricePerUnit * quantity;

        // Cập nhật tổng tiền cho sản phẩm
        document.getElementById('total-' + productId).innerHTML = total.toLocaleString('vi-VN', {
            style: 'currency',
            currency: 'VND'
        });

        // Gửi yêu cầu AJAX để cập nhật số lượng trên server
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_quantity.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText);
            }
        };
        xhr.send("product_id=" + productId + "&quantity=" + quantity);
    }
</script>