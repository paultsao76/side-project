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
		        				Search Key：<input type="text" name="search_key" id="search_key" value="<?=$search_key?>">
		        				<button id="search">search</button>
		        			</td>
		        		</tr>
		        	</tbody>
		        </table>
		        <form id="postform">
			   		<table border="1" width="<?=$CFG->width?>" bgcolor="white">
			   		  	<thead align="center">
			   		  		<tr>
			   		  			<th>pick</th>
			   		  			<th>item</th>
			   		  			<th>first name</th>
			   		  			<th>last name</th>
			   		  			<th>phone</th>
			   		  			<th>email</th>
			   		  			<th>point</th>
			   		  			<th>remark</th>
			   		  			<th>creat date</th>
			   		  		</tr> 
			   		  	</thead>
			   		  	<tbody align="center">
			   		  	<?
			   		  		if ($data_count == 0) {
			   		  			?>
			   		  			   <tr><td colspan="9">no data</td></tr>
			   		  			<?
			   		  		}else{
			   		  			foreach ($data as $key => $val) {			   	
			   		  				     $i+=1;
			   		  				?>
				   		  			    <tr>
				   		  			    	<td>
				   		  			    		<input type="checkbox" name="item[]" id="item" value="<?=$val['id']?>">
		   		  			    			</td>
				   		  			   	 	<td><?=$i?></td>
				   		  			     	<td><?=$val['first_name']?></td>
				   		  			   		<td><?=$val['last_name']?></td>
				   		  			   		<td><?=$val['phone']?></td>
				   		  			   		<td><?=$val['email']?></td>
				   		  			   		<td><?=$val['point']?></td>
				   		  			   		<td><?=$val['remark']?></td>
				   		  			   		<td><?=$val['creat_date'];?></td>
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
		   						page <select name="page" id="page">
		   							<?=$page_select_display?>
		   						</select>
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

	/*搜尋按鈕*/
	$("#search").click(function(){
		var search_key = $("#search_key").val();//搜尋關鍵字

		if  (search_key == ""){
			location.href = '<?=$ME?>';
	    }else{
	    	location.href = '<?=$ME?>?search_key='+search_key;
		}  
	});

	/*頁碼選取*/
	$("#page").change(function(){
	    var page  = $("#page").val();//頁碼選取
	    var search_key  = $("#search_key").val();//關鍵字設定

	   	if  (search_key != ""){
	   		location.href = '<?=$ME?>?search_key='+search_key+'&page='+page;
	    }else{
	    	location.href = '<?=$ME?>?page='+page;
		}  
	});
</script>