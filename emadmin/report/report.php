<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../../application.php');
include_once('../includes/chk_login.php');//驗證是否登入
include_once('../../includes/non_css.php'); 

$CFG->headerlink = '../includes/em_headerlink.php';
$CFG->leftlink   = '../includes/em_leftnavlink.php';
$CFG->tb = "report_list";
$ME = "report.php";
$CFG->limit = 10;
$act = $_REQUEST['act']; 
$CFG->width = "100%";

switch ($act) {
	case 'del':
		report_del($_REQUEST);//刪除舉報功能
		break;
	
	default:
		report_list($_REQUEST);//舉報列表
		break;
}

/*舉報列表*/
function report_list($form){
	global $CFG, $db, $ME;
	
	$title = "Report List";
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
	include_once('./templates/report_list.php');
}

/*刪除舉報功能*/
function report_del($form){
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
	$message = "report delete success.";
	die("<script>alert(\"".$message."\");location.href='".$ME."';</script>");
}
























?>

