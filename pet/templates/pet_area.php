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
                <input type="text" class="search_key" name="search_key" size="10" id="search_key" placeholder="pet name" value="<?=$search_key?>">
                <button id="search">search</button>
              </div>    
              <!-- 寵物資訊顯示區 -->
              <div class="col-12 col-sm-12 mb-3 mx-auto" align="center">
                <form id="postform" method="post" action="./" onsubmit="return chk_form(postform);">  
                  <table class="table pet_list">
                    <thead align="center">
                      <tr>
                        <th scope="col" width="10%">#</th>
                        <th scope="col" width="30%">Name</th>
                        <th scope="col" width="30%">edit</th>
                        <th scope="col" width="30%">delete</th>
                      </tr>
                    </thead>
                    <tbody align="center">
                <?/*確認是否有資料*/
                  if ($data_count != 0) {//如果有, 印出來
                    /*迴圈執行印出*/
                    foreach ($data as $key => $val) {
                             $key+=1;//item
                    ?>
                      <tr>
                        <th scope="row"><?=$key?></th>
                        <td><?=$val['name']?></td>
                        <td><button id="edit" onclick="return pet_edit(<?=$val['id']?>)">edit</button></td>
                        <td><button id="del" onclick="return pet_del('<?=$val["name"]?>', <?=$val['id']?>)">delete</button></td>
                      </tr>
                  <?}?>
                <?}else{//沒有?>
                      <tr>
                        <th scope="row" colspan="4">no pet data now.</th>
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
    var url = '<?=$short_url?>add/';
      location.href = url;
  });

  /*修改按鈕*/
  function pet_edit(id){
    location.href = '<?=$short_url?>?act=edit&id='+id;
    return false;
  }

  /*刪除按鈕*/
  function pet_del(pet_name, id){
    var chk = confirm('You want to delete '+pet_name+' data for sure?');
    if ( !chk ){
       var msg = "You canceled the action.";
       alert(msg);
       return false;
    }
    // alert('<?=$short_url?>?act=del&id='+id);
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