<?php 
include_once('../application.php');
include_once('../functions/chk_login.php');//驗證是否登入及帳號權限 

//登出執行
unset($_SESSION['admin']);
header("Location:".$CFG->wwwroot."/admin_login.php");
?>