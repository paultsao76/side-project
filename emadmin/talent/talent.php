<?php 
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../../application.php');
include_once('../../functions/chk_login.php');//驗證是否登入
include('../../includes/non_css.php'); 
include_once('../../functions/common.php');//引入公用函式庫

$CFG->tb = "talent";
$ME = "talent.php";
$CFG->limit = 20;

$act = $_REQUEST['act']; 

switch ($act) {
	case 'add':
		talent_add();//新增天賦畫面
		break;

	case 'insert':
		talent_insert($_REQUEST);//新增天賦功能
		break;

	case 'edit':
		talent_edit($_REQUEST);//修改天賦畫面
		break;

	case 'update':
		talent_update($_REQUEST);//修改天賦功能
		break;

	case 'del':
		talent_del($_REQUEST);//刪除天賦功能
		break;
	
	default:
		talent_list($_REQUEST);//天賦列表
		break;
}


/*天賦列表*/
function talent_list($form){
	global $CFG, $db, $ME;
	
	$title = "天賦列表";
	$tb   = $CFG->tb;
	$op    = "*";
	$act   = " is_del = '0'";

	$data_count = $db->getOne("SELECT COUNT(*) FROM $tb WHERE $act");
/*判定是否送出查詢 start*/
	/*關鍵字*/
	if ($form['search_key']) {
		$act .= " AND (";
		$act .= " `talent_name` LIKE '%".$form['search_key']."%'";
		$act .= " )";
	}

	/*所屬職業*/
	if ($form['c_id'] AND $form['c_id'] != "0") {
		$act .= "AND classes_id ='".$form['c_id']."'";
	}

	/*所屬位置*/
	if ($form['p_id'] AND $form['p_id'] != "0") {
		$act .= "AND position_id ='".$form['p_id']."'";
	}
/*判定是否送出查詢 end*/

/*目前頁數資料判定 start*/
	if (!$form['page']) {
		$page = 1;
	}else{
		$page = $form['page'];
	}
	if ( ($page - 1) == 0 ) {
		$start = 0;
	}else{
		$start = $CFG->limit * ($page-1);
	}
	
	$limit = $start." , ".$CFG->limit;
/*目前頁數資料判定 end*/

	$talent_data = $db->getAll("SELECT $op FROM $tb WHERE $act ORDER BY classes_id ASC, id ASC LIMIT ".$limit);
	$now_data_count = count($talent_data);
	$search_key = $form['search_key'];

	/*做出頁數下拉選單*/
	
	$page_select_display = page_option($CFG->limit, $data_count, $page);

	/*做出職業選取下拉選單*/
	$classes_select_display = classes_option($form['c_id']);

	/*做出位置選取下拉選單*/
	$position_select_display = position_option($form['p_id']);

	include('./templates/talent_list.php');
}

/*新增天賦畫面*/
function talent_add(){
	global $CFG, $ME;
	
	$next_act = "insert";
	$title = "天賦新增";

/*做出職業選取下拉選單 start*/
	$classes_select_display = "<option value='0'>---請選擇所屬職業---</option>";//定義職業選單語法
	$classes_data = get_all_classes();//取得所有職業資料
	foreach ($classes_data as $val) {
		$classes_select_display .= "<option value='".$val['id']."'>".$val['ch_name']."</option>";
	}
/*做出職業選取下拉選單 end*/

/*做出位置選取下拉選單 start*/
	$position_select_display = "<option value='0'>---請選擇所屬位置---</option>";//定義位置選單語法
	$position_data = get_all_position();//取得所有位置資料
	foreach ($position_data as $val) {
		/*定義預設選取*/
		if ($form['c_id'] == $val['id']) {
			$selected = "selected";
		}else{
			$selected = "";
		}
		$position_select_display .= "<option value='".$val['id']."'".$selected.">".$val['position_name']."</option>";
	}
/*做出位置選取下拉選單 end*/



	include('./templates/talent_form.php');
}

/*新增天賦功能*/
function talent_insert($form){
	global $CFG, $db, $ME;
	
	$tb  = $CFG->tb;
	$talent_name  = $form['talent_name'];
	$classes_id   = $form['classes_id'];
	$position_id  = $form['position_id'];


	$input = "`talent_name`, `classes_id`, `position_id`";

	$value  = "'".$talent_name."',";
	$value .= "'".$classes_id."',";
	$value .= "'".$position_id."'";

	$GLOBALS['db']->query("INSERT INTO $tb ($input) VALUES ($value)");
	die("<script>alert('天賦新增成功。');location.href='".$ME."';</script>");
}

/*修改天賦畫面*/
function talent_edit($form){
	global $CFG, $db, $ME;

	$next_act = "update";
	$title = "天賦修改";
	$tb    = $CFG->tb;
	$op    = "*";
	$act   = "`id` =".$form['id'];
	$talent_data = $db->getRow("SELECT $op FROM $tb WHERE $act");


/*做出職業選取下拉選單 start*/
	$classes_select_display = "<option value='0'>---請選擇所屬職業---</option>";//定義職業選單語法
	$classes_data = get_all_classes();//取得所有職業資料
	foreach ($classes_data as $val) {
		/*定義預設選取*/
		if ($talent_data['classes_id'] == $val['id']) {
			$selected = "selected";
		}else{
			$selected = "";
		}
		$classes_select_display .= "<option value='".$val['id']."'".$selected.">".$val['ch_name']."</option>";
	}
/*做出職業選取下拉選單 end*/

/*做出位置選取下拉選單 start*/
	$position_select_display = "<option value='0'>---請選擇所屬位置---</option>";//定義位置選單語法
	$position_data = get_all_position();//取得所有位置資料
	foreach ($position_data as $val) {
		/*定義預設選取*/
		if ($talent_data['position_id'] == $val['id']) {
			$selected = "selected";
		}else{
			$selected = "";
		}
		$position_select_display .= "<option value='".$val['id']."'".$selected.">".$val['position_name']."</option>";
	}
/*做出位置選取下拉選單 end*/

	include('./templates/talent_form.php');
}

/*修改天賦功能*/
function talent_update($form){
	global $CFG, $db, $ME;
	
	$tb  = $CFG->tb;
	$id = $form['id'];
	$talent_name = $form['talent_name'];
	$classes_id  = $form['classes_id'];
	$position_id = $form['position_id'];

	$act	= "`id` = '" .$id. "'";

	$fix	= "`talent_name` = '" .$talent_name. "', ";
	$fix   .= "`classes_id` = '" .$classes_id. "',";
	$fix   .= "`position_id` = '" .$position_id. "'";

	$GLOBALS['db']->query("UPDATE $tb SET $fix WHERE $act");
	die("<script>alert('天賦資料修改成功。');location.href='".$ME."';</script>");
}

/*刪除天賦功能*/
function talent_del($form){
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
	die("<script>alert('天賦資料刪除成功。');location.href='".$ME."';</script>");
}
























?>

