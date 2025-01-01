<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
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
   
<!-- 頁首(上導覽列) -->
    <? include("../includes/header.php"); ?>
<!-- 內容開始 -->
   	<main class="container"  style="margin-top:70px;">
         <div  align="center">   
            <h1><?=$title?></h1>
         </div>
         <div class="post_area row align-items-center mx-auto" align="center">
         <!-- 迴圈執行輸出PO文內容 -->
      <? 
      if ($data_count != 0) {
         foreach ($data as $key => $val) {
               /*處理需要的變數 start*/
                  /*po文人判定*/
                  if ($val['publish'] != 0) {//會員PO的就把拉出的資料組出來
                     $publish = $val['first_name']." ".$val['last_name']." #".$val['publish'];
                  }else{
                     $publish = "administrator #0";//管理員PO的就直接顯示管理員
                  }
               /*處理需要的變數 end*/?>
            <div class="col-12 col-sm-12" style="margin-top:30px;">
               <div  class="post_title">
                  <?=$publish?>
               </div>
               <div  class="post_content" align="left">
                  <?=$val['content']?>
               </div>
               <img width="100%" height="400" title="" src="<?=$save_path?>/<?=$val['file']?>">
               <div  class="post_log">
                   posted at <?=$val['creat_date']?><br> 
                   by <?=$publish?>.
               </div>
               <hr>
            </div>

      <?}
         }else{?>
            <div  class="post_title col-12 col-sm-12" align="center">
                <h1>no post now.</h1>
            </div>
      <?}?>
            
            
               






         </div>
	   </main>
      <!-- 內容結束 -->
	   <!-- 頁尾 -->
	   <? include("../includes/footer.php"); ?>
</body>
</html>
