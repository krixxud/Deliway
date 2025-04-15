<?php
session_start();
include "../../config/db.php";

$user_phone = $_POST['user_phone'];

// 전화번호 중복 체크
$phone_check = "SELECT * FROM member WHERE user_phone='".$user_phone."'";
$result_check = mysqli_query($con,$phone_check);
$row_check = mysqli_num_rows($result_check);

if ($row_check >= 1) {
    echo htmlspecialchars("중복된 전화번호입니다.");
} else {
    echo htmlspecialchars("사용 가능한 전화번호입니다.");
}
?>