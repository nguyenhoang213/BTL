<?php
    include("../side_nav.php");
    $id = generateUniqueId(12);

    function generateUniqueId($length = 8) {
        return bin2hex(random_bytes($length / 2));
    }
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm tài khoản User</title>
    <link rel="stylesheet" href="/BTL/css/create.css">
</head>

<body>
    <div class="content">
        <h1>Thêm tài khoản User</h1>

        <form action="" method="post">
            <label for="user_id">ID tài khoản</label>
            <input type="text" name="user_id" required value="<?php echo $id ?>"> <br>

            <div class="col-md-4">
                <label for="validationDefault01" class="form-label">Họ</label>
                <input type="text" name="firstName" class="form-control" id="validationDefault01" value="" required />
            </div>
            <div class="col-md-4">
                <label for="validationDefault02" class="form-label">Tên đệm</label>
                <input type="text" name="lastName" class="form-control" id="validationDefault02" value="" required />
            </div>
            <div class="col-md-4">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" id="password" required />
            </div>
            <div class="col-md-5">
                <label for="validationDefault03" class="form-label">Số điện thoại</label>
                <input type="text" name="phone" class="form-control" id="validationDefault03" required />
            </div>
            <div class="col-md-7">
                <label for="validationDefault03" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="validationDefault03" required />
            </div>
            <div class="col-md-3">
                <label for="validationDefault04" class="form-label">Ngày</label>
                <select class="form-select" id="validationDefault04" name="day" required>
                    <option selected disabled value="Ngày"></option>
                    <?php
            for ($i = 1; $i <= 31; $i++) {
                echo "<option value='$i'>$i</option>";
            }
            ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="validationDefault04" class="form-label">Tháng</label>
                <select class="form-select" id="validationDefault04" name="month" required>
                    <option selected disabled value="Tháng"></option>
                    <?php
            for ($i = 1; $i <= 12; $i++) {
                echo "<option value='$i'>$i</option>";
            }
            ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="validationDefault04" class="form-label">Năm</label>
                <select class="form-select" id="validationDefault04" name="year" required>
                    <option selected disabled value="Nam"></option>
                    <?php
            $currentYear = date("Y");
            for ($i = $currentYear; $i >= 1900; $i--) {
                echo "<option value='$i'>$i</option>";
            }
            ?>

                </select>
            </div>
            <div class="col-md-3">
                <label for="validationDefault04" class="form-label">Giới tính</label>
                <select class="form-select" id="validationDefault04" name="gender" required>
                    <option selected disabled value="Nam"></option>
                    <option>Nam</option>
                    <option>Nữ</option>
                </select>
            </div>

            <input type="checkbox" id="show_password"> Hiển thị mật khẩu <br>

            <button name="submit">Xác nhận</button>
        </form>
    </div>

    <script>
    // Script hiện/ẩn mật khẩu
    const password = document.getElementById('password');
    // const confirmPassword = document.getElementById('confirm_password');
    const showPassword = document.getElementById('show_password');

    showPassword.addEventListener('change', function() {
        const type = this.checked ? 'text' : 'password';
        password.type = type;
        confirmPassword.type = type;
    });

    // Script kiểm tra mật khẩu xác nhận trước khi gửi form
    // const form = document.querySelector('form');
    // form.addEventListener('submit', function(e) {
    //     if (password.value !== confirmPassword.value) {
    //         e.preventDefault(); // Ngăn không cho gửi form
    //         alert('Mật khẩu và mật khẩu xác nhận không khớp!');
    //     }
    // });
    </script>
</body>

</html>

<?php
    include("../connection.php");

    // Xử lý khi form thêm tài khoản user được submit
    if (isset($_POST['submit'])) {
        $user_id = $_POST['user_id'];
        $firstName = $_POST["firstName"];
        $lastName= $_POST["lastName"];
        $gender = $_POST['gender'];
        $day = $_POST['day'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        $birth = "$year-$month-$day";
        $phone = $_POST['phone'];
        $email = $_POST['email'];

        $password_user = $_POST['password'];
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT); 

    $check_query = "SELECT * FROM `user` WHERE email = '$email' OR phone = '$phone'";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Email hoặc số điện thoại đã được đăng ký. Vui lòng chọn email hoặc số điện thoại khác.')</script>";
        echo "<script>window.location.href='<script>window.location.href='http://localhost/BTL/account/user_account_create.php';</script>";
        exit();
    } else {
        $result_query_user = mysqli_query($conn, "insert into user(user_id, first_name, last_name, gender, birth, phone, email) VALUES ('$user_id','$firstName','$lastName','$gender','$birth','$phone','$email')");
        if($result_query_user){
          $result_query_user_account = mysqli_query($conn, "insert into user_account(email,user_id, password, phone) VALUES ('$email','$user_id','$password_user','$phone')");
          if ($result_query_user_account) {
              echo "<script>alert('Tạo mới người dùng thành công !')</script>";
              echo "<script>window.location.href='http://localhost/BTL/account/user_account.php';</script>';</script>";  
          } else {
              echo "<script>alert('Đã xảy ra lỗi khi đăng ký!')</script>";
              echo "<script>window.location.href='http://localhost/BTL/account/user_account.php';</script>';</script>";
          }

        }else {
          echo "<script>alert('Đã xảy ra lỗi khi đăng ký tài khoản!')</script>";
        }
    }
}
    $conn->close();
?>