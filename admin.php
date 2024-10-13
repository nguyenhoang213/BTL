<?php
    session_start();
    include("./connection.php");
    if(!isset($_SESSION['role'])) {
        echo "<script>
            alert('Không có quyền truy cập vào trang này. Bạn sẽ được chuyển tới trang chủ');
            window.location.href = 'http://localhost/BTL';
            </script>";
    }
    include("side_nav.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/side_nav.css">

    <title>Quản trị viên</title>
</head>

<body>

</body>

</html>