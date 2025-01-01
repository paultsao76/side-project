<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('application.php');
$menu_data   = $db->getAll("SELECT * FROM menu ORDER BY id ASC");//拉出menu資料
$haired_data = $db->getAll("SELECT * FROM haired_list ORDER BY id ASC");//拉出毛型態資料
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$CFG->title?></title>


<? include('includes/non_css.php'); ?>
<link href="css/aaa.css" rel="stylesheet" type="text/css">
	
</head>
<body>
   
<!-- 頁首(上導覽列) -->
    <? include("includes/header.php"); ?>
<!-- 內容開始 -->
   	<main class="container">
   		<!-- MenuTitle show-->
   		<div class="menu_title" align="center" style="margin-top: 50px;">
   			<h1>MENU</h1>  				
   		</div>
   		<!-- Menu show-->
   		<div class="menu_show" align="center">
   			<table class="table table-bordered">
			  <thead>
			    <tr align="center">
			      <th class="align-middle" scope="col">Body Size</th>
			      <th class="align-middle" scope="col">Minimum Weight</th>
			      <th class="align-middle" scope="col">Maximum Weight</th>
			      <th class="align-middle" scope="col">Bath</th>
			      <th class="align-middle" scope="col">Cut</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?
		  	foreach ($menu_data as $val) {?>
		  		<tr align="center">
			      <th class="align-middle" scope="row"><?=$val['body']?></th>
			      <td class="align-middle"><?=$val['w_min']?>KG</td>
			      <td class="align-middle"><?=$val['w_max']?>KG</td>
			      <td class="align-middle">NT$<?=$val['bath']?>UP</td>
			      <td class="align-middle">NT$<?=$val['cut']?>UP</td>
			    </tr>
		  	<?}?>
			  </tbody>
			</table>
   		</div>

   		<!-- HairedTitle show-->
   		<div class="haired_title" align="center" style="margin-top: 100px;">
   			<h1>Haired Type</h1>  				
   		</div>
   		<!-- HairedType show-->
   		<div class="haired_show" align="center" style="font-size: 20px;">
   			<table class="table table-bordered" style="width: 100px;">
			  <thead>
			    <tr>
			      <th class="align-middle" scope="col" width="50%" style="text-align: right;">#</th>
			      <th class="align-middle" scope="col" width="50%" >Type</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?
		  	foreach ($haired_data as $key => $val) {?>
		  		<tr>
			      <th class="align-middle" scope="row" width="50%" style="text-align: right;"><?=$key+=1;?></th>
			      <td class="align-middle" width="50%"><?=$val['type']?></td>
			    </tr>
		  	<?}?>
			  </tbody>
			</table>
   		</div>
   		<!-- RuleTitle show-->
   		<div class="rule_title" align="center" style="margin-top: 100px;">
   			<h1>Rule Description</h1>  				
   		</div>
   		<!-- Rule show-->
   		<div class="rule_show" align="left" style="font-size: 20px;">
   			<b>1.</b> Your doggy's body size is determine by weight, it will measure by "PET BOOK".<br><br>

   			<b>2.</b> The doggy's haired type is kind of three. Thoes are 「Short」, 「Long」 and 「special」. 

   			<ul>
   				<li>Maybe you need extra some NT dollars. The price is basic in menu , just for 「short haired」 type doggys.</li>
   				<li>It also determine by "PET BOOK", depends on the situation for doggy's haired of the day.</li>
   			</ul><br>

   			<b>3.</b>The service is kind of two. Thoes are 「Bath」 and 「Cut」.
			<ul>
   				<li>Bath - This service is take a bath for your doggy.</li>
   				<li>Cut  - This service is full body clean for your doggy. Contains 「Take a bath」, 「Trim the hair on the edge of the genitals」, 「Basic combing and Unknoting」, 「Sole hair trimming」, 「Trim nails」and 「Ear hair removal」.</li>
   			</ul><br>

   			<b>4.</b>If you buy our service, you can get points. 
   			<ul>
   				<li>Spend over NT$500 will get 1 point, spend over NT$1000 will get 2 points, and so on.</li>
   				<li>10 points can get 1 time free service.</li>
   			</ul><br>

   			





   			<b>We will description to you again on phone when we accept your reserve.</b>
   		</div>
	</main>
<!-- 內容結束 -->
	<!-- 頁尾 -->
	<? include("includes/footer.php"); ?>
</body>
</html>
