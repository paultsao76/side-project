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
   	<main class="container"  style="font-size: 20px;">
   		<!-- AboutUsTitle show-->
   		<div class="about_title" align="center" style="margin-top: 100px;">
   			<h1>About Us</h1>  				
   		</div>
   		<!-- Rule show-->
   		<div class="about_show" align="left">
	   			<p>
	   				Hey! Every one. This is Pet Book. We supply service for your doggy. 
	   			  Or you want share your feeling, and your baby pet feeling on the 「feeling wall」, now.
	   			  It's OK! Here you go! If you have any demand, welcome use this platform a lot.
	   			</p> 
	   			  <p>AND if you don't understand the description on front page, and you want know something about us more, you can contact us.</p>
   		</div>
   		<hr style="margin-top: 100px;">
   		<!-- PicAreaTitle show-->
   		<div class="about_title" align="center" style="margin-top: 100px;">
   			<h1>The Dog In Pet Book</h1>  				
   		</div>
   		<div class="pic_show row align-items-center" align="center" style="margin-top: 70px; text-indent: 20px;">
   			<div class="col-12 col-sm-6">
   				<img width="300" height="300" title="" src="<?=$CFG->sample_file?>/dobby.jpg">
   			</div>
   			<div  class="col-12 col-sm-6" align="left">
   				 Hey! This is dobby. He is a boy dog.
   				 And he is approachable.<br>
   				 If you play with him , he will happy and crazy play with you.<br>
   				 Sometimes he will appear in PET BOOK.
   			</div>

   			<div class="col-12 col-sm-6" style="margin-top: 70px;">
   				<img width="300" height="300" title="" src="<?=$CFG->sample_file?>/enen.jpg">
   			</div>
   			<div  class="col-12 col-sm-6" align="left">
   				 Hey! This is enen. She is a girl dog.
   				 And she is timid and shy.<br>
   				 If you want play with her , maybe you can take a pet snacks for her , she is a greedy dog.<br>
   				 Sometimes she also appear in PET BOOK, And when you have pet snacks , she will be crazy.
   			</div>
   		</div>
	</main>
<!-- 內容結束 -->
	<!-- 頁尾 -->
	<? include("../includes/footer.php"); ?>
</body>
</html>
