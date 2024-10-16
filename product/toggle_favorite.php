<?php
include('../connection.php');


if (isset($_POST['product_id']) && isset($_POST['user_id'])) {
    $product_id = $_POST['product_id'];
    $user_id = $_POST['user_id'];

    $sql_check_fav = "SELECT * FROM user_favorites WHERE user_id = '$user_id' AND product_id = '$product_id'";
    $result_check_fav = $conn->query($sql_check_fav);

    if ($result_check_fav->num_rows > 0) {
        // Xóa khỏi yêu thích
        $sql_delete_fav = "DELETE FROM user_favorites WHERE user_id = '$user_id' AND product_id = '$product_id'";
        $conn->query($sql_delete_fav);
    } else {
        // Thêm vào yêu thích
        $sql_insert_fav = "INSERT INTO user_favorites (user_id, product_id) VALUES ('$user_id', '$product_id')";
        $conn->query($sql_insert_fav);
    }
}
?>