<?
include 'common/member_lib.inc'; // ��� ���̺귯��
include 'common/lib.inc'       ; // ���� ���̺귯��
include 'common/message.inc'   ; // ���� ������ ó��
include 'common/db_connect.inc'; // Data Base ���� Ŭ����

$memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����
if ( preg_match("/${HTTP_HOST}/",$HTTP_REFERER) && preg_match( "/(member_infor_search.php)/", $HTTP_REFERER) && $REQUEST_METHOD == 'POST' ) {
    $db = initDBConnection (); // �����ͺ��̽��� �����մϴ�.

    /* ----- ���� �б� ---------------------------------- */
    $memForm  = getMemFormSetup (0  ); // ȸ�� �� ����

    $mailSend = false;
    $msgNo = '';
    $sql = "select name, e_mail, user_id from $tb_member";
    if ( $memForm['jumin' ] == 'Y' ) {
        $jumin = $jumin_1 . $jumin_2;
        $where = " where name = '$name' and jumin  = password('$jumin')";
    } else {
        $where = " where name = '$name'";
    }
    if ( $memForm['hint' ] == 'Y' ) {
        if ( !escapeYN () ) { // magic_quotes_gpc Off
            $answer = addslashes($answer);
        }
        $where .= " and hint = '$hint' and answer = '$answer'";
    }

    /* mysql 4.1 - patch */
    if ( simpleSQLQuery("SELECT VERSION()") >= 4.1 ) {
        $mb_db_jumin  = simpleSQLQuery("select jumin from $tb_member where user_id = '" . addslashes($user_id) . "';");
        $mb_old_jumin = @sql_old_password($jumin);
        if( strlen($mb_db_jumin) == 16 && $mb_old_jumin == $mb_db_jumin ) {
            simpleSQLExecute("update {$tb_member} set jumin = PASSWORD('".addslashes($jumin)."') where user_id = '" . addslashes($user_id) . "'");
        }
    }
    $userInfor = singleRowSQLQuery($sql. $where); // ȸ�� ����
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
                css();
                js ('URLRef'            ); // URL  ����
                js ('FileRef'           ); // File ����
                echo ( "\n<script type='text/javascript'>\n");
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
                Message('P', '0009', "javascript:sendEnd();:�Ϸ�", $skinDir);    // ȸ�� ���� �Ϸ�
            }
        } else {
            head('ȸ�� ���� ���� �߼�');          // Header ���
            css();
            Message('P', '0010', 'CLOSE:�Ϸ�.', $skinDir    );    // ȸ�� ���Խ� ���� �Է� ���� �ʾҽ��ϴ�.
        }
    } else {
        if ( $memForm['jumin' ] == 'Y' ) {
            head('ȸ�� ���� ���� �߼�');          // Header ���
            css();
            Message('P', '0011', 'JAVASCRIPT:history.back();:���ư���:', $skinDir);    // ȸ�� ������ �������� �ʽ��ϴ�.
        } else {
            head('ȸ�� ���� ���� �߼�');          // Header ���
            css();
            Message('P', '0011', 'JAVASCRIPT:history.back();:���ư���:', $skinDir);    // ȸ�� ������ �������� �ʽ��ϴ�.
        }
    }
} else { // Parameter ������ ���
        Message('S', '0003', 'CLOSE:�ݱ�'    );    // ������ ������ �ź� �Ǿ����ϴ�.
}
?>
</head>
<body>
<?
footer(); // Footer ���
?>