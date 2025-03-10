<?php
session_start();
include "../../config/db.php";

$user_id = $_POST['user_id'];
$user_phone = $_POST['user_phone'];
$user_pass = $_POST['user_pass'];
$user_pass1 = $_POST['user_pass1'];

// 이메일 중복 체크
$id_check = "select * from member where user_id='".$user_id."'";
$result_check = mysqli_query($con,$id_check);
$row_check = mysqli_num_rows($result_check);

if ($row_check >= 1) {
    echo "<script> alert('중복된 아이디입니다');history.back();</script>";
    exit;
}
   
// 비밀번호 확인
if ($user_pass != $user_pass1){
    echo "<script>alert('비밀번호가 다릅니다.');history.back();</script>";
    exit;
}
$secret_pass = password_hash($user_pass, PASSWORD_DEFAULT); //암호화처리

// 회원가입 sql 실행
$sql = "INSERT INTO member (user_id, user_pass, user_name, user_phone, user_type, user_wdate, user_ing, user_login) VALUES ('".$user_id."','".$secret_pass."','".$user_name."','".$user_phone."','1','".$user_wdate."','1','".$user_login."')";
$result = mysqli_query($con,$sql);
?>

<script>
    alert ('회원가입 다음단계로 진행하겠습니다');
    location.href="../login_info.html?user_id=<?php echo $user_id; ?>";
</script>