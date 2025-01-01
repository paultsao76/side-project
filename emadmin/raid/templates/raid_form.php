<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$CFG->em_title?></title>
<link href="<?=$CFG->wwwroot?>/css/admin.css" rel="stylesheet" type="text/css">

<style type="text/css">
	td .insert{
		margin-left: 5px;
		margin-top: 5px;
		margin-bottom: 5px;
	}
</style>

</head>
<body>
<div class="container-fluid">	
    <!-- 上選單 -->	
    <?php include('../../includes/em_headerlink.php'); ?>
	<div class="row">	
		<!-- 左選單 -->
		<nav class="col-2 leftnav">		
		    <?php include('../../includes/em_leftnavlink.php'); ?>
		</nav>
	    <!-- 內容開始 -->
		<div class="col-10">
			<main>
		        <h3><?=$title?></h3>
		        <form name="postform" method="post" action="<?=$ME?>" onsubmit="return chk_form(postform);">
			   		<table border="2" bgcolor="white" width="50%" style="margin-top: 20px;margin-bottom: 10px;">
			   		  	<tbody>
			   		  		<tr>
			   		  			<td width="30%" align="center">天賦名稱</td>
			   		  			<td width="70%" align="left"><input type="text" name="talent_name" id="talent_name" class="insert" value="<?=$talent_data['talent_name']?>"></td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td width="30%" align="center">所屬職業</td>
			   		  			<td width="70%" align="left"><select name="classes_id" id="classes_id" class="insert"><?=$classes_select_display?></select></td>
			   		  		</tr>
			   		  	</tbody>
			   		</table>
			   		<table width="50%">
			   			<tr>
			   				<td align="center">
			   					<input type="submit" name="send" value="送出">
			   					<input type="hidden" name="act" value="<?=$next_act?>">
			   					<input type="hidden" name="id" value="<?=$talent_data['id']?>">
			   				</td>
			   			</tr>
			   		</table>
			   	</form>
		  	</main>   
		</div>
	</div>
</div>
</body>
</html>

<script type="text/javascript">
	function chk_form(form){
		var talent_name = $("#talent_name").val();//天賦名稱
	    var classes_id = $("#classes_id").val();//所屬職業

	    if (talent_name == "") {
	    	alert('請輸入 [ 天賦名稱 ] 欄位');
	    	$("#en_name").focus();
	    	return false;
	    }
	    if (classes_id == "0") {
	    	alert('請選擇 [ 所屬職業 ] 欄位');
	    	$("#classes_id").focus();
	    	return false;
	    }
	}
</script>