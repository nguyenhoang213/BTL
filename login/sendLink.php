<!-- 2.Tạo file PHP để gửi link -->

<?php
include("../connection.php");

include "../PHPMailer-master/src/DSNConfigurator.php";
include "../PHPMailer-master/src/PHPMailer.php";
include "../PHPMailer-master/src/Exception.php";
include "../PHPMailer-master/src/OAuthTokenProvider.php";
include "../PHPMailer-master/src/OAuth.php";
include "../PHPMailer-master/src/POP3.php";
include "../PHPMailer-master/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if (isset($_POST['submit_email']) && $_POST['email']) {
  function generateUniqueId($length = 8)
  {
    return bin2hex(random_bytes($length / 2));
  }
  $email = $_POST['email'];
  $new_password = generateUniqueId();
  $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

  $update_password = mysqli_query($conn, "
            update user_account 
            inner join user
            on user_account.user_id=user.user_id
            set user_account.password = '$hashed_new_password' 
            where user.email='$email'");
  if ($update_password) {
    $select = mysqli_query($conn, "
      select *
      from user 
      where email ='$email'");
    if (mysqli_num_rows($select) == 1) {
      while ($row = mysqli_fetch_array($select)) {
        $email_reset = $row['email'];
      }

      $mail = new PHPMailer();
      $mail->CharSet = "utf-8";
      $mail->SMTPDebug = 2; // Render thông tin mail truyền 
      $mail->SMTPDebug = 0;
      $mail->IsSMTP();
      $mail->SMTPAuth = true;
      $mail->Username = "longhq36@gmail.com";
      $mail->Password = "koxb fmda fnjp tnge"; // => App password
      $mail->SMTPSecure = "ssl";
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 465;
      $mail->From = "longhq36@gmail.com";
      $mail->FromName = "Hq Long";
      $mail->AddAddress($email_reset);
      $mail->Subject = 'Reset Password';
      $mail->IsHTML(true);
      $mail->Body = 'Mật khẩu của bạn là : ' . $new_password;
      if ($mail->Send()) {
        echo "<script>alert('Kiểm tra mail của bạn!')</script>";
        echo "<script>window.location.href='http://localhost/BTL/login/login.php';</script>";
      } else {
        echo "Mail Error - >" . $mail->ErrorInfo;
      }
    }
  } else {
    echo "Long1";

  }
}
?>