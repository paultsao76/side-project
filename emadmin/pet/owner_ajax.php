<?
include_once('../../application.php');
include_once('../includes/chk_login.php');//驗證是否登入

$error = 0;
$result = array();
$result['message'] = "";
if (!$_POST['pet_pass']) {
	$error = 1;
	$result['message'] = "You're accessing illegally.";
}

if ($error == 0) {
	$fil_key = $_POST['fil_key'];
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


echo json_encode($result);






?>