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
   	<main class="row mx-auto container" align="center" style="margin-top:70px;">
         <div class="col-12 col-sm-12">   
            <h1><?=$area_title?></h1>
         </div>
         <div class="form_style col-12 col-sm-4 mx-auto">
           <form id="postform" method="post" action="./" onsubmit="return chk_form(postform);">
              <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone">
                <div class="form-text">We'll never share your phone with anyone else.</div>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
              <input type="hidden" id="act" name="act" value="<?=$next_act?>">
              <div align="center" width="50%" style="margin-top: 30px;">
                  <table>
                     <tbody>
                        <tr>
                           <td class="nav-href" align="center" width="50%"><a href="<?=$CFG->wwwroot?>/member/apply/" title="apply">Join Us!</a></td>
                           <td class="nav-href" align="center" width="50%"><a href="<?=$CFG->wwwroot?>/member/forget/" title="Forget">Forget Password?</a></td>
                        </tr>
                     </tbody>
                  </table>
              </div>
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
    var phone    = $("#phone").val();//phone
    var password = $("#password").val();//password

    // if (phone == "") {
    //   alert("The 「phone」 column is required.");
    //   $("#phone").focus();
    //   return false;
    // }
    // if (password == "") {
    //   alert("The 「password」 column is required.");
    //   $("#password").focus();
    //   return false;
    // }
    // alert("Here we go.");
    // return false;
  }
</script>