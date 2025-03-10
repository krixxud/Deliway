<?php
session_start();
// 세션 종료
session_destroy();
?>
<script>
    alert('로그아웃 하였습니다');
    location.href="/admin";
</script>
