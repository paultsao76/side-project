<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../application.php');

$title = "Post Preview";

if ($_POST['is_upload'] == "" AND $_POST['old_file'] != "") {
    $file_path = $CFG->post_file."/".$_POST['old_file'];
}elseif($_POST['is_upload'] == $_POST['old_file']){
    $file_path = $CFG->post_file."/".$_POST['old_file'];
}else{
    $file_path = $CFG->tmp_file."/".$_POST['is_upload'];
}


?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$CFG->title?></title>


<? include('../includes/non_css.php'); ?>
<link href="<?=$CFG->wwwroot?>/css/aaa.css" rel="stylesheet" type="text/css">
	
</head>
<body>
   	<main class="container"  style="margin-top:70px;">
         <div  align="center">   
            <h1><?=$title?></h1>
         </div>
         <div class="post_area row align-items-center mx-auto" align="center">
            <div class="col-12 col-sm-12" style="margin-top:30px;">
               <div  class="post_content" align="left">
                  <?=$_POST['content']?>
               </div>
               <img width="100%" height="400" title="" src="<?=$file_path?>">
            </div>
         </div>
	   </main>
</body>
</html>
