<?
session_start(); 
/*引入設定檔*/
include_once('connectadmin/ver_script.php'); 
include_once('connectadmin/cls_mysql.php');
include_once('functions/common.php');//引入公用函式庫
include_once('functions/pet_book.php');//引入公用函式庫
$db = new cls_mysql($db_host, $db_user, $db_pw, $database);//連接資料庫


/* define a generic object */
class CFG {};
$CFG = new CFG;

$s_host = "http://localhost/pet_book";
$CFG->wwwroot = $s_host;
$CFG->back_wwwroot = $s_host."/emadmin";
$CFG->root = "C:/xampp/htdocs";

$CFG->title = "PET BOOK";
$CFG->em_title = "PET BOOK-Website Management System";
$CFG->MemberArea = ($_SESSION['member']) ? $_SESSION['member']['first_name']." ".$_SESSION['member']['last_name'] : "Member Area" ;//確認是否登入


/*圖片取得路徑*/
$CFG->sample_file = $CFG->wwwroot."/images/sample";//樣本圖片取得路徑
$CFG->tmp_file    = $CFG->wwwroot."/images/tmp";//暫存圖片取得路徑
$CFG->post_file   = $CFG->wwwroot."/images/save/post";//貼文圖片取得路徑


/*圖片上傳路徑*/
$CFG->tmp_upload   = $CFG->root."/pet_book/images/tmp";//暫存圖片上傳路徑
$CFG->post_upload  = $CFG->root."/pet_book/images/save/post";//貼文圖片上傳路徑


/*email資訊*/
$CFG->email 	 = "my email";//發件帳號
$CFG->email_psd  = "my password";//發件密碼
$CFG->email_name = "Pet Book";//發件名稱

?>