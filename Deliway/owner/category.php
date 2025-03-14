<?php
session_start();
include "../config/db.php"; 

$cate_userid = $_POST['cate_userid'];
$cate_name = $_POST['cate_name'];

$sql = "INSERT INTO menu_category (cate_name, cate_userid) values ('".$cate_name."', '".$cate_userid."')";
mysqli_query($con, $sql);
?>

<script>
    alert("카테고리를 등록하였습니다.");
    location.href="menu_category.html";
</script>