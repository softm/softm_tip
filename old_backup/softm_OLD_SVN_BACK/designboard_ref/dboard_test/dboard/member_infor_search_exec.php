<?
include 'common/member_lib.inc'; // 멤버 라이브러리
include 'common/lib.inc'       ; // 공통 라이브러리
include 'common/message.inc'   ; // 에러 페이지 처리
include 'common/db_connect.inc'; // Data Base 연결 클래스

$memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음
if ( preg_match("/${HTTP_HOST}/",$HTTP_REFERER) && preg_match( "/(member_infor_search.php)/", $HTTP_REFERER) && $REQUEST_METHOD == 'POST' ) {
    $db = initDBConnection (); // 데이터베이스에 접속합니다.

    /* ----- 정보 읽기 ---------------------------------- */
    $memForm  = getMemFormSetup (0  ); // 회원 폼 설정

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
    $userInfor = singleRowSQLQuery($sql. $where); // 회원 정보
    if ( $userInfor['e_mail'] ) { $mailSend = true; }
    $user_id = $userInfor ['user_id']; // 사용자 아이디

    if ( $mailSend ) {
        $adminInfor = singleRowSQLQuery("select name, e_mail from $tb_member where member_level = 99;"); // 관리자 정보

        if ( !$adminInfor['name'] ) { $from_name = '관리자'; } else { $from_name = $adminInfor['name']; } // 보내는 사람 이름
        if ( !$userInfor ['name'] ) { $to_name   = '회원님'; } else { $to_name   = $userInfor ['name']; } // 받는   사람 이름

        $from_mail = $adminInfor['e_mail']; // 받는   사람 이름
        $to_mail   = $userInfor ['e_mail']; // 받는   사람 이름

        include ( 'common/mail.inc'      ); // 메일 관련

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

    //          echo '발송 자료 : ' . $content;

                $from_mail = $from_name . ' ' . "<$from_mail>";
                $to_mail   = $to_name   . ' ' . "<$to_mail>"  ;

                @mail_sender( $from_mail, $to_mail, '비밀 번호 발송', $content ); // 메일 발송

                head('회원 정보 메일 발송');          // Header 출력
                css();
                js ('URLRef'            ); // URL  관련
                js ('FileRef'           ); // File 관련
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
                Message('P', '0009', "javascript:sendEnd();:완료", $skinDir);    // 회원 가입 완료
            }
        } else {
            head('회원 정보 메일 발송');          // Header 출력
            css();
            Message('P', '0010', 'CLOSE:완료.', $skinDir    );    // 회원 가입시 메일 입력 되지 않았습니다.
        }
    } else {
        if ( $memForm['jumin' ] == 'Y' ) {
            head('회원 정보 메일 발송');          // Header 출력
            css();
            Message('P', '0011', 'JAVASCRIPT:history.back();:돌아가기:', $skinDir);    // 회원 정보가 존재하지 않습니다.
        } else {
            head('회원 정보 메일 발송');          // Header 출력
            css();
            Message('P', '0011', 'JAVASCRIPT:history.back();:돌아가기:', $skinDir);    // 회원 정보가 존재하지 않습니다.
        }
    }
} else { // Parameter 조작의 경우
        Message('S', '0003', 'CLOSE:닫기'    );    // 페이지 접근이 거부 되었습니다.
}
?>
</head>
<body>
<?
footer(); // Footer 출력
?>