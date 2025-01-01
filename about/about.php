<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../application.php');

$act = $_REQUEST['s']; 

switch ($act) {
	default:
		about_area();//AboutUs頁面
		break;
}




function about_area(){
	global $CFG;


	include_once('./templates/about_area.php');
}

?>


