/*密碼顯示調整*/
function display_defind(id){
/* 鎖定顯示目標 start */
	switch(id) {
	  case 'display1':
	  		var target = "password";
	  	break;
	  case 'display2':
	    	var target = "again";
	    break;
	}
/* 鎖定顯示目標 end */

	var now_type = $("#"+target).attr('type');
	if (now_type == "text") {
		// alert('1');
		$("#"+target).attr('type', 'password');
    }else{
    	// alert('2');
    	$("#"+target).attr('type', 'text');
	}
}