<?php 
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../../application.php');
include_once('../../functions/chk_login.php');//驗證是否登入
include('../../includes/non_css.php'); 
include_once('../../functions/common.php');//引入公用函式庫

$CFG->tb = "raid";
$ME = "raid.php";

$act = $_REQUEST['act']; 

switch ($act) {
	case 'add':
		raid_add();//新增天賦畫面
		break;

	case 'insert':
		raid_insert($_REQUEST);//新增天賦功能
		break;

	case 'edit':
		raid_edit($_REQUEST);//修改天賦畫面
		break;

	case 'update':
		raid_update($_REQUEST);//修改天賦功能
		break;

	case 'del':
		raid_del($_REQUEST);//刪除天賦功能
		break;
	
	default:
		raid_list($_REQUEST);//天賦列表
		break;
}


/*天賦列表*/
function raid_list($form){
	global $CFG, $db, $ME;
	
	$title = "天賦列表";
	$tb1   = $CFG->tb." `t`";
	$tb2   = "classes `c`";
	$op    = "`t`.`id` AS id, `t`.`raid_name`, `c`.`ch_name`";
	$on    = "`t`.classes_id = `c`.id";
	$act   = " `t`.is_del = '0'";
	if ($form['search_key']) {
		$act .= " AND (";
		$act .= " `t`.`raid_name` LIKE '%".$form['search_key']."%'";
		$act .= " OR `c`.`ch_name` LIKE '%".$form['search_key']."%'";
		$act .= " )";
	}
	$raid_data = $db->getAll("SELECT $op FROM $tb1 LEFT JOIN $tb2 ON $on WHERE $act ORDER BY classes_id, id");
	$data_count = count($raid_data);
	$search_key = $form['search_key'];

	include('./templates/raid_list.php');
}

/*新增天賦畫面*/
function raid_add(){
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

	include('./templates/raid_form.php');
}

/*新增天賦功能*/
function raid_insert($form){
	global $CFG, $db, $ME;
	
	$tb  = $CFG->tb;
	$raid_name = $form['raid_name'];
	$classes_id  = $form['classes_id'];


	$input = "`raid_name`, `classes_id`";

	$value  = "'".$raid_name."',";
	$value .= "'".$classes_id."'";

	$GLOBALS['db']->query("INSERT INTO $tb ($input) VALUES ($value)");
	die("<script>alert('天賦新增成功。');location.href='".$ME."';</script>");
}

/*修改天賦畫面*/
function raid_edit($form){
	global $CFG, $db, $ME;

	$next_act = "update";
	$title = "天賦修改";
	$tb    = $CFG->tb;
	$op    = "*";
	$act   = "`id` =".$form['id'];
	$raid_data = $db->getRow("SELECT $op FROM $tb WHERE $act");


/*做出職業選取下拉選單 start*/
	$classes_select_display = "<option value='0'>---請選擇所屬職業---</option>";//定義職業選單語法
	$classes_data = get_all_classes();//取得所有職業資料
	foreach ($classes_data as $val) {
		/*定義預設選取*/
		if ($raid_data['classes_id'] == $val['id']) {
			$selected = "selected";
		}else{
			$selected = "";
		}
		$classes_select_display .= "<option value='".$val['id']."'".$selected.">".$val['ch_name']."</option>";
	}
/*做出職業選取下拉選單 end*/

	include('./templates/raid_form.php');
}

/*修改天賦功能*/
function raid_update($form){
	global $CFG, $db, $ME;
	
	$tb  = $CFG->tb;
	$id = $form['id'];
	$raid_name = $form['raid_name'];
	$classes_id = $form['classes_id'];

	$act	= "`id` = '" .$id. "'";

	$fix	= "`raid_name` = '" .$raid_name. "', ";
	$fix   .= "`classes_id` = '" .$classes_id. "'";

	$GLOBALS['db']->query("UPDATE $tb SET $fix WHERE $act");
	die("<script>alert('天賦資料修改成功。');location.href='".$ME."';</script>");
}

/*刪除天賦功能*/
function raid_del($form){
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

