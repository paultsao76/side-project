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
   	<main class="mx-auto container" align="center" style="margin-top:70px;">
         <div>   
            <h1><?=$area_title?></h1>
         </div>
         <form id="postform" method="post" action="./" onsubmit="return chk_form(postform);">
         <div class="form_style row mx-auto">
              <div class="col-12 col-sm-6 mb-3">
                <label for="name" class="form-label"><span class="required">*</span>Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?=$data['name']?>">
                <div class="form-text">30 words is max. If over 30 words, the words behind 30 will cut.</div>
              </div>

              <div class="col-12 col-sm-6 mb-3">
                <label for="gender" class="form-label"><span class="required">*</span>Gender</label><br>
                <select id="gender" name="gender" class="form-control" style="text-align: center;">
                  <option value="none">Select one</option>
                  <?=front_gd_option($data['gender']);?>
                </select>
              </div>

              <div class="col-12 col-sm-6 mb-3">
                <label for="body_shape" class="form-label">Body Shape</label>
                <input type="text" class="form-control" id="body_shape" name="body_shape" value="<?=$body_shape?>" disabled>
                <div class="form-text">When pet receive service to us, we defind in store.</div>
              </div>

              <div class="col-12 col-sm-6 mb-3">
                <label for="haired" class="form-label">Haired Type</label>
                <input type="text" class="form-control" id="haired" name="haired" value="<?=$haired?>" disabled>
                <div class="form-text">When pet receive service to us, we defind in store.</div>
              </div>


              <!-- <div class="col-12 col-sm-6 mb-3">
                <label for="body_shape" class="form-label">Body Shape</label><br>
                <select id="body_shape" name="body_shape" class="form-control" style="text-align: center;">
                  <option value="none">Select one</option>
                  <?=front_bs_option($val['body_shape']);?>
                </select>
                <div class="form-text">If you don't know it. This column is optional, It's ok. we got it.</div>
              </div> -->

              <!-- <div class="col-12 col-sm-6 mb-3">
                <label for="haired" class="form-label">Haired Type</label><br>
                <select id="haired" name="haired" class="form-control" style="text-align: center;">
                  <option value="none">Select one</option>
                  <?=front_ht_option($val['haired']);?>
                </select>
              </div> -->
              
              <div class="col-12 col-sm-12 mb-3">
                <label for="remark" class="form-label">Remark</label>
                <textarea class="form-control" id="remark" name="remark" style="height: 300px;"><?=$data['remark']?></textarea>
                <div class="form-text">Try your best to tell us the pet information. And we will additional message at here when pet any happen in store.</div>
              </div>

              <div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <input type="hidden" name="act" value="<?=$next_act?>">
                  <input type="hidden" name="id" value="<?=$data['id']?>">
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

  function chk_form(form){
    var name    = $("#name").val();//name
    var gender  = $("#gender").val();//gender

    if (name == "") {
      alert("The 「Name」 column is required.");
      $("#name").focus();
      return false;
    }
    if (gender == "none") {
      alert("The 「Gender」 column is required.");
      $("#gender").focus();
      return false;
    }
    // alert("Here we go.");
    // return false;
  }
</script>