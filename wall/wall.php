<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../application.php');
$act = $_REQUEST['act'];
$CFG->$short_url = $CFG->wwwroot."/wall/";
$CFG->tb = "post_list";
$CFG->tmp_path  = $CFG->tmp_upload;//root圖片暫存路徑
$CFG->save_path = $CFG->post_upload;//root圖片上傳路徑
$CFG->file_path	= $CFG->post_file;//web圖片取得路徑

switch ($act) {
	case 'add':
		member_login_chk();//確認是否登入會員
		wall_add();//會員專區 FeelingWall新增頁面
		break;

	case 'insert':
		member_login_chk();//確認是否登入會員
		wall_insert($_REQUEST);//會員專區 FeelingWall新增功能
		break;

	case 'edit':
		member_login_chk();//確認是否登入會員
		wall_edit($_REQUEST);//會員專區 FeelingWall內容修改頁面
		break;

	case 'update':
		member_login_chk();//確認是否登入會員
		wall_update($_REQUEST);//會員專區 FeelingWall內容修改功能
		break;

	case 'del':
		member_login_chk();//確認是否登入會員
		wall_delete($_REQUEST);//會員專區 FeelingWall刪除功能
		break;

	case 'area':
		wall_area();//FeelingWall Area
		break;

	default:
		member_login_chk();//確認是否登入會員
		wall_list($_REQUEST);//會員專區 FeelingWall列表
		break;
}

/*會員專區 FeelingWall列表*/
function wall_list($form){
	global $CFG,$db;

	$area_title    = "Post List";
	$insert_button = "Add Post";
	$short_url     = $CFG->$short_url;

	$tb   = $CFG->tb;//貼文列表
	$op   = "*";
	$act  = " publish ='".$_SESSION['member']['id']."'";
	$act .= " AND `is_del` ='0'";
/* 關鍵字判定 start */
	// if ($form['search_key']) {
	// 	$act .= " AND (";
	// 	$act .= "`name` LIKE '%".string_filter($form['search_key'])."%'";
	// 	$act .= " )";
	// }
	// $search_key = $form['search_key'];
/* 關鍵字判定 end */

	// die("SELECT COUNT(*) FROM $tb WHERE $act"); 
	$data_count = $db->getOne("SELECT COUNT(*) FROM $tb WHERE $act");//取得資料筆數
	if ($data_count != 0) {//如果有資料
		$data   = $db->getAll("SELECT * FROM $tb WHERE $act");//讀取寵物資料
	}
	include_once('./templates/wall_list.php');
		
}


/*會員專區 FeelingWall新增頁面*/
function wall_add(){
	global $CFG,$db;

	$next_act   = "insert";
	$area_title = "Post Add";
	$file_link  = $CFG->sample_file."/no_file.png";
	$no_file_link  = $CFG->sample_file."/no_file.png";
	$file_title = "preview";
	include_once('./templates/wall_form.php');
}

/*新增貼文功能*/
function wall_insert($form){
	global $CFG, $db;

	$tb  = $CFG->tb;
/*新增變數定義 start*/
	$publish 	 = $_SESSION['member']['id'];//會員ID
	$is_upload 	 = string_filter($form['is_upload']);//上傳檔案檔名
	$content     = string_filter($form['content']);//文章內容
	$open     	 = $form['open'];//文章是否公開
	$creat_date	 = date("Y-m-d H:i:s");
/*新增變數定義 end*/
	$input = "`publish`, `file`, `content`, `open`, `creat_date`";//欄位定義
/*欄位值組裝 start*/
	$value  = "'".$publish."',";
	$value .= "'".$is_upload."',";
	$value .= "'".$content."',";
	$value .= "'".$open."',";
	$value .= "'".$creat_date."'";
/*欄位值組裝 end*/
	// echo "INSERT INTO $tb ($input) VALUES ($value)"."<br>";die();
	$GLOBALS['db']->query("INSERT INTO $tb ($input) VALUES ($value)");//先將資料存到資料庫
/*處理上傳圖片 start*/
	$tmp_path  = $CFG->tmp_path."/".$form['is_upload'];//暫存圖片路徑
	$save_path = $CFG->save_path."/".$form['is_upload'];//上傳圖片路徑
	// echo $tmp_path." 暫存圖片路徑<br>";
	// echo $save_path." 上傳圖片路徑<br>";
	// die('end');
	rename($tmp_path, $save_path);//傳送
/*處理上傳圖片 end*/
	$short_url     = $CFG->$short_url;
	die("<script>alert('add post success.');location.href='".$short_url."';</script>");
}

/*會員專區 FeelingWall內容修改頁面*/
function wall_edit($form){
	global $CFG, $db;

	$next_act = "update";
	$title = "Post Edit";
	$tb    = $CFG->tb;
	$op    = "*";
	$act   = "`id` =".$form['id'];
	$data = $db->getRow("SELECT $op FROM $tb WHERE $act");

	$file_link  = $CFG->file_path."/".$data['file'];
	$no_file_link  = $CFG->sample_file."/no_file.png";
	$file_title = $data['file'];

	include('./templates/wall_form.php');
}

/*會員專區 FeelingWall內容修改功能*/
function wall_update($form){
	global $CFG, $db;

	$short_url   = $CFG->$short_url;
	$tb  		 = $CFG->tb;
/*修改變數定義 start*/
	$id 		 = $form['id'];
	$content     = string_filter($form['content']);//文章內容
	$open     	 = $form['open'];//文章是否公開
/*修改變數定義 end*/
	$act		 = "`id` = '" .$id. "'";
/*欄位值組裝 start */
	$fix         = "`content` = '" .$content. "', ";
	$fix        .= "`open` = '" .$open. "'";
/*欄位值組裝 end */
/*額外判定是否新上傳圖片 start*/
if ($form['old_file'] != $form['is_upload'] AND $form['is_upload'] != "") {//判定有新上傳圖片後動作
	$is_upload 	 = string_filter($form['is_upload']);//上傳檔案檔名
	$fix   		.= ", `file` = '" .$is_upload. "'";//串進修改sql
	$tmp_path    = $CFG->tmp_path."/".$form['is_upload'];//暫存圖片路徑
	$save_path   = $CFG->save_path."/".$form['is_upload'];//上傳圖片路徑
	$old_path    = $CFG->save_path."/".$form['old_file'];//舊圖片路徑
	rename($tmp_path, $save_path);//傳送新圖片
	unlink($old_path);//刪除原本圖片檔案
}
/*額外判定是否新上傳圖片 end*/
	// echo $tmp_path." 暫存圖片路徑<br>";
	// echo $save_path." 上傳圖片路徑<br>";
	// echo $old_path." 舊圖片路徑<br>";
	// echo "UPDATE $tb SET $fix WHERE $act";die();
	$GLOBALS['db']->query("UPDATE $tb SET $fix WHERE $act");
	$message = "The post update success.";
	die("<script>alert(\"".$message."\");location.href='".$short_url."';</script>");
}

/*會員專區 FeelingWall刪除功能*/
function wall_delete($form){
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

/* FeelingWall Area*/
function wall_area(){
	global $CFG,$db;

	$title = "Feeling Wall";
	$op   = "p.`publish`, p.`file`, p.`content`, p.`content`, p.`creat_date`, m.`first_name`, m.`last_name`";
	$tb1  = "`post_list` p";//貼文列表
	$tb2  = "`member_list` m";//會員列表
	$on   = "p.`publish` = m.`id`";
	$act  = "p.`is_del` = '0'";
	$act .= " AND p.`open` = '1'";

	$data_count = $db->getOne("SELECT COUNT(*) FROM $tb1 LEFT JOIN $tb2 ON $on WHERE $act");//抓出資料筆數
	if ($data_count != 0) {//確認是否有資料, 有才撈
		$data = $db->getAll("SELECT $op FROM $tb1 LEFT JOIN $tb2 ON $on WHERE $act ORDER BY p.`id` ASC");
	}
	$save_path = $CFG->post_file;
	include_once('./templates/wall_area.php');
}

?>


