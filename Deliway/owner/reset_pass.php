<?php
session_start();
include "../config/db.php";
include "../code/PHP/password.php";

$user_id = $_POST['user_id'];
$user_pass = $_POST['user_pass'];
$user_pass1 = $_POST['user_pass1'];

if ($user_pass != $user_pass1) {
    echo "<script> alert('비밀번호가 일치하지 않습니다.');history.back();</script>";
}  else {
    $user_pass = password_hash($user_pass,PASSWORD_DEFAULT);
    $sql = "UPDATE member SET user_pass = '".$user_pass."' where user_id='".$user_id."'";
    mysqli_query($con, $sql);

    echo "<script> alert('비밀번호를 변경하였습니다.');location.href='index.html';</script>";
}
?>