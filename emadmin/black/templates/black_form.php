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
    <? include($CFG->headerlink); ?>
	<div class="row">	
		<!-- 左選單 -->
		<nav class="col-2 leftnav">		
		    <? include($CFG->leftlink); ?>
		</nav>
	    <!-- 內容開始 -->
		<div class="col-10">
			<main>
		        <h3><?=$title?></h3>
		        
		        <table width="50%" style="margin-top: 20px;margin-bottom: 10px;">
		        	<tbody><tr><td align="right">The 「<span style="color:red;">*</span>」 is required.</td></tr></tbody>					
		        </table>	
		        <form name="postform" method="post" action="<?=$ME?>" onsubmit="return chk_form(postform);">
			   		<table bgcolor="white" class="table table-bordered" style="width:50%;">
			   		  	<tbody>
			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>member</td>
			   		  			<td width="70%" align="left">
			   		  				filter：<input type="text" size="4" name="filter" id="filter" class="insert">
			   		  				<?=owner_option($data['member'])?>
			   		  			</td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>remark</td>
			   		  			<td width="70%" align="left">
			   		  				<textarea name="remark" id="remark" class="insert" rows="6" cols="50"><?=$data['remark']?></textarea>
			   		  			</td>
			   		  		</tr>
			   		  	</tbody>
			   		</table>
			   		<table width="50%">
			   			<tr>
			   				<td align="center">
			   					<input type="submit" name="send" value="submit">
			   					<input type="hidden" name="act" value="<?=$next_act?>">
			   					<input type="hidden" name="id" value="<?=$data['id']?>">
			   					<input type="hidden" id="old_owner" name="old_owner" value="<?=$data['member']?>">
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

	/*過濾器動作*/
	$('#filter').on('input',function(e){
		var fil_key    = $(this).val();//filter_key
		var old_owner  = $("#old_owner").val();//old_owner
		owner_ajax(fil_key, old_owner);
	});

	function chk_form(form){
		var owner  = $("#owner").val();//member
		var remark = $("#remark").val();//remark

	    if (owner == "none") {
	    	alert("The 「member」 column is required.");
	    	$("#owner").focus();
	    	return false;
	    }
	    if (remark == "") {
	    	alert("The 「remark」 column is required.");
	    	$("#remark").focus();
	    	return false;
	    }
	    // alert("Here we go.");
	    // return false;
	}
</script>