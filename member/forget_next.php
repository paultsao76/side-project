<?
// ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../application.php');
$area_title = "Forget Password";

if (!$_POST['step']) {
  die("<script>alert(\"You can't input invalid parameter.\");history.back();</script>");
}
if (!$_POST['phone']) {
  die("<script>alert(\"You can't input invalid parameter.\");history.back();</script>");
}

$phone = $_POST['phone'];//會員電話
phone_chk($phone);//確認會員電話號碼存在

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
            STEP2
         </div>
         <div class="form_style col-12 col-sm-4 mx-auto">
           <form id="postform" method="post" action="../../forget_finish.php" onsubmit="return chk_form(postform);">
              <div class="mb-3">
                <label for="password" class="form-label"><span class="required">*</span>New Password</label>
                <input type="password" class="form-control" id="password" name="password">
                <div class="form-text">Input your new password.</div>
              </div>
              <div class="mb-3">
                <label for="psd_again" class="form-label"><span class="required">*</span>Password Again</label>
                <input type="password" class="form-control" id="psd_again" name="psd_again">
                <div class="form-text">Input your new password again.</div>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
              <input type="hidden" name="act" value="forget">
              <input type="hidden" name="phone" value="<?=$phone?>">
            </form> 
         </div>
     </main><br><br><br><br><br><br><br><br>
      <!-- 內容結束 -->
	   <!-- 頁尾 -->
	   <? include("../includes/footer.php"); ?>
</body>
</html>

<script type="text/javascript">

  function chk_form(form){
    var password  = $("#password").val();//password
    var psd_again = $("#psd_again").val();//password again

    if (password == "") {
      alert("The 「New Password」 column is required.");
      $("#password").focus();
      return false;
    }
    if (password != psd_again) {
      alert("The 「New Password」 column and the 「Password Again」 column should input same.");
      $("#psd_again").focus();
      return false;
    }
    // alert("Here we go.");
    // return false;
  }
</script>