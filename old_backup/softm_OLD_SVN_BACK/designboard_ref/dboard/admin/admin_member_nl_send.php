<?
set_time_limit ( 0 );
$baseDir = '../';
include ( "../common/lib.inc"          ); // ���� ���̺귯��
include ( "../common/message.inc"      ); // ���� ������ ó��
include ( '../common/db_connect.inc'   ); // Data Base ���� Ŭ����
$memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����

if ( $memInfor['admin_yn'] == 'Y' ) {
    head("",'sendMail();');        // Header ���
    _css($baseDir);
    include ( '../common/mail.inc'     ); // ���� ����

    $percent = 0;
    if ( !$from_name ) $from_name = '�ູ�� ã�� ���..' ; // ������ ��� �̸�
    if ( !$to_name   ) $to_name   = '�ູ�� ����鿡��..'; // �޴�   ��� �̸�

    if ( escapeYN() ) {
        $title   = stripslashes($title  );
        $content = stripslashes($content);
    }

    if ( check_email ( $to_mail ) ) {
        $from_mail = $from_name . ' ' . "<$from_mail>";
        $to_mail   = $to_name   . ' ' . "<$to_mail>"  ;
        mail_sender( $from_mail, $to_mail, $title, $content ); // ���� �߼�
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
    closeDBConnection (); // �����ͺ��̽� ���� ���� ����
    footer(); // Footer ���
}
?>