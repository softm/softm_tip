<?
include 'common/member_lib.inc'; // ��� ���̺귯��
include 'common/lib.inc'       ; // ���� ���̺귯��
include 'common/message.inc'   ; // ���� ������ ó��
include 'common/db_connect.inc'; // Data Base ���� Ŭ����

$memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����

if ( ereg($HTTP_HOST,$HTTP_REFERER) && ereg( "(member_infor_search.php)", $HTTP_REFERER) && $REQUEST_METHOD == 'POST' ) {
    include ( 'common/db_connect.inc'   ); // Data Base ���� Ŭ����
    $db = initDBConnection (); // �����ͺ��̽��� �����մϴ�.

    /* ----- ���� �б� ---------------------------------- */
    $memForm  = getMemFormSetup (0  ); // ȸ�� �� ����

    $mailSend = false;
    $msgNo = '';
    if ( $memForm['jumin' ] == 'Y' ) {
        $jumin = $jumin_1 . $jumin_2;
        $sql = "select name, e_mail, user_id from $tb_member where name = '$name' and jumin  = password('$jumin')";
    } else {
        $sql = "select name, e_mail, user_id from $tb_member where name = '$name'";
    }
    if ( $memForm['hint' ] == 'Y' ) {
        if ( !escapeYN () ) { // magic_quotes_gpc Off
            $answer = addslashes($answer);
        }
        $sql .= " and hint = '$hint' and answer = '$answer'";
    }

    $userInfor = singleRowSQLQuery($sql); // ȸ�� ����

    if ( $userInfor['e_mail'] ) { $mailSend = true; }
    $user_id = $userInfor ['user_id']; // ����� ���̵�

    if ( $mailSend ) {
        $adminInfor = singleRowSQLQuery("select name, e_mail from $tb_member where member_level = 99;"); // ������ ����

        if ( !$adminInfor['name'] ) { $from_name = '������'; } else { $from_name = $adminInfor['name']; } // ������ ��� �̸�
        if ( !$userInfor ['name'] ) { $to_name   = 'ȸ����'; } else { $to_name   = $userInfor ['name']; } // �޴�   ��� �̸�

        $from_mail = $adminInfor['e_mail']; // �޴�   ��� �̸�
        $to_mail   = $userInfor ['e_mail']; // �޴�   ��� �̸�

        include ( 'common/mail.inc'      ); // ���� ����

        if ( check_email ( $to_mail ) ) {
            if ( !escapeYN() ) { $content = addslashes($content); }

            if ( $user_id ) {
                srand(make_seed());
                $password = rand ( 10000, 10000000 );

                $fileName = 'member_password_mail_form.php';
                $fp       = fopen ($fileName, "r");
                $content  = fread ($fp, filesize ($fileName));
                fclose ($fp);
                $content  = str_replace("[user_id]" , $user_id , $content);
                $content  = str_replace("[password]", $password, $content);

                $sql  = "update $tb_member set ";
                $sql .= " password    =  PASSWORD('$password')  ";
                $sql .= " where user_id = '$user_id';";
                simpleSQLExecute($sql);

    //          echo '�߼� �ڷ� : ' . $content;

                $from_mail = $from_name . ' ' . "<$from_mail>";
                $to_mail   = $to_name   . ' ' . "<$to_mail>"  ;

                @mail_sender( $from_mail, $to_mail, '��� ��ȣ �߼�', $content ); // ���� �߼�

                head('ȸ�� ���� ���� �߼�');          // Header ���
                _css();
                _javascript ('URLRef'            ); // URL  ����
                _javascript ('FileRef'           ); // File ����
                echo ( "\n<SCRIPT LANGUAGE='javascript'>\n");
                echo ( "function sendEnd() {\n" );
                echo ( "        var url = '?id=$id&exec=$exec&no=$no&npop=$npop';\n");
                echo ( "    if ( typeof(opener     ) != 'undefined' ) {\n");
                    if ( $succ_url ) { 
    //                          echo ( "    alert ( 'start :' + getFileName('$succ_url') + ':end'); \n");
                    echo ( "    if ( getFileName ('$succ_url') == '' ) {\n");
                    echo ( "        url = '$succ_url' ;\n" );
                    echo ( "    } else {\n");
                    echo ( "        url = '$succ_url' + url;\n" );
                    echo ( "    }\n");
                    echo ( "    opener.document.location.replace( url );\n" );
                    }
                echo ( "        opener.focus();\n" );
                echo ( "        self.close();\n" );
                echo ( "    } else { \n");
                    if ( $succ_url ) { 
    //                          echo ( "    alert ( 'start :' + getFileName('$succ_url') + ':end'); \n");
                    echo ( "    if ( getFileName ('$succ_url') == '' ) {\n");
                    echo ( "        url = '$succ_url' ;\n" );
                    echo ( "    } else {\n");
                    echo ( "        url = '$succ_url' + url;\n" );
                    echo ( "    }\n");
                    } else {
                        echo ( "        url = 'http://" . $HTTP_HOST . "';\n" );
                    }
                echo ( "        document.location.replace( url );\n" );
                echo ( "    }\n");
                echo ( "}\n");
                echo ( "</SCRIPT>\n" );
                MessageC('P', '0009', "javascript:sendEnd();:�Ϸ�", $skinDir);    // ȸ�� ���� �Ϸ�
            }
        } else {
            head('ȸ�� ���� ���� �߼�');          // Header ���
            _css();
            MessageC('P', '0010', 'CLOSE:�Ϸ�.', $skinDir    );    // ȸ�� ���Խ� ���� �Է� ���� �ʾҽ��ϴ�.
        }
    } else {
        if ( $memForm['jumin' ] == 'Y' ) {
            head('ȸ�� ���� ���� �߼�');          // Header ���
            _css();
            MessageC('P', '0011', 'JAVASCRIPT:history.back();:���ư���:', $skinDir);    // ȸ�� ������ �������� �ʽ��ϴ�.
        } else {
            head('ȸ�� ���� ���� �߼�');          // Header ���
            _css();
            MessageC('P', '0011', 'JAVASCRIPT:history.back();:���ư���:', $skinDir);    // ȸ�� ������ �������� �ʽ��ϴ�.
        }
    }
} else { // Parameter ������ ���
        MessageC('S', '0003', 'CLOSE:�ݱ�'    );    // ������ ������ �ź� �Ǿ����ϴ�.
}
footer(); // Footer ���
?>