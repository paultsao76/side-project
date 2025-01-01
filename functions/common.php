<?

/* 頁數判定 */
function page_defind($get_page="", $limit){
  if (!$get_page) {
    $page = 1;
  }else{
    $page = $get_page;
  }
  if ( ($page - 1) == 0 ) {
    $start = 0;
  }else{
    $start = $limit * ($page-1);
  }
  $limit = $start." , ".$limit;
  $result['page']  = $page;
  $result['limit'] = $limit;
  return  $result;

}


/*做出頁數下拉選單*/
function page_option($limit, $data_count , $page){

   $page_total = 0;
   if ($data_count != 0) {
       $page_total = $data_count / $limit;
   }

   if ($page_total != 0) {
       $page_total = ceil($page_total);//將總頁數無條件進位
   }

/* 阻止無效參數 start */
   if ($page > $page_total) {
     die("<script>alert(\"You can't input invalid parameter.\");history.back();</script>");
   }
/* 阻止無效參數 end */

   $selected = "";
   if ($page == 1) {
       $selected = "selected";
   }

   $page_select_display  = "page <select name=\"page\" id=\"page\">";//定義頁數選單語法
   $page_select_display .= "<option value='1' ".$selected.">1</option>";

   if ($page_total > 1) {
      // die('1');
       for ($i=2; $i <= $page_total; $i++) { 
            $selected = "";
            if ($page == $i) {
                $selected = "selected";
            }
            $page_select_display .= "<option value='".$i."' ".$selected.">".$i."</option>";
       }
   }
   $page_select_display .= "</select>";
   return $page_select_display;
}

/* 職等判定 */
function level_output($level){
    switch ($level) {
      case '0':
          $positon = "administrator";
        break;
      case '1':
          $positon = "leader";
        break;
      case '2':
          $positon = "normal";
        break;

    }
    return $positon;
}

/* 重複檢查(不包含已刪除) */
function chk_reuse($val, $tb, $column, $message){
  global $db;

  $op  = "count(*)";
  $act = $column." = '".$val."'";
  $act .= " AND is_del ='0'";
  $count = $db->getOne("SELECT $op FROM $tb WHERE $act");
  if ($count > 0) {
    die("<script>alert(\"".$message."\");history.back();</script>");
  }
}

/* 重複檢查(包含已刪除) */
function chk_reuse_all($val, $tb, $column, $message){
  global $db;

  $op   = "count(*)";
  $act  = $column." = '".$val."'";
  $count = $db->getOne("SELECT $op FROM $tb WHERE $act");
  if ($count > 0) {
    die("<script>alert(\"".$message."\");history.back();</script>");
  }
}      

/* 字串過濾 */
function string_filter($string){
  return addslashes($string);
}

/* 確認是否輸入有效ID */
function id_chk($tb, $id){
  global $db;
  $op    = "count(*)";
  $act   = "id = '".$id."'";
  $act  .= " AND is_del = '0'";
  $count = $db->getOne("SELECT $op FROM $tb WHERE $act");
  if ($count == 0) {
    $message = "You can't input invalid parameter.";
    die("<script>alert(\"".$message."\");history.back();</script>");
  }
}

/* 確認是否為黑名單 */
function chk_black($member_id){
  global $CFG, $db;

  $tb   = "black_list";//黑名單列表
  $op   = "count(*)";
  $act  = "member = '".$member_id."'";
  $act .= " AND is_del = '0'";
  $count = $db->getOne("SELECT $op FROM $tb WHERE $act");//數量
  if ($count != 0) {
      $message  = "You are the member in blacklist. \\n";
      $message .= "If you have any question, connect us. \\n";
      $message .= "Tel：0981981396. \\n";
      die("<script>alert(\"".$message."\");history.back();</script>");
  }
}


/* 確認是否登入會員 */
function member_login_chk(){
  global $CFG;

  if (!$_SESSION['member']) {//沒登入
      $url = $CFG->wwwroot."/member/";
      $msg = "You should login member account first.";
      die("<script>alert(\"".$msg."\");location.href='".$url."';</script>");
      header("Location:".$url); 
  }
}
?>