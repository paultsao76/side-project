<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../../application.php');
include_once('../includes/chk_login.php');//驗證是否登入
include_once('../../includes/non_css.php'); 

$CFG->headerlink = '../includes/em_headerlink.php';
$CFG->leftlink   = '../includes/em_leftnavlink.php';
$CFG->tb = "post_list";
$ME = "test2.php";
$CFG->limit = 10;
$CFG->width = "100%";



$file_new_name = "20241203040658.jpg";//定義新檔名
$save_path	   = $CFG->tmp_upload."/".$file_new_name;//傳送路徑
$chk = file_exists($save_path);//確認檔名是否重複
$type = get_debug_type($chk);
echo $chk."<br>";
echo $type."<br>";
// die();
if ($chk) {
	echo 'yes<br>';
}else{
	echo 'no<br>';
}
die('end');

?>

<!-- <form id="postform" action="<?=$ME?>" method="post" enctype="multipart/form-data">
	<input type="file" id="file" name="file"><br>
    <input type="submit" value="go">
</form> -->
