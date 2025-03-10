<?php
session_start();
include "../../config/db.php";

$user_id = $_POST['user_id'];
$user_name = $_POST['user_name'];
$user_addr = $_POST['user_addr'];
$user_wdate = date("Y-m-d H:i:s");

// 회원가입 sql 실행
$sql = "UPDATE member set user_name = '".$user_name."', user_addr = '".$user_addr."', user_wdate = '".$user_wdate."' where user_id='".$user_id."'";
$result = mysqli_query($con,$sql);

?>

<script>
    alert ('회원가입이 완료되었습니다');
    location.href="../login_confirm.html?user_id=<?php echo $user_id; ?>";
</script>