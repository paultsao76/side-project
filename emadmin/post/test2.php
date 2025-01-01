<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../../application.php');
include_once('../includes/chk_login.php');//驗證是否登入
include_once('../../includes/non_css.php'); 

$CFG->headerlink = '../includes/em_headerlink.php';
$CFG->leftlink   = '../includes/em_leftnavlink.php';
$CFG->tb = "post_list";
$ME = "test.php";
$CFG->limit = 10;
$act = $_REQUEST['act']; 
$CFG->width = "100%";

// echo "Error: " . $_FILES["file"]["error"]."<br/>";
// echo "檔案名稱: " . $_FILES["file"]["name"]."<br/>"; 
// echo "檔案類型: " . $_FILES["file"]["type"]."<br/>";
// echo "檔案大小: " . ($_FILES["file"]["size"] / 1024)." Kb<br />";
// echo "暫存名稱: " . $_FILES["file"]["tmp_name"]; 
// die();
$save_path = "C:/xampp/htdocs/pet_book/team_img/".$_FILES["file"]["name"];
move_uploaded_file($_FILES["file"]["tmp_name"], $save_path);
$message = "done.";
die("<script>alert(\"".$message."\");location.href='".$ME."';</script>");








?>

