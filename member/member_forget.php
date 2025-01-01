<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../application.php');
$area_title = "Forget Password";
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
   	<main class="row mx-auto container" align="center" style="margin-top:70px;">
         <div class="col-12 col-sm-12">   
            <h1><?=$area_title?></h1><br>
            STEP1
         </div>
         <div class="form_style col-12 col-sm-4 mx-auto">
           <form id="postform" method="post" action="./next/" onsubmit="return chk_form(postform);">
              <div class="mb-3">
                <label for="phone" class="form-label"><span class="required">*</span>Phone</label>
                <input type="text" class="form-control" id="phone" name="phone">
                <div class="form-text">Input your phone number.</div>
              </div>
              <button type="submit" class="btn btn-primary">Next Step</button>
              <input type="hidden" name="step" value="1">
            </form> 
         </div>
     </main><br><br><br><br><br><br><br><br><br><br><br><br>
      <!-- 內容結束 -->
	   <!-- 頁尾 -->
	   <? include("../includes/footer.php"); ?>
</body>
</html>

<script type="text/javascript">

  function chk_form(form){
    var phone = $("#phone").val();//phone

    if (phone == "") {
      alert("The 「Phone」 column is required.");
      $("#phone").focus();
      return false;
    }
    // alert("Here we go.");
    // return false;
  }
</script>