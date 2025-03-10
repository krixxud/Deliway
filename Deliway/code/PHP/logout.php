<?php
session_start();

setcookie('user_id','',time()-3600,'/');
setcookie('user_name','',time()-3600,'/');
setcookie('user_ing','',time()-3600,'/');

?>

<script>
    alert('로그아웃 하였습니다.');
    location.href = "../login.html"
</script>