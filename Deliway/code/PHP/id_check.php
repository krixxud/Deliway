<?php
session_start();
include "../../config/db.php";

$user_id = $_POST['user_id'];

//아이디 중복체크
$id_check = "select * from member where user_id = '".$user_id."'";

$result_check = mysqli_query($con,$id_check);
$row_check = mysqli_num_rows($result_check);

if ($row_check >= 1) {
    echo "중복된 아이디입니다.";
} else {
    echo "가입 가능한 아이디입니다.";
}
?>