<?php
//驗證是否登入及帳號權限 
if( !isset($_SESSION['admin']['id']) ){
  die("<script>alert('You login any admin account yet. Login first.');location.href='".$CFG->wwwroot."/admin_login.php';</script>");
    // header("Location:".$CFG->wwwroot."/admin_login.php");
 }
 ?>