<?
include ( 'common/lib.inc'          ); // 공통 라이브러리
include ( 'common/message.inc'      ); // 에러 페이지 처리
include ( 'common/db_connect.inc'   ); // Data Base 연결 클래스
include ( 'common/_service.inc'     ); // 서비스 화면 관련

//include 'common/event_lib.inc'    ; // 이벤트 라이브러리
//include 'common/member_lib.inc'   ; // 멤버 라이브러리

$package = 'form_mail';   // 폼메일

$db = initDBConnection (); // 데이터베이스 접속
$memInfor = getMemInfor (); // 회원   정보
$INFOR = '';
if ( $gubun == 'board' ) {
    include 'common/board_lib.inc'    ; // 게시판 라이브러리
    $INFOR = getBbsInfor ( $id ); // 게시판 정보
    $displayList      = $INFOR['display_list'];
    $displayCharacter = $displayList[9]       ;
    $grantCharStr     = $INFOR['grant_character_image']; // 회원 아이콘 권한

    if ( !$send_mail_method ) {
        $mailSendMethod = $INFOR['mail_send_method'];
    } else {
        $mailSendMethod = $send_mail_method         ;
    }
} else if ( $gubun == 'poll' ) {
    include 'common/poll_lib.inc'     ; // 설문 라이브러리
    $INFOR = getPollInfor ( $id ); // 설문 정보
    $displayCharacter = '1'      ; // 설문에서 회원이미지는 스킨 의존적으로 반영됨
    $grantCharStr = $INFOR['grant_character_image']; // 회원 아이콘 권한
    $mailSendMethod = $send_mail_method;
} else {
	// addon 모듈 설정
    $instDir  = $baseDir. 'addon/d' . $gubun . '/';
    $dirName  = $gubun . 'Dir';
    $$dirName = $instDir;
    include $instDir . 'common/' . $gubun . '_lib.inc'    ; // 라이브러리
    include $$dirName . 'common/' .$gubun. '_infor.inc';
    $inforName  = $gubun . 'Infor';
    $INFOR = $$inforName; // 정보
    $displayCharacter = '1'      ; // 설문에서 회원이미지는 스킨 의존적으로 반영됨
    $mailSendMethod = $send_mail_method;
}
//$bbsGrant = getBbsGrant ($bbsInfor['no'],$memInfor['member_level'] ); // 권한 정보

if ( $INFOR )  { // 정보 존재
    _head(); // Header 출력
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
<title><?='폼 메일 - ' . $_dboard_ver?></title>
<body text='#000000' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>
<?
    if ( $mailSendMethod == '1' || $mailSendMethod == '2' ) {
        $_skinName = $INFOR['skin_name'];
        $skinDir  = 'skin/'. $gubun .'/' . $_skinName . '/'   ;
        $libDir   = "common/lib/" . $sysInfor["driver"] . '/';
        if ( !$from_mail ) $from_mail  = $memInfor['e_mail' ];
        if ( !$from_name ) $from_name  = $memInfor['name'   ];
        _css ($skinDir );   // css 설정
		include $baseDir.'common/js/form_mail_js.php'; // 폼메일 javascript

        if ( $mailSendMethod == '1' && $exec == 'send_mail' ) {
            if ( $name == '비회원' ) { $name = ''; }
            $to_mail = base64_decode($to_mail);
            $to_name = base64_decode($to_name);
            echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" . "var id      = '".$id         ."';\n</SCRIPT>\n" );
            echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" . "var user_id = '".$user_id    ."';\n</SCRIPT>\n" );
            echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" . "var e_mail  = '".$e_mail     ."';\n</SCRIPT>\n" );
            echo ( "\n<FORM name='MailForm' method=post action=''><input name='gubun' type='hidden' value='$gubun'><input name='send_mail_method' type='hidden' value='$send_mail_method'><input name='exec' type='hidden' value='send_mail_exec'><input name='id' type='hidden' value='$id'><input name='user_id' type='hidden' value='$user_id'><input name='to_name' type='hidden' value='$to_name'><input name='to_mail' type='hidden' value='$to_mail'><input name='from_mail' type='hidden' value=''><input name='from_name' type='hidden' value=''><input name='title' type='hidden' value=''><input name='content' type='hidden' value=''></FORM>\n" );

            $character = '';    // 회원 아이콘
            $character = printMemberIcon($member_level          , $user_id, $displayCharacter ); // 회원 아이콘

            include $skinDir . "form_mail.php"; // 폼 메일

        } else if ( $mailSendMethod == '1' && $exec == 'send_mail_exec' ) {
            if( eregi($HTTP_HOST,$HTTP_REFERER) ) {
                include ( 'common/mail.inc'      ); // 메일 관련

                if ( !$from_name ) $from_name = '행복을 찾는 사람..' ; // 보내는 사람 이름
                if ( !$to_name   ) $to_name   = '행복한 사람들에게..'; // 받는   사람 이름

                if ( escapeYN() ) { $content = stripslashes($content); } // 입력하면서 애드했던 슬래쉬빼기

                    $content = str_replace("  ", "&nbsp;&nbsp;", $content );
                    $content = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$content );
                    $content = nl2br ( $content );   /* 내용 */

                if ( check_email ( $to_mail ) ) {

                    $from_mail = $from_name . ' ' . "<$from_mail>";
                    $to_mail   = $to_name   . ' ' . "<$to_mail>"  ;
//                  logs ( '$from_mail : '. $from_mail . '<BR>' , true);
//                  logs ( '$to_mail : '. $to_mail . '<BR>' , true);
					include ( 'common/message_table.inc'      ); // 메시지 테이블
                    echo ( "\n<SCRIPT LANGUAGE='javascript'>\n alert('" . $errMsgTable['S0080'] . "'); self.close();  \n</SCRIPT>\n" );
                    // 메일 발송
                    mail_sender( $from_mail, $to_mail, $title, $content ) Or Message ('S', '0034',"javascript:windowClose();:확인", $skinDir);
                }

            } else {
                MessageC ('S', '0035',"javascript:windowClose();:확인", $skinDir);   // 정상적인 방법으로 폼메일을 발송해주세요.
            }
        } else if ( $mailSendMethod == '2' && $exec == 'outlook_mail' ) {
            $to_mail = base64_decode($to_mail);
            echo ( "\n<SCRIPT LANGUAGE='javascript'>\n  self.document.location.href = 'mailto:" . $to_mail . "'; \n</SCRIPT>\n" );
//          echo ( "\n<SCRIPT LANGUAGE='javascript'>\n  self.document.location.href = 'mailto:" . $to_mail . "'; history.go(-1)\n</SCRIPT>\n" );
        } else {
        }
    } else {
        MessageC ('S', '0036',"javascript:windowClose();:확인", $skinDir);  // 폼메일을 발송이 제한 되었습니다.
    }
} // if END
else { // 게시판 정보 없음
//  logs ('스킨 정보 없음' , true);
    head($_title);   // Header 출력
    if ( $gubun == 'board' ) {
        MessageC ('S', '0004');  // 게시판이 존재하지 않습니다.
    } else if ( $gubun == 'poll' ) {
        MessageC ('S', '0041');  // 설문 조사가 존재하지 않습니다.
    }
} // else END

closeDBConnection (); // 데이터베이스 연결 설정 해제
_footer(); // Footer 출력
?>
</body>