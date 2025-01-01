<?php 
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../../application.php');
include_once('../../functions/chk_login.php');//驗證是否登入
include('../../includes/non_css.php'); 
include_once('../../functions/common.php');//引入公用函式庫

$CFG->tb = "position";
$ME = "position.php";

$act = $_REQUEST['act']; 

switch ($act) {
	case 'add':
		position_add();//新增位置畫面
		break;

	case 'insert':
		position_insert($_REQUEST);//新增位置功能
		break;

	case 'edit':
		position_edit($_REQUEST);//修改位置畫面
		break;

	case 'update':
		position_update($_REQUEST);//修改位置功能
		break;

	case 'del':
		position_del($_REQUEST);//刪除位置功能
		break;
	
	default:
		position_list($_REQUEST);//位置列表
		break;
}


/*位置列表*/
function position_list($form){
	global $CFG, $db, $ME;
	
	$title = "位置列表";
	$tb   = $CFG->tb;
	$op    = "*";
	$act   = " is_del = '0'";
	if ($form['search_key']) {
		$act .= " AND (";
		$act .= " `position_name` LIKE '%".$form['search_key']."%'";
		$act .= " )";
	}
	$position_data = $db->getAll("SELECT $op FROM $tb WHERE $act ORDER BY id ASC");
	$data_count = count($position_data);
	$search_key = $form['search_key'];

	include('./templates/position_list.php');
}

/*新增位置畫面*/
function position_add(){
	global $CFG, $ME;
	
	$next_act = "insert";
	$title = "位置新增";

/*做出職業選取下拉選單 start*/
	$classes_select_display = "<option value='0'>---請選擇所屬職業---</option>";//定義職業選單語法
	$classes_data = get_all_classes();//取得所有職業資料
	foreach ($classes_data as $val) {
		$classes_select_display .= "<option value='".$val['id']."'>".$val['ch_name']."</option>";
	}
/*做出職業選取下拉選單 end*/

	include('./templates/position_form.php');
}

/*新增位置功能*/
function position_insert($form){
	global $CFG, $db, $ME;
	
	$tb  = $CFG->tb;
	$position_name = $form['position_name'];

	$input = "`position_name`";

	$value  = "'".$position_name."'";

	$GLOBALS['db']->query("INSERT INTO $tb ($input) VALUES ($value)");
	die("<script>alert('位置新增成功。');location.href='".$ME."';</script>");
}

/*修改位置畫面*/
function position_edit($form){
	global $CFG, $db, $ME;

	$next_act = "update";
	$title = "位置修改";
	$tb    = $CFG->tb;
	$op    = "*";
	$act   = "`id` =".$form['id'];
	$position_data = $db->getRow("SELECT $op FROM $tb WHERE $act");


/*做出職業選取下拉選單 start*/
	$classes_select_display = "<option value='0'>---請選擇所屬職業---</option>";//定義職業選單語法
	$classes_data = get_all_classes();//取得所有職業資料
	foreach ($classes_data as $val) {
		/*定義預設選取*/
		if ($position_data['classes_id'] == $val['id']) {
			$selected = "selected";
		}else{
			$selected = "";
		}
		$classes_select_display .= "<option value='".$val['id']."'".$selected.">".$val['ch_name']."</option>";
	}
/*做出職業選取下拉選單 end*/

	include('./templates/position_form.php');
}

/*修改位置功能*/
function position_update($form){
	global $CFG, $db, $ME;
	
	$tb  = $CFG->tb;
	$id = $form['id'];
	$position_name = $form['position_name'];

	$act	= "`id` = '" .$id. "'";

	$fix	= "`position_name` = '" .$position_name. "'";

	$GLOBALS['db']->query("UPDATE $tb SET $fix WHERE $act");
	die("<script>alert('位置資料修改成功。');location.href='".$ME."';</script>");
}

/*刪除位置功能*/
function position_del($form){
	global $CFG, $db, $ME;
	
	$tb  = $CFG->tb;

	$item = $form['item'];
	$items = "";
	foreach ($item as $val) {
		$items .= ($items == "") ? $val : ",".$val;
	}
	// echo $items;die();

	$act	= "`id` IN (".$items.")";

	$fix	= "`is_del` = '1'";

	// echo "UPDATE $tb SET $fix WHERE $act";die();
	$GLOBALS['db']->query("UPDATE $tb SET $fix WHERE $act");
	die("<script>alert('位置資料刪除成功。');location.href='".$ME."';</script>");
}
























?>

