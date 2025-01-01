<?php 
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../../application.php');
include_once('../../functions/chk_login.php');//驗證是否登入
include('../../includes/non_css.php'); 

$CFG->tb = "classes";
$ME = "classes.php";

$act = $_REQUEST['act']; 

switch ($act) {
	case 'add':
		classes_add();//新增職業畫面
		break;

	case 'insert':
		classes_insert($_REQUEST);//新增職業功能
		break;

	case 'edit':
		classes_edit($_REQUEST);//修改職業畫面
		break;

	case 'update':
		classes_update($_REQUEST);//修改職業功能
		break;

	case 'del':
		classes_del($_REQUEST);//刪除職業功能
		break;
	
	default:
		classes_list($_REQUEST);//職業列表
		break;
}


/*職業列表*/
function classes_list($form){
	global $CFG, $db, $ME;
	
	$title = "職業列表";
	$tb  = $CFG->tb;
	$op  = "*";
	$act = " is_del = '0'";
	if ($form['search_key']) {
		$act .= " AND (";
		$act .= " `en_name` LIKE '%".$form['search_key']."%'";
		$act .= " OR `ch_name` LIKE '%".$form['search_key']."%'";
		$act .= " )";
	}
	$classes_data = $db->getAll("SELECT $op FROM $tb WHERE $act");
	$data_count = count($classes_data);
	$search_key = $form['search_key'];

	include('./templates/classes_list.php');
}

/*新增職業畫面*/
function classes_add(){
	global $CFG, $ME;
	
	$next_act = "insert";
	$title = "職業新增";
	include('./templates/classes_form.php');
}

/*新增職業功能*/
function classes_insert($form){
	global $CFG, $db, $ME;
	
	$tb  = $CFG->tb;
	$en_name = $form['en_name'];
	$ch_name = $form['ch_name'];


	$input = "`en_name`, `ch_name`";

	$value  = "'".$en_name."',";
	$value .= "'".$ch_name."'";

	$GLOBALS['db']->query("INSERT INTO $tb ($input) VALUES ($value)");
	die("<script>alert('職業新增成功。');location.href='".$ME."';</script>");
}

/*修改職業畫面*/
function classes_edit($form){
	global $CFG, $db, $ME;

	$next_act = "update";
	$title = "職業修改";
	$tb    = $CFG->tb;
	$op    = "*";
	$act   = "`id` =".$form['id'];
	$classes_data = $db->getRow("SELECT $op FROM $tb WHERE $act");


	include('./templates/classes_form.php');
}

/*修改職業功能*/
function classes_update($form){
	global $CFG, $db, $ME;
	
	$tb  = $CFG->tb;
	$id = $form['id'];
	$en_name = $form['en_name'];
	$ch_name = $form['ch_name'];

	$act	= "`id` = '" .$id. "'";

	$fix	= "`en_name` = '" .$form['en_name']. "', ";
	$fix   .= "`ch_name` = '" .$form['ch_name']. "'";

	$GLOBALS['db']->query("UPDATE $tb SET $fix WHERE $act");
	die("<script>alert('職業資料修改成功。');location.href='".$ME."';</script>");
}

/*刪除職業功能*/
function classes_del($form){
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
	die("<script>alert('職業資料刪除成功。');location.href='".$ME."';</script>");
}
























?>

