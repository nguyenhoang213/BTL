<?php
include("../connection.php");
if (isset($_SESSION["user_id"])) {
    echo "<script>window.location.href='http://localhost/BTL/';</script>";
}
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    // $phone = $_POST['phone'];
    $password = $_POST['password'];
    $select = mysqli_query(
        $conn,
        "select * 
                from user_account 
                where email = '$email'
                "
    );
    $row = mysqli_fetch_assoc($select);
    if ($row) {
        // Giải mã mật khẩu (compare)
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            echo "<script>alert('Đăng nhập thành công')</script>";
            //truy vết
            $user_id = $row['user_id'];
            //Lấy IP
            $ip = get_client_ip();
            //Lấy thời gian truy cập 
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $time = date('Y-m-d H:i:s');
            //Lấy tên thiết bị 
            $device = getDeviceType();
            // Insert thông tin truy vết
            $insert_login_history = "insert into user_login_history(user_id, time, ip, device) values ('$user_id', '$time','$ip','$device')";
            $insert_login_history_query = mysqli_query($conn, $insert_login_history);
            echo "<script> window.location.href = 'http://localhost/BTL';</script>";

            exit();
        } else {
            echo "<script type='text/javascript'>alert('Sai mật khẩu hoặc email')</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('Sai mật khẩu hoặc email')</script>";
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/BTL/css/login.css">
    <link rel="stylesheet" href="/BTL/css/index.css">
    <link rel="stylesheet" href="/BTL/css/footer.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" />
    <title>Đăng nhập</title>
    <style>
        .btn-number {
            margin: 10px;
        }
         

        .password {
            position: relative;
        }

        .password i {
            position: absolute;
            top: 43px;
            right: 20px;
        }
    </style>
</head>

<body>
    <?php
    include("../header.php")
        ?>
    <div class="form-login">
        <div class="form-register">
            <form class="row g-3" method="POST">
                <h1>Đăng nhập</h1>
                <div class="col-md-12">
                    <label for="validationDefault02" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="validationDefault02" value="" required />
                </div>
                <div class="col-md-12 password">
                    <label for="validationDefault03" class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" id="validationDefault03" required />
                    <i onclick="showPassword();" class="fa-solid fa-eye-slash" id="toggleIcon"></i>
                </div>
                <div class="col-12">
                    <button style="width: 100%; margin-top: 5px;" class="btn btn-primary" type="submit"
                        name="login">Đăng nhập</button>
                </div>
                <div class="col-12" style="text-align: center;">
                    <span style="margin-right: 20px;">Chưa có tài khoản?</span>
                    <a style="margin-right: 10px;" href="./register.php">Đăng ký</a>
                    <a href="#" id="forgot-password-link">Quên mật khẩu</a>
                </div>
            </form>
        </div>

        <!-- Modal for Forgot Password -->
        <div id="forgot-password-modal" class="modal">
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <form method="post" action="sendLink.php">
                    <p>Nhập email bạn muốn khôi phục mật khẩu</p>
                    <input type="email" name="email" class="form-control mb-3" required>
                    <input type="submit" class="btn btn-primary" name="submit_email" value="Gửi link khôi phục">
                </form>
            </div>
        </div>

        <script>
            // Open modal on link click
            var modal = document.getElementById("forgot-password-modal");
            var link = document.getElementById("forgot-password-link");
            var closeBtn = document.getElementsByClassName("close-btn")[0];

            link.onclick = function (event) {
                event.preventDefault();
                modal.style.display = "flex";
            }

            // Close modal on 'x' click
            closeBtn.onclick = function () {
                modal.style.display = "none";
            }

            // Close modal if user clicks outside of the modal content
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>

        <script>
            // show password
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
    </div>
    <?php
    include("../footer.php")
        ?>
</body>

</html>

<?php
function get_client_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
?>
<!-- Hàm Check thiết bị -->
<?php
// Hàm kiểm tra thiết bị và hệ điều hành dựa vào User-Agent
function getDeviceType()
{
    $userAgent = strtolower($_SERVER["HTTP_USER_AGENT"]);

    // Kiểm tra Mobile
    $isMob = is_numeric(strpos($userAgent, "mobile"));

    // Kiểm tra Tablet
    $isTab = is_numeric(strpos($userAgent, "tablet"));

    // Kiểm tra nền tảng
    // $isWin = is_numeric(strpos($userAgent, "windows"));
    // $isAndroid = is_numeric(strpos($userAgent, "android"));
    // $isIPhone = is_numeric(strpos($userAgent, "iphone"));
    // $isIPad = is_numeric(strpos($userAgent, "ipad"));
    // $isIOS = $isIPhone || $isIPad;

    $device = '';

    // Xác định thiết bị
    if ($isMob) {
        if ($isTab) {
            $device = 'Tablet';
        } else {
            $device = 'Mobile';
        }
    } else {
        $device = 'Desktop';
    }

    // Xác định hệ điều hành
    // if ($isIOS) {
    //     $os = 'iOS';
    // } elseif ($isAndroid) {
    //     $os = 'ANDROID';
    // } elseif ($isWin) {
    //     $os = 'WINDOWS';
    // } else {
    //     $os = 'UNKNOWN OS';
    // }

    // return [$device, $os];
    return $device;
}

?>