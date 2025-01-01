<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../application.php');
member_login_chk();//確認是否登入會員
$act = $_REQUEST['act'];
$CFG->$short_url = $CFG->wwwroot."/reserve/";
$CFG->tb = "service_list";



switch ($act) {
	case 'add':
		reserve_add();//會員專區 預約新增頁面
		break;

	case 'insert':
		reserve_insert($_REQUEST);//會員專區 預約新增功能
		break;

	case 'edit':
		reserve_edit($_REQUEST);//會員專區 預約內容修改頁面
		break;

	case 'update':
		reserve_update($_REQUEST);//會員專區 預約內容修改功能
		break;

	case 'del':
		reserve_delete($_REQUEST);//會員專區 預約刪除功能
		break;

	default:
		reserve_area($_REQUEST);//會員專區 預約列表
		break;
}

/*會員專區 預約列表*/
function reserve_area($form){
	global $CFG,$db;

	$area_title    = "My Reserve";
	$insert_button = "Reserve Apply";
	$short_url     = $CFG->$short_url;

	$tb1  = "`service_list` s";//服務列表
	$tb2  = "`pet_list` p";//寵物列表
	$op   = "p.`name`, s.`id`, s.`project`, s.`state`, s.`reserve_date`, s.`finish_time`";
	$on   = "s.`pet` = p.`id`";
	$act  = " p.`owner` ='".$_SESSION['member']['id']."'";
	$act .= " AND s.`is_del` ='0'";
/* 搜尋寵物名稱判定 start */
	if ($form['pet_name']) {
		$act .= " AND (";
		$act .= "p.`name` = '".string_filter($form['pet_name'])."'";
		$act .= " )";
	}
	$pet_name = $form['pet_name'];
/* 搜尋寵物名稱判定 end */
/* 搜尋日期判定 start */
	/* 排除起訖只有一個參數的狀況 start */
	if ($form['start_date'] AND $form['end_date'] == "") {
		$msg = "You can't input invalid parameter.";
		die("<script>alert(\"".$msg."\");history.back();</script>");
	}
	if ($form['end_date'] AND $form['start_date'] == "") {
		$msg = "You can't input invalid parameter.";
		die("<script>alert(\"".$msg."\");history.back();</script>");
	}
	/* 排除起訖只有一個參數的狀況 start */
	if ($form['start_date']) {
		$act .= " AND (";
		$act .= " s.`reserve_date` BETWEEN '".string_filter($form['start_date'])." 00:00:00' AND '".string_filter($form['end_date'])." 23:59:59'";
		$act .= " )";
	}

	$start_date = $form['start_date'];
	$end_date 	= $form['end_date'];
/* 搜尋日期判定 end */

	// die("SELECT COUNT(*) FROM $tb1 LEFT JOIN $tb2 ON $on WHERE $act"); 
	$data_count = $db->getOne("SELECT COUNT(*) FROM $tb1 LEFT JOIN $tb2 ON $on WHERE $act");//取得資料筆數
	if ($data_count != 0) {//如果有資料
		$data   = $db->getAll("SELECT $op FROM $tb1 LEFT JOIN $tb2 ON $on WHERE $act ORDER BY s.`id` ASC");//讀取預約資料
	}
	include_once('./templates/reserve_list.php');
		
}


/*會員專區 預約新增頁面*/
function reserve_add(){
	global $CFG;

	chk_pet_count($_SESSION['member']['id']);//確認是否有寵物
	$next_act    = "insert";
	$area_title  = "Reserve Apply";
	$finish_time = "no defind";
	$extra	     = "no defind";
	$price       = 0;
	$price_tip   = "This column will input by us, when we accept this reserve and check your pet state in store.";
	$point       = members_point($_SESSION['member']['id']);//取得會員現有點數
	$point_pay_disabled  = ( chk_point($point) ) ? "" : "disabled";//判定會員點數是否足夠
	$state_disabled      = "disabled";
	$submit_button = '<button type="submit" class="btn btn-primary">Submit</button>';

	include_once('./templates/reserve_form.php');
}

/*會員專區 預約新增功能*/
function reserve_insert($form){
	global $CFG, $db;

	date_chk($form['reserve_date']);//確認時間是否已經超過

	$tb  = $CFG->tb;
/*新增變數定義 start*/
	if (!$form['point_pay']) {//如果沒選取點數支付
		$form['point_pay'] = 0;//定義欄位值
	}
	$project 	  = $form['project'];//預約服務項目
	$pet 	 	  = $form['pet'];//寵物ID
	$remark       = string_filter($form['remark']);//備註
	$state     	  = 0;//預約服務狀態
	$reserve_date = string_filter($form['reserve_date']);//預約日期
	$point_pay    = $form['point_pay'];//是否點數支付
	$creat_date	  = date("Y-m-d H:i:s");//創建日期
/*新增變數定義 end*/
	$input = "`project`, `pet`, `remark`, `state`, `reserve_date`, `point_pay`, `creat_date`";//欄位定義
/*欄位值組裝 start*/
	$value  = "'".$project."',";
	$value .= "'".$pet."',";
	$value .= "'".$remark."',";
	$value .= "'".$state."',";
	$value .= "'".$reserve_date."',";
	$value .= "'".$point_pay."',";
	$value .= "'".$creat_date."'";
/*欄位值組裝 end*/
	// echo "INSERT INTO $tb ($input) VALUES ($value)"."<br>";
	// die();
	$GLOBALS['db']->query("INSERT INTO $tb ($input) VALUES ($value)");//將資料存到資料庫
	include_once('./reserve_email.php');
}

/*會員專區 預約內容修改頁面*/
function reserve_edit($form){
	global $CFG, $db;

	chk_reserve_member($form['id'], $_SESSION['member']['id']);//確認會員參數
	$next_act = "update";
	$title = "Reserve Edit";
	$tb    = $CFG->tb;
	$op    = "*";
	$act   = "`id` =".$form['id'];
	$data = $db->getRow("SELECT $op FROM $tb WHERE $act");


	$finish_time 		= ($data['finish_time'] == "") ? "no defind" : $data['finish_time'];//判定預定結束時間欄位值
	$extra	     		= ($data['extra'] == "") ? "no defind" : $data['extra'];//判定加購價欄位值
	$price       		= ($data['price'] == "") ? "no defind" : $data['price'];
	$price_tip   		= "This column will input by us, when we accept this reserve and check your pet state in store.";
	$point_pay_disabled = ( chk_point($_SESSION['member']['point']) ) ? "" : "disabled";//判定會員點數是否足夠
	$checked     		= ($data['point_pay'] == 1) ? "checked" : "";//判定是否使用點數支付

/* 預約狀態判定 */
if ($data['state'] != "0" AND $data['state'] != 6) {//如果已接受申請, 鎖住所有欄位
	$project_disabled   = "disabled";
	$pet_disabled 	    = "disabled";
	$date_disabled 	    = "disabled";
	$state_disabled     = "disabled";
	$point_pay_disabled = "disabled";
	$submit_button = '';
}else{
	$submit_button = '<button type="submit" class="btn btn-primary">Submit</button>';
}

	include('./templates/reserve_form.php');
}

/*會員專區 Feelingreserve內容修改功能*/
function reserve_update($form){
	global $CFG, $db;

	date_chk($form['reserve_date']);//確認時間是否已經超過
	$tb  		  = $CFG->tb;
/*修改變數定義 start*/
	$id 		  = $form['id'];//預約服務ID
	if (!$form['point_pay']) {//如果沒選取點數支付
		$form['point_pay'] = 0;//定義欄位值
	}
	$project 	  = $form['project'];//預約服務項目
	$pet 	 	  = $form['pet'];//寵物ID
	$remark       = string_filter($form['remark']);//備註
	$state        = $form['state'];//預約狀態
	$reserve_date = string_filter($form['reserve_date']);//預約日期
	$point_pay    = $form['point_pay'];//是否點數支付
/*修改變數定義 end*/
	$act		  = "`id` = '" .$id. "'";
/*欄位值組裝 sta rt */
	$fix          = "`project` = '" .$project. "', ";
	$fix         .= "`pet` = '" .$pet. "', ";
	$fix         .= "`remark` = '" .$remark. "', ";
	$fix         .= "`state` = '" .$state. "', ";
	$fix         .= "`reserve_date` = '" .$reserve_date. "', ";
	$fix         .= "`point_pay` = '" .$point_pay. "'";
/*欄位值組裝 end */
	// die("UPDATE $tb SET $fix WHERE $act");
	$GLOBALS['db']->query("UPDATE $tb SET $fix WHERE $act");
	include_once('./reserve_email.php');
}

/*會員專區 Feelingreserve刪除功能*/
function reserve_delete($form){
	global $CFG, $db;

	$tb    	 = $CFG->tb;
	$id    	 = $form['id'];//貼文ID
	$publish = $_SESSION['member']['id'];//publish

	$act	= "`id` IN (".$id.")";
	$act   .= " AND `publish` IN (".$publish.")";
	$fix	= "`is_del` = '1'";
	post_del_chk($id, $publish);//刪除前檢查參數
	// echo "UPDATE $tb SET $fix WHERE $act";die();
	$GLOBALS['db']->query("UPDATE $tb SET $fix WHERE $act");//執行修改
	$message = "Your pet data delete success.";
	$url = $CFG->$short_url;
	die("<script>alert(\"".$message."\");location.href='".$url."';</script>");
}

?>


