/*主人選單生成*/
function owner_ajax(key, old_owner="", old_pet="", pet_switch=0, url=""){
		var fil_key    = key;//filter_key
		// var old_owner  = old_owner;//old_owner
		$("#owner").empty();
	 	$.ajax({	 			
                url: "../ajax/process.php",
                type: "POST",
                dataType: "json",
                data: {
                		fil_key    : fil_key,
                		act    	   : "owner_ajax",
                },
                success: function(data) {
                				if(data.message != ""){//有出錯就輸出訊息
                					alert(data.message);
                				}else{//沒出錯做該做的事
                					$("#owner").append(data.output);//塞入後端拉到的資料
                					if(old_owner != ""){//鎖定原本主人
	                					$('#owner option[value='+old_owner+']').attr('selected', 'selected');	                		
	                				}
	                				var now_owner = $("#owner").val();//主人選單目前選取	                				
	                				if (pet_switch != 0 && now_owner == "none") {//有寵物選單時,過濾器改動處理
	                					$('#pet option[value=none]').attr('selected', 'selected');
	                					$('#pet').attr('disabled', true);
	                					$("#dog_data").attr("href", "");//清掉寵物data連結
	    								$("#dog_data").text("");//清掉寵物data連結
	                				}else{
	                					pet_ajax(now_owner, old_pet);//重載寵物選單
	                					new_url = url+old_pet;
								    	$("#dog_data").attr("href", new_url);
								    	$("#dog_data").text("dog_data");
	                				}
                				}
                		}
        });
}

/*寵物選單生成*/
function pet_ajax(owner, old_pet){
	if (owner == "none") {//如果沒選主人
		$('#pet option[value=none]').attr('selected', 'selected');
	    $('#pet').attr('disabled', true);//寵物欄鎖住
	}else{
		$("#pet").empty();
		$.ajax({	 			
	            url: "../ajax/process.php",
	            type: "POST",
	            dataType: "json",
	            data: {
	            		owner      : owner,
	            		act    	   : "pet_ajax",
	            },
	            success: function(data) {
	            				if(data.message != ""){
	            					alert(data.message);
	            				}else{
	            					$('#pet').attr('disabled', false);//寵物欄解鎖
	            					$("#pet").append(data.output);//塞入後端拉到的資料
	            					if(old_pet != ""){//鎖定原本寵物
	                					$('#pet option[value='+old_pet+']').attr('selected', 'selected');	                		
	                				}
	            				}
	            		}
	    });	
	}	
}


/*計算總價*/
function total_price(project, pet, extra){
	 	$.ajax({	 			
                url: "../ajax/process.php",
                type: "POST",
                dataType: "json",
                data: {
                		project  : project,
                		pet  	 : pet,
                		extra  	 : extra,
                		act  	 : "total_price",
                },
                success: function(data) {
                				if(data.message != ""){//有出錯就輸出訊息
                					alert(data.message);
                				}else{//沒出錯做該做的事
                					$("#pet").empty();//清空寵物選單
                					$("#pet").append(data.output);//塞入後端拉到的資料
                					$("#check_box").text(data.item);//塞入後端計算項目
                					$("#price").val(data.total_price);//塞入後端計算的總價
                					$("#is_check").val("1");//確認有無check total               					
                				}
                		}
        });
}

/*重置總價*/
function reset_price(){
		$("#is_check").val("0");//需重新check total
		$("#price").val("0");//總價歸0
		$("#check_box").text("");//拿掉計算項目		
}

/*計算url參數*/
function chk_count(count){
		if (count != 0) {
			insert = "&";
		}else{
			insert = "";
		}
		return insert;
}

/*圖片上傳預覽*/
function upload_pic(id, chk_id, tar_id, save_path, loading_path) {
        var formData = new FormData();
        formData.append(id, document.getElementById(id).files[0]);//圖片資訊
        formData.append("act", "upload_pic");//執行參數
        formData.append("save_path", save_path);//儲存路徑
        $.ajax({
            url : '../ajax/process.php',
            type : 'POST',
            data : formData, // 上传formdata封装的数据包
            dataType : 'JSON',
            cache : false, // 不缓存
            processData : false, // jQuery不要去处理发送的数据
            contentType : false, // jQuery不要去设置Content-Type请求头
            success : function(data) {
			            	if(data.error != 0){//出錯處理
								alert(data.message);//跳出訊息
							}else{//沒出錯處理
								$("#"+tar_id).attr("src", loading_path+"/"+data.new_name);//覆蓋預覽圖
								$("#"+tar_id).attr("title", data.new_name);//預覽圖title
				            	$("#"+chk_id).val(data.new_name);//已上傳檔名
				                alert(data.message);//跳出訊息
							}
			            	
            }
        });
}

/*圖片刪除預覽處理*/
function pic_del(chk_id, tar_id, save_path, no_file_path) {
		var chk_val = $("#"+chk_id).val();
        $.ajax({
            	url: "../ajax/process.php",
                type: "POST",
                dataType: "json",
                data: {
                		save_path : save_path,
                		file_name : chk_val,
                		act  	  : "pic_del",
                },
            success : function(data) {
			            	if(data.done == 1){//有執行
								$("#"+tar_id).attr("src", no_file_path);//覆蓋預覽圖
								$("#"+tar_id).attr("title", "preview");//預覽圖title
				            	$("#"+chk_id).val("");//清空已上傳檔名
				                alert(data.message);//跳出訊息
							}
			            	
            }
        });
}

/*for前台 圖片上傳預覽*/
function front_upload_pic(id, chk_id, tar_id, save_path, loading_path) {
        var formData = new FormData();
        formData.append(id, document.getElementById(id).files[0]);//圖片資訊
        formData.append("act", "upload_pic");//執行參數
        formData.append("save_path", save_path);//儲存路徑
        $.ajax({
            url : '../emadmin/ajax/process.php',
            type : 'POST',
            data : formData, // 上传formdata封装的数据包
            dataType : 'JSON',
            cache : false, // 不缓存
            processData : false, // jQuery不要去处理发送的数据
            contentType : false, // jQuery不要去设置Content-Type请求头
            success : function(data) {
			            	if(data.error != 0){//出錯處理
								alert(data.message);//跳出訊息
							}else{//沒出錯處理
								$("#"+tar_id).attr("src", loading_path+"/"+data.new_name);//覆蓋預覽圖
								$("#"+tar_id).attr("title", data.new_name);//預覽圖title
				            	$("#"+chk_id).val(data.new_name);//已上傳檔名
				                alert(data.message);//跳出訊息
							}
			            	
            }
        });
}

/*for前台 圖片刪除預覽處理*/
function front_pic_del(chk_id, tar_id, save_path, no_file_path) {
		var chk_val = $("#"+chk_id).val();
        $.ajax({
            	url: "../emadmin/ajax/process.php",
                type: "POST",
                dataType: "json",
                data: {
                		save_path : save_path,
                		file_name : chk_val,
                		act  	  : "pic_del",
                },
            success : function(data) {
			            	if(data.done == 1){//有執行
								$("#"+tar_id).attr("src", no_file_path);//覆蓋預覽圖
								$("#"+tar_id).attr("title", "preview");//預覽圖title
				            	$("#"+chk_id).val("");//清空已上傳檔名
				                alert(data.message);//跳出訊息
							}
			            	
            }
        });
}


/*搜選選單選取判定*/
function defind_selected(tar, val="") {
		if (val=="") {val = "none";}
		var target = "#"+tar;
		$(target+' option[value='+val+']').attr('selected', 'selected');	
}

/*預覽按鈕*/
function view(){
	var is_upload 	 = $("#is_upload").val();//紀錄上傳檔案檔名
	var content 	 = CKEDITOR.instances['content'].getData();//content
    var old_file     = $("#old_file").val();//old_file

/*檢查所需欄位是否滿足 start*/	
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
/*檢查所需欄位是否滿足 end*/

    $("#preview_form").html("");//先清空preview_form
    var pic  = $("#is_upload").clone();//複製檔名
    var old_pic  = $("#old_file").clone();//複製舊檔名
    var cont = $("#content").clone();//複製內容
	$("#preview_form").append(pic);//檔名塞到preview_form
    $("#preview_form").append(old_pic);//舊檔名塞到preview_form
	$("#preview_form").append(cont);//內容塞到preview_form
	$("#preview_form").children("textarea").text(content);//內容塞到preview_form
	setTimeout(sb_form, 4000, "preview_form");//preview_form送出(延遲三秒)
	return false;
}

/* 送出表單 */
function sb_form(form_id){
    var form = "#"+form_id;
    $(form).submit();//form送出

}