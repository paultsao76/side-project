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
         <form id="postform" method="post" action="./" onsubmit="return chk_form(postform);">
         <div class="form_style row mx-auto">
              <div class="col-12 col-sm-6 mb-3">
                <label for="first_name" class="form-label"><span class="required">*</span>First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?=$_SESSION['member']['first_name']?>" disabled>
              </div>
              <div class="col-12 col-sm-6 mb-3">
                <label for="last_name" class="form-label"><span class="required">*</span>Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?=$_SESSION['member']['last_name']?>" disabled>
              </div>

              <div class="col-12 col-sm-6 mb-3">
                <label for="phone" class="form-label"><span class="required">*</span>Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?=$_SESSION['member']['phone']?>" disabled>
              </div>
              <div class="col-12 col-sm-6 mb-3">
                <label for="gender" class="form-label"><span class="required">*</span>Gender</label><br>
                <select id="gender" name="gender" class="form-control" style="text-align: center;" disabled>
                  <option value="none">Select one</option>
                  <?=front_gd_option($_SESSION['member']['gender']);?>
                </select>
              </div>
              
              <div class="col-12 col-sm-6 mb-3">
                <label for="password" class="form-label"><span class="required">*</span>Password</label>
                <input type="password" class="form-control" id="password" name="password" value="<?=$_SESSION['member']['psd']?>" disabled>
              </div>
              <div class="col-12 col-sm-6 mb-3">
                <label for="psd_again" class="form-label"><span class="required">*</span>Password Again</label>
                <input type="password" class="form-control" id="psd_again" name="psd_again" value="<?=$_SESSION['member']['psd']?>" disabled>
                <div class="form-text">Input your password again.</div>
              </div>

              <div class="col-12 col-sm-6 mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="text" class="form-control" id="email" name="email" value="<?=$_SESSION['member']['email']?>" disabled>
              </div>
              <div class="col-12 col-sm-6 mb-3">
                <label for="point" class="form-label">My Point</label>
                <input type="text" class="form-control" id="point" name="point" value="<?=$_SESSION['member']['point']?>" disabled>
              </div>
              
              <div class="col-12 col-sm-12 mb-3">
                  <input type="button" class="btn btn-primary" id="edit_button" value="edit" onclick="unlock()"></input>
                  <button type="submit" class="btn btn-primary" id="sub_button" disabled>Submit</button>
                  <input type="hidden" name="act" value="update">
              </div>
         </div>
         </form> 
	   </main><br><br><br><br><br><br><br>
      <!-- 內容結束 -->
	   <!-- 頁尾 -->
	   <? include("../includes/footer.php"); ?>
</body>
</html>

<script type="text/javascript">

   /*解鎖表單*/
   function unlock(form){
      $('#first_name, #last_name, #phone, #gender, #email, #password, #psd_again, #sub_button').attr('disabled', false);
      $('#edit_button').attr('disabled', true);
   }


  function chk_form(form){
    var first_name = $("#first_name").val();//first name
    var last_name  = $("#last_name").val();//last name
    var phone      = $("#phone").val();//phone
    var gender     = $("#gender").val();//gender
    var email      = $("#email").val();//email
    var password   = $("#password").val();//password
    var psd_again  = $("#psd_again").val();//password again

    if (first_name == "") {
      alert("The 「First Name」 column is required.");
      $("#first_name").focus();
      return false;
    }
    if (last_name == "") {
      alert("The 「Last Name」 column is required.");
      $("#last_name").focus();
      return false;
    }
    if (phone == "") {
      alert("The 「Phone」 column is required.");
      $("#phone").focus();
      return false;
    }
    if (gender == "none") {
      alert("The 「Gender」 column is required.");
      $("#gender").focus();
      return false;
    }
    if (email != "") {
      var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      if (!regex.test(email)) {
        alert("You should input correct e-mail format.");
        $("#email").focus();
        return false;
      }
    }
    if (password == "") {
      alert("The 「Password」 column is required.");
      $("#password").focus();
      return false;
    }
    if (password != psd_again) {
      alert("The 「Password」 column and the 「Password Again」 column should input same.");
      $("#psd_again").focus();
      return false;
    }
    // alert("Here we go.");
    // return false;
  }
</script>