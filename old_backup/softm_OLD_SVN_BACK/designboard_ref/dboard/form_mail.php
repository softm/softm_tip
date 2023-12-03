<?
include ( 'common/lib.inc'          ); // ���� ���̺귯��
include ( 'common/message.inc'      ); // ���� ������ ó��
include ( 'common/db_connect.inc'   ); // Data Base ���� Ŭ����
include ( 'common/_service.inc'     ); // ���� ȭ�� ����

//include 'common/event_lib.inc'    ; // �̺�Ʈ ���̺귯��
//include 'common/member_lib.inc'   ; // ��� ���̺귯��

$package = 'form_mail';   // ������

$db = initDBConnection (); // �����ͺ��̽� ����
$memInfor = getMemInfor (); // ȸ��   ����
$INFOR = '';
if ( $gubun == 'board' ) {
    include 'common/board_lib.inc'    ; // �Խ��� ���̺귯��
    $INFOR = getBbsInfor ( $id ); // �Խ��� ����
    $displayList      = $INFOR['display_list'];
    $displayCharacter = $displayList[9]       ;
    $grantCharStr     = $INFOR['grant_character_image']; // ȸ�� ������ ����

    if ( !$send_mail_method ) {
        $mailSendMethod = $INFOR['mail_send_method'];
    } else {
        $mailSendMethod = $send_mail_method         ;
    }
} else if ( $gubun == 'poll' ) {
    include 'common/poll_lib.inc'     ; // ���� ���̺귯��
    $INFOR = getPollInfor ( $id ); // ���� ����
    $displayCharacter = '1'      ; // �������� ȸ���̹����� ��Ų ���������� �ݿ���
    $grantCharStr = $INFOR['grant_character_image']; // ȸ�� ������ ����
    $mailSendMethod = $send_mail_method;
} else {
	// addon ��� ����
    $instDir  = $baseDir. 'addon/d' . $gubun . '/';
    $dirName  = $gubun . 'Dir';
    $$dirName = $instDir;
    include $instDir . 'common/' . $gubun . '_lib.inc'    ; // ���̺귯��
    include $$dirName . 'common/' .$gubun. '_infor.inc';
    $inforName  = $gubun . 'Infor';
    $INFOR = $$inforName; // ����
    $displayCharacter = '1'      ; // �������� ȸ���̹����� ��Ų ���������� �ݿ���
    $mailSendMethod = $send_mail_method;
}
//$bbsGrant = getBbsGrant ($bbsInfor['no'],$memInfor['member_level'] ); // ���� ����

if ( $INFOR )  { // ���� ����
    _head(); // Header ���
    echo ( "<SCRIPT LANGUAGE='JavaScript'>\n");
    echo ( "<!--\n");
    echo ( "    function windowClose() {\n");
    echo ( "        if ( typeof( opener ) == 'object' ) {\n");
    echo ( "            self.close();\n");
    echo ( "        } else {\n");
    echo ( "            history.back();\n");
    echo ( "        }\n");
    echo ( "    }\n");
    echo ( "//-->\n");
    echo ( "</SCRIPT>\n");
?>
<title><?='�� ���� - ' . $_dboard_ver?></title>
<body text='#000000' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>
<?
    if ( $mailSendMethod == '1' || $mailSendMethod == '2' ) {
        $_skinName = $INFOR['skin_name'];
        $skinDir  = 'skin/'. $gubun .'/' . $_skinName . '/'   ;
        $libDir   = "common/lib/" . $sysInfor["driver"] . '/';
        if ( !$from_mail ) $from_mail  = $memInfor['e_mail' ];
        if ( !$from_name ) $from_name  = $memInfor['name'   ];
        _css ($skinDir );   // css ����
		include $baseDir.'common/js/form_mail_js.php'; // ������ javascript

        if ( $mailSendMethod == '1' && $exec == 'send_mail' ) {
            if ( $name == '��ȸ��' ) { $name = ''; }
            $to_mail = base64_decode($to_mail);
            $to_name = base64_decode($to_name);
            echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" . "var id      = '".$id         ."';\n</SCRIPT>\n" );
            echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" . "var user_id = '".$user_id    ."';\n</SCRIPT>\n" );
            echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" . "var e_mail  = '".$e_mail     ."';\n</SCRIPT>\n" );
            echo ( "\n<FORM name='MailForm' method=post action=''><input name='gubun' type='hidden' value='$gubun'><input name='send_mail_method' type='hidden' value='$send_mail_method'><input name='exec' type='hidden' value='send_mail_exec'><input name='id' type='hidden' value='$id'><input name='user_id' type='hidden' value='$user_id'><input name='to_name' type='hidden' value='$to_name'><input name='to_mail' type='hidden' value='$to_mail'><input name='from_mail' type='hidden' value=''><input name='from_name' type='hidden' value=''><input name='title' type='hidden' value=''><input name='content' type='hidden' value=''></FORM>\n" );

            $character = '';    // ȸ�� ������
            $character = printMemberIcon($member_level          , $user_id, $displayCharacter ); // ȸ�� ������

            include $skinDir . "form_mail.php"; // �� ����

        } else if ( $mailSendMethod == '1' && $exec == 'send_mail_exec' ) {
            if( eregi($HTTP_HOST,$HTTP_REFERER) ) {
                include ( 'common/mail.inc'      ); // ���� ����

                if ( !$from_name ) $from_name = '�ູ�� ã�� ���..' ; // ������ ��� �̸�
                if ( !$to_name   ) $to_name   = '�ູ�� ����鿡��..'; // �޴�   ��� �̸�

                if ( escapeYN() ) { $content = stripslashes($content); } // �Է��ϸ鼭 �ֵ��ߴ� ����������

                    $content = str_replace("  ", "&nbsp;&nbsp;", $content );
                    $content = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$content );
                    $content = nl2br ( $content );   /* ���� */

                if ( check_email ( $to_mail ) ) {

                    $from_mail = $from_name . ' ' . "<$from_mail>";
                    $to_mail   = $to_name   . ' ' . "<$to_mail>"  ;
//                  logs ( '$from_mail : '. $from_mail . '<BR>' , true);
//                  logs ( '$to_mail : '. $to_mail . '<BR>' , true);
					include ( 'common/message_table.inc'      ); // �޽��� ���̺�
                    echo ( "\n<SCRIPT LANGUAGE='javascript'>\n alert('" . $errMsgTable['S0080'] . "'); self.close();  \n</SCRIPT>\n" );
                    // ���� �߼�
                    mail_sender( $from_mail, $to_mail, $title, $content ) Or Message ('S', '0034',"javascript:windowClose();:Ȯ��", $skinDir);
                }

            } else {
                MessageC ('S', '0035',"javascript:windowClose();:Ȯ��", $skinDir);   // �������� ������� �������� �߼����ּ���.
            }
        } else if ( $mailSendMethod == '2' && $exec == 'outlook_mail' ) {
            $to_mail = base64_decode($to_mail);
            echo ( "\n<SCRIPT LANGUAGE='javascript'>\n  self.document.location.href = 'mailto:" . $to_mail . "'; \n</SCRIPT>\n" );
//          echo ( "\n<SCRIPT LANGUAGE='javascript'>\n  self.document.location.href = 'mailto:" . $to_mail . "'; history.go(-1)\n</SCRIPT>\n" );
        } else {
        }
    } else {
        MessageC ('S', '0036',"javascript:windowClose();:Ȯ��", $skinDir);  // �������� �߼��� ���� �Ǿ����ϴ�.
    }
} // if END
else { // �Խ��� ���� ����
//  logs ('��Ų ���� ����' , true);
    head($_title);   // Header ���
    if ( $gubun == 'board' ) {
        MessageC ('S', '0004');  // �Խ����� �������� �ʽ��ϴ�.
    } else if ( $gubun == 'poll' ) {
        MessageC ('S', '0041');  // ���� ���簡 �������� �ʽ��ϴ�.
    }
} // else END

closeDBConnection (); // �����ͺ��̽� ���� ���� ����
_footer(); // Footer ���
?>
</body>