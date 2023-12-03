<?
set_time_limit ( 0 );
$baseDir = '../';
include ( "../common/lib.inc"          ); // 공통 라이브러리
include ( "../common/message.inc"      ); // 에러 페이지 처리
include ( '../common/db_connect.inc'   ); // Data Base 연결 클래스
$memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음

if ( $memInfor['admin_yn'] == 'Y' ) {
    head("",'sendMail();');        // Header 출력
    _css($baseDir);
    include ( '../common/mail.inc'     ); // 메일 관련

    $percent = 0;
    if ( !$from_name ) $from_name = '행복을 찾는 사람..' ; // 보내는 사람 이름
    if ( !$to_name   ) $to_name   = '행복한 사람들에게..'; // 받는   사람 이름

    if ( escapeYN() ) {
        $title   = stripslashes($title  );
        $content = stripslashes($content);
    }

    if ( check_email ( $to_mail ) ) {
        $from_mail = $from_name . ' ' . "<$from_mail>";
        $to_mail   = $to_name   . ' ' . "<$to_mail>"  ;
        mail_sender( $from_mail, $to_mail, $title, $content ); // 메일 발송
    }
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
    function sendMail() {
        var saveArea      = parent.frames[0];
        var progressArea  = parent.frames[2];
        if ( saveArea.mailSend == 'Y' && saveArea.curIdx <= saveArea.totCnt ) {
            progressArea.getMailIInfor();
        } else {
            saveArea.mailSend = 'N';
        }
    }
//-->
</SCRIPT>
<?
    closeDBConnection (); // 데이터베이스 연결 설정 해제
    footer(); // Footer 출력
}
?>