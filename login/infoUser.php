<?php

include("../connection.php");$email = $_SESSION['email'];
$select_info = "select * from user where email = '$email'";
$select_info_query = mysqli_query($connect, $select_info);
if (mysqli_num_rows($select_info_query) == 1) {
    while($row = mysqli_fetch_assoc($select_info_query)) {
        $id = $row['user_id'];
        $firstName = $row["first_name"];
        $lastName = $row["last_name"];
        $gender = $row["gender"];
        $date = $row["birth"];
        $phone = $row["phone"];
        $email = $row["email"];
        $address= $row["andress"];
    }
  } else {
    echo "0 results";
  }

  if(isset($_POST["update-info"])){
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $gender= $_POST["gender"];
    $address = $_POST["address"];
    $birth = $_POST["birth"];

    $update_user = "update user set first_name='$firstName', last_name='$lastName', email='$email', phone='$phone', gender='$gender', andress='$address', birth='$birth' where user_id='$id'";
    $update_user_query = mysqli_query($connect, $update_user);
    if($update_user_query){
        echo "<script>alert('Đổi thông tin thành công')</script>";
    }else {
        echo "<script>alert('Server bị lỗi!')</script>";
    }
  }

  if(isset($_POST['change-password'])){
    $email = $_SESSION['email'];
    $current_password = $_POST['current-password'];
    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-password'];
    if($new_password===$confirm_password){
        // $update_password = "UPDATE user_account SET password = '$password' WHERE email='$email'";
        if (mysqli_query($connect, 
            "update user_account 
            inner join user
            on user_account.user_id=user.user_id
            set user_account.password = '$confirm_password' 
            where email='$email'"
        )) {
            echo "<script>alert('Đổi mật khẩu thành công!')</script>";
        } else {
            echo "Error updating record: " . mysqli_error($connect);
        }
    }else {
        echo "<script>alert('Xác nhận lại mật khẩu!')</script>";
    }
    
}

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thông tin người dùng</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }

    .container {
        display: flex;
        width: 80%;
        margin: 50px auto;
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 20px;
    }

    /* Sidebar styling */
    .sidebar {
        width: 20%;
        background-color: #f7f7f7;
        padding: 20px;
        border-right: 1px solid #ddd;
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
    }

    .sidebar ul li {
        margin-bottom: 10px;
    }

    .sidebar ul li button {
        width: 100%;
        background-color: #007bff;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: left;
    }

    .sidebar ul li button:hover {
        background-color: #0056b3;
    }

    /* Main content styling */
    .main-content {
        width: 80%;
        padding-left: 20px;
    }

    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    .content {
        display: flex;
        gap: 100px;
    }

    .avatar {
        border: 1px solid #333;
        border-radius: 50%;
        width: 160px;
        height: 160px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .avatar img {
        width: 100px;
        object-fit: cover;
    }

    .info-group {
        margin-bottom: 15px;
        color: #555;
    }

    .info-group label {
        font-weight: bold;
        color: #333;
        display: inline-block;
        width: 120px;
    }

    .info-group span {
        font-style: italic;
    }

    .btn-group {
        text-align: center;
        margin-top: 20px;
    }

    .btn {
        padding: 10px 20px;
        margin: 0 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        color: #fff;
    }

    .btn-edit {
        background-color: #007bff;
    }

    .btn-edit:hover {
        background-color: #0069d9;
    }

    .btn-delete {
        background-color: #dc3545;
    }

    .btn-delete:hover {
        background-color: #c82333;
    }

    /* Modal styling */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fff;
        margin: 10px auto;
        padding: 20px;
        width: 40%;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .modal-content h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 1.5rem;
        color: #333;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .form-group input[type="text"],
    .form-group input[type="password"],
    .form-group input[type="radio"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .form-group input[type="radio"] {
        width: auto;
        margin-left: 10px;
    }

    .form-group label p {
        display: inline-block;
        margin-right: 10px;
    }

    .btn-update {
        width: 100%;
        background-color: #28a745;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
        border: none;
    }

    .btn-update:hover {
        background-color: #218838;
    }

    /* Password Change Form */
    .password-form {
        display: none;
    }

    .password-form h2 {
        text-align: center;
        font-size: 1.5rem;
        color: #333;
    }

    .password-form .form-group input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .password-form .btn-update {
        width: 100%;
        background-color: #28a745;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
        border: none;
    }

    .password-form .btn-update:hover {
        background-color: #218838;
    }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar with User Info and Change Password Options -->
        <div class="sidebar">
            <ul>
                <li><button onclick="showSection('user-info')">Thông tin người dùng</button></li>
                <li><button onclick="showSection('change-password')">Đổi mật khẩu</button></li>
            </ul>
        </div>
        <!-- Main content area -->
        <div class="main-content">
            <!-- User Information Section -->
            <div id="user-info">
                <h1>Thông tin người dùng</h1>
                <div class="content">
                    <div class="avatar">
                        <img src="./src/assets/images/save-money-2.png" alt="">
                    </div>
                    <div class="info-content">
                        <div class="info-group">
                            <label>Họ:</label>
                            <span><?php echo $firstName; ?></span>
                        </div>
                        <div class="info-group">
                            <label>Tên đệm:</label>
                            <span><?php echo $lastName; ?></span>
                        </div>
                        <div class="info-group">
                            <label>Ngày sinh:</label>
                            <span><?php echo $date; ?></span>
                        </div>
                        <div class="info-group">
                            <label>Giới tính:</label>
                            <span><?php echo $gender; ?></span>
                        </div>
                        <div class="info-group">
                            <label>Email:</label>
                            <span><?php echo $email; ?></span>
                        </div>
                        <div class="info-group">
                            <label>Số điện thoại:</label>
                            <span><?php echo $phone; ?></span>
                        </div>
                        <div class="info-group">
                            <label>Địa chỉ:</label>
                            <span><?php echo $address; ?></span>
                        </div>
                    </div>
                </div>

                <div class="btn-group">
                    <button class="btn btn-edit" onclick="openModal()">Sửa</button>
                </div>
            </div>
            <!-- Change Password Section -->
            <div id="change-password" class="password-form">
                <h2>Đổi mật khẩu</h2>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="current-password">Mật khẩu hiện tại:</label>
                        <input type="password" name="current-password" id="current-password">
                    </div>
                    <div class="form-group">
                        <label for="new-password">Mật khẩu mới:</label>
                        <input type="password" name="new-password" id="new-password">
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Xác nhận mật khẩu mới:</label>
                        <input type="password" name="confirm-password" id="confirm-password">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-update" name="change-password">Cập nhật mật khẩu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Form for Editing -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span style="cursor: pointer;" class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Sửa thông tin người dùng</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="firstName">Họ:</label>
                    <input type="text" name="firstName" id="firstName" value="<?php echo $firstName; ?>">
                </div>
                <div class="form-group">
                    <label for="lastName">Tên đệm:</label>
                    <input type="text" name="lastName" id="lastName" value="<?php echo $lastName; ?>">
                </div>
                <div class="form-group">
                    <label for="birth">Ngày sinh:</label>
                    <input type="text" name="birth" id="birth" value="<?php echo $date; ?>">
                </div>
                <div class="form-group">
                    <label for="gender">Giới tính:</label>
                    <label>
                        <p style="margin: 10px 15px 0px 0px;">Nam</p> <input type="radio" name="gender" value="Nam"
                            <?php if($gender=="Nam") echo 'checked' ?>>
                    </label>
                    <label>
                        <p style="margin: 0px 27px 0px 0px;">Nữ</p> <input type="radio" name="gender" value="Nữ"
                            <?php if($gender=="Nữ") echo 'checked' ?>>
                    </label>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" value="<?php echo $email; ?>">
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="text" name="phone" id="phone" value="<?php echo $phone; ?>">
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ:</label>
                    <input type="text" name="address" id="address" value="<?php echo $address; ?>">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn-update" name="update-info">Xác nhận thông tin sửa</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Open modal
    function openModal() {
        document.getElementById('editModal').style.display = 'block';
    }

    // Close modal
    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // Show different sections
    function showSection(sectionId) {
        const sections = ['user-info', 'change-password'];
        sections.forEach(id => {
            document.getElementById(id).style.display = (id === sectionId) ? 'block' : 'none';
        });
    }

    // Initialize by showing user info section
    showSection('user-info');
    </script>
</body>

</html>