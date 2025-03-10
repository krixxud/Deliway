<?php
session_start();

include "../config/db.php";

$adm_id = $_POST['adm_id'];

$adm_pass = $_POST['adm_pass'];

// 1. 전송방식으로 데이터 전달
// 2. DB 연동
// 3. select value 값을 sql로 불러서 값을 비교
// 4. 비교값이 맞으면 로그인 틀리면 back

$sql = "select * from admin where adm_id= '".$adm_id."'";
echo $sql;
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result);

if ($adm_pass == $row['adm_pass']){
    // 세션부여
    $_SESSION['adm_id'] = $row['adm_id'];
    $_SESSION['adm_name'] = $row['adm_name'];
    
    // echo $row['adm_name'];
    echo "<script> alert('로그인에 성공하였습니다!'); location.href='manager-dashboard.html';</script>";
    // 세션: 서버에서 일정하게 부여 아무런 동작을 안했을 때 기본 20분 후 강제 종료 (관리자 페이지에 사용)
    // 쿠키: 설정에 따라 계속 유지 (사용자 페이지에 사용)
} else {
    echo "<script> alert('아이디 혹은 비밀번호를 확인하세요');history.back();</script>";
}

?>