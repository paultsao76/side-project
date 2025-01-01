<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../../application.php');
include_once('../includes/chk_login.php');//驗證是否登入
include_once('../../includes/non_css.php'); 

$CFG->headerlink = '../includes/em_headerlink.php';
$CFG->leftlink   = '../includes/em_leftnavlink.php';
$CFG->tb = "member_list";
$ME = "member.php";
$CFG->limit = 10;
$act = $_REQUEST['act']; 
$CFG->width = "100%";

switch ($act) {
	case 'add':
		member_add();//新增會員畫面
		break;

	case 'insert':
		member_insert($_REQUEST);//新增會員功能
		break;

	case 'edit':
		member_edit($_REQUEST);//修改會員畫面
		break;

	case 'update':
		member_update($_REQUEST);//修改會員功能
		break;

	case 'del':
		member_del($_REQUEST);//刪除會員功能
		break;
	
	default:
		member_list($_REQUEST);//會員列表
		break;
}


/*會員列表*/
function member_list($form){
	global $CFG, $db, $ME;
	
	$title = "Member List";
	$insert_button = "add member";
	$op    = "count(*)";
	$act   = " is_del = 0";
/* 關鍵字判定 start */
	if ($form['search_key']) {
		$act .= " AND (";
		$act .= "first_name LIKE '%".string_filter($form['search_key'])."%' OR ";
		$act .= "last_name LIKE '%".string_filter($form['search_key'])."%' OR ";
		$act .= "phone LIKE '%".string_filter($form['search_key'])."%' OR ";
		$act .= "email LIKE '%".string_filter($form['search_key'])."%'";
		$act .= " )";
	}
	$search_key = $form['search_key'];
/* 關鍵字判定 end */
// echo "SELECT $op FROM $CFG->tb WHERE $act";die();
	$data_count = $db->getOne("SELECT $op FROM $CFG->tb WHERE $act");//抓出資料筆數

if ($data_count != 0) {
	$result = page_defind($form['page'], $CFG->limit);//目前頁數資料判定
	$op    = "*";
	$data = $db->getAll("SELECT $op FROM $CFG->tb WHERE $act ORDER BY id ASC LIMIT ".$result['limit']);
	/*做出頁數下拉選單*/
	$page_select_display = page_option($CFG->limit, $data_count, $result['page']);
}
	include_once('./templates/member_list.php');
}

/*新增會員畫面*/
function member_add(){
	global $CFG, $ME;
	
	$next_act = "insert";
	$title = "Add Member";
	include('./templates/member_form.php');
}

/*新增會員功能*/
function member_insert($form){
	global $CFG, $db, $ME;

	$tb  = $CFG->tb;
/*新增變數定義 start*/
	$phone 	   = string_filter($form['phone']);
	chk_reuse($phone, $tb, "phone", "The 「phone」 is reuse, input another.");//確認帳號是否重複
	$first_name  = string_filter($form['first_name']);
	$last_name   = string_filter($form['last_name']);
	$gender   	 = $form['gender'];
	$password    = string_filter($form['password']);
	$email     	 = string_filter($form['email']);
	$remark      = string_filter($form['remark']);
	$creat_date	 = date("Y-m-d H:i:s");
/*新增變數定義 end*/
	$input = "`first_name`, `last_name`, `phone`, `gender`, `psd`, `email`, `remark`, `creat_date`";//欄位定義
/*欄位值組裝 start*/
	$value  = "'".$first_name."',";
	$value .= "'".$last_name."',";
	$value .= "'".$phone."',";
	$value .= "'".$gender."',";
	$value .= "'".$password."',";
	$value .= "'".$email."',";
	$value .= "'".$remark."',";
	$value .= "'".$creat_date."'";
/*欄位值組裝 end*/
	// die("INSERT INTO $tb ($input) VALUES ($value)");
	$GLOBALS['db']->query("INSERT INTO $tb ($input) VALUES ($value)");
	die("<script>alert('add member success.');location.href='".$ME."';</script>");
}

/*修改會員畫面*/
function member_edit($form){
	global $CFG, $db, $ME;

	$next_act = "update";
	$title = "Member's Data Edit";
	$tb    = $CFG->tb;
	$op    = "*";
	$act   = "`id` =".$form['id'];
	$data = $db->getRow("SELECT $op FROM $tb WHERE $act");

	include('./templates/member_form.php');
}

/*修改會員功能*/
function member_update($form){
	global $CFG, $db, $ME;

	$tb  = $CFG->tb;
/*修改變數定義 start*/
	$id = $form['id'];
	$phone = string_filter($form['phone']);
	if ($form['phone'] != $form['old_phone']) {//這邊要有改帳號才執行
		chk_reuse($phone, $tb, "phone", "The 「phone」 is reuse, input another.");//確認帳號是否重複
	}
	$first_name = string_filter($form['first_name']);
	$last_name  = string_filter($form['last_name']);
	$gender   	= $form['gender'];
	$password   = string_filter($form['password']);
	$email     	= string_filter($form['email']);
	$remark     = string_filter($form['remark']);
/*修改變數定義 end*/
	$act	= "`id` = '" .$id. "'";
/*欄位值組裝 start */
	$fix	= "`first_name` = '" .$first_name. "', ";
	$fix   .= "`last_name` = '" .$last_name. "', ";
	$fix   .= "`phone` = '" .$phone. "', ";
	$fix   .= "`gender` = '" .$gender. "', ";
	$fix   .= "`psd` = '" .$password. "', ";
	$fix   .= "`email` = '" .$email. "', ";
	$fix   .= "`remark` = '" .$remark. "'";
/*欄位值組裝 end */
	// echo "UPDATE $tb SET $fix WHERE $act";die();
	$GLOBALS['db']->query("UPDATE $tb SET $fix WHERE $act");
	$message = "member's data update success.";
	die("<script>alert(\"".$message."\");location.href='".$ME."';</script>");
}

/*刪除會員功能*/
function member_del($form){
	global $CFG, $db, $ME;
	
	$tb  = $CFG->tb;

	$item = $form['item'];
	$items = "";//定義刪除id串
	foreach ($item as $val) {
		$items .= ($items == "") ? $val : ",".$val;//組出刪除id
	}
	$act	= "`id` IN (".$items.")";
	$fix	= "`is_del` = '1'";

	// echo "UPDATE $tb SET $fix WHERE $act";die();
	$GLOBALS['db']->query("UPDATE $tb SET $fix WHERE $act");
	$message = "member's data delete success.";
	die("<script>alert(\"".$message."\");location.href='".$ME."';</script>");
}
























?>

