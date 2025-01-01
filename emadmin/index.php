<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../application.php');
include_once('includes/chk_login.php');//驗證是否登入
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$CFG->em_title?></title>
<?php include('../includes/non_css.php'); ?>
<link href="<?=$CFG->wwwroot?>/css/admin.css" rel="stylesheet" type="text/css">
<link href="<?=$CFG->wwwroot?>/css/admin_select.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container-fluid">
    <!-- 上選單 -->	
	<?php include('./includes/em_headerlink.php'); ?>  
	<div class="row">	
		<!-- 左選單 -->
		<nav class="col-2 leftnav">		
		    <?php include('./includes/em_leftnavlink.php'); ?>
		</nav>   
	</div>
</div>
</body>
</html>