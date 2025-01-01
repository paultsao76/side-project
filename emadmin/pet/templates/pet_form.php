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
			   		<table bgcolor="white" class="table table-bordered" style="width: 50%;">
			   		  	<tbody>
			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>name</td>
			   		  			<td width="70%" align="left"><input type="text" name="name" id="name" class="insert" value="<?=$data['name']?>"></td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>gender</td>
			   		  			<td width="70%" align="left"><?=gender_option($data['gender'])?></td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>body shape</td>
			   		  			<td width="70%" align="left"><?=bs_option($data['body_shape'])?></td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>haired</td>
			   		  			<td width="70%" align="left"><?=haired_option($data['haired'])?></td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>owner</td>
			   		  			<td width="70%" align="left">
			   		  				filter：<input type="text" size="4" name="filter" id="filter" class="insert">
			   		  				<?=owner_option($data['owner'])?>
			   		  			</td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center">remark</td>
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
			   					<input type="hidden" id="old_owner" name="old_owner" value="<?=$data['owner']?>">
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
		var name 		= $("#name").val();//name
		var gender 		= $("#gender").val();//gender
		var body_shape  = $("#body_shape").val();//body shape
	    var haired      = $("#haired").val();//haired
	    var owner       = $("#owner").val();//owner

	    if (name == "") {
	    	alert("The 「name」 column is required.");
	    	$("#name").focus();
	    	return false;
	    }
	    if (gender == "none") {
	    	alert("The 「gender」 column is required.");
	    	$("#gender").focus();
	    	return false;
	    }
	    if (body_shape == "none") {
	    	alert("The 「body shape」 column is required.");
	    	$("#body_shape").focus();
	    	return false;
	    }
	    if (haired == "none") {
	    	alert("The 「haired」 column is required.");
	    	$("#haired").focus();
	    	return false;
	    }
	    if (owner == "none") {
	    	alert("The 「owner」 column is required.");
	    	$("#owner").focus();
	    	return false;
	    }
	    // alert("Here we go.");
	    // return false;
	}
</script>