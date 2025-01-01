<?php
ini_set('display_errors','on');     # 開啟錯誤輸出
include_once('../application.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require "../includes/PHPMailer/src/Exception.php";
require "../includes/PHPMailer/src/PHPMailer.php";
require "../includes/PHPMailer/src/SMTP.php";

$phone    = $_POST['phone'];//會員電話
$password = $_POST['password'];//會員新密碼
$tb = "member_list";//會員列表
$op = "`first_name`, `last_name`, `email`";
$act  = "`phone` ='".$phone."' ";
$act .= " AND `is_del` = '0'";

$data = $db->getRow("SELECT $op FROM $tb WHERE $act");

//判定會員有無email
if ($data['email'] != "") {//如果有, 寄一發通知信件
    // try {
        $email      = $CFG->email;//發件帳號
        $psd        = $CFG->email_psd;//發件密碼
        $email_name = $CFG->email_name;//發件人名稱
        $member_name = $data['first_name']." ".$data['last_name'];//定義會員稱呼
        $subject     = "You change your password";//定義信件標題
        //定義信件內容
        $content     = "<div><p>Hi, ".$data['first_name'].". you change your password at ".date("Y-m-d H:i:s").".<p>";
        $content    .= "<p>This is system notify. If you have any question, connect us.<p>";
        $content    .= "<p>tel：0981981396.<p></div>";


        $mail = new PHPMailer(true);
        $mail->SMTPDebug  = 0;                    //Enable verbose debug output
        $mail->isSMTP();                          //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';     //SMTP server 位址
        $mail->SMTPAuth   = true;                 //開啟SMTP驗證
        $mail->Username   = $email;               //SMTP 帳號
        $mail->Password   = $psd;                 //SMTP 密碼
        $mail->SMTPSecure = "ssl";                //Enable implicit TLS encryption
        $mail->Port       = 465;                  //TCP port to connect to; 
        $mail->Charset    ='UTF-8';

        //設定收件人資料
        $mail->setFrom($email, $email_name);      //寄件人
        $mail->addAddress($email, $member_name);  //收件人
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');                          //副本
        // $mail->addBCC('bcc@example.com');                        //密件副本

        //附件
        // $mail->addAttachment('/var/tmp/file.tar.gz');            //附件
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');       //插入附件可更改檔名

        //信件內容
        $mail->isHTML(true);                                        //設定為HTML格式
        $mail->Subject = $subject;                                  //信件標題
        $mail->Body    = $content;                                  //郵件內容
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';//對方若不支援HTML的信件內容
        $mail->send();//發送
        // echo 'Message has been sent';

    // } catch (Exception $e) {
    //     echo "無法發送信息。 郵件錯誤碼: {$mail->ErrorInfo}";
    // }   
}

/*欄位值組裝 start */
$fix  = "`psd` = '" .$password. "'";
/*欄位值組裝 end */
$GLOBALS['db']->query("UPDATE $tb SET $fix WHERE $act");
$url = $CFG->wwwroot."/member/";
die("<script>alert('Your password update success.');location.href='".$url."';</script>");

?>

