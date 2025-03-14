<?php
session_start();
include "../config/db.php";

$store_idx = $_POST['store_idx'];
$store_ing = $_POST['store_ing'];
$user_id = $_POST['user_id'];

$sql = "UPDATE store SET store_ing = '".$store_ing."' where store_idx='".$store_idx."'";
mysqli_query($con, $sql);

if($store_ing == "승인") {
$sql1 = "UPDATE member SET user_type = 2 WHERE user_id = '".$user_id."'";
mysqli_query($con,$sql1);

}


?>

<script>
    alert("업체 승인이 완료되었습니다.");
    location.href="manager-store.html";
</script>