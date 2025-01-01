<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../../application.php');
include_once('../includes/chk_login.php');//驗證是否登入
include_once('../../includes/non_css.php'); 

$CFG->headerlink = '../includes/em_headerlink.php';
$CFG->leftlink   = '../includes/em_leftnavlink.php';
$CFG->tb = "`service_list`";
$ME = "service.php";
$CFG->limit = 10;
$act = $_REQUEST['act']; 
$CFG->width = "100%";

switch ($act) {
	case 'add':
		service_add();//新增服務畫面
		break;

	case 'insert':
		service_insert($_REQUEST);//新增服務功能
		break;

	case 'edit':
		service_edit($_REQUEST);//修改服務畫面
		break;

	case 'update':
		service_update($_REQUEST);//修改服務功能
		break;

	case 'del':
		service_del($_REQUEST);//刪除服務功能
		break;
	
	default:
		service_list($_REQUEST);//服務列表
		break;
}


/*服務列表*/
function service_list($form){
	global $CFG, $db, $ME;
	
	$title = "Service List";
	$insert_button = "add service";
	$op    = "count(*)";
	$act   = " s.is_del = 0";
/* 進度查詢判定 start */
	if ($form['finished'] == "0" OR $form['finished'] == "1") {
		$act .= " AND s.finished ='".$form['finished']."'";
	}
	$finished = $form['finished'];//查詢進度
/* 進度查詢判定 end */
/* 預約日期查詢判定 start */
	if ($form['sea_date']) {
		$day_start = $form['sea_date']." 00:00:00";
		$day_end   = $form['sea_date']." 23:59:59";
		$act .= " AND s.reserve_date BETWEEN '".$day_start."' AND '".$day_end."'";
	}
	$sea_date = $form['sea_date'];//查詢預約日期
/* 預約日期查詢判定 end */
/* 點數支付判定 start */
	// echo $form['point_pay'];die();
	if ($form['point_pay'] == "0" OR $form['point_pay'] == "1") {
		$act .= " AND s.point_pay ='".$form['point_pay']."'";
	}
	$p_pay = $form['point_pay'];//查詢點數支付
/* 點數支付判定 end */
/* 關鍵字判定 start */
	if ($form['search_key']) {
		$act .= " AND (";
		$act .= "m.`first_name` LIKE '%".string_filter($form['search_key'])."%' OR ";
		$act .= "m.`last_name` LIKE '%".string_filter($form['search_key'])."%' OR ";
		$act .= "m.`phone` LIKE '%".string_filter($form['search_key'])."%' OR ";
		$act .= "p.`name` LIKE '%".string_filter($form['search_key'])."%'";
		$act .= " )";
	}
	$search_key = $form['search_key'];//查詢關鍵字
/* 關鍵字判定 end */
	$tb1 = "`service_list` s";
	$tb2 = "`pet_list` p";
	$tb3 = "`member_list` m";
	$on1 = "s.`pet` = p.`id`";
	$on2 = "p.`owner` = m.`id`";
	// echo "SELECT $op FROM $tb1 LEFT JOIN $tb2 ON $on1 LEFT JOIN $tb3 ON $on2 WHERE $act";die();
	$data_count = $db->getOne("SELECT $op FROM $tb1 LEFT JOIN $tb2 ON $on1 LEFT JOIN $tb3 ON $on2 WHERE $act");//抓出資料筆數
	if ($data_count != 0) {
		$result = page_defind($form['page'], $CFG->limit);//目前頁數資料判定
		$op    = "s.`id`, s.`project`, s.`project`, p.`name`, m.`first_name`, m.`last_name`, m.`phone`, s.`extra`, s.`remark`, s.`state`, s.`reserve_date`, s.`finish_time`, s.`price`, s.`point_pay`, s.`creat_date`";
		$data = $db->getAll("SELECT $op FROM $tb1 LEFT JOIN $tb2 ON $on1 LEFT JOIN $tb3 ON $on2 WHERE $act ORDER BY id ASC LIMIT ".$result['limit']);
		/*做出頁數下拉選單*/
		$page_select_display = page_option($CFG->limit, $data_count, $result['page']);
	}
	include_once('./templates/service_list.php');
}

/*新增服務畫面*/
function service_add(){
	global $CFG, $ME;
	
	$next_act  = "insert";
	$title 	   = "Add Service";
	$dog_href  = "";
	$dog_text  = "";
	include('./templates/service_form.php');
}

/*新增服務功能*/
function service_insert($form){
	global $CFG, $db, $ME;

	chk_reserve_date($form['reserve_date'] , $form['finish_time']);//確認預計完成時間大於預約時間
/*使用點數支付判定 start*/
	if ($form['point_pay']) {
		$point = get_point($form['pet']);//抓出會員剩餘點數
		$result = chk_point($point);//確認點數是否足夠支付
		if (!$result) {//不夠
			$msg = "The member's points have not reached 10.";
			die("<script>alert(\"".$msg."\");history.back();</script>");
		}else{//夠
			$point_pay = 1;
		}
	}else{
		$point_pay = 0;
	}
/*使用點數支付判定 end*/
	$tb  = $CFG->tb;
/*新增變數定義 start*/
	$project 	  = $form['project'];//服務項目
	$pet  		  = $form['pet'];//寵物
	$extra   	  = $form['extra'];//加購價
	$remark       = string_filter($form['remark']);//備註
	$state        = $form['state'];//訂單狀態
	$reserve_date = string_filter($form['reserve_date']);//送店日期
	$finish_time  = string_filter($form['finish_time']);//預估完成時間
	$price        = $form['price'];//總價
	$creat_date	  = date("Y-m-d H:i:s");//創建日期
/*新增變數定義 end*/
/*訂單狀態額外處理判定 start*/
	if ($state == 5) {
		$finished = 1;
	}else{
		$finished = 0;
	}
/*訂單狀態額外處理判定 end*/
	$input = "`project`, `pet`, `extra`, `remark`, `state`, `reserve_date`, `finish_time`, `finished`, `price`, `point_pay`, `creat_date`";//欄位定義
/*欄位值組裝 start*/
	$value  = "'".$project."',";
	$value .= "'".$pet."',";
	$value .= "'".$extra."',";
	$value .= "'".$remark."',";
	$value .= "'".$state."',";
	$value .= "'".$reserve_date."',";
	$value .= "'".$finish_time."',";
	$value .= "'".$finished."',";
	$value .= "'".$price."',";
	$value .= "'".$point_pay."',";
	$value .= "'".$creat_date."'";
/*欄位值組裝 end*/
	$GLOBALS['db']->query("INSERT INTO $tb ($input) VALUES ($value)");
	die("<script>alert('add service success.');location.href='".$ME."';</script>");
}

/*修改服務畫面*/
function service_edit($form){
	global $CFG, $db, $ME;

	$next_act = "update";
	$title = "Service Data Edit";
	$tb    = $CFG->tb;
	$op    = "*";
	$act   = "`id` =".$form['id'];
	$data = $db->getRow("SELECT $op FROM $tb WHERE $act");
	$owner = $db->getOne("SELECT `owner` FROM pet_list WHERE id='".$data['pet']."'");//拉出寵物主人
	$is_ckeck = ($data['price'] != "") ? "1" : "0";
	$total_text  = ($data['price'] != "") ? "total price = basic price(".$data['price'] - $data['extra'].") + extra price(".$data['extra'].") = ".$data['price'] : "";
	$dog_href  = $CFG->back_wwwroot."/pet/pet.php?act=edit&id=".$data['pet'];
	$dog_text  = "dog_data";
	$point_checked = ($data['point_pay']) ? "checked" : "";

	include('./templates/service_form.php');
}

/*修改服務功能*/
function service_update($form){
	global $CFG, $db, $ME;

/*使用點數支付判定 start*/
	if ($form['point_pay']) {
		$point = member_point($form['id']);//抓出會員剩餘點數
		$result = chk_point($point);//確認點數是否足夠支付
		if (!$result AND $form['old_state'] != "5") {//不夠
			$msg = "The member's points have not reached 10.";
			die("<script>alert(\"".$msg."\");history.back();</script>");
		}else{//夠
			$point_pay = 1;
		}
	}else{
		$point_pay = 0;
	}
/*使用點數支付判定 end*/
	chk_reserve_date($form['reserve_date'] , $form['finish_time']);//確認預計完成時間大於預約時間
/*使用點數支付判定 end*/
	$tb  = $CFG->tb;
/*修改變數定義 start*/
	$id 		  = $form['id'];
	$project 	  = $form['project'];//服務項目
	$pet  		  = $form['pet'];//寵物
	$extra   	  = $form['extra'];//加購價
	$remark       = string_filter($form['remark']);//備註
	$state        = $form['state'];//訂單狀態
	$reserve_date = string_filter($form['reserve_date']);//送店日期
	$finish_time  = string_filter($form['finish_time']);//預估完成時間
	$price        = $form['price'];//總價
/*修改變數定義 end*/
/*欄位值組裝 start */
	$fix	= "`project` = '" .$project. "', ";
	$fix   .= "`pet` = '" .$pet. "', ";
	$fix   .= "`extra` = '" .$extra. "', ";
	$fix   .= "`remark` = '" .$remark. "', ";
	$fix   .= "`state` = '" .$state. "', ";
	$fix   .= "`reserve_date` = '" .$reserve_date. "', ";
	$fix   .= "`finish_time` = '" .$finish_time. "', ";
	$fix   .= "`price` = '" .$price. "', ";
	$fix   .= "`point_pay` = '" .$point_pay. "'";
/*欄位值組裝 end */
/*訂單狀態額外處理判定 start*/
	if ($state == "5") {//finished
		if ($form['old_state'] != "5") {//這邊要加條件處理從Paid and left以外的狀態改的話,才處理以下動作
		$finish_pay = array();//紀錄最後結帳金額及是否點數支付
		array_push($finish_pay, $pet);//寵物塞陣列
		array_push($finish_pay, $price);//金額塞陣列
		array_push($finish_pay, $point_pay);//支付方式塞陣列
		service_done_action($pet, $price, $point_pay);//結算點數處理
		$fix   .= " ,`finish_pay` = '" .json_encode($finish_pay). "'";//串出sql語法
		}
		$finished = 1;
	}else{
		$finished = 0;
		$fix   .= " ,`finish_pay` = null";//清空最後結帳金額及是否點數支付紀錄
		if ($form['old_state'] == "5") {//這邊要加條件處理從Paid and left改狀態的話,會員的點數狀況
			service_done_cancel($id);//返還點數處理
		}
	}
	$fix   .= ", `finished` = '" .$finished. "'";
/*訂單狀態額外處理判定 end*/

	$act	= "`id` = '" .$id. "'";
	// echo "UPDATE $tb SET $fix WHERE $act";die();
	$GLOBALS['db']->query("UPDATE $tb SET $fix WHERE $act");
	$message = "service data update success.";
	die("<script>alert(\"".$message."\");location.href='".$ME."';</script>");
}

/*刪除服務功能*/
function service_del($form){
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
	$message = "service data delete success.";
	die("<script>alert(\"".$message."\");location.href='".$ME."';</script>");
}
























?>

