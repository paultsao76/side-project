<?
include_once('../../functions/pet_book.php');
include_once('../../application.php');
// include_once('../includes/chk_login.php');//驗證是否登入

$act = $_POST['act']; 
$error = 0;
$result = array();
$result['message'] = "";



if (!$_POST['act']) {
	$error = 1;
	$result['message'] = "You're accessing illegally.";
}


if ($error == 0) {
	switch ($act) {
		case 'pet_ajax':
			pet_ajax($_POST);//寵物選單生成
			break;

		case 'owner_ajax':
			owner_ajax($_POST);//主人選單生成
			break;

		case 'total_price':
			total_price($_POST);//計算總價
			
			break;
		case 'upload_pic':
			upload_pic($_POST);//預覽圖片
			break;

		case 'pic_del':
			pic_del($_POST);//刪除圖片
			break;

		default:
			break;
	}
}

/*寵物選單生成*/
function pet_ajax($form){
	global $db, $result;
	$owner = $_POST['owner'];
	$tb   = "pet_list";
	$op   = "id, name, body_shape, haired";//ID, 寵物名, 體型, 毛型
	$act  = "owner ='".$owner."'";
	$data = $db->getAll("SELECT $op FROM $tb WHERE $act ORDER BY id ASC");
/* 組出option新增字串 start */
	$output = '<option value="none" >-------select one-------</option>';
	foreach ($data as $val) {
		// $output .= "<option value=\"".$val['id']."\" >".$val['name']."</option>";
		$output .= '<option value="'.$val['id'].'" '.$selected.' >'.$val['name'].'('.bs_show($val['body_shape']).', '.haired_show($val['haired']).')'.'</option>';
	}
/* 組出option新增字串 end */
		$result['output'] = $output;
}

/*主人選單生成*/
function owner_ajax($form){
	global $db, $result;
	$fil_key = $form['fil_key'];
	$tb   = "member_list";
	$op   = "id, first_name, last_name, phone";//ID, 姓, 名, 電話

	if ($fil_key == "") {//如果沒下過濾條件
		$sql = "SELECT $op FROM $tb ORDER BY id ASC";
	}else{//如果有下過濾條件
		$act  = "first_name LIKE '%".$fil_key."%' OR ";
		$act .= "last_name LIKE '%".$fil_key."%' OR ";
		$act .= "phone LIKE '%".$fil_key."%'";
		$sql = "SELECT $op FROM $tb WHERE $act ORDER BY id ASC";
	}
		$data = $db->getAll($sql);
	/* 組出option新增字串 start */
		$output = '<option value="none" >-------select one-------</option>';
		foreach ($data as $val) {
			$output .= "<option value=\"".$val['id']."\" >".$val['first_name']." ".$val['last_name']."(".$val['phone'].")"."</option>";
		}
	/* 組出option新增字串 end */
	$result['output'] = $output;
}


/*計算總價*/
function total_price($form){
	global $db, $result;
	$project = $form['project'];//選擇服務
	$pet  	 = $form['pet'];//寵物ID
	$extra   = $form['extra'];//額外價
	
	$pet_data 	 = pet_data($form['pet']);//取得寵物資料

	if ($pet_data['body_shape'] == "" OR $pet_data['haired'] == "" ) {//確認寵物資料是否齊全
		$error = 1;
		$message = "The pet's 「body shape」 or 「haired」 column data is null , input thoes and try again.";
		$result['message'] = $message;//回傳訊息
	}

	if ($error != 1) {
		$basic_price = basic_price($pet_data['body_shape'], $project);//基本價格
		$total_price = $basic_price + $extra;//總價計算
		$result['total_price'] = $total_price;//總價
		$result['item'] = "total price = basic price(".$basic_price.") + extra price(".$extra.") = ".$total_price;//計算項目
		$result['output'] = pet_option_reset($pet_data['owner'], $form['pet']);//寵物選單重置
	}	
}

/*預覽圖片*/
function upload_pic($form){
	global $error, $result;
	
	if (!$_FILES["file"]) {//如果沒選擇圖片
		$error = 1;
		$message = "choose you wanna upload picture.";//錯誤訊息
	}
	if ($error == 0) {//沒錯誤才執行
		$file_data     = $_FILES["file"];//圖片資訊
		$tmp_path 	   = $file_data["tmp_name"];//取得暫存路徑
		$ext 		   = end(explode('.', $file_data["name"]));//取得副檔名
		$new_name      = date("YmdHis");
		$file_new_name = $new_name.".".$ext;//定義新檔名
		$save_path	   = $form['save_path']."/".$file_new_name;//傳送路徑
		$chk = file_exists($save_path);//確認檔名是否重複
		$count = ($chk) ? 1 : 0;
		while ( $count == 1) {//如果有重複
			$new_name++;//檔名數字串+1處理
			$save_path = $form['save_path']."/".$new_name.".".$ext;//組出新傳送參數
			$chk_again = file_exists($save_path);//再次確認檔名是否重複
			$count = ($chk_again) ? 1 : 0;
		}
		move_uploaded_file($tmp_path, $save_path);//傳送
		unlink($tmp_path);//砍掉暫存
		$message = "upload success.";//成功訊息
		$result['new_name'] = $new_name.".".$ext;//回傳新檔名
	}
	$result['message'] = $message;//回傳訊息
	$result['error']   = $error;//回傳是否錯誤
}

/*刪除圖片*/
function pic_del($form){
	global $result;

	$file_name = $form['file_name'];//暫存檔名
	$done = 0;//是否執行
	if ($file_name != "") {//有暫存才執行
		$save_path = $form['save_path'];//暫存資料夾
		$del_path = $save_path."/".$form['file_name'];//執行目標
		unlink($del_path);//砍掉暫存
		$message = "picture delete success.";//成功訊息
		$done++;//已執行
	}
	$result['message'] = $message;//回傳訊息
	$result['done'] = $done;//回傳訊息
}

echo json_encode($result);






	






?>