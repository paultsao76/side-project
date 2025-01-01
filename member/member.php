<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../application.php');

$act = $_REQUEST['act'];
$CFG->$short_url = $CFG->wwwroot."/member/";
$CFG->tb = "member_list";

switch ($act) {
	case 'insert':
		member_insert($_REQUEST);//新增會員功能
		break;

	case 'update':
		member_update($_REQUEST);//會員資料修改功能
		break;

	case 'login':
		member_login($_REQUEST);//會員登入功能
		break;

	default:
		member_area();//會員登入OR會員資料畫面
		break;
}

/*會員登入OR會員資料畫面*/
function member_area(){
	global $CFG,$db;

	/*確認有無登入*/
	if (!$_SESSION['member']) {//沒登入去登入頁
		$area_title = "Member Login";
		$next_act   = "login";
		include_once('./templates/member_login.php');
	}else{//有登入去會員資料畫面
		$area_title = "Member Area";
		include_once('./templates/member_area.php');
	}	
}

/*新增會員功能*/
function member_insert($form){
	global $CFG, $db;

	$tb  = $CFG->tb;
/*新增變數定義 start*/
	$phone 	     = string_filter($form['phone']);
	chk_reuse($phone, $tb, "phone", "The 「phone」 is reuse, input another.");//確認電話是否重複
	$first_name  = string_filter($form['first_name']);//first name
	$last_name   = string_filter($form['last_name']);//last name
	$gender 	 = $form['gender'];//gender
	$password    = string_filter($form['password']);//password
	$email     	 = string_filter($form['email']);//email
	$creat_date	 = date("Y-m-d H:i:s");//creat date
/*新增變數定義 end*/
	$input = "`first_name`, `last_name`, `phone`, `gender`, `psd`, `email`, `creat_date`";//欄位定義
/*欄位值組裝 start*/
	$value  = "'".$first_name."',";
	$value .= "'".$last_name."',";
	$value .= "'".$phone."',";
	$value .= "'".$gender."',";
	$value .= "'".$password."',";
	$value .= "'".$email."',";
	$value .= "'".$creat_date."'";
/*欄位值組裝 end*/
	// echo "INSERT INTO $tb ($input) VALUES ($value)";die();
	$GLOBALS['db']->query("INSERT INTO $tb ($input) VALUES ($value)");

	$url = $CFG->$short_url;
	die("<script>alert('add member success.');location.href='".$url."';</script>");
}

/*會員資料修改功能*/
function member_update($form){
	global $CFG, $db;

	$tb  = $CFG->tb;
	$old_phone = $_SESSION['member']['phone'];//原本電話
/*修改變數定義 start*/
	$id = $_SESSION['member']['id'];//會員ID
	$phone 		= string_filter($form['phone']);
	if ($form['phone'] != $old_phone) {//這邊要有改電話才執行
		chk_reuse($phone, $tb, "phone", "The 「phone」 is reuse, input another.");//確認帳號是否重複
	}
	$first_name = string_filter($form['first_name']);
	$last_name  = string_filter($form['last_name']);
	$gender 	= $form['gender'];//gender
	$email     	= string_filter($form['email']);
	$password   = string_filter($form['password']);
/*修改變數定義 end*/
	$act	= "`id` = '" .$id. "'";
/*欄位值組裝 start */
	$fix	= "`first_name` = '" .$first_name. "', ";
	$fix   .= "`last_name` = '" .$last_name. "', ";
	$fix   .= "`phone` = '" .$phone. "', ";
	$fix   .= "`gender` = '" .$gender. "', ";
	$fix   .= "`email` = '" .$email. "', ";
	$fix   .= "`psd` = '" .$password. "'";
/*欄位值組裝 end */
	// echo "UPDATE $tb SET $fix WHERE $act";die();
	$GLOBALS['db']->query("UPDATE $tb SET $fix WHERE $act");//執行修改
/*重新定義member session start*/
	$new_member_data = $db->getRow("SELECT * FROM $tb WHERE $act");//讀取新的會員資料
	$_SESSION['member'] = $new_member_data;//覆蓋原本session變數
	// print_r($_SESSION['member']);die();
/*重新定義member session end*/
	$message = "Your data update success.";
	$url = $CFG->$short_url;
	die("<script>alert(\"".$message."\");location.href='".$url."';</script>");
}


/*會員登入功能*/
function member_login($form){
	global $CFG, $db;

	$phone    = string_filter($_POST['phone']);//會員電話
	$password = string_filter($_POST['password']);//會員密碼

	//檢查是否輸入資料
	if ($phone=='') {
		die('<script>alert("The 「phone」 column is required.");history.back();</script>');
	}
	if ($password=='') {
		die('<script>alert("The 「password」 column is required.");history.back();</script>');
	}

	//驗證輸入帳密是否正確
	$tb  = $CFG->tb;
	$op  = "count(*)";
	$act = "phone = '".$phone."' AND psd = '".$password."' AND is_del = '0'";
	$count = $db->getOne("SELECT $op FROM $tb WHERE $act");//找到的使用者數量

	if($count == 0){//沒找到
		$msg  = "The phone number or password you entered is doesn't exist. \\n";
		$msg .= "check it again. \\n";
		$msg .= "If you have any question, connect us. \\n";
		$msg .= "Tel：0981981396.";
		die("<script>alert(\"".$msg."\");history.back();</script>");	
	}else{//找到了, 先拉出資料
		$op  = "*";
		$member_data = $db->getRow("SELECT $op FROM $tb WHERE $act");
		chk_black($member_data['id']);//確認是否為黑名單
		//宣告SESSION變數
		$_SESSION['member'] = $member_data;
		$url = $CFG->$short_url;
		die("<script>location.href='".$url."';</script>");	
	}
}
?>


