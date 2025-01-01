<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../../application.php');
include_once('../includes/chk_login.php');//驗證是否登入
include_once('../../includes/non_css.php'); 

$CFG->headerlink = '../includes/em_headerlink.php';
$CFG->leftlink   = '../includes/em_leftnavlink.php';
$CFG->tb = "`post_list`";
$ME = "post.php";
$CFG->limit = 10;
$act = $_REQUEST['act']; 
$CFG->width = "100%";
$CFG->tmp_path  = $CFG->tmp_upload;
$CFG->save_path = $CFG->post_upload;
$CFG->file_path	= $CFG->post_file;//圖片路徑

switch ($act) {
	case 'add':
		post_add();//新增貼文畫面
		break;

	case 'insert':
		post_insert($_REQUEST);//新增貼文功能
		break;

	case 'edit':
		post_edit($_REQUEST);//修改貼文畫面
		break;

	case 'update':
		post_update($_REQUEST);//修改貼文功能
		break;

	case 'del':
		post_del($_REQUEST);//刪除貼文功能
		break;
	
	default:
		post_list($_REQUEST);//貼文列表
		break;
}


/*貼文列表*/
function post_list($form){
	global $CFG, $db, $ME;
	
	$title  = "Post List";
	$insert_button = "add post";
	$tb1 	= "`post_list` p";
	$tb2 	= "`member_list` m";
	$on1 	= "p.`publish` = m.`id`";
	$op     = "count(*)";
	$is_del = "0,1";
	$open   = "0,1";

/* 查詢禁用判定 start */
	if ($form['disable'] == "0") {
		$is_del = "0";
	}elseif($form['disable'] == "1"){
		$is_del = "1";
	}
	$act   = " p.`is_del` in (".$is_del.")";
	$disable = $form['disable'];//查詢禁用狀態
/* 查詢禁用判定 end */
/* 查詢公開判定 start */
	if ($form['open'] == "0") {
		$open = "0";
	}elseif($form['open'] == "1"){
		$open = "1";
	}
	$act .= " AND p.`open` in (".$open.")";
	$open = $form['open'];//查詢公開狀態
/* 查詢公開判定 end */
/* 群組查詢判定 start */
	if ($form['group'] == "0") {
		$act .= " AND p.`publish` = '0'";
	}elseif($form['group'] == "1"){
		$act .= " AND p.`publish` != '0'";
	}elseif($form['group'] == ""){
		$act .= "";
	}
	$group = $form['group'];//查詢群組
/* 群組查詢判定 end */
/* 關鍵字判定 start */
	if ($form['search_key']) {
		$act .= " AND (";
		$act .= "m.`first_name` LIKE '%".string_filter($form['search_key'])."%' OR ";
		$act .= "m.`last_name` LIKE '%".string_filter($form['search_key'])."%' OR ";
		$act .= "m.`phone` LIKE '%".string_filter($form['search_key'])."%'";
		$act .= " )";
	}
	$search_key = $form['search_key'];
/* 關鍵字判定 end */
	// echo "SELECT $op FROM $tb1 LEFT JOIN $tb2 ON $on1 WHERE $act";die();
	$data_count = $db->getOne("SELECT $op FROM $tb1 LEFT JOIN $tb2 ON $on1 WHERE $act");//抓出資料筆數

if ($data_count != 0) {
	$result = page_defind($form['page'], $CFG->limit);//目前頁數資料判定
	$op    = "p.*, m.`first_name`, m.`last_name`, m.`phone`";
	$data = $db->getAll("SELECT $op FROM $tb1 LEFT JOIN $tb2 ON $on1 WHERE $act ORDER BY p.`id` ASC LIMIT ".$result['limit']);
	/*做出頁數下拉選單*/
	$page_select_display = page_option($CFG->limit, $data_count, $result['page']);
}
	include_once('./templates/post_list.php');
}

/*新增貼文畫面*/
function post_add(){
	global $CFG, $ME;
	
	$next_act      = "insert";
	$title 	       = "Add Post";
	$file_link     = $CFG->sample_file."/no_file.png";
	$no_file_link  = $CFG->sample_file."/no_file.png";
	$file_title    = "preview";
	$disable_selected1 = "selected";
	$disable_selected2 = "";
	include('./templates/post_form.php');
}

/*新增貼文功能*/
function post_insert($form){
	global $CFG, $db, $ME;

	$tb  = $CFG->tb;
/*新增變數定義 start*/
	$publish 	 = 0;//從後台上的預設就是0
	$is_upload 	 = string_filter($form['is_upload']);//上傳檔案檔名
	$content     = string_filter($form['content']);//文章內容
	$open     	 = $form['open'];//是否公開
	$disable     = $form['disable'];//是否禁用
	$remark      = string_filter($form['remark']);//備註
	$creat_date	 = date("Y-m-d H:i:s");
/*新增變數定義 end*/
	$input = "`publish`, `file`, `content`, `open`, `is_del`, `remark`, `creat_date`";//欄位定義
/*欄位值組裝 start*/
	$value  = "'".$publish."',";
	$value .= "'".$is_upload."',";
	$value .= "'".$content."',";
	$value .= "'".$open."',";
	$value .= "'".$disable."',";
	$value .= "'".$remark."',";
	$value .= "'".$creat_date."'";
/*欄位值組裝 end*/
	// echo "INSERT INTO $tb ($input) VALUES ($value)"."<br>";die();
	$GLOBALS['db']->query("INSERT INTO $tb ($input) VALUES ($value)");//先將資料存到資料庫
/*處理上傳圖片 start*/
	$tmp_path  = $CFG->tmp_path."/".$form['is_upload'];//暫存圖片路徑
	$save_path = $CFG->save_path."/".$form['is_upload'];//上傳圖片路徑
	rename($tmp_path, $save_path);//傳送
/*處理上傳圖片 end*/
	die("<script>alert('add post success.');location.href='".$ME."';</script>");
}

/*修改貼文畫面*/
function post_edit($form){
	global $CFG, $db, $ME;

	$next_act = "update";
	$title = "Post Edit";
	$tb    = $CFG->tb;
	$op    = "*";
	$act   = "`id` =".$form['id'];
	$data = $db->getRow("SELECT $op FROM $tb WHERE $act");

	$disable_selected1 = "";
	$disable_selected2 = "";
	if ($data['is_del'] == "0") {
		$disable_selected1 = "selected";
	}else{
		$disable_selected2 = "selected";
	}

	$file_link  = $CFG->file_path."/".$data['file'];
	$no_file_link  = $CFG->sample_file."/no_file.png";
	$file_title = $data['file'];

	include('./templates/post_form.php');
}

/*修改貼文功能*/
function post_update($form){
	global $CFG, $db, $ME;

	$tb  = $CFG->tb;
/*修改變數定義 start*/
	$id = $form['id'];
	$content     = string_filter($form['content']);//文章內容
	$open     	 = $form['open'];//是否公開
	$disable     = $form['disable'];//是否禁用
	$remark      = string_filter($form['remark']);//備註
/*修改變數定義 end*/
	$act	= "`id` = '" .$id. "'";
/*欄位值組裝 start */
	$fix    = "`content` = '" .$content. "', ";
	$fix   .= "`open` = '" .$open. "', ";
	$fix   .= "`is_del` = '" .$disable. "', ";
	$fix   .= "`remark` = '" .$remark. "'";
/*欄位值組裝 end */
/*額外判定是否新上傳圖片 start*/
if ($form['old_file'] != $form['is_upload'] AND $form['is_upload'] != "") {//判定有新上傳圖片後動作
	$is_upload 	 = string_filter($form['is_upload']);//上傳檔案檔名
	$fix   .= ", `file` = '" .$is_upload. "'";//串進修改sql
	$tmp_path  = $CFG->tmp_path."/".$form['is_upload'];//圖片存放路徑
	$save_path = $CFG->save_path."/".$form['is_upload'];//上傳圖片路徑
	$old_path  = $CFG->save_path."/".$form['old_file'];//舊圖片路徑
	rename($tmp_path, $save_path);//傳送新圖片
	unlink($old_path);//刪除原本圖片檔案
}
/*額外判定是否新上傳圖片 end*/
	// echo $tmp_path."<br>";
	// echo $save_path."<br>";
	// echo $old_path."<br>";
	// echo "UPDATE $tb SET $fix WHERE $act";die();
	$GLOBALS['db']->query("UPDATE $tb SET $fix WHERE $act");
	$message = "the post update success.";
	die("<script>alert(\"".$message."\");location.href='".$ME."';</script>");
}

/*刪除貼文功能*/
function post_del($form){
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
	$message = "the post delete success.";
	die("<script>alert(\"".$message."\");location.href='".$ME."';</script>");
}
























?>

