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
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>first name</td>
			   		  			<td width="70%" align="left"><input type="text" name="first_name" id="first_name" class="insert" value="<?=$data['first_name']?>"></td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>last name</td>
			   		  			<td width="70%" align="left"><input type="text" name="last_name" id="last_name" class="insert" value="<?=$data['last_name']?>"></td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>phone</td>
			   		  			<td width="70%" align="left"><input type="text" name="phone" id="phone" class="insert" value="<?=$data['phone']?>"></td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>gender</td>
			   		  			<td width="70%" align="left">
			   		  				<select id="gender" name="gender" class="insert">
			   		  					<option value="none">--Select one--</option>
                  						<?=front_gd_option($data['gender']);?>
			   		  				</select>
			   		  			</td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td width="30%" align="center"><span style="color:red;">*</span>password</td>
			   		  			<td width="70%" align="left"><input type="password" name="password" id="password" class="insert" value="<?=$data['psd']?>"><button id="display1" style="margin-left: 10px;">show</button></td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td width="30%" align="center"><span style="color:red;">*</span>password again</td>
			   		  			<td width="70%" align="left"><input type="password" name="again" id="again" class="insert" value="<?=$data['psd']?>"><button id="display2" style="margin-left: 10px;">show</button></td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center">email</td>
			   		  			<td width="70%" align="left"><input type="text" name="email" id="email" class="insert" size="30" value="<?=$data['email']?>"></td>
			   		  		</tr>

			   		  	<?if ($next_act == "update") {?>
			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center">point</td>
			   		  			<td width="70%" align="left"><input class="insert" value="<?=$data['point']?>" disabled ></td>
			   		  		</tr>
			   		  	<?}?>
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
			   					<input type="hidden" name="old_phone" value="<?=$data['phone']?>">
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
	/*密碼隱藏顯示功能*/
	$("#display1, #display2").click(function(){
		var id 	 = $(this).attr('id');
		display_defind(id);//修改物件顯示
		return false;
	});

	function chk_form(form){
		var first_name = $("#first_name").val();//first name
		var last_name  = $("#last_name").val();//last name
	    var phone      = $("#phone").val();//phone
	    var gender     = $("#gender").val();//gender
	    var password   = $("#password").val();//password
	    var again      = $("#again").val();//password again
	    var email      = $("#email").val();//email

	    if (first_name == "") {
	    	alert("The 「first name」 column is required.");
	    	$("#first_name").focus();
	    	return false;
	    }
	    if (last_name == "") {
	    	alert("The 「last name」 column is required.");
	    	$("#last_name").focus();
	    	return false;
	    }
	    if (phone == "") {
	    	alert("The 「phone」 column is required.");
	    	$("#phone").focus();
	    	return false;
	    }
	    if (gender == "none") {
	    	alert("The 「gender」 column is required.");
	    	$("#gender").focus();
	    	return false;
	    }
	    if (password == "") {
	    	alert("The 「password」 column is required.");
	    	$("#password").focus();
	    	return false;
	    }
	    if (password != again) {
	    	alert("The 「password」 column and the 「password again」 column should input same.");
	    	$("#password").focus();
	    	return false;
	    }
	    if (email != "") {
	    	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		    if (!regex.test(email)) {
		    	alert("you should input correct e-mail format.");
		    	$("#email").focus();
		    	return false;
	    	}
	    }
	    // alert("Here we go.");
	    // return false;
	}
</script>