<?php
session_start();
include "../../config/db.php";

$user_id = $_POST['user_id'];
$store_idx = $_POST['store_idx'];
$reser_ing = $_POST['reser_ing'];
$reser_day = $_POST['reser_day'];
$reser_name = $_POST['reser_name'];
$reser_number = $_POST['reser_number'];
$reser_memo = $_POST['reser_memo'];
$reser_pickup = $_POST['reser_pickup'];
$reser_place = $_POST['reser_place'];
$reser_wdate = date("Y-m-d H:i:s");

$sql = "INSERT INTO reser (user_id, store_idx, reser_ing, reser_day, reser_name, reser_number, reser_memo, reser_pickup, reser_place, reser_wdate)
                    VALUES ('".$user_id."', '".$store_idx."', '".$reser_ing."', '".$reser_day."', '".$reser_name."', '".$reser_number."', '".$reser_memo."', '".$reser_pickup."', '".$reser_place."', '".$reser_wdate."')";

// echo $sql;
mysqli_query($con, $sql);

?>

<script>
    alert("예약신청이 완료되었습니다.\n예약현황은 마이페이지를 확인해주세요.")
    location.href="../reser_list.html";
</script>