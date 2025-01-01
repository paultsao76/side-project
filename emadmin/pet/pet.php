<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../../application.php');
include_once('../includes/chk_login.php');//驗證是否登入
include_once('../../includes/non_css.php'); 

$CFG->headerlink = '../includes/em_headerlink.php';
$CFG->leftlink   = '../includes/em_leftnavlink.php';
$CFG->tb = "pet_list";
$ME = "pet.php";
$CFG->limit = 10;
$act = $_REQUEST['act']; 
$CFG->width = "100%";

switch ($act) {
	case 'add':
		pet_add();//新增寵物畫面
		break;

	case 'insert':
		pet_insert($_REQUEST);//新增寵物功能
		break;

	case 'edit':
		pet_edit($_REQUEST);//修改寵物畫面
		break;

	case 'update':
		pet_update($_REQUEST);//修改寵物功能
		break;

	case 'del':
		pet_del($_REQUEST);//刪除寵物功能
		break;

	default:
		pet_list($_REQUEST);//寵物列表
		break;
}


/*寵物列表*/
function pet_list($form){
	global $CFG, $db, $ME;
	
	$title = "Pet List";
	$insert_button = "add pet";
	$tb1 = "`pet_list` p";
	$tb2 = "`member_list` m";
	$on  = "p.`owner` = m.`id`";
	$op    = "count(*)";
	$act   = " p.`is_del` = '0'";
/* 關鍵字判定 start */
	if ($form['search_key']) {
		$act .= " AND (";
		$act .= "p.`name` LIKE '%".string_filter($form['search_key'])."%' OR ";
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
	$op    = "p.*, m.`first_name`, m.`last_name`, m.`phone`";
	$data = $db->getAll("SELECT $op FROM $tb1 LEFT JOIN $tb2 ON $on WHERE $act ORDER BY p.`id` ASC LIMIT ".$result['limit']);
	$page_select_display = page_option($CFG->limit, $data_count, $result['page']);/*做出頁數下拉選單*/
}
	include_once('./templates/pet_list.php');
}

/*新增寵物畫面*/
function pet_add(){
	global $CFG, $ME;
	
	$next_act = "insert";
	$title = "Add Pet";
	include('./templates/pet_form.php');
}

/*新增寵物功能*/
function pet_insert($form){
	global $CFG, $db, $ME;

	$tb  = $CFG->tb;
/*新增變數定義 start*/
	$name 	     = string_filter($form['name']);
	$gender  	 = $form['gender'];
	$body_shape  = $form['body_shape'];
	$haired   	 = $form['haired'];
	$owner     	 = $form['owner'];
	$remark      = string_filter($form['remark']);
	$creat_date	 = date("Y-m-d H:i:s");
/*新增變數定義 end*/
	$input = "`name`, `gender`, `body_shape`, `haired`, `owner`, `remark`, `creat_date`";//欄位定義
/*欄位值組裝 start*/
	$value  = "'".$name."',";
	$value .= "'".$gender."',";
	$value .= "'".$body_shape."',";
	$value .= "'".$haired."',";
	$value .= "'".$owner."',";
	$value .= "'".$remark."',";
	$value .= "'".$creat_date."'";
/*欄位值組裝 end*/
	$GLOBALS['db']->query("INSERT INTO $tb ($input) VALUES ($value)");
	die("<script>alert('add pet success.');location.href='".$ME."';</script>");
}

/*修改寵物畫面*/
function pet_edit($form){
	global $CFG, $db, $ME;

	id_chk($CFG->tb, $form['id']);//確認是否輸入有效ID
	$next_act = "update";
	$title = "Pet's Data Edit";
	$tb    = $CFG->tb;
	$op    = "*";
	$act   = "`id` =".$form['id'];
	$data = $db->getRow("SELECT $op FROM $tb WHERE $act");

	include('./templates/pet_form.php');
}

/*修改寵物功能*/
function pet_update($form){
	global $CFG, $db, $ME;

	$tb  = $CFG->tb;
/*修改變數定義 start*/
	$id = $form['id'];
	$name 	     = string_filter($form['name']);
	$gender  	 = $form['gender'];
	$body_shape  = $form['body_shape'];
	$haired   	 = $form['haired'];
	$owner     	 = $form['owner'];
	$remark      = string_filter($form['remark']);
/*修改變數定義 end*/
	$act	= "`id` = '" .$id. "'";
/*欄位值組裝 start */
	$fix	= "`name` = '" .$name. "', ";
	$fix   .= "`gender` = '" .$gender. "', ";
	$fix   .= "`body_shape` = '" .$body_shape. "', ";
	$fix   .= "`haired` = '" .$haired. "', ";
	$fix   .= "`owner` = '" .$owner. "', ";
	$fix   .= "`remark` = '" .$remark. "'";
/*欄位值組裝 end */
	$GLOBALS['db']->query("UPDATE $tb SET $fix WHERE $act");
	$message = "pet's data update success.";
	die("<script>alert(\"".$message."\");location.href='".$ME."';</script>");
}

/*刪除寵物功能*/
function pet_del($form){
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
	$message = "pet's data delete success.";
	die("<script>alert(\"".$message."\");location.href='".$ME."';</script>");
}
?>

