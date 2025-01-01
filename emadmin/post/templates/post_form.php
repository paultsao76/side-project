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
		        
		        <table width="70%" style="margin-top: 20px;margin-bottom: 10px;">
		        	<tbody><tr><td align="right">The 「<span style="color:red;">*</span>」 is required.</td></tr></tbody>					
		        </table>	
		        <form name="postform" method="post" action="<?=$ME?>" enctype="multipart/form-data" onsubmit="return chk_form(postform);">
			   		<table bgcolor="white" class="table table-bordered" style="width: 70%;">
			   		  	<tbody>
		   		  	  <?
		   		  		if ($next_act == "update" ) {//只有修改畫面才秀出發布人?>
		   		  			<tr>
			   		  			<td class="align-middle" width="30%" align="center">publish</td>
			   		  			<td width="70%" align="left">
			   		  				<p class="insert"><?=publish_show($val['publish'])?></p>
			   		  			</td>
			   		  		</tr>
		   		  	  <?}?>
		   		  	  		<!-- 圖片上傳區域,含有預覽圖片功能 start -->
			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>file</td>
			   		  			<td width="70%" align="left">
			   		  				<input type="file" name="file" id="file" multiple="multiple" accept="image/*" class="insert" value="<?=$data['file']?>"><br>
			   		  				<input type="button" value="upload" onclick="upload_pic('file', 'is_upload', 'up_file','<?=$CFG->tmp_upload?>', '<?=$CFG->tmp_file?>')">
			   		  				<input type="button" value="pic_del" onclick="pic_del('is_upload', 'up_file', '<?=$CFG->tmp_upload?>', '<?=$no_file_link?>')">
			   		  				<input type="hidden" id="old_file" name="old_file" value="<?=$data['file']?>">
			   		  				<input type="hidden" id="is_upload" name="is_upload" value="<?=$data['file']?>">
									<img id = "up_file" name = "up_file" width="100" height="100" title="<?=$file_title?>" src="<?=$file_link?>" align="right">
			   		  			</td>
			   		  		</tr>
			   		  		<!-- 圖片上傳區域,含有預覽圖片功能 end -->

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>content</td>
			   		  			<td width="70%" align="left">
			   		  				<textarea name="content" id="content" class="insert" rows="12" cols="95"><?=htmlentities($data['content'])?></textarea>
			   		  			</td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center">preview</td>
			   		  			<td width="70%" align="left">
			   		  				<button id="preview" class="insert" onclick="return view();">preview</button>
			   		  			</td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>open</td>
			   		  			<td width="70%" align="left">
			   		  				<select id="open" name="open" class="insert" style="text-align: center;">
			   		  					<option value="none">--Select one--</option>
                  						<?=post_open_option($data['open']);?>
			   		  				</select>
			   		  				<span style="color:red;margin-left: 5px;">N：no open , Y：open</span>
			   		  			</td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center"><span style="color:red;">*</span>disable</td>
			   		  			<td width="70%" align="left">
			   		  				<select id="disable" name="disable" class="insert" style="text-align: center;">
			   		  					<option value="0" <?=$disable_selected1?> >N</option>
                  						<option value="1" <?=$disable_selected2?> >Y</option>
			   		  				</select>
			   		  				<span style="color:red;margin-left: 5px;">N：no disable , Y：disable</span>
			   		  			</td>
			   		  		</tr>

			   		  		<tr>
			   		  			<td class="align-middle" width="30%" align="center">remark</td>
			   		  			<td width="70%" align="left">
			   		  				<textarea name="remark" id="remark" class="insert" rows="12" cols="95"><?=$data['remark']?></textarea>
			   		  			</td>
			   		  		</tr>
			   		  	</tbody>
			   		</table>
			   		<table width="70%">
			   			<tr>
			   				<td align="center">
			   					<input type="submit" name="send" value="submit">
			   					<input type="hidden" name="act" value="<?=$next_act?>">
			   					<input type="hidden" name="id" value="<?=$data['id']?>">
			   					<input type="hidden" id="old_publish" name="old_publish" value="<?=$data['publish']?>">
			   				</td>
			   			</tr>
			   		</table>
			   	</form>
			   	<form id="preview_form" action="../../wall/wall_preview.php" method="post" target="_blank">
			   	</form>
		  	</main><br><br><br>    
		</div>
	</div>
</div>
</body>
</html>

<script src="../../js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">

	CKEDITOR.replace("content");//啟用editor

	function chk_form(form){
		var is_upload 	 = $("#is_upload").val();//紀錄上傳檔案檔名
		var content 	 = CKEDITOR.instances['content'].getData();//content
		var open  	     = $("#open").val();//open
		var disable  	 = $("#disable").val();//disable
		var old_file  	 = $("#old_file").val();//old_file

	    if (is_upload == "" && old_file == "") {
	    	alert("choose you wanna upload picture.");
	    	$("#file").focus();
	    	return false;
	    }
	    if (content == "") {
	    	alert("The 「content」 column is required.");
	    	$("#content").focus();
	    	return false;
	    }
	    if (open == "none") {
	    	alert("The 「open」 column is required.");
	    	$("#open").focus();
	    	return false;
	    }
	    if (disable == "") {
	    	alert("The 「disable」 column is required.");
	    	$("#disable").focus();
	    	return false;
	    }
	    // alert("Here we go.");
	    // return false;
	}
</script>