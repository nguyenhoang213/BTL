<?php

require 'connection.php';

// Thêm sản phẩm vào giỏ hàng
if (isset($_POST['pid'])) {
	$pid = $_POST['pid'];
	$pname = $_POST['pname'];
	$pprice = $_POST['pprice'];
	$pimage = $_POST['pimage'];
	$pproductid = $_POST['pproductid'];
	$pstock = $_POST['pstock'];
	$total_price = $pprice * $pstock;

	$stmt = $conn->prepare('SELECT product_id FROM cart WHERE product_id=?');
	$stmt->bind_param('s', $pproductid);
	$stmt->execute();
	$res = $stmt->get_result();
	$r = $res->fetch_assoc();
	$productid = $r['product_id'] ?? '';

	if (!$productid) {
		$query = $conn->prepare('INSERT INTO cart (product_name,price,image,total_price,product_id) VALUES (?,?,?,?,?)');
		$query->bind_param('ssssss', $pname, $pprice, $pimage, $pstock, $total_price, $pproductid);
		$query->execute();

		echo '<div class="alert alert-success alert-dismissible mt-2">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Đã thêm sản phẩm vào giỏ hàng</strong>
						</div>';
	} else {
		echo '<div class="alert alert-danger alert-dismissible mt-2">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Sản phẩm này đã có trong giỏ hàng</strong>
						</div>';
	}
}

// Thêm sản phẩm có sẵn vào giỏ hàng
if (isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item') {
	$stmt = $conn->prepare('SELECT * FROM cart');
	$stmt->execute();
	$stmt->store_result();
	$rows = $stmt->num_rows;

	echo $rows;
}

// Xóa 1 sản phẩm khỏi giỏ hàng
if (isset($_GET['remove'])) {
	$id = $_GET['remove'];

	$stmt = $conn->prepare('DELETE FROM cart WHERE id=?');
	$stmt->bind_param('i', $id);
	$stmt->execute();

	$_SESSION['showAlert'] = 'block';
	$_SESSION['message'] = 'Sản phẩm đã bị xóa khỏi giỏ hàng!';
	header('location:cart.php');
}

// Xóa tất cả sản phẩm khỏi giỏ hàng
if (isset($_GET['clear'])) {
	$stmt = $conn->prepare('DELETE FROM cart');
	$stmt->execute();
	$_SESSION['showAlert'] = 'block';
	$_SESSION['message'] = 'Tất cả sản phẩm đã bị xóa!';
	header('location:cart.php');
}

// Tổng tiền của sản phẩm trong giỏ hàng
if (isset($_POST['stock'])) {
	$stock = $_POST['stock'];
	$pid = $_POST['pid'];
	$pprice = $_POST['pprice'];

	$tprice = $stock * $pprice;

	$stmt = $conn->prepare('UPDATE cart SET stock=?, total_price=? WHERE id=?');
	$stmt->bind_param('isi', $stock, $tprice, $pid);
	$stmt->execute();
}

// Thanh toán và lưu thông tin khách hàng
if (isset($_POST['action']) && isset($_POST['action']) == 'order') {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$products = $_POST['products'];
	$grand_total = $_POST['grand_total'];
	$address = $_POST['address'];
	$pmode = $_POST['pmode'];

	$data = '';

	$stmt = $conn->prepare('INSERT INTO orders (name,email,phone,address,pmode,products,amount_paid)VALUES(?,?,?,?,?,?,?)');
	$stmt->bind_param('sssssss', $name, $email, $phone, $address, $pmode, $products, $grand_total);
	$stmt->execute();
	$stmt2 = $conn->prepare('DELETE FROM cart');
	$stmt2->execute();
	$data .= '<div class="text-center">
			<h1 class="display-4 mt-2 text-danger">Cảm ơn!</h1>
			<h2 class="text-success">Your Order Placed Successfully!</h2>
			<h4 class="bg-danger text-light rounded p-2">Sản phẩm đã mua: ' . $products . '</h4>
			<h4>Tên của bạn: ' . $name . '</h4>
			<h4>Your E-mail : ' . $email . '</h4>
			<h4>Your Phone : ' . $phone . '</h4>
			<h4>Total Amount Paid : ' . number_format($grand_total, 2) . '</h4>
			<h4>Payment Mode : ' . $pmode . '</h4>
		</div>';
	echo $data;
}
?>
<script src="https://kit.fontawesome.com/0236bf0649.js" crossorigin="anonymous"></script>