<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    .success-container {
        max-width: 600px;
        margin: 100px auto;
        text-align: center;
        padding: 30px;
        border-radius: 8px;
        background-color: white;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .success-icon {
        font-size: 50px;
        color: green;
    }

    .success-message {
        font-size: 24px;
        font-weight: bold;
        margin: 20px 0;
    }

    .action-buttons {
        margin-top: 30px;
    }

    .btn-custom {
        margin: 0 10px;
    }
    </style>
</head>

<body>

    <div class="success-container">
        <i class="fas fa-check-circle success-icon"></i>
        <div class="success-message">Đặt hàng thành công!</div>
        <p>Cảm ơn bạn đã mua sắm với chúng tôi.</p>
        <?php
            $id = $_GET['id'];
        ?>
        <div class="action-buttons">
            <a href="/BTL/index.php" class="btn btn-primary btn-custom">Quay lại trang chủ</a>
            <a href="/BTL/user/view_order_details.php?order_id=<?php echo $id ?>"
                class="btn btn-secondary btn-custom">Xem chi tiết hóa đơn</a>
        </div>
    </div>

</body>

</html>