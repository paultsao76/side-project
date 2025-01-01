<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../../application.php');
include_once('../includes/chk_login.php');//驗證是否登入
include_once('../../includes/non_css.php'); 

$CFG->headerlink = '../includes/em_headerlink.php';
$CFG->leftlink   = '../includes/em_leftnavlink.php';
$CFG->tb = "black_list";
$ME = "black.php";
$CFG->limit = 10;
$act = $_REQUEST['act']; 
$CFG->width = "100%";

switch ($act) {
	case 'add':
		black_add();//新增黑名單畫面
		break;

	case 'insert':
		black_insert($_REQUEST);//新增黑名單功能
		break;

	case 'edit':
		black_edit($_REQUEST);//修改黑名單畫面
		break;

	case 'update':
		black_update($_REQUEST);//修改黑名單功能
		break;

	case 'del':
		black_del($_REQUEST);//刪除黑名單功能
		break;

	default:
		black_list($_REQUEST);//黑名單列表
		break;
}


/*黑名單列表*/
function black_list($form){
	global $CFG, $db, $ME;
	
	$title = "Black List";
	$insert_button = "add black";
	$tb1   = "`black_list` b";
	$tb2   = "`member_list` m";
	$on    = "b.`member` = m.`id`";
	$op    = "count(*)";
	$act   = " b.`is_del` = 0";
/* 關鍵字判定 start */
	if ($form['search_key']) {
		$act .= " AND (";
		$act .= "m.`first_name` LIKE '%".string_filter($form['search_key'])."%' OR ";
		$act .= "m.`last_name` LIKE '%".string_filter($form['search_key'])."%' OR ";
		$act .= "m.`phone` LIKE '%".string_filter($form['search_key'])."%'";
		$act .= " )";
	}
	$search_key = $form['search_key'];
/* 關鍵字判定 end */
// echo "SELECT $op FROM $CFG->tb WHERE $act";die();
	$data_count = $db->getOne("SELECT $op FROM $tb1 LEFT JOIN $tb2 ON $on WHERE $act");//抓出資料筆數

if ($data_count != 0) {
	$result = page_defind($form['page'], $CFG->limit);//目前頁數資料判定
	$op    = "b.`id`, b.`member`, b.`remark`, b.`creat_date`, m.`first_name`, m.`last_name`, m.`phone`";
	$data = $db->getAll("SELECT $op FROM $tb1 LEFT JOIN $tb2 ON $on WHERE $act ORDER BY id ASC LIMIT ".$result['limit']);
	$page_select_display = page_option($CFG->limit, $data_count, $result['page']);/*做出頁數下拉選單*/
}
	include_once('./templates/black_list.php');
}

/*新增黑名單畫面*/
function black_add(){
	global $CFG, $ME;
	
	$next_act = "insert";
	$title = "Add black";
	include('./templates/black_form.php');
}

/*新增黑名單功能*/
function black_insert($form){
	global $CFG, $db, $ME;

	$tb  = $CFG->tb;
/*新增變數定義 start*/
	$member  	 = $form['owner'];
	chk_reuse($member, $tb, "member", "The 「member」 is blacked, check it again.");//確認會員是否重複黑單
	$remark      = string_filter($form['remark']);
	$creat_date	 = date("Y-m-d H:i:s");
/*新增變數定義 end*/
	$input = "`member`, `remark`, `creat_date`";//欄位定義
/*欄位值組裝 start*/
	$value  = "'".$member."',";
	$value .= "'".$remark."',";
	$value .= "'".$creat_date."'";
/*欄位值組裝 end*/
	$GLOBALS['db']->query("INSERT INTO $tb ($input) VALUES ($value)");
	die("<script>alert('add black success.');location.href='".$ME."';</script>");
}

/*修改黑名單畫面*/
function black_edit($form){
	global $CFG, $db, $ME;

	id_chk($CFG->tb, $form['id']);//確認是否輸入有效ID
	$next_act = "update";
	$title = "black's Data Edit";
	$tb    = $CFG->tb;
	$op    = "*";
	$act   = "`id` =".$form['id'];
	$data = $db->getRow("SELECT $op FROM $tb WHERE $act");

	include('./templates/black_form.php');
}

/*修改黑名單功能*/
function black_update($form){
	global $CFG, $db, $ME;

	$tb  = $CFG->tb;
	$old_member = $form['old_owner'];
/*修改變數定義 start*/
	$id = $form['id'];
	$member  	 = $form['owner'];
if ($member != $old_member) {//有修改memeber才進行確認
	chk_reuse($member, $tb, "member", "The 「member」 is blacked, check it again.");//確認會員是否重複黑單
}
	$remark      = string_filter($form['remark']);
/*修改變數定義 end*/
	$act	= "`id` = '" .$id. "'";
/*欄位值組裝 start */
	$fix	= "`member` = '" .$member. "', ";
	$fix   .= "`remark` = '" .$remark. "'";
/*欄位值組裝 end */
	$GLOBALS['db']->query("UPDATE $tb SET $fix WHERE $act");
	$message = "black's data update success.";
	die("<script>alert(\"".$message."\");location.href='".$ME."';</script>");
}

/*刪除黑名單功能*/
function black_del($form){
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
	$message = "black's data delete success.";
	die("<script>alert(\"".$message."\");location.href='".$ME."';</script>");
}
?>

