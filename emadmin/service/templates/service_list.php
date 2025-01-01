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
		        				point pay：
		        				<select id="point_pay" name="point_pay" style="text-align: center">
		        					<option value="none">-select one-</option>
		        					<option value="0">N</option>
		        					<option value="1">Y</option>
		        				</select>
		        				state：<?=finished_option($finished)?>
		        				reserve date：<input type="date" name="sea_date" id="sea_date" value="<?=$sea_date?>">
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
			   		  			<th width="5%">project</th>
			   		  			<th width="15%">pet</th>
			   		  			<th width="7%">extra</th>
			   		  			<th>state</th>
			   		  			<th width="10%">reserve date</th>
			   		  			<th width="10%">finish time</th>
			   		  			<th width="7%">total_price</th>
			   		  			<th width="2%">point pay</th>
			   		  			<th width="10%">creat date</th>
			   		  		</tr> 
			   		  	</thead>
			   		  	<tbody align="center">
			   		  	<?
			   		  		if ($data_count == 0) {
			   		  			?>
			   		  			   <tr><td colspan="11">no data</td></tr>
			   		  			<?
			   		  		}else{
			   		  			foreach ($data as $key => $val) {			   	
			   		  				     $i+=1;
			   		  				     $point_pay = ($val['point_pay']) ? "Y" : "N";
			   		  				?>
				   		  			    <tr>
				   		  			    	<td class="align-middle">
				   		  			    		<input type="checkbox" name="item[]" id="item" value="<?=$val['id']?>">
		   		  			    			</td>
				   		  			   	 	<td class="align-middle"><?=$i?></td>
				   		  			     	<td class="align-middle"><?=project_show($val['project'])?></td>
				   		  			   		<td class="align-middle">
				   		  			   			<?=$val['name']."<br>"?>
				   		  			   			<?="(".$val['first_name']." ".$val['last_name'].")<br>"?>
				   		  			   			<?="(".$val['phone'].")<br>"?>
				   		  			   		</td>
				   		  			   		<td class="align-middle"><?=$val['extra']?></td>
				   		  			   		<td class="align-middle"><?=state_show($val['state'])?></td>
				   		  			   		<td class="align-middle"><?=$val['reserve_date']?></td>
				   		  			   		<td class="align-middle"><?=$val['finish_time']?></td>
				   		  			   		<td class="align-middle"><?=$val['price']?></td>
				   		  			   		<td class="align-middle"><?=$point_pay?></td>
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
		  	</main>   
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

	defind_selected('point_pay', '<?=$p_pay?>');//是否點數支付預設判定
	/*搜尋按鈕*/
	$("#search").click(function(){
		var finished   = $("#finished").val();//進度搜索
		var sea_date   = $("#sea_date").val();//搜尋預約日期
		var search_key = $("#search_key").val();//搜尋關鍵字
		var point_pay  = $("#point_pay").val();//搜尋點數支付

		var string = "";//連結字串定義
		var count = 0;//參數計數
		if  (finished != "none"){//如果有下進度搜索
			var insert = chk_count(count);//參數數量確認
			string += insert+"finished="+finished;//組出字串
			count ++;//參數計數
	    }
	    if  (sea_date != ""){//如果有下預約日期搜索
	    	var insert = chk_count(count);//參數數量確認
			string += insert+"sea_date="+sea_date;//組出字串
			count ++;//參數計數
	    }
	    if  (search_key != ""){//如果有下關鍵字搜索
	    	var insert = chk_count(count);//參數數量確認
			string += insert+"search_key="+search_key;//組出字串
			count ++;//參數計數
	    }
	    if  (point_pay != "none"){//如果有下點數支付搜索
	    	var insert = chk_count(count);//參數數量確認
			string += insert+"point_pay="+point_pay;//組出字串
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
	    var page  = $("#page").val();//頁碼選取
	    var finished   = $("#finished").val();//進度搜索
		var sea_date   = $("#sea_date").val();//搜尋預約日期
		var search_key = $("#search_key").val();//搜尋關鍵字
		var point_pay  = $("#point_pay").val();//搜尋點數支付

		var string = "";//連結字串定義
		var insert = "&";
		if  (finished != "none"){//如果有下進度搜索
			string += insert+"finished="+finished;//組出字串
	    }
	    if  (sea_date != ""){//如果有下預約日期搜索
			string += insert+"sea_date="+sea_date;//組出字串
	    }
	    if  (search_key != ""){//如果有下關鍵字搜索
			string += insert+"search_key="+search_key;//組出字串
	    }
	    if  (point_pay != "none"){//如果有下點數支付搜索
			string += insert+"point_pay="+point_pay;//組出字串
	    }
	    /*準備好連結字串*/
	    if  (string != ""){
	   		url = '<?=$ME?>?page='+page+string;
	    }else{
	    	url = '<?=$ME?>?page='+page;
		} 
	    location.href = url;//執行
	});





</script>