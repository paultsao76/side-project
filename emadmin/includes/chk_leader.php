<?php
//驗證是否登入及帳號權限
if($_SESSION['admin_GD']){
  if($_SESSION['admin_GD']!= 'leader'){
      die('<script>alert("你的帳號權限不足。");history.back();</script>');
      header("Location:admin_index.php");
  }
}else{
  die('<script>alert("你還未登入任何帳號,請先進行登入。");location.href="admin_login.php";</script>');
    header("Location:admin_login.php");
}
 ?>