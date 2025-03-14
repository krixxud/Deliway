<?php
session_start();
include "../config/db.php";

$user_name = $_POST['user_name'];
$user_phone = $_POST['user_phone'];

$sql = "select * from member where user_name='".$user_name."' and user_phone='".$user_phone."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$row_num = mysqli_num_rows($result);

if ($row_num == 0) {
    echo "<script> alert('등록된 계정이 없습니다.');history.back();</script>";
} else {
    echo "<script> alert('회원님의 아이디는 ".$row['user_id']." 입니다.');history.back();</script>";
}