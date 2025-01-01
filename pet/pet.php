<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../application.php');
member_login_chk();//確認是否登入會員
$act = $_REQUEST['act'];
$CFG->$short_url = $CFG->wwwroot."/pet/";
$CFG->tb = "pet_list";

switch ($act) {
	case 'add':
		pet_add($_REQUEST);//會員寵物新增頁面
		break;

	case 'insert':
		pet_insert($_REQUEST);//新增會員寵物功能
		break;

	case 'edit':
		pet_edit($_REQUEST);//修改會員寵物資料畫面
		break;

	case 'update':
		pet_update($_REQUEST);//會員寵物資料修改功能
		break;

	case 'del':
		pet_delete($_REQUEST);//會員寵物資料刪除功能
		break;

	default:
		pet_area($_REQUEST);//會員寵物列表
		break;
}

/*會員寵物列表*/
function pet_area($form){
	global $CFG,$db;

	$area_title    = "Pet Area";
	$insert_button = "Add Pet";
	$short_url     = $CFG->$short_url;

	$tb   = "pet_list";//寵物列表
	$op   = "*";
	$act  = " owner ='".$_SESSION['member']['id']."'";
	$act .= " AND is_del ='0'";

/* 關鍵字判定 start */
	if ($form['search_key']) {
		$act .= " AND (";
		$act .= "`name` LIKE '%".string_filter($form['search_key'])."%'";
		$act .= " )";
	}
	$search_key = $form['search_key'];
/* 關鍵字判定 end */

	// die("SELECT COUNT(*) FROM $tb WHERE $act"); 
	$data_count = $db->getOne("SELECT COUNT(*) FROM $tb WHERE $act");//取得資料筆數
	if ($data_count != 0) {//如果有資料
		$data   = $db->getAll("SELECT * FROM $tb WHERE $act");//讀取寵物資料
	}
	include_once('./templates/pet_area.php');
		
}

/*會員寵物新增頁面*/
function pet_add(){
	global $CFG,$db;

	$next_act   = "insert";
	$area_title = "Pet Add";
	$body_shape = "defind yet";
	$haired 	= "defind yet";
	include_once('./templates/pet_form.php');
}

/*新增會員寵物功能*/
function pet_insert($form){
	global $CFG, $db;

	$tb  = $CFG->tb;
/*新增變數定義 start*/
	$name 	     = string_filter($form['name']);//name
	$gender  	 = $form['gender'];//gender
	$owner		 = $_SESSION['member']['id'];//owner
	$remark   	 = string_filter($form['remark']);//remark
	$creat_date	 = date("Y-m-d H:i:s");//creat date
/*新增變數定義 end*/
	$input = "`name`, `gender`, `owner`, `remark`, `creat_date`";//欄位定義
/*欄位值組裝 start*/
	$value  = "'".$name."',";
	$value .= "'".$gender."',";
	$value .= "'".$owner."',";
	$value .= "'".$remark."',";
	$value .= "'".$creat_date."'";
/*欄位值組裝 end*/
	// echo "INSERT INTO $tb ($input) VALUES ($value)";die();
	$GLOBALS['db']->query("INSERT INTO $tb ($input) VALUES ($value)");

	$url = $CFG->$short_url;
	$msg = "Add pet success.";
	die("<script>alert(\"".$msg."\");location.href='".$url."';</script>");
}


/*修改會員寵物資料畫面*/
function pet_edit($form){
	global $CFG,$db;

	$next_act   = "update";
	$area_title = "Pet Edit";

	$id   = $form['id'];//寵物ID
	$tb   = $CFG->tb;//寵物列表
	id_chk($tb, $id);//確認是否輸入有效ID
	$op   = "*";
	$act  = "id ='".$id."'";
	$act .= " AND is_del = '0'";
	// echo "SELECT $op FROM $tb WHERE $act";die();
	$data = $db->getRow("SELECT $op FROM $tb WHERE $act");//讀取寵物資料

	$body_shape = ($data['body_shape'] != "") ? bs_show($data['body_shape']) : "defind yet";
	$haired 	= ($data['haired'] != "") ? haired_show($data['haired']) : "defind yet";
	include_once('./templates/pet_form.php');
}


/*會員寵物資料修改功能*/
function pet_update($form){
	global $CFG, $db;

	$tb  = $CFG->tb;
	$id  = $form['id'];//寵物ID
/*修改變數定義 start*/
	$name 	     = string_filter($form['name']);//name
	$gender  	 = $form['gender'];//gender
	$owner		 = $_SESSION['member']['id'];//owner
	$remark   	 = string_filter($form['remark']);//remark
/*修改變數定義 end*/
	$act	= "`id` = '" .$id. "'";
/*欄位值組裝 start */
	$fix	= "`name` = '" .$name. "', ";
	$fix   .= "`gender` = '" .$gender. "', ";
	$fix   .= "`owner` = '" .$owner. "', ";
	$fix   .= "`remark` = '" .$remark. "'";
/*欄位值組裝 end */
	// echo "UPDATE $tb SET $fix WHERE $act";die();
	$GLOBALS['db']->query("UPDATE $tb SET $fix WHERE $act");//執行修改
	$message = "Your pet data update success.";
	$url = $CFG->$short_url;
	die("<script>alert(\"".$message."\");location.href='".$url."';</script>");
}

/*會員寵物資料刪除功能*/
function pet_delete($form){
	global $CFG, $db;

	$tb    = $CFG->tb;
	$id    = $form['id'];//寵物ID
	$owner = $_SESSION['member']['id'];//owner

	$act	= "`id` IN (".$id.")";
	$act   .= " AND `owner` IN (".$owner.")";
	$fix	= "`is_del` = '1'";
	pet_del_chk($id, $owner);//刪除前檢查參數
	// echo "UPDATE $tb SET $fix WHERE $act";die();
	$GLOBALS['db']->query("UPDATE $tb SET $fix WHERE $act");//執行修改
	$message = "Your pet data delete success.";
	$url = $CFG->$short_url;
	die("<script>alert(\"".$message."\");location.href='".$url."';</script>");
}
?>


