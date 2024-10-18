<?php
include("../connection.php");

if (isset($_POST['submit'])) {
    function generateUniqueId($length = 8)
    {
        return bin2hex(random_bytes($length / 2));
    }
    $user_id = generateUniqueId(12); // Tạo ID ngẫu nhiên có độ dài 12 ký tự
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $gender = $_POST['gender'];
    $day = $_POST['day'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $birth = "$year-$month-$day";
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $password_user = $_POST['password'];
    $hashed_password = password_hash($password_user, PASSWORD_DEFAULT);

    $check_query = "select * from `user` where email='$email'";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Email đã được đăng ký. Vui lòng chọn email khác.')</script>";
        echo "<script>window.location.href='<script>window.location.href='http://localhost/BTL/login/register.php';</script>";
        exit();
    } else {
        $result_query_user = mysqli_query($conn, "insert into user(user_id, first_name, last_name, gender, birth, phone, email) VALUES ('$user_id','$firstName','$lastName','$gender','$birth','$phone','$email')");
        if ($result_query_user) {
            $result_query_user_account = mysqli_query($conn, "insert into user_account(email,user_id, password, phone) VALUES ('$email','$user_id','$hashed_password','$phone')");
            if ($result_query_user_account) {
                echo "<script>alert('Tạo mới người dùng thành công !')</script>";
                echo "<script> window.location.href = 'http://localhost/BTL/login/login.php';</script>";
            } else {
                echo "<script>alert('Đã xảy ra lỗi khi đăng ký!')</script>";
                echo "<script>window.location.href='http://localhost/BTL/login/login.php';</script>'";
            }

        } else {
            echo "<script>alert('Đã xảy ra lỗi khi đăng ký tài khoản!')</script>";
        }
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
    <link rel="stylesheet" href="/BTL/css/index.css">
    <link rel="stylesheet" href="/BTL/css/footer.css">
    <title>Đăng ký</title>
    <style>
        .password {
            position: relative;
        }

        .password i {
            position: absolute;
            top: 45px;
            right: 15px;
            font-size: 13px;
                }
    </style>
</head>

<body>
    <?php
    include("../header.php")
        ?>
    <div class="form-register" style="
        width: 500px;
        border: 1px solid #333;
        border-radius: 15px;
        padding: 25px;
        background-color: #FFFFFF;
        margin: 40px 500px 50px 500px;
      ">
       
            <h1>Đăng ký</h1>
            <form class="row g-3" method="POST">
                <div class="col-md-4">
                    <label for="validationDefault01" class="form-label">Họ</label>
                    <input type="text" name="firstName" class="form-control" id="validationDefault01" value=""
                        required />
                </div>
                <div class="col-md-4">
                    <label for="validationDefault02" class="form-label">Tên đệm</label>
                    <input type="text" name="lastName" class="form-control" id="validationDefault02" value=""
                        required />
                </div>
                <div class="col-md-4 password">
                    <label for="validationDefault03" class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" id="validationDefault03" required />
                    <i onclick="showPassword();" class="fa-solid fa-eye-slash" id="toggleIcon"></i>
                </div>
                <div class="col-md-5">
                    <label for="validationDefault03" class="form-label">Số điện thoại</label>
                    <input type="text" pattern="[0-9]{10}" name="phone" class="form-control" id="validationDefault03" required />
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
                <div class="col-12">
                    <button style="margin-top: 10px;width: 100%;" class="btn btn-primary" name="submit"
                        type="submit">Đăng
                        ký</button>
                </div>
                <div class="col-12" style="text-align: center;">
                    <span style="margin-right: 20px;">Đã có tài khoản?</span>
                    <a href="./login.php">Đăng nhập</a>
                </div>
            </form>
    </div>
    <?php
    include("../footer.php")
        ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>

<script>
function showPassword() {
    var passwordInput = document.getElementById('validationDefault03');
    var toggleIcon = document.getElementById('toggleIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text'; // Hiển thị giá trị trong input
        toggleIcon.classList.remove('fa-eye-slash'); // Đổi icon thành con mắt mở
        toggleIcon.classList.add('fa-eye');
    } else {
        passwordInput.type = 'password'; // Ẩn giá trị trong input
        toggleIcon.classList.remove('fa-eye'); // Đổi icon thành con mắt đóng
        toggleIcon.classList.add('fa-eye-slash');
    }
}
</script>
</body>

</html>

<script src="https://kit.fontawesome.com/0236bf0649.js" crossorigin="anonymous"></script>
