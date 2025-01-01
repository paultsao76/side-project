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
		        
		        <table width="90%" style="margin-top: 20px;margin-bottom: 10px;">
		        	<tbody><tr><td align="right">The 「<span style="color:red;">*</span>」 is required.</td></tr></tbody>					
		        </table>	
		        <form name="postform" method="post" action="<?=$ME?>" onsubmit="return chk_form(postform);">
			   		<table bgcolor="white" class="table table-bordered" style="width: 90%;">
			   		  	<tbody>
			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>project</td>
			   		  			<td width="70%" align="left"><?=project_option($data['project'])?></td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>pet</td>
			   		  			<td width="70%" align="left">
			   		  				owner：<input type="text" size="2" name="filter" id="filter" class="insert">
			   		  				<?=owner_option($owner)?>
			   		  				<?=pet_option($owner, $data['pet'])?>
			   		  				<a id="dog_data" name="dog_data" href="<?=$dog_href?>" title="dog_data" target="_blank"><?=$dog_text?></a>
			   		  			</td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>extra</td>
			   		  			<td width="70%" align="left"><input type="text" name="extra" id="extra" class="insert" value="<?=$data['extra']?>"></td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center">remark</td>
			   		  			<td width="70%" align="left">
			   		  				<textarea name="remark" id="remark" class="insert" rows="6" cols="50"><?=$data['remark']?></textarea>
			   		  			</td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>state</td>
			   		  			<td width="70%" align="left"><?=service_state_option($data['state'])?></td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>reserve date</td>
			   		  			<td width="70%" align="left">
			   		  				<input type="datetime-local" name="reserve_date" id="reserve_date" class="insert" value="<?=$data['reserve_date']?>">
			   		  			</td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>finish time</td>
			   		  			<td width="70%" align="left">
			   		  				<input type="datetime-local" name="finish_time" id="finish_time" class="insert" value="<?=$data['finish_time']?>">
			   		  			</td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>price</td>
			   		  			<td width="70%" align="left">
			   		  				<div id="check_box" name="check_box" style="color:red;"><?=$total_text?></div>
			   		  				<?=price_column($data['price'])?>
			   		  				<button type="button" id="check" name="check">check</button>
			   		  				<input type="hidden" id="is_check" name="is_check" value="<?=$is_ckeck?>">
			   		  			</td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center">point pay</td>
			   		  			<td width="70%" align="left">
			   		  				<input type="checkbox" name="point_pay" id="point_pay" class="insert" value="1" <?=$point_checked?> > use point
			   		  			</td>
			   		  		</tr>

			   		  	</tbody>
			   		</table>
			   		<table width="90%">
			   			<tr>
			   				<td align="center">
			   					<input type="submit" name="send" value="submit">
			   					<input type="hidden" name="act" value="<?=$next_act?>">
			   					<input type="hidden" name="id" value="<?=$data['id']?>">
			   					<input type="hidden" id="old_owner" name="old_owner" value="<?=$owner?>">
			   					<input type="hidden" id="old_pet" name="old_pet" value="<?=$data['pet']?>">
			   					<input type="hidden" id="old_state" name="old_state" value="<?=$data['state']?>">
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

	/*服務選單動作*/
	$('#project').bind('change',function(e){
		reset_price();/*重置總價*/
	});

	/*過濾器動作*/
	$('#filter').on('input',function(e){
		var fil_key    = $(this).val();//filter_key
		var old_owner  = $("#old_owner").val();//old_owner
		var old_pet    = $("#old_pet").val();//old_pet
		var pet_switch = 1;//判定是否有寵物選單
		var url = "<?=$CFG->back_wwwroot?>/pet/pet.php?act=edit&id=";//寵物data路徑
		owner_ajax(fil_key, old_owner, old_pet, pet_switch, url);
		reset_price();/*重置總價*/
	});

	/*加購價動作*/
	$('#extra').on('input',function(e){
		reset_price();/*重置總價*/
	});

	/*主人選單動作*/
	$('#owner').bind('change',function(e){
		var owner 	= $(this).val();//owner
		var old_pet = $("#old_pet").val();//old_pet
		pet_ajax(owner, old_pet);
		reset_price();/*重置總價*/
	});

	/*寵物選單動作*/
	$('#pet').bind('change',function(e){
		var pet 	= $(this).val();//pet
		if (pet != "none") {
			url = "<?=$CFG->back_wwwroot?>/pet/pet.php?act=edit&id="+pet;
	    	$("#dog_data").attr("href", url);
	    	$("#dog_data").text("dog_data");
	    }else{
	    	$("#dog_data").attr("href", "");
	    	$("#dog_data").text("");
	    }
	    reset_price();/*重置總價*/
	});

	/*確認總價*/
	$('#check').bind('click',function(e){
		var project = $('#project').val();//project
		var pet     = $('#pet').val();//pet
		var extra   = $('#extra').val();//extra
		if (project == "none") {//先檢查服務選了沒
	    	alert("The 「project」 column is required.");
	    	return false;
	    }
		if (pet == "none") {//再檢查選寵物了沒
	    	alert("The 「pet」 column is required.");
	    	return false;
	    }
	    if (extra == "") {//再檢查輸入額外價了沒
	    	alert("The 「extra」 column is required.");
	    	return false;
	    }
	    if (isNaN(extra)) {//再檢查額外價是否為數字
	    	alert("The 「extra」 column should  be number.");
	    	return false;
	    }
	    // alert("Here we go.");
	    // return false;
	    total_price(project, pet, extra);//計算總價
	    return false;
	});

	function chk_form(form){
		var project 	 = $("#project").val();//project
		var pet  	   	 = $("#pet").val();//pet
	    var extra 		 = $("#extra").val();//extra
	    var state 		 = $("#state").val();//state
	    var reserve_date = $("#reserve_date").val();//reserve date
	    var finish_time  = $("#finish_time").val();//finish time
	    var price 		 = $("#price").val();//price

	    if (project == "none") {//檢查服務選單
	    	alert("The 「project」 column is required.");
	    	$("#project").focus();
	    	return false;
	    }
	    if (pet == "none") {//檢查寵物選單
	    	alert("The 「pet」 column is required.");
	    	$("#pet").focus();
	    	return false;
	    }
	    if (extra == "") {//檢查額外價欄位
	    	alert("The 「extra」 column is required.");
	    	$("#extra").focus();
	    	return false;
	    }
	    if (isNaN(extra)) {//再檢查額外價是否為數字
	    	alert("The 「extra」 column should  be number.");
	    	return false;
	    }
	    if (state == "none") {//檢查訂單狀態選單
	    	alert("The 「state」 column is required.");
	    	$("#state").focus();
	    	return false;
	    }
	    if (reserve_date == "") {//檢查送店日期欄位
	    	alert("The 「reserve date」 column is required.");
	    	$("#reserve_date").focus();
	    	return false;
	    }
	    if (finish_time == "") {//檢查預估完成時間欄位
	    	alert("The 「finish time」 column is required.");
	    	$("#finish_time").focus();
	    	return false;
	    }
	    if (price == "0") {//檢查總價欄位
	    	alert("You should check price.");
	    	return false;
	    }
	    $('#price').attr('disabled', false);//總價欄解鎖
	    // alert("Here we go.");
	    // return false;
	}
</script>