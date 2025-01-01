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
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.css">	
</head>
<body>
   
<!-- 頁首(上導覽列) -->
    <? include("../includes/header.php"); ?>
<!-- 內容開始 -->
   	<main class="mx-auto container" align="center" style="margin-top:70px;">
         <div>   
            <h1><?=$area_title?></h1>
         </div>
         <form id="postform" method="post" action="./" enctype="multipart/form-data" onsubmit="return chk_form(postform);">
         <div class="form_style row mx-auto">
              <div class="col-12 col-sm-6 mb-3" align="left">
                <div align="center">
                  <label for="file" class="form-label"><span style="color:red;">*</span>Picture</label>
                </div>
                <input type="file" class="form-control" name="file" id="file" multiple="multiple" accept="image/*" class="insert" value="<?=$data['file']?>">
                <input type="button" class="btn btn-primary" value="upload" onclick="front_upload_pic('file', 'is_upload', 'up_file','<?=$CFG->tmp_upload?>', '<?=$CFG->tmp_file?>')">
                <input type="button" class="btn btn-primary" value="pic_del" onclick="front_pic_del('is_upload', 'up_file', '<?=$CFG->tmp_upload?>', '<?=$no_file_link?>')">
              </div>
              <div class="col-12 col-sm-6 mb-3">
                      <div align="center">
                        <label class="form-label">Picture Preview</label>
                      </div>
                      <input type="hidden" id="old_file" name="old_file" value="<?=$data['file']?>">
                      <input type="hidden" id="is_upload" name="is_upload" value="<?=$data['file']?>">
                      <img id = "up_file" name = "up_file" width="200" height="200" title="<?=$file_title?>" src="<?=$file_link?>" align="center">
              </div>

              <div class="col-12 col-sm-12 mb-3" style="margin-top:50px;">
                <label class="form-label"><span style="color:red;">*</span>content</label>
                <textarea id="content" name="content" style="height: 300px;"><?=htmlentities($data['content'])?></textarea>
                <div class="form-text">Try your best to share your feeling at here. Let's go！</div>
              </div>

              <div class="col-12 col-sm-6 mb-3" style="margin-top:25px;">
                <label for="open" class="form-label"><span class="required">*</span>Open</label><br>
                <select id="open" name="open" class="form-control" style="text-align: center;">
                  <option value="none">Select one</option>
                  <?=post_open_option($data['open']);?>
                </select>
                <div class="form-text">N：no open, Y：open.</div>
              </div>
              <div class="col-12 col-sm-6 mb-3" style="margin-top:25px;">
                <label class="form-label"><span style="color:red;">*</span>preview</label><br>
                <button id="preview" class="btn btn-primary" onclick="return view();">preview</button>
                <div class="form-text">You can preview your post.</div>
              </div>

              <div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <input type="hidden" name="act" value="<?=$next_act?>">
                  <input type="hidden" name="id" value="<?=$data['id']?>">
              </div>
         </div>
         </form>
         <form id="preview_form" action="./wall_preview.php" method="post" target="_blank">
         </form> 
	   </main><br><br><br><br><br><br><br>
      <!-- 內容結束 -->
	   <!-- 頁尾 -->
	   <? include("../includes/footer.php"); ?>
</body>
</html>
<script src="../js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">

  CKEDITOR.replace("content");//啟用editor

  function chk_form(form){
    var is_upload    = $("#is_upload").val();//紀錄上傳檔案檔名
    var content      = CKEDITOR.instances['content'].getData();//content
    var old_file     = $("#old_file").val();//old_file
    var open         = $("#open").val();//open

      if (is_upload == "" && old_file == "") {
        alert("choose you wanna upload picture.");
        $("#file").focus();
        return false;
      }
      if (content == "") {
        alert("The 「content」 column is required.");
        $("#content").focus();
        return false;
      }
      if (open == "none") {
        alert("The 「Open」 column is required.");
        $("#open").focus();
        return false;
      }
      // alert("Here we go.");
      // return false;
  }
</script>