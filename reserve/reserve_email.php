<?php
// ini_set('display_errors','on');     # 開啟錯誤輸出
// include_once('../application.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require "../includes/PHPMailer/src/Exception.php";
require "../includes/PHPMailer/src/PHPMailer.php";
require "../includes/PHPMailer/src/SMTP.php";

$state_list[0] = "applying";
$state_list[6] = "cancel";
$phone = $_SESSION['member']['phone'];
$first_name = $_SESSION['member']['first_name'];
$last_name  = $_SESSION['member']['last_name'];
$state_now  = $state_list[$state];
$reserve_date = date("Y-m-d H:i:s", strtotime($reserve_date));
$sub  = ($state == "0") ? "New Reserve" : "Cancle Reserve";
$cont = ($state == "0") ? "<p>Reserve at ".$reserve_date.".<p>" : "<p>Cancel the reserve for ".$reserve_date." .<p>";

//判定會員有無email
// if ($data['email'] != "") {//如果有, 寄一發通知信件
    // try {
        $email       = $CFG->email;//發件帳號
        $psd         = $CFG->email_psd;//發件密碼
        $email_name  = $CFG->email_name;//發件人名稱
        $ad_name     = $first_name." ".$last_name;//收件人稱呼
        $ad_mail     = $email;//收件人email
        $subject     = $sub;//定義信件標題
        //定義信件內容
        $content     = "<div><p>".$ad_name." ".$state_now." at ".date("Y-m-d H:i:s").".<p>";
        $content    .= $cont;
        $content    .= "<p>tel：".$phone.".<p></div>";

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
        $mail->addAddress($ad_mail, $ad_name);  //收件人
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
// }
$short_url = $CFG->$short_url;
$message = $state_now." success.";
die("<script>alert(\"".$message."\");location.href='".$short_url."';</script>");


?>

