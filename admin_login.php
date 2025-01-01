<?php 

include_once('application.php');

$title = $CFG->title."管理者登入";

//使用者submit後處理
if(isset($_POST['admin_login'])){
					
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$title?></title>
<?php include('includes/non_css.php'); ?>
<link href="css/login_common.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="container_fluid">
		<header class="row">
		  <div class="col text-center"><?=$title?></div>
		</header>
	</div>
	<div class="container_fluid">
	   <main class="row">
	      <div class="col text-center">
	      	<form action="./Php/login_action.php" method="post">

			    帳號: <input type="text" name="name" class="insert" size="12"><br>

				密碼: <input type="password" name="password" class="insert" size="12"><br>

				<input type="submit" value="送出" class="insert">

			</form>
		   </div>
	   </main>
	</div>
</body>
</html>
