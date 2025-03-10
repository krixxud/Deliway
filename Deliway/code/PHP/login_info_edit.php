<?php
session_start();
include "../../config/db.php";

$user_post = $_POST['user_post'];
$user_addr = $_POST['user_addr'];
$user_addr1 = $_POST['user_addr1'];

if (isset($_POST['user_phone'] )) { // 폼에서 전화번호를 제출했는지 확인 후 제출 되었으면
    $user_phone = $_POST['user_phone']; // $_POST['user_phone'] 로 값을 받음 , 변경된 전화번호가 담겨 있습니다.

    $phone_check = "select * from member where user_phone='".$user_phone."'"; // user_phone이 데이터베이스의 member 테이블에 이미 존재하는지 확인합니다.
    $result_check = mysqli_query($con,$phone_check);

    // 쿼리 실행 결과로 몇 개의 데이터가 반환되었는지 확인합니다. 결과가 1 이상이면, 이미 해당 전화번호가 존재하는 것입니다.
    $row_check = mysqli_num_rows($result_check);

    // 만약 $row_check가 1 이상이라면, 이미 해당 전화번호가 다른 사용자가 사용하고 있다
    if ($row_check >= 1) {
        echo "<script> alert('이미 사용중인 번호입니다.');history.back();</script>";
        exit;
    } else {
       // 쿠키에 저장된 user_id를 사용하여, 해당 사용자의 정보를 업데이트
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