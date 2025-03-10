<?php
session_start();
include "../../config/db.php";

$user_post = $_POST['user_post'];
$user_addr = $_POST['user_addr'];
$user_addr1 = $_POST['user_addr1'];

$sql = "update member set user_post = '".$user_post."', user_addr = '".$user_addr."', user_addr1 = '".$user_addr1."'
where user_id = '".$_COOKIE['user_id']."'";

mysqli_query($con,$sql);
?>

<script>
    alert("프로필을 수정하였습니다.");
    location.href="../mypage_info.html";
</script>