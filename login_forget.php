<?php include_once('connectadmin/connectdb.php'); 


	if(isset($_POST['login_forget'])){
		
	$forget_SQL = "SELECT * FROM user WHERE user_ac = '$_POST[user_ac]'";
	$myData_forget = $myconnect->query($forget_SQL);
	$total_records_forget = $myData_forget->num_rows;	
	
      if($total_records_forget==0){
		header("Location:cpbl_all_ng_message.php?title=forget_ng&action=forget_ng&go=login_forget.php");
   }else{
		header("Location:forget_ok.php?user_ac=$_POST[user_ac]");
	}
}
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>黑之棒球後台系統-忘記密碼</title>


<?php include('link/non_css.php'); ?>
<link href="css/login_common.css" rel="stylesheet" type="text/css">

</head>

<body>


<div class="container_fluid">
	<header class="row">
	  <div class="col text-center">忘記密碼</div>
	  <div class="col-auto text-right goback"><a href="admin_login.php">返回</a></div>
	</header>
</div>



<div class="container_fluid">
   <main class="row">
      <div class="col text-center">

    <form action="login_forget.php" method="post">

	    帳號: <input type="text" name="user_ac" class="insert" required><br>

		<input type="submit" value="送出" class="insert">

		<input type="hidden" name="login_forget" value="login_forget">

	</form>

	   </div>
   </main>
</div>
</body>
</html>