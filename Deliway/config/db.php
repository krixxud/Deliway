<?php

$db_host = "localhost";
$db_user = "nanunna18";
$db_password = "oka1838!";
$db_name = "nanunna18";

$con = new mysqli($db_host, $db_user, $db_password, $db_name); //database 접속구문

// 접속이 안되었을 때 오류 메시지 출력
if ($con -> connect_error) {die('Connection Error: '.$con ->connect_error);}

?>