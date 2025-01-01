<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$CFG->title?></title>


<? include('../includes/non_css.php'); ?>
<link href="<?=$CFG->wwwroot?>/css/aaa.css" rel="stylesheet" type="text/css">
	
</head>
<body>
   
<!-- 頁首(上導覽列) -->
    <? include("../includes/header.php"); ?>
<!-- 內容開始 -->
   	<main class="container" align="center"  style="margin-top:70px;">
         <div>   
            <h1><?=$area_title?></h1>
         </div>
         <div class="row mx-auto reserve_div f-10" align="center">
            <!-- 操作區 -->
              <div class="col-12 col-sm-12 mb-3 mx-auto" style="margin-top: 20px;" align="center"> 
                <button id="add" style="margin-right: 10px;"><?=$insert_button?></button>
                Search Pet：<select id="pet_name" style="margin-right: 10px;">
                  <option value="none">select one</option>
                  <?=pet_search_option($_SESSION['member']['id'], $pet_name);?>
                </select>
                <button id="search">Search</button>
              </div>
              <div class="col-12 col-sm-12 mb-3 mx-auto" align="center"> 
                Date Range：<input type="date" id="start_date" value="<?=$start_date?>"> - <input type="date" id="end_date" value="<?=$end_date?>">
              </div>
         </div>
         
        <!-- 預約資訊顯示區 -->
        <?if ($data_count == 0) {//沒資料輸出?>
              <div class="reserve_div reserve_column mx-auto" align="center">
                    No reserve data.
              </div> 
          <?}?>
        <!-- 有資料, 迴圈輸出 -->
        <?foreach ($data as $key => $val) {
                /*變數定義 start*/
                   $key+=1;//資料筆數排序
                   $finish_time = ($val['finish_time'] == "")? "no defind" : $val['finish_time'];//預計結束時間顯示判定
                   $bgc = state_color($val['state']);//預約狀態顏色判定 
                   $edit_button = ($val['state'] == "0" OR $val['state'] == "6")? "Edit" : "Review";//修改按鈕選是判定
        ?>
          <div class="row mx-auto reserve_div reserve_column" align="left">
              <div class="col-6 col-sm-6 mb-3">
                    Pet Name：<?=$val['name']?>
              </div>    
              <div class="col-6 col-sm-6 mb-3">
                    Project：<?=project_show($val['project'])?>
              </div> 

              <div class="col-6 col-sm-6 mb-3">
                    Reserve Date：<span class="br_class"><?=$val['reserve_date']?></span>
              </div>    
              <div class="col-6 col-sm-6 mb-3">
                    Finish Time：<span class="br_class"><?=$finish_time?></span>
              </div> 

              <div class="col-8 col-sm-6 mb-8">
                  <span style= "background-color:<?=$bgc?>;box-shadow:1px 1px 1px #090808;border-radius:5px 5px 5px 5px; padding-left:5px;padding-right:5px;">
                    State：<?=state_show($val['state'])?>
                  </span>
              </div>
              <div class="col-4 col-sm-6 mb-4" align="left">
                  <button id="edit" onclick="reserve_edit(<?=$val['id']?>);"><?=$edit_button?></button>  
              </div>
              <div class="col-12 col-sm-12 mb-3" align="right">
                  #<?=$key?> 
              </div>
          </div>
        <?}?> 
	   </main><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      <!-- 內容結束 -->
	   <!-- 頁尾 -->
	   <? include("../includes/footer.php"); ?>
</body>
</html>

<script type="text/javascript">

  /*新增按鈕*/
  $("#add").click(function(){
    var url = '<?=$short_url?>?act=add';
      location.href = url;
  });

  /*修改按鈕*/
  function reserve_edit(id){
    location.href = '<?=$short_url?>?act=edit&id='+id;
    return false;
  }

  /*搜尋按鈕*/
  // defind_selected('state', '<?=$state?>');//狀態選單預設判定
  $("#search").click(function(){
    var pet_name   = $("#pet_name").val();//搜尋寵物名稱
    var start_date = $("#start_date").val();//搜尋起始日期
    var end_date   = $("#end_date").val();//搜尋結束日期

    var start = new Date( $('#start_date').val() );
    var end   = new Date( $('#end_date').val() );
    var start_timestamp = start.getTime();
    var end_timestamp   = end.getTime();

    if  (start_timestamp > end_timestamp){//檢查搜索時間選取
        var msg = "The start date is over than end date.";
        alert(msg);
        return false;
    }

    var string = "";//連結字串定義
    var count = 0;//參數計數

    if  (pet_name != "none"){//如果有下搜尋寵物名稱
      var insert = chk_count(count);//參數數量確認
      string += insert+"pet_name="+pet_name;//組出字串
      count ++;//參數計數
    }
    if  (start_date != ""){//如果有下搜尋起始日期
      var insert = chk_count(count);//參數數量確認
      string += insert+"start_date="+start_date;//組出字串
      count ++;//參數計數
      if  (end_date == ""){
        string += "&"+"end_date="+start_date;//組出字串
      }
    }
    if  (end_date != ""){//如果有下搜尋結束日期
      var insert = chk_count(count);//參數數量確認
      string += insert+"end_date="+end_date;//組出字串
      count ++;//參數計數
      if  (start_date == ""){
        string += "&"+"start_date="+end_date;//組出字串
      }
    }
    /*準備好連結字串*/
    if  (string != ""){
      url = '<?=$short_url?>?'+string;
    }else{
      url = '<?=$short_url?>';
    }
      // alert(url);
      // return false;
      location.href = url;//執行
  });


  
</script>