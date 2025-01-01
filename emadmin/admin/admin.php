<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../../application.php');
include_once('../includes/chk_login.php');//驗證是否登入
include_once('../../includes/non_css.php'); 

$CFG->headerlink = '../includes/em_headerlink.php';
$CFG->leftlink   = '../includes/em_leftnavlink.php';
$CFG->tb = "admin_list";
$ME = "admin.php";
$CFG->limit = 10;
$act = $_REQUEST['act']; 

switch ($act) {
	case 'add':
		admin_add();//新增管理員畫面
		break;

	case 'insert':
		admin_insert($_REQUEST);//新增管理員功能
		break;

	case 'edit':
		admin_edit($_REQUEST);//修改管理員畫面
		break;

	case 'update':
		admin_update($_REQUEST);//修改管理員功能
		break;

	case 'del':
		admin_del($_REQUEST);//刪除管理員功能
		break;
	
	default:
		admin_list($_REQUEST);//管理員列表
		break;
}


/*管理員列表*/
function admin_list($form){
	global $CFG, $db, $ME;
	
	$title = "Admin List";
	$insert_button = "add admin";
	$op    = "count(*)";
	$act   = " is_del = 0";
	$search_key = $form['search_key'];
/* 關鍵字判定 start */
	if ($form['search_key']) {
		$act .= " AND (";
		$act .= "name LIKE '%".string_filter($form['search_key'])."%'";
		$act .= " )";
	}
/* 關鍵字判定 end */
	$data_count = $db->getOne("SELECT $op FROM $CFG->tb WHERE $act");//抓出資料筆數
if ($data_count != 0) {
	$result = page_defind($form['page'], $CFG->limit);//目前頁數資料判定
	$op    = "*";
	$data = $db->getAll("SELECT $op FROM $CFG->tb WHERE $act ORDER BY id ASC LIMIT ".$result['limit']);
	
	/*做出頁數下拉選單*/
	$page_select_display = page_option($CFG->limit, $data_count, $result['page']);
}
	include_once('./templates/admin_list.php');
}

/*新增管理員畫面*/
function admin_add(){
	global $CFG, $ME;
	
	$next_act = "insert";
	$title = "Add Admin";


	include('./templates/admin_form.php');
}

/*新增管理員功能*/
function admin_insert($form){
	global $CFG, $db, $ME;

	$tb  = $CFG->tb;
/*新增變數定義 start*/
	$name 	   = string_filter($form['name']);
	chk_reuse($name, $tb, "name", "The 「name」 is reuse, input another.");//確認帳號是否重複
	$password  = $form['password'];
	$level     = $form['level'];
	$creat_date= date("Y-m-d H:i:s");
/*新增變數定義 end*/
	$input = "`name`, `password`, `level`, `creat_date`";//欄位定義
/*欄位值組裝 start*/
	$value  = "'".$name."',";
	$value .= "'".$password."',";
	$value .= "'".$level."',";
	$value .= "'".$creat_date."'";
/*欄位值組裝 end*/
	$GLOBALS['db']->query("INSERT INTO $tb ($input) VALUES ($value)");
	die("<script>alert('add admin success.');location.href='".$ME."';</script>");
}

/*修改管理員畫面*/
function admin_edit($form){
	global $CFG, $db, $ME;

	$next_act = "update";
	$title = "Admin's Data Edit";
	$tb    = $CFG->tb;
	$op    = "*";
	$act   = "`id` =".$form['id'];
	$data = $db->getRow("SELECT $op FROM $tb WHERE $act");

	include('./templates/admin_form.php');
}

/*修改管理員功能*/
function admin_update($form){
	global $CFG, $db, $ME;

	$tb  = $CFG->tb;
/*修改變數定義 start*/
	$id = $form['id'];
	$name 	   = string_filter($form['name']);
	if ($form['name'] != $form['old_name']) {//這邊要有改帳號才執行
		chk_reuse($name, $tb, "name", "The 「name」 is reuse, input another.");//確認帳號是否重複
	}
	$password  = $form['password'];
	$level     = $form['level'];
/*修改變數定義 end*/
	$act	= "`id` = '" .$id. "'";
/*欄位值組裝 start */
	$fix	= "`name` = '" .$name. "', ";
	$fix   .= "`password` = '" .$password. "', ";
	$fix   .= "`level` = '" .$level. "'";
/*欄位值組裝 end */
	// echo "UPDATE $tb SET $fix WHERE $act";die();
	$GLOBALS['db']->query("UPDATE $tb SET $fix WHERE $act");
	$message = "admin's data update success.";
	die("<script>alert(\"".$message."\");location.href='".$ME."';</script>");
}

/*刪除管理員功能*/
function admin_del($form){
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
	$message = "admin's data delete success.";
	die("<script>alert(\"".$message."\");location.href='".$ME."';</script>");
}
























?>

