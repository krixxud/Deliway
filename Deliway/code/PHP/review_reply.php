<?php
session_start();
include "../../config/db.php";

$user_idx = $_POST['user_idx'];
$review_idx = $_POST['review_idx'];
$reply_num = $_POST['reply_num'];
$reply_memo = $_POST['reply_memo'];
$reply_wdate = date("Y-m-d H:i:s");

$sql = "INSERT INTO reply (user_idx, review_idx, reply_num, reply_memo, reply_wdate)
                     VALUES ('".$user_idx."','".$review_idx."','".$reply_num."','".$reply_memo."','".$reply_wdate."')";

                    // echo $sql;
                     mysqli_query($con, $sql);

?>

<script>
    alert("댓글을 등록하였습니다")
    location.href="../review_detail.html?review_idx=<?php echo $review_idx;?>";
</script>
