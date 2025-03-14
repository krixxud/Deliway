<?php
session_start();
include "../config/db.php";

$user_id = $_POST['user_id'];
$user_name = $_POST['user_name'];
$user_phone = $_POST['user_phone'];


$sql = "select * from member where user_name='".$user_name."' and user_phone='".$user_phone."' and user_id='".$user_id."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$row_num = mysqli_num_rows($result);

if ($row_num == 0) {
    echo "<script> alert('등록된 계정이 없습니다.');history.back();</script>";
} else {
    echo "<script> alert('새로운 비밀번호로 변경해주세요.');location.href='reset_pass.html?user_id=".$row['user_id']."';</script>";
}