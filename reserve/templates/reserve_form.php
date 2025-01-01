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
                <label for="project" class="form-label"><span class="required">*</span>Project</label><br>
                <select id="project" name="project" class="form-control" style="text-align: center;" <?=$project_disabled?> >
                  <option value="none">Select one</option>
                  <?=front_project_option($data['project']);?>
                </select>
              </div>
              <div class="col-12 col-sm-6 mb-3">
                <label for="pet" class="form-label"><span class="required">*</span>Pet</label><br>
                <select id="pet" name="pet" class="form-control" style="text-align: center;" <?=$pet_disabled?> >
                  <option value="none">Select one</option>
                  <?=front_pet_option($data['pet']);?>
                </select>
              </div>

              <div class="col-12 col-sm-6 mb-3">
                <label for="reserve_date" class="form-label"><span class="required">*</span>Reserve Date</label>
                <input type="datetime-local" class="form-control" id="reserve_date" name="reserve_date" value="<?=$data['reserve_date']?>" <?=$date_disabled?> >
              </div>
              <div class="col-12 col-sm-6 mb-3">
                <label for="finish_time" class="form-label">Finish Time</label>
              <?if ($data['finish_time'] == "") {//如果預計完成時間是空的?>
                <input type="text" class="form-control" id="finish_time" name="finish_time" value="<?=$finish_time?>" style="text-align: center;" disabled>
              <?}else{//沒空就直接帶入?>
                <input type="datetime-local" class="form-control" id="finish_time" name="finish_time" value="<?=$finish_time?>" disabled>
              <?}?>
              <div class="form-text">This column will input by us, when we accept this reserve.</div>
              </div>

              <div class="col-12 col-sm-6 mb-3">
                <label for="extra" class="form-label">Extra</label><br>
                <input type="text" class="form-control" id="extra" name="extra" value="<?=$extra?>" style="text-align: center;" disabled>
                <div class="form-text">This column will input by us, when we check your pet state in store.</div>
              </div>
              <div class="col-12 col-sm-6 mb-3">
                <label for="state" class="form-label">State</label><br>
                <select id="state" name="state" class="form-control" style="text-align: center;" <?=$state_disabled?> >
                  <?=front_reserve_state_option($data['state']);?>
                </select>
                <input type="hidden" id="old_state" name="old_state" value="<?=$data['state']?>">
                <div class="form-text">This column is auto.</div>
              </div>

              <div class="col-12 col-sm-6 mb-3">
                <label for="price" class="form-label">Total Price</label><br>
                <input type="text" class="form-control" id="price" name="price" value="<?=$price?>" style="text-align: center;" disabled>
                <div class="form-text"><?=$price_tip?></div>
              </div>
              <div class="col-12 col-sm-6 mb-3">
                <label for="point_pay" class="form-label">point pay</label><br>
                <input type="checkbox" class="form-check-input" id="point_pay" name="point_pay" value="1" style="width:30px;height:30px;" <?=$point_pay_disabled?> <?=$checked?> ><br>
                <div class="form-text" style="margin-top: 15px;">Your point now is <span class="required"><?=$_SESSION['member']['point']?></span> . If you have 10 , you can get free one time.</div>
              </div>


              <div class="col-12 col-sm-12 mb-3" style="margin-top: 50px;">
                <label for="remark" class="form-label">Remark</label>
                <textarea class="form-control" id="remark" name="remark" style="height: 300px;"><?=$data['remark']?></textarea>
                <div class="form-text">Try your best to tell us the pet information. And we will additional message at here when pet any happen in store.</div>
              </div>

              <div>
                  <?=$submit_button?>
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
    var project      = $("#project").val();//project
    var pet          = $("#pet").val();//pet
    var reserve_date = $("#reserve_date").val();//reserve date
    var state        = $("#state").val();//state
    var old_state    = $("#old_state").val();//old_state

    if (project == "none") {
      alert("The 「Project」 column is required.");
      $("#project").focus();
      return false;
    }
    if (pet == "none") {
      alert("The 「Pet」 column is required.");
      $("#pet").focus();
      return false;
    }
    if (reserve_date == "") {
      alert("The 「Reserve Date」 column is required.");
      $("#pet").focus();
      return false;
    }
    if (state == "6" && old_state != "6") {
      var chk = confirm('You want to cancel this reserve for sure?');
      if ( !chk ){
         var msg = "You canceled the action.";
         alert(msg);
         return false;
      }
    }
    // alert("Here we go.");
    // return false;
  }
</script>