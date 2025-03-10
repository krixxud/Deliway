<?php
session_start();
include "../../config/db.php";
include "password.php";

$user_id = $_POST['user_id'];
$user_name = $_POST['user_name'];
$user_pass = $_POST['user_pass'];
$auto_login = $_POST['auto_login'];
$user_login = date("Y-m-d H:i:s"); //최근로그인기록

$sql = "SELECT * FROM member WHERE user_id = '$user_id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);

// 암호화된 비밀번호를 변수에 담기
$hash_pass = $row['user_pass'];

if (password_verify($user_pass,$hash_pass)) {
    
    if ($auto_login == 1) {
        setcookie("user_id", $row['user_id'], (time() + 3600 * 24 * 30000), "/" );
        setcookie("user_name", $row['user_name'], (time() + 3600 * 24 * 30000), "/" );
        setcookie("user_ing", $row['user_ing'], (time() + 3600 * 24 * 30000), "/" );
        
    } else {
        setcookie("user_id", $row['user_id'], time() + 3600, "/" );
        setcookie("user_name", $row['user_name'], time() + 3600, "/" );
        setcookie("user_ing", $row['user_ing'], time() + 3600, "/" );
    }
    $sql_login = "UPDATE member set user_login = '".$user_login."' where user_id = '".$user_id."'";
    $result = mysqli_query($con,$sql_login);
    echo "<script>alert('로그인되었습니다!'); location.href='../main.html';</script>";
    
} else {
    echo "<script>alert('아이디 혹은 비밀번호를 확인하세요.'); history.back();</script>";
    
}


?>