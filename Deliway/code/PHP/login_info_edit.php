<?php
session_start();
include "../../config/db.php";

$user_post = $_POST['user_post'];
$user_addr = $_POST['user_addr'];
$user_addr1 = $_POST['user_addr1'];

if (isset($_POST['user_phone'])) {
    $user_phone = $_POST['user_phone']; 

    $phone_check = "select * from member where user_phone='".$user_phone."'";
    $result_check = mysqli_query($con,$phone_check);
    $row_check = mysqli_num_rows($result_check);

    if ($row_check >= 1) {
        echo "<script> alert('이미 사용중인 번호입니다.');history.back();</script>";
        exit;
    } else {
       // SQL 쿼리 작성 : 전화번호 업데이트
       $sql = "update member set user_post = '".$user_post."', user_addr = '".$user_addr."', user_addr1 = '".$user_addr1."', user_phone = '".$user_phone."'
       where user_id = '".$_COOKIE['user_id']."'";

       if (mysqli_query($con,$sql)) {
        echo "<script> alert('전화번호가 변경되었습니다.');</script>";
       }
    }
} else {
    echo "<script> alert('전화번호를 입력해주세요.'); history.back();</script>";
}
?>

<script>
    alert("프로필을 수정하였습니다.");
    location.href="../mypage_info.html";
</script>