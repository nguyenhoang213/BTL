<?php
include("../connection.php");

if (isset($_SESSION['user_id'])) {
    echo "<script>
    alert('Không có quyền truy cập vào trang này. Bạn sẽ được chuyển tới trang chủ');
    window.location.href = 'http://localhost/BTL';
    </script>";
}
if (isset($_POST['login'])) {
    $admin_name = $_POST['admin_name'];
    $password = $_POST['password'];
    $select = mysqli_query(
        $conn,
        "select *
      from admin_account 
      where admin_name = '$admin_name'
      "
    );
    $row = mysqli_fetch_assoc($select);
    if (is_array($row)) {
        $_SESSION['admin_id'] = $row['admin_id'];
        $_SESSION['admin_name'] = $row['admin_name'];
        $_SESSION['role'] = $row['role'];
        if (isset($_SESSION['admin_name']) && $row['password'] == $password) {
            echo "<script>
          alert('Đăng nhập thành công');
          window.location.href = 'http://localhost/BTL/admin.php';
          </script>";
            exit();
        } else {
            echo "<script type='text/javascript'>alert('Sai thông tin')</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('Sai thông tin')</script>";

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" />
    <!-- <link rel="stylesheet" href="./css/form.css" /> -->
    <title>Đăng nhập</title>
</head>

<body style="
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #333;
    ">
    <div class="form-register" style="
        width: 500px;
        border: 1px solid #333;
        border-radius: 15px;
        padding: 25px;
        background-color: #eaeaea;
      ">
        <form class="row g-3" method="POST">
            <div class="col-md-12">
                <label for="validationDefault02" class="form-label">ID tài khoản</label>
                <input type="text" name="admin_name" class="form-control" id="validationDefault02" value="" required />
            </div>
            <div class="col-md-12">
                <label for="validationDefault03" class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" id="validationDefault03" required />
            </div>

            <div class="col-12">
                <button style="width: 100%; margin-top: 5px;" class="btn btn-primary" type="submit" name="login">Đăng
                    nhập</button>
            </div>
            <div class="col-12" style="text-align: center;">

            </div>
    </div>
    </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
</body>

</html>