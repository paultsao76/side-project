<?
/* level選單生成 */
function level_option($level=1){
	$position = ["leader", "normal"];//所有level定義
	$output  = '<select name="level" id="level" class="insert">';//開始組出選單
	$output .= '<option value="none" >---select one---</option>';
	for ($i=0; $i < count($position); $i++) { 
		$val = $i+1;
		if ($level == $val) {
			$selected = "selected";
		}else{
			$selected = "";
		}
		$output .= '<option value="'.$val.'" '.$selected.' >'.$position[$i].'</option>';
	}
	$output .= "</select>";
	return $output;
}

/* 寵物體型選單生成 */
function bs_option($type = 1){
	global $db;
	$op   = "id, body";//ID, 體型資料
	$tb   = "menu";//價目表
    $data = $db->getAll("SELECT $op FROM $tb ORDER BY id ASC");
	$output  = '<select name="body_shape" id="body_shape" class="insert">';//開始組出選單
	$output .= '<option value="none" >-------select one-------</option>';
	foreach ($data as $val) {
		if ($type == $val['id']) {
			$selected = "selected";
		}else{
			$selected = "";
		}
		$output .= '<option value="'.$val['id'].'" '.$selected.' >'.$val['body'].'</option>';
	}

	// for ($i=0; $i < count($data); $i++) { 
	// 	$val = $i+1;
	// 	if ($type == $val) {
	// 		$selected = "selected";
	// 	}else{
	// 		$selected = "";？
	// 	}
	// 	$output .= '<option value="'.$val.'" '.$selected.' >'.$data[$i]['body'].'</option>';
	// }
	$output .= "</select>";
	return $output;
}

/* 寵物毛的型態選單生成 */
function haired_option($type = 1){
	global $db;
	$op   = "id, type";//ID, 毛的型態
	$tb   = "haired_list";//價目表
    $data = $db->getAll("SELECT $op FROM $tb ORDER BY id ASC");
	$output  = '<select name="haired" id="haired" class="insert">';//開始組出選單
	$output .= '<option value="none" >-------select one-------</option>';
	foreach ($data as $val) {
		if ($type == $val['id']) {
			$selected = "selected";
		}else{
			$selected = "";
		}
		$output .= '<option value="'.$val['id'].'" '.$selected.' >'.$val['type'].'</option>';
	}
	$output .= "</select>";
	return $output;
}

/* 會員選單生成 */
function owner_option($owner = "none"){
	global $db;
	$op   = "id, first_name, last_name, phone";//ID, 姓, 名, 電話
	$tb   = "member_list";//會員列表
    $data = $db->getAll("SELECT $op FROM $tb ORDER BY id ASC");
	$output  = '<select name="owner" id="owner" class="insert">';//開始組出選單
	$output .= '<option value="none" >-------select one-------</option>';
	foreach ($data as $val) {
		if ($owner == $val['id']) {
			$selected = "selected";
		}else{
			$selected = "";
		}
		$output .= '<option value="'.$val['id'].'" '.$selected.' >'.$val['first_name'].' '.$val['last_name'].'('.$val['phone'].')'.'</option>';
	}
	$output .= "</select>";
	return $output;
}

/* 寵物選單生成 */
function pet_option($owner = "", $pet = ""){
	global $db;
	$tb   = "pet_list";//寵物列表
	$op   = "id, name, body_shape, haired";//ID, 寵物名, 體型, 毛型
	$act  = "owner ='".$owner."'";
    $data = $db->getAll("SELECT $op FROM $tb WHERE $act ORDER BY id ASC");
    if ($owner != "" AND $pet != "") {//修改畫面顯示
    	$output  = '<select name="pet" id="pet" class="insert">';//開始組出選單
		$output .= '<option value="none" >-------select one-------</option>';
		foreach ($data as $val) {
			if ($pet == $val['id']) {
				$selected = "selected";
			}else{
				$selected = "";
			}
			$output .= '<option value="'.$val['id'].'" '.$selected.' >'.$val['name'].'('.bs_show($val['body_shape']).', '.haired_show($val['haired']).')'.'</option>';
		}
		$output .= "</select>";
    }else{//新增畫面顯示
    	$output  = '<select name="pet" id="pet" class="insert" disabled>';//開始組出選單
    	$output .= '<option value="none" >-------select one-------</option>';
    	$output .= "</select>";
    }
	return $output;
}

/* 寵物性別選單生成 */
function gender_option($gender = "none"){

	$gender_list = ["Male", "Female"];//性別選項定義

	$output  = '<select name="gender" id="gender" class="insert">';//開始組出選單
	$output .= '<option value="none" >-------select one-------</option>';
	foreach ($gender_list as $key => $val) {
		$key+=1;
		if ($gender == $key) {
			$selected = "selected";
		}else{
			$selected = "";
		}
		$output .= '<option value="'.$key.'" '.$selected.' >'.$val.'</option>';
	}
	$output .= "</select>";
	return $output;
}

/* 服務選單生成 */
function project_option($project = "none"){

	$project_list = ["Bath", "Cut"];//服務選項定義

	$output  = '<select name="project" id="project" class="insert">';//開始組出選單
	$output .= '<option value="none" >-------select one-------</option>';
	foreach ($project_list as $key => $val) {
		$key+=1;
		if ($project == $key) {
			$selected = "selected";
		}else{
			$selected = "";
		}
		$output .= '<option value="'.$key.'" '.$selected.' >'.$val.'</option>';
	}
	$output .= "</select>";
	return $output;
}

/* 服務狀態選單生成 */
function service_state_option($state= ""){	
	if ($state== "") {
		$state = "none";
	}
	$state_list = ["Review", "Accept", "In store", "Finished, but no leave", "Stood up", "Paid and left", "cancle"];//所有state定義
	$output  = '<select name="state" id="state" class="insert">';//開始組出選單
	$output .= '<option value="none" >---select one---</option>';
	foreach ($state_list as $key => $val) {
		if ($state == $key) {
			$selected = "selected";
		}else{
			$selected = "";
		}
		$output .= '<option value="'.$key.'" '.$selected.' >'.$val.'</option>';
	}
	$output .= "</select>";
	return $output;
}

/* 進度選單生成 */
function finished_option($finished = "none"){
	if ($finished== "") {
		$finished = "none";
	}
	$finished_list = ["not finish", "finished"];//進度定義
	$output  = '<select name="finished" id="finished">';//開始組出選單
	$output .= '<option value="none" >-select one-</option>';
	foreach ($finished_list as $key => $val) {
		if ($finished == $key) {
			$selected = "selected";
		}else{
			$selected = "";
		}
		$output .= '<option value="'.$key.'" '.$selected.' >'.$val.'</option>';
	}
	$output .= "</select>";


	return $output;
}

/* 總價欄位生成 */
function price_column($price=0){	
	if ($price == "") {
		$val = 0;
	}else{
		$val = $price;
	}
	$output = '<input type="text" name="price" id="price" class="insert" value="'.$val.'" disabled>';

	return $output;
}

/* 體型資料顯示 */
function bs_show($id= ""){
	global $db;
	if ($id != "") {
		$op   = "body";//體型資料
		$tb   = "menu";//價目表
		$act  = "id ='".$id."'";
	    $data = $db->getOne("SELECT $op FROM $tb WHERE $act");
	}else{
		$data = "NULL";
	}
	return $data;
}

/* 毛的型態資料顯示 */
function haired_show($id){
	global $db;
    if ($id != "") {
    	$op   = "type";//毛的型態
		$tb   = "haired_list";//價目表
		$act  = "id ='".$id."'";
	    $data = $db->getOne("SELECT $op FROM $tb WHERE $act");
    }else{
    	$data = "NULL";
    }
	return $data;
}

/* 寵物主人資料顯示 */
function owner_show($id){
	global $db;
	$op   = "first_name, last_name, phone";//姓, 名, 電話
	$tb   = "member_list";//會員列表
	$act  = "id ='".$id."'";
    $data = $db->getRow("SELECT $op FROM $tb WHERE $act");
    $result = $data['first_name']." ".$data['last_name']."(".$data['phone'].")";
	return $result;
}

/* 寵物性別資料顯示 */
function gender_show($gender){
  if ($gender == 1) {
  	$result = "Male";
  }else{
  	$result = "Female";
  }
  return $result;
}

/* 發表人資料顯示 */
function publish_show($publish){
    global $db;
	if ($publish == 0) {
		$result = "administrator";
	}else{
		$op   = "first_name, last_name, phone";//姓, 名, 電話
		$tb   = "member_list";//會員列表
		$act  = "id ='".$publish."'";
	    $data = $db->getRow("SELECT $op FROM $tb WHERE $act");
	    $result = $data['first_name']." ".$data['last_name']."(".$data['phone'].")";
	}
	return $result;
}

/* 寵物性別資料顯示 */
function state_show($state){
  $state_list = ["Review", "Accept", "In store", "Finished, but no leave", "Stood up", "Paid and left", "cancle"];//所有state定義
  $result = $state_list[$state];
  return $result;
}

/* 寵物性別資料顯示 */
function project_show($project){
  if ($project == 1) {
  	$result = "Bath";
  }else{
  	$result = "Cut";
  }
  return $result;
}

/* 取得寵物資料 */
function pet_data($id){
	global $db;
	$tb = "pet_list";//寵物列表
  	$op = "*";
  	$act  = "id ='".$id."'";
  	$data = $db->getRow("SELECT $op FROM $tb WHERE $act");
  	return $data;
}

/* 取得主人資料 */
function owner_data($id){
	global $db;
	$tb = "member_list";//會員列表
  	$op = "*";
  	$act  = "id ='".$id."'";
  	$data = $db->getRow("SELECT $op FROM $tb WHERE $act");
  	return $data;
}

/* 取得基本價格 */
function basic_price($body_shape, $project){
	global $db;
	$service[1] = "bath";
	$service[2] = "cut";
	$tb = "menu";//價目表
  	$op = $service[$project];
  	$act  = "id ='".$body_shape."'";
  	$data = $db->getOne("SELECT $op FROM $tb WHERE $act");
  	return $data;
}

/* 寵物選單重置 */
function pet_option_reset($owner, $pet){
	global $db;
	$tb   = "pet_list";//寵物列表
	$op   = "id, name, body_shape, haired";//ID, 寵物名, 體型, 毛型
	$act  = "owner ='".$owner."'";
    $data = $db->getAll("SELECT $op FROM $tb WHERE $act ORDER BY id ASC");
	$output = '<option value="none" >-------select one-------</option>';//option定義
	foreach ($data as $val) {//開始組裝
		if ($pet == $val['id']) {
			$selected = "selected";
		}else{
			$selected = "";
		}
		$output .= '<option value="'.$val['id'].'" '.$selected.' >'.$val['name'].'('.bs_show($val['body_shape']).', '.haired_show($val['haired']).')'.'</option>';
	}
	return $output;
}


/* 會員忘記密碼, 電話確認 */
function phone_chk($phone){
	global $db;
	$tb    = "member_list";//會員列表
	$op    = "count(*)";//資料數量
	$act   = " `phone` ='".$phone."'";
	$act  .= " AND  `is_del` = '0'";
    $count = $db->getOne("SELECT $op FROM $tb WHERE $act");
	if ($count == 0) {
		$msg  = "The phone number 「".$phone."」 you entered is doesn't exist. \\n";
		$msg .= "If you have any question, connect us. \\n";
		$msg .= "Tel：0981981396.";
		die("<script>alert(\"".$msg."\");history.back();</script>");
	}

}

/* 拉出寵物體型資料, 做出options */
function front_bs_option($body_shape){
	global $db;

	if ($body_shape == "") {
		$body_shape = "none";
	}

	$tb     = "menu";//價目表
	$op     = "id, body";//ID, 體型名稱
    $data   = $db->getAll("SELECT $op FROM $tb ORDER BY id ASC");
    $output = "";//定義輸出字串
    foreach ($data as $val) {
    	$selected = "";//定義選取參數
    	/*判定是否帶有參數*/
    	if ($body_shape == $val['id']) {//如果有
    		$selected = "selected";//定義選取參數
    	}
    	$output .= '<option value="'.$val['id'].'" '.$selected.' >'.$val['body'].'</option>';//組出輸出字串
    }
    return $output;
}

/* for前台 拉出寵物毛型資料, 做出options */
function front_ht_option($haired = ""){
	global $db;

	if ($haired == "") {
		$haired = "none";
	}

	$tb     = "haired_list";//毛型態列表
	$op     = "id, type";//ID, 型態名稱
    $data   = $db->getAll("SELECT $op FROM $tb ORDER BY id ASC");
    $output = "";//定義輸出字串
    foreach ($data as $val) {
    	$selected = "";//定義選取參數
    	/*判定是否帶有參數*/
    	if ($body_shape == $val['id']) {//如果有
    		$selected = "selected";//定義選取參數
    	}
    	$output .= '<option value="'.$val['id'].'" '.$selected.' >'.$val['type'].'</option>';//組出輸出字串
    }
    return $output;
}

/* for前台 做出性別options */
function front_gd_option($gender = ""){
	global $db;

	if ($gender == "") {
		$gender = "none";
	}
	$data = array();//定義性別陣列
	$data[1] = "Male";
    $data[2] = "Female";

    foreach ($data as $key => $val) {
    	$selected = "";//定義選取參數
    	/*判定是否帶有參數*/
    	if ($gender == $key) {//如果有
    		$selected = "selected";//定義選取參數
    	}
    	$output .= '<option value="'.$key.'" '.$selected.' >'.$val.'</option>';//組出輸出字串
    }
    return $output;
}

/* 做出貼文公開狀態options */
function post_open_option($open = ""){
	global $db;

	if ($open == "") {
		$open = "none";
	}
	$data = ["N","Y"];//定義公開狀態陣列

    foreach ($data as $key => $val) {
    	$selected = "";//定義選取參數
    	/*判定是否帶有參數*/
    	if ($open == $key) {//如果有
    		$selected = "selected";//定義選取參數
    	}
    	$output .= '<option value="'.$key.'" '.$selected.' >'.$val.'</option>';//組出輸出字串
    }
    return $output;
}

/* for前台 會員刪除寵物 刪除前檢查參數 */
function pet_del_chk($id, $owner){
	global $db;

	$tb   = "pet_list";
	$op   = "count(*)";
	$act  = " `id` ='".$id."'";
	$act .= " AND `owner` ='".$owner."'";
	$act .= " AND `is_del` ='0'";
	$count = $db->getOne("SELECT $op FROM $tb WHERE $act");
	if ($count == 0) {
		$msg = "You can't input invalid parameter.";
		die("<script>alert(\"".$msg."\");history.back();</script>");
	}

}

/* for前台 會員刪除貼文 刪除前檢查參數 */
function post_del_chk($id, $publish){
	global $db;

	$tb   = "post_list";
	$op   = "count(*)";
	$act  = " `id` ='".$id."'";
	$act .= " AND `publish` ='".$publish."'";
	$act .= " AND `is_del` ='0'";
	$count = $db->getOne("SELECT $op FROM $tb WHERE $act");
	if ($count == 0) {
		$msg = "You can't input invalid parameter.";
		die("<script>alert(\"".$msg."\");history.back();</script>");
	}

}

/* for前台 預約功能 確認會員是否有寵物 */
function chk_pet_count($id){
	global $db;

	$tb   = "pet_list";
	$op   = "count(*)";
	$act  = " `owner` ='".$id."'";
	$act .= " AND `is_del` ='0'";
	$count = $db->getOne("SELECT $op FROM $tb WHERE $act");
	if ($count == 0) {
		$msg = "No pet data in your pet list, you should add one in your pet list.";
		die("<script>alert(\"".$msg."\");history.back();</script>");
	}

}

/* for前台 預約功能 服務方案options生成 */
function front_project_option($project = ""){

	if ($project == "") {
		$project = "none";
	}
	$data = array();//定義服務方案陣列
	$data[1] = "Bath";
	$data[2] = "Cut";

    foreach ($data as $key => $val) {
    	$selected = "";//定義選取參數
    	/*判定是否帶有參數*/
    	if ($project == $key) {//如果有
    		$selected = "selected";//定義選取參數
    	}
    	$output .= '<option value="'.$key.'" '.$selected.' >'.$val.'</option>';//組出輸出字串
    }
    return $output;

}

/* for前台 預約功能 寵物options生成 */
function front_pet_option($pet_id = ""){
	global $db;

	if ($pet_id == "") {
		$pet_id = "none";
	}

	$tb   = "pet_list";
	$op   = "`id`, `name`";
	$act  = " `owner` ='".$_SESSION['member']['id']."'";
	$act .= " AND `is_del` ='0'";
	$data = $count = $db->getAll("SELECT $op FROM $tb WHERE $act");//抓出該會員寵物資料

    foreach ($data as $key => $val) {
    	$selected = "";//定義選取參數
    	/*判定是否帶有參數*/
    	if ($pet_id == $val['id']) {//如果有
    		$selected = "selected";//定義選取參數
    	}
    	$output .= '<option value="'.$val['id'].'" '.$selected.' >'.$val['name'].'</option>';//組出輸出字串
    }
    return $output;

}

/* for前台 預約功能 預約狀態options生成 */
function front_reserve_state_option($state = ""){
	global $db;

	if ($state == "") {
		$state = "none";
	}
	/* 預約狀態判定 */
	if ($state != "0" AND $state != 6) {//如果不在Review和Cancle階段
		// die('1');
		$data = ["Review", "Accept", "In store", "Finished, but no leave", "Stood up", "Paid and left", "cancle"];//所有預約狀態定義
		$output = '<option value="none">Applying</option>';
	    foreach ($data as $key => $val) {
	    	$selected = "";//定義選取參數
	    	/*判定是否帶有參數*/
	    	if ($state == $key) {//如果有
	    		$selected = "selected";//定義選取參數
	    	}
	    	$output .= '<option value="'.$key.'" '.$selected.' >'.$val.'</option>';//組出輸出字串
	    }
	}else{//如果在Review和Cancle階段
		// die('2');
		$data = array();//所有預約狀態定義
		if ($state == "0") {//如果在Review階段
			$data[0] = "Review";
		}else{//如果在Cancle階段
			$data[0] = "Applying";
		}
		$data[6] = "cancle";

	    foreach ($data as $key => $val) {
	    	$selected = "";//定義選取參數
	    	/*判定是否帶有參數*/
	    	if ($state == $key) {//如果有
	    		$selected = "selected";//定義選取參數
	    	}
	    	$output .= '<option value="'.$key.'" '.$selected.' >'.$val.'</option>';//組出輸出字串
	    }

	}
    return $output;
}

/* 確認時間是否已經超過 */
function date_chk($date){

	$now  = strtotime(date("Y-m-d H:i:s"));
	$date = strtotime($date);
	if ($date < $now) {
		$msg = "Time is over than reserve date, now.";
		die("<script>alert(\"".$msg."\");history.back();</script>");
	}
}

/* 預約服務狀態顏色判定 */
function state_color($state){
	
	if ($state == 0) {//審核中
		$display = "#FF9797";//淺紅色
	}
	elseif ($state == 5) {//已付費且接離
		$display = "#A6FFA6";//淺綠色
	}
	elseif ($state == 6) {//已取消
		$display = "#9D9D9D";//灰色
	}
	else{//其餘狀態
		$display = "#FFFF93";//淺黃色
	}
	return $display;
}

/* for前台 預約修改功能 確認會員參數 */
function chk_reserve_member($r_id, $m_id){
	global $db;

	$tb1   = "`service_list` s";
	$tb2   = "`pet_list` p";
	$op   = "count(*)";
	$on    = "s.`pet` = p.`id`";
	$act  = " `owner` ='".$m_id."'";
	$act .= " AND s.`id` ='".$r_id."'";
	$act .= " AND s.`is_del` ='0'";
	// echo "SELECT $op FROM $tb1 LEFT JOIN $tb2 ON $on WHERE $act";die();
	$count = $db->getOne("SELECT $op FROM $tb1 LEFT JOIN $tb2 ON $on WHERE $act");
	if ($count == 0) {
		$msg = "You can't input invalid parameter.";
		die("<script>alert(\"".$msg."\");history.back();</script>");
	}

}

/* 會員點數支付確認 */
function chk_point($point){
	
	if ($point > 9) {//如果大於9點
		$result = true;
	}else{
		$result = false;
	}
	return $result;
}

/* for前台 預約功能 寵物查詢options生成 */
function pet_search_option($m_id, $pet_name= ""){
	global $db;

	if ($pet_name == "") {
		$pet_name = "none";
	}
	$tb = "pet_list";//寵物列表
	$op   = "name";
	$act  = " `owner` ='".$m_id."'";
	$act .= " AND `is_del` ='0'";
	// echo "SELECT $op FROM $tb WHERE $act ORDER BY id ASC";die();
	$data = $db->getAll("SELECT $op FROM $tb WHERE $act ORDER BY id ASC");
	foreach ($data as $val) {
    	$selected = "";//定義選取參數
    	/*判定是否帶有參數*/
    	if ($pet_name == $val['name']) {//如果有
    		$selected = "selected";//定義選取參數
    	}
    	$output .= '<option value="'.$val['name'].'" '.$selected.' >'.$val['name'].'</option>';//組出輸出字串
    }
    return $output;
}

/* 抓出會員點數(訂單參數) */
function member_point($s_id){
	global $db;
	$tb1 = "`service_list` s";//服務列表
	$tb2 = "`pet_list` p";//寵物列表
	$tb3 = "`member_list` m";//會員列表
	$op  = "m.`point`";
	$on1 = "s.`pet` = p.`id`";
	$on2 = "p.`owner` = m.`id`";
	$act = "s.`id` ='".$s_id."'";
	// echo "SELECT $op FROM $tb WHERE $act ORDER BY id ASC";die();
	$point = $db->getOne("SELECT $op FROM $tb1 LEFT JOIN $tb2 ON $on1 LEFT JOIN $tb3 ON $on2 WHERE $act");

    return $point;
}

/* 抓出會員點數(pet參數) */
function get_point($p_id){
	global $db;
	$tb1 = "`pet_list` p";//寵物列表
	$tb2 = "`member_list` m";//會員列表
	$op  = "m.`point`";
	$on  = "p.`owner` = m.`id`";
	$act = "p.`id` ='".$p_id."'";
	// echo "SELECT $op FROM $tb WHERE $act ORDER BY id ASC";die();
	$point = $db->getOne("SELECT $op FROM $tb1 LEFT JOIN $tb2 ON $on WHERE $act");

    return $point;
}

/* 抓出會員點數(member參數) */
function members_point($m_id){
	global $db;
	$tb = "`member_list`";//會員列表
	$op  = "`point`";
	$act = "`id` ='".$m_id."'";
	// echo "SELECT $op FROM $tb WHERE $act ORDER BY id ASC";die();
	$point = $db->getOne("SELECT $op FROM $tb WHERE $act");

    return $point;
}

/* 確認預計完成時間大於預約時間 */
function chk_reserve_date($r_time, $f_time){
	$r_time = strtotime($r_time);
	$f_time = strtotime($f_time);
	if ($r_time > $f_time) {
		$msg = "The reserve date is over than finish time, check it again.";
		die("<script>alert(\"".$msg."\");history.back();</script>");
	}
}

/* 加點數或扣點數判定 */
function service_done_action($pet, $price, $point_pay){

	$member = get_pet_owner($pet);//取得寵物主人
	if ($point_pay == "0") {//現金支付
		$point  = floor($price / 500);//計算獲取點數
		point_action($member,"0" , $point);//獲得點數
	}else{//點數支付
		point_action($member,"1" , 10);//扣除10點
	}

}

/* 返還點數處理 */
function service_done_cancel($s_id){
	global $db;
	
/* 抓出原本結算紀錄 start*/
	$tb    = "service_list";
	$op    = "finish_pay";
	$act   = "`id` = '" .$s_id. "'";
	$finish_pay_data = $db->getOne("SELECT $op FROM $tb WHERE $act");
/* 抓出原本結算紀錄 end*/
/*分解紀錄並存取需求變數 start*/
	$finish_pay = json_decode($finish_pay_data);
	$pet 	    = $finish_pay[0];//結算寵物
	$price 	    = $finish_pay[1];//結算金額
	$point_pay  = $finish_pay[2];//支付方式
	$member     = get_pet_owner($pet);//取得寵物主人
/*分解紀錄並存取需求變數 end*/
	if ($point_pay == "0") {//現金支付
		$point  = floor($price / 500);//計算點數
		point_action($member,"2" , $point);//返還獲得點數
	}else{//點數支付
		point_action($member,"3" , 10);//返還扣除的10點
	}
}

/* 處理點數 */
function point_action($m_id, $action, $point){
	global $db;
/*抓出會員現有點數 start*/
	$tb    = "member_list";
	$op    = "point";
	$act   = "`id` = '" .$m_id. "'";
	$member_point = $db->getOne("SELECT $op FROM $tb WHERE $act");
/*抓出會員現有點數 end*/
/*點數處理判定 start*/	
	switch ($action) {
		case "0"://會員使用現金支付,獲得點數
			$new_point = $member_point + $point;//加上應得點數
			break;
		case "1"://會員使用點數支付,會員扣除10點
			$new_point = $member_point - $point;//扣掉應扣點數
			break;
		case "2"://會員使用現金支付,取消結算需返還獲得點數
			$new_point = $member_point - $point;//返還獲得點數
			break;
		case "3"://會員使用點數支付,返還會員扣除的10點
			$new_point = $member_point + $point;//扣掉應扣點數
			break;
	}
/*點數處理判定 end*/
	$fix = "`point` = '" .$new_point. "'";//串進修改sql
	// die("UPDATE $tb SET $fix WHERE $act");
	$GLOBALS['db']->query("UPDATE $tb SET $fix WHERE $act");
}

/* 取得寵物主人 */
function get_pet_owner($p_id){
	global $db;
	$tb1 = "`pet_list` p";
	$tb2 = "`member_list` m";
	$op  = "m.`id`";
	$on  = "p.`owner` = m.`id`";
	$act = "p.`id` ='".$p_id."'";
	// echo "SELECT $op FROM $tb1 LEFT JOIN $tb2 ON $on WHERE $act";die();
	$data = $db->getOne("SELECT $op FROM $tb1 LEFT JOIN $tb2 ON $on WHERE $act");
	return $data;
}

?>