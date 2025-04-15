<?php
session_start();
include "../../config/db.php";

$user_name = $_POST['user_name'];

// 전화번호 중복 체크
$name_check = "SELECT * FROM member WHERE user_name='".$user_name."'";
$result_check = mysqli_query($con,$name_check);
$row_check = mysqli_num_rows($result_check);

if ($row_check >= 1) {
    echo ("중복된 닉네임입니다.");
} else {
    echo ("사용 가능한 닉네임입니다.");
}
?>