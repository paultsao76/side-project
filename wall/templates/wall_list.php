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
         <div class="form_style row mx-auto">
              <!-- 操作區 -->
              <div class="col-12 col-sm-12 mb-3" style="margin-top: 15px;"> 
                <button id="add"><?=$insert_button?></button>
              </div>    
              <!-- 寵物資訊顯示區 -->
              <div class="col-12 col-sm-12 mb-3 mx-auto f-10" align="center">
                <form id="postform" method="post" action="./" onsubmit="return chk_form(postform);">  
                  <table class="table pet_list mx-auto">
                    <thead align="center">
                      <tr>
                        <th scope="col" width="10%">#</th>
                        <th scope="col" width="20%">picture</th>
                        <th scope="col" width="40%">creat date</th>
                        <th scope="col" width="10%">open</th>
                        <th scope="col" width="10%">edit</th>
                        <th scope="col" width="10%">delete</th>
                      </tr>
                    </thead>
                    <tbody align="center">
                <?/*確認是否有資料*/
                  if ($data_count != 0) {//如果有, 印出來
                    /*迴圈執行印出*/
                    foreach ($data as $key => $val) {
                             $key+=1;//item
                             $file_title = $val['file'];//定義圖片標題
                             $file_link  = $CFG->file_path."/".$val['file'];//定義圖片web取得路徑
                             $open       = ($val['open']) ? "Y" : "N";//定義是否公開
                    ?>
                      <tr>
                        <th scope="row" class="align-middle"><?=$key?></th>
                        <td><img width="100" height="100" title="<?=$file_title?>" src="<?=$file_link?>"></td>
                        <td class="align-middle"><?=$val['creat_date']?></td>
                        <td class="align-middle"><?=$open?></td>
                        <td class="align-middle"><button id="edit" onclick="return post_edit(<?=$val['id']?>)">edit</button></td>
                        <td class="align-middle"><button id="del" onclick="return post_del(<?=$key?>, <?=$val['id']?>)">delete</button></td>
                      </tr>
                  <?}?>
                <?}else{//沒有?>
                      <tr>
                        <th scope="row" colspan="6">no pet data now.</th>
                      </tr>
                <?}?>
                    </tbody>
                  </table>
                </form>
              </div>    
         </div> 
	   </main><br><br><br><br><br><br><br><br><br><br><br><br>
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
  function post_edit(id){
    location.href = '<?=$short_url?>?act=edit&id='+id;
    return false;
  }

  /*刪除按鈕*/
  function post_del(number, id){
    var chk = confirm('You want to delete the post No.'+number+' in your list for sure?');
    if ( !chk ){
       var msg = "You canceled the action.";
       alert(msg);
       return false;
    }
    alert('<?=$short_url?>?act=del&id='+id);
    location.href = '<?=$short_url?>?act=del&id='+id;
    return false;
  }



  /*搜尋按鈕*/
  // defind_selected('state', '<?=$state?>');//狀態選單預設判定
  $("#search").click(function(){
    var search_key = $("#search_key").val();//搜尋關鍵字

    var string = "";//連結字串定義
    var count = 0;//參數計數

    if  (search_key != ""){//如果有下關鍵字搜索
      var insert = chk_count(count);//參數數量確認
    string += insert+"search_key="+search_key;//組出字串
    count ++;//參數計數
    }
    /*準備好連結字串*/
    if  (string != ""){
    url = '<?=$short_url?>?'+string;
    }else{
      url = '<?=$short_url?>';
    }
    location.href = url;//執行
  });


  
</script>