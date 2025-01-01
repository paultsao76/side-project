<?
include_once('../application.php');

$emlogin  = $CFG->wwwroot."/admin_index.php";//後台登入頁
$em_index = $CFG->wwwroot."/emadmin/index.php";//後台首頁



$name     = $_POST['name'];//帳號
$password = $_POST['password'];//密碼

//檢查是否輸入資料
if ($name=='') {
	die('<script>alert("The 「account」 column is required.");history.back();</script>');
	header("Location:".$emlogin);
}
if ($password=='') {
	die('<script>alert("The 「password」 column is required.");history.back();</script>');
	header("Location:".$emlogin);
}

//驗證輸入帳密是否正確
$tb  = "admin_list";
$op  = "count(*)";
$act = "name = '".$name."' AND password = '".$password."' AND is_del = '0'";
$count = $db->getOne("SELECT $op FROM $tb WHERE $act");//找到的使用者數量

if($count == 0){//沒找到
	$msg  = "The phone number or password you entered is doesn't exist.";
	die("<script>alert(\"".$msg."\");history.back();</script>");	
	header("Location:".$emlogin);	
}else{//找到了, 先拉出資料
	$tb  = "admin_list";
	$op  = "*";
	$act = "name = '".$name."' AND password = '".$password."' AND is_del = '0'";
	$admin_data = $db->getRow("SELECT $op FROM $tb WHERE $act");
	//宣告SESSION變數
	$_SESSION['admin'] = $admin_data;
	header("Location:".$em_index);			
}

?>