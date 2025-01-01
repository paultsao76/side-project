<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$CFG->em_title?></title>
<link href="<?=$CFG->wwwroot?>/css/admin.css" rel="stylesheet" type="text/css">
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
		        <table width="<?=$CFG->width?>" style="margin-top: 20px;margin-bottom: 10px;">
		        	<tbody>
		        		<tr>
		        			<td align="left">
		        				<button id="add"><?=$insert_button?></button>
					        	<button id="edit">edit</button>
					        	<button id="del">delete</button>
		        			</td>
		        			<td align="right">
		        				disable：
		        				<select id="disable" name="disable">
		        					<option value="none">--select one--</option>
		        					<option value="0">no disable</option>
		        					<option value="1">disable</option>
		        				</select>
		        				open：
		        				<select id="open" name="open">
		        					<option value="none">--select one--</option>
		        					<option value="0">no open</option>
		        					<option value="1">open</option>
		        				</select>
		        				group：
		        				<select id="group" name="group">
		        					<option value="none">--select one--</option>
		        					<option value="0">administrator</option>
		        					<option value="1">member</option>
		        				</select>
		        				Search Key：<input type="text" name="search_key" id="search_key" value="<?=$search_key?>">
		        				<button id="search">search</button>
		        			</td>
		        		</tr>
		        	</tbody>
		        </table>
		        <form id="postform">
			   		<table bgcolor="white" class="table table-bordered" style="width: <?=$CFG->width?>;">
			   		  	<thead align="center">
			   		  		<tr>
			   		  			<th width="2%">pick</th>
			   		  			<th width="3%">item</th>
			   		  			<th width="10%">publish</th>
			   		  			<th width="10%">file</th>
			   		  			<th>content</th>
			   		  			<th width="5%">open</th>
			   		  			<th width="5%">disable</th>
			   		  			<th width="10%">creat date</th>
			   		  		</tr> 
			   		  	</thead>
			   		  	<tbody align="center">
			   		  	<?
			   		  		if ($data_count == 0) {
			   		  			?>
			   		  			   <tr><td colspan="8">no data</td></tr>
			   		  			<?
			   		  		}else{
			   		  			foreach ($data as $key => $val) {			   	
			   		  				     $i+=1;
			   		  				     if ($val['publish'] != "0") {//定義PO文者
			   		  				     	 $publish = $val['first_name']." ".$val['last_name']."<br>(".$val['phone'].")";
			   		  				     }else{
			   		  				     	 $publish = "administrator";
			   		  				     } 
			   		  				?>
				   		  			    <tr>
				   		  			    	<td class="align-middle">
				   		  			    		<input type="checkbox" name="item[]" id="item" value="<?=$val['id']?>">
		   		  			    			</td>
				   		  			   	 	<td class="align-middle"><?=$i?></td>
				   		  			     	<td class="align-middle"><?=$publish?></td>
				   		  			   		<td class="align-middle"><img src="<?=$CFG->file_path?>/<?=$val['file']?>" alt="<?=$val['file']?>" width="100" height="100"></td>
				   		  			   		<td class="align-middle"><?=$val['content']?></td>
				   		  			   		<td class="align-middle"><?=($val['open']) ? "Y" : "N";?></td>
				   		  			   		<td class="align-middle"><?=($val['is_del']) ? "Y" : "N";?></td>
				   		  			   		<td class="align-middle"><?=$val['creat_date'];?></td>
				   		  				</tr>
				   		  			<?
			   		  			}
			   		  		}
			   		  	?>
			   		  	</tbody>
			   		</table>
			   		<div id="act_box"></div>
			   	</form>
			<!-- page欄 start -->
			   	<table width="<?=$CFG->width?>" style="margin-top: 20px;margin-bottom: 10px;">
		   			<tbody>
		   				<tr>
		   					<td align="center">
		   						<?=$page_select_display?>
		   					</td>
		   				</tr>
		   			</tbody>
		   		</table>
		   	<!-- page欄 end -->
		  	</main><br><br><br>
		</div>
	</div>
</div>
</body>
</html>

<script type="text/javascript">
	/*新增按鈕*/
	$("#add").click(function(){
		var url = '<?=$ME?>?act=add';
	    location.href = url;
	});

	/*修改按鈕*/
	$("#edit").click(function(){
	    var count = $("#item:checked").length;//選取項目數量
	    var item = $("#item:checked").val();//選取項目ID

	    /*檢查是否選取*/
	    if (count == 0) {
	    	alert("you should pick one item to edit.");
	    	return false;
	    }
	    /*檢查是否選取多餘1個*/
	    if (count > 1) {
	    	alert("you can't pick more than one item.");
	    	return false;
	    }
	    location.href = '<?=$ME?>?act=edit&id='+item;
	});

	/*刪除按鈕*/
	$("#del").click(function(){
	    var form  = $("#postform");//指定form
	    $("#act_box").append('<input type="hidden" name="act" id="act" value="del">');//指定後續動作
		var count = $("#item:checked").length;//選取項目數量
	  
		if  (count == 0){
			alert("you should pick at least one item to delete.");
			return false;
	    }else{
			Scheck = confirm("delete for sure?");
			if (Scheck==true){
				// alert("Here we go.");
				// return false;
				form.action = "<?=$ME?>";
				form.method = "post";
				form.submit();
				return true; 
			} 
		}  
	});

	/*搜尋按鈕*/
	defind_selected('disable', '<?=$disable?>');//是否禁用預設判定
	defind_selected('open', '<?=$open?>');//狀態選單預設判定
	defind_selected('group', '<?=$group?>');//群組選單預設判定
	$("#search").click(function(){
		var disable      = $("#disable").val();//搜索是否禁用
		var open      	 = $("#open").val();//搜索是否公開
		var group     	 = $("#group").val();//搜尋群組
		var search_key   = $("#search_key").val();//搜尋關鍵字

		var string = "";//連結字串定義
		var count = 0;//參數計數
		if  (disable != "none"){//如果有下禁用搜索
			var insert = chk_count(count);//參數數量確認
			string += insert+"disable="+disable;//組出字串
			count ++;//參數計數
	    }
	    if  (open != "none"){//如果有下公開搜索
			var insert = chk_count(count);//參數數量確認
			string += insert+"open="+open;//組出字串
			count ++;//參數計數
	    }
	    if  (group != "none"){//如果有下群組搜索
	    	var insert = chk_count(count);//參數數量確認
			string += insert+"group="+group;//組出字串
			count ++;//參數計數
	    }
	    if  (search_key != ""){//如果有下關鍵字搜索
	    	var insert = chk_count(count);//參數數量確認
			string += insert+"search_key="+search_key;//組出字串
			count ++;//參數計數
	    }
	    /*準備好連結字串*/
	    if  (string != ""){
			url = '<?=$ME?>?'+string;
	    }else{
	    	url = '<?=$ME?>';
	    }
	    location.href = url;//執行
	});

	/*頁碼選取*/
	$("#page").change(function(){
	    var page  	     = $("#page").val();//頁碼選取
	    var disable      = $("#disable").val();//搜索是否禁用
		var open      	 = $("#open").val();//搜索是否公開
		var group     	 = $("#group").val();//搜尋群組
		var search_key   = $("#search_key").val();//搜尋關鍵字

		/*處理其他查詢 start*/
		var string = "";//連結字串定義
		var insert = "&";
		if  (disable != "none"){//如果有下禁用搜索
			string += insert+"disable="+disable;//組出字串
	    }
	    if  (open != "none"){//如果有下公開搜索
			string += insert+"open="+open;//組出字串
	    }
	    if  (group != "none"){//如果有下群組搜索
			string += insert+"group="+group;//組出字串
	    }
	    if  (search_key != ""){//如果有下關鍵字搜索
			string += insert+"search_key="+search_key;//組出字串
	    }
	    /*處理其他查詢 end*/

	   	if  (string != ""){
	   		url = '<?=$ME?>?page='+page+string;
	    }else{
	    	url = '<?=$ME?>?page='+page;
		} 
		// alert(url);
		// return false;
		location.href = url;//執行
	});
</script>