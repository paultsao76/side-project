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
		        <table width="50%" style="margin-top: 20px;margin-bottom: 10px; width:50%;">
		        	<tbody>
		        		<tr>
		        			<td align="left">
		        				<button id="add">新增位置</button>
					        	<button id="edit">修改</button>
					        	<button id="del">刪除</button>
		        			</td>
		        			<td align="right">
		        				關鍵字：<input type="text" name="search_key" id="search_key" value="<?=$search_key?>">
		        				<button id="search">搜尋</button>
		        			</td>
		        		</tr>
		        	</tbody>
		        </table>
		        <form id="postform">
			   		<table border="1" width="50%" bgcolor="white">
			   		  	<thead align="center">
			   		  		<tr>
			   		  			<th width="10%">選取</th>
			   		  			<th width="15%">項目</th>
			   		  			<th width="75%">位置名稱</th>
			   		  		</tr> 
			   		  	</thead>
			   		  	<tbody align="center">
			   		  	<?
			   		  		if ($data_count == 0) {
			   		  			?>
			   		  			   <tr><td colspan="3">目前沒有位置資料</td></tr>
			   		  			<?
			   		  		}else{
			   		  			foreach ($position_data as $key => $val) {
			   		  				     $key+=1;
			   		  				?>
				   		  			    <tr>
				   		  			    	<td width="10%"><input type="checkbox" name="item[]" id="item" value="<?=$val['id']?>"></td>
				   		  			   	 	<td width="15%"><?=$key?></td>
				   		  			     	<td width="75%"><?=$val['position_name']?></td>
				   		  				</tr>
				   		  			<?
			   		  			}
			   		  		}
			   		  	?>
			   		  	</tbody>
			   		</table>
			   		<div id="act_box"></div>
			   	</form>
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
	    	alert("請選取一個項目修改！");
	    	return false;
	    }
	    /*檢查是否選取多餘1個*/
	    if (count > 1) {
	    	alert("只能選取一個執行 [修改] 動作！");
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
			alert("請勾選欲刪除的項目!!");
			return false;
	    }else{
			Scheck = confirm("確定要刪除嗎？");
			if (Scheck==true){
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
			alert("請輸入欲搜尋 [關鍵字]!!");
			$("#search_key").focus();
			return false;
	    }else{
	    	location.href = '<?=$ME?>?search_key='+search_key;
		}  
	});
</script>