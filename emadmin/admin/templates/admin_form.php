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
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>password</td>
			   		  			<td width="70%" align="left"><input type="password" name="password" id="password" class="insert" value="<?=$data['password']?>"><button id="display1" style="margin-left: 10px;">show</button></td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>password again</td>
			   		  			<td width="70%" align="left"><input type="password" name="again" id="again" class="insert" value="<?=$data['password']?>"><button id="display2" style="margin-left: 10px;">show</button></td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>level</td>
			   		  			<td width="70%" align="left">
			   		  				<?=level_option($data['level'])?>
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
			   					<input type="hidden" name="old_name" value="<?=$data['name']?>">
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

	$("#display1, #display2").click(function(){
		var id 	 = $(this).attr('id');
		display_defind(id);//修改物件顯示
		return false;
	});

	function chk_form(form){
		var name = $("#name").val();//name
	    var password = $("#password").val();//password
	    var again = $("#again").val();//password again
	    var level = $("#level").val();//level

	    if (name == "") {
	    	alert("The 「name」 column is required.");
	    	$("#name").focus();
	    	return false;
	    }
	    if (password == "") {
	    	alert("The 「password」 column is required.");
	    	$("#password").focus();
	    	return false;
	    }
	    if (again == "") {
	    	alert("The 「password again」 column is required.");
	    	$("#again").focus();
	    	return false;
	    }
	    if (level == "none") {
	    	alert("The 「level」 column is required.");
	    	$("#level").focus();
	    	return false;
	    }
	    if (password != again) {
	    	alert("The 「password」 column and the 「password again」 column should input same.");
	    	$("#password").focus();
	    	return false;
	    }
	    // alert("Here we go.");
	    // return false;
	}
</script>