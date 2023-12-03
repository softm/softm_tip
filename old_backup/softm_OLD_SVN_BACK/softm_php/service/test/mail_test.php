<?
/*
 Filename        : /index.php
 Fuction         : 인덱스
 Comment         :
 시작 일자       : 2009-12-26,
 수정 일자       : 2010-01-26, v1.0 first
 작 성 자        : 김지훈
 수 정 자        :
 @version        : 1.0
*/
?>
<?
require_once 'lib/common.lib.inc';
require_once SERVICE_DIR . '/classes/common/Session.php';
require_once SERVICE_DIR . '/lib/mail.lib.inc';

$memInfor = Session::getSession();
//echo 'login_yn : ' . $memInfor['login_yn'];
$mode = !$_GET["mode"]?"login":$_GET["mode"];
// echo "mode : " .$mode;
require_once SERVICE_DIR . '/inc/header.inc'   ; // header
//phpinfo();

/*
    //function sendMailItem($host,$port,$tomail,$toname,$frommail,$fromname,$subject,$type,$message) {

$sendMailItem = new sendMailItem("mail.tkek.co.kr",25,
                                 "jihun.kim@tkek.co.kr","english 되는지 받는사람이름",
                                 "test.kim@tkek.co.kr","english 되는지 보낸사람이름",
                                 date('l jS \of F Y h:i:s A') . "제목 abcdefg 되는지 iconv","text/html",
                                 "되는지 xonte.s.s.ds.d.s.d.sx" . "한글" . "d.ds <B>aaa</B><iframe src='http://172.17.160.48?backurl=http://220.95.195.170/calko/calko_write.php?p_esti_no=XX09100005901'></iframe>"
                                );
$sendmail_flag = sendMail($sendMailItem);
if ($sendmail_flag) {
    print ("메일 보내기 성공");
} else {
    print ("메일 보내기 실패");
}
*/
?>
<?
echo mail("softm@nate.com", "제목", "내용");
//phpinfo();
//json_encode($arg);
$to     = 'softm@nate.com';
//$to     = 'jihun.kim@tkek.co.kr';
$from   ="jihun.kim@tkek.co.kr";
$subject = ('test file...mail..');
$message = 'hello';
$headers = 'From: ' . $from. "\r\n" .
    'Reply-To: ' . $to . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
//phpinfo();
$fromname = ('관리자');
$toname = ('받는사람');
function sendmail1($to,$from,$fromname,$subject,$content){
   $add_header ="From: $fromname <$from> \n";
   $add_header .="Reply-To: $from \n";
   $add_header .="Content-Type: text/html;charset=EUC-KR";
   return mail ("$to","$subject",$content,$add_header);
}

$subject = $subject . '/' . $_SERVER['HTTP_HOST']  ;
echo $subject . '<BR>';
echo 'mail : ' . mail($to, 'direct : ' . $subject, $message, $headers). '<BR>';
echo 'sendmail : ' .sendmail1($to,$from,$fromname,$subject,$message). '<BR>';
echo 'MailFunc : ' . sendMailByPHPAPI('utf-8',$toname,$to,$fromname,$from,$subject,$message,'1','3',$fInfo). '<BR>';            $fInfo = array();
$p_file_cnt = 1;
for ( $i=0;$i<$p_file_cnt;$i++) {
    if ( @file_exists('C:\WEB_APP\logs\\' . iconv("UTF-8", "EUC-KR","test.log")) ) {
        $tmpFinfo[dir      ] = 'C:\\WEB_APP\\logs';
        $tmpFinfo[real_name] = iconv("UTF-8", "EUC-KR","test.log");
        $tmpFinfo[size     ] = @filesize('C:\\WEB_APP\\logs\\test.log');
        $tmpFinfo[name     ] = '';
        echo 'size : ' . $tmpFinfo[size     ]. "\n";
        $fInfo[] = $tmpFinfo;
    } else {
        echo '파일 없음.';
    }
}

$sendMailItem = new sendMailItem("mail.tkek.co.kr",25,
                                 $to, $toname,
                                 'softm@nate.com','관리자.',
                                 $subject . "Quotation Completed - " . substr($p_esti_no,0,6) . '-' . substr($p_esti_no,6,5) . '-' . substr($p_esti_no,11) . ' / ' . date('Y/m/d h:i:s A') ,"text/html",
                                 $message,
                                 $fInfo
                                );
$sendMailItem->gubun = 'PHP';
$sendmail_flag = sendMail($sendMailItem);

?>