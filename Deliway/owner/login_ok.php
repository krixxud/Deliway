<?php
session_start();
include "../config/db.php";
include "../code/PHP/password.php";

$user_id = $_POST['user_id'];
$user_pass = $_POST['user_pass'];
$auto_login = $_POST['auto_login'];
$user_login = date("Y-m-d H:i:s");

$sql = "select * from member where user_id = '".$user_id."' and user_type = 2" ;
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);

$hash_pass = $row['user_pass'];

if(password_verify($user_pass, $hash_pass)){

        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_name'] = $row['user_name'];

        $sql1 = "update member set user_login ='".$user_login."' where user_id = '".$user_id."'";

        echo "<script>alert('로그인이 완료되었습니다.'); location.href='owner-dashboard.html'</script>";
}else{
    echo "<script>alert('아이디 또는 비밀번호가 틀렸습니다'); history.back();</script>";
}


?>