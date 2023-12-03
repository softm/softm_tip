<?
$IJTSEC = ( $HTTP_GET_VARS["baseDir"] || $HTTP_POST_VARS["baseDir"] || $HTTP_GET_VARS["libDir"] || $HTTP_POST_VARS["libDir"] ) ? false : true;
if ( $IJTSEC ) {
    include 'common/lib.inc'       ; // 공통 라이브러리
    include 'common/member_lib.inc'; // 멤버 라이브러리
    include 'common/message.inc'   ; // 에러 페이지 처리
    include 'common/db_connect.inc'; // Data Base 연결 클래스
    include 'common/_service.inc'  ; // 서비스 화면 관련

    $package = 'outlogin';   // 아웃 로그인

    /* ----- 정보 읽기 ---------------------------------- */
    $memInfor  = getMemInfor ( ); // 회원  정보
    $login_yn  = $memInfor['login_yn']; // 로그인 여부
    $self_yn   = ereg( "(".$HTTP_SERVER_VARS['HTTP_HOST'].")((.)*(/)+)+(dlogin.php)", $HTTP_SERVER_VARS['HTTP_HOST'] . $HTTP_SERVER_VARS['PHP_SELF'] ) ;

        $libDir = $baseDir . "common/lib/" . $sysInfor["driver"] . '/';

        if(!$_dboard_login_inc) {
            // 링크 설정
            appendParam ($a_params,'id',$id);
            appendParam ($a_params,'s',$s);
            appendParam ($a_params,'npop',$npop);
            appendParam ($a_params,'poll_id',$poll_id);
            appendParam ($a_params,'poll_exec',$poll_exec);

            $loginSkinDir= $baseDir . 'skin/login/doutlogin_' . $_dboard_ver_str . '/';

            include "common/login_setup_default.inc"  ; // 기본 설정
            if ( file_exists($loginSkinDir ."setup.php" ) ) {
                include $loginSkinDir ."setup.php"       ; // 스킨 관련 설정
            }

            if ( $login_yn == 'Y'  ) {
                $a_login ="<a href='#' style='display:none'>"                        ;  // 로그 인
                $a_logout="<a href='" . $baseDir . "logout_ok.php$a_params'>"        ;  // 로그 아웃
                $a_member_register     ="<a href='#' style='display:none'>"         ;  // 회원 가입
                $a_member_update       ="<a href='#' onClick=\"openMemberUpdate ('$member_update_mode', '$member_update_succ_url', '$member_update_popup_width', '$member_update_popup_height', '$member_update_scroll_yn' );return false;\">"   ;// 회원 수정
                $a_member_secession    ="<a href='#' onClick=\"openMemberSecession('$member_secession_mode', '$member_secession_succ_url', '$member_secession_popup_width', '$member_secession_popup_height', '$member_secession_scroll_yn');return false;\">";// 회원 탈퇴
                $a_member_infor_search ="<a href='#' style='display:none'>"   ;   // 회원 정보 찾기
            } else {
                $a_login ="<a href='#' onClick=\"loginPopup ( '$member_login_popup_width', '$member_login_popup_height', '$member_login_mode', 'doutlogin_" . $_dboard_ver_str . "' );return false;\">"       ;  // 로그 인
                $a_logout="<a href='#' style='display:none'>"                        ;  // 로그 아웃
                $a_member_register     ="<a href='#' onClick=\"openMemberRegister ('$member_register_mode', '$member_register_succ_url', '$member_register_popup_width', '$member_register_popup_height', '$member_register_scroll_yn' );return false;\">" ;   // 회원 가입
                $a_member_update       ="<a href='#' style='display:none'>"   ;   // 회원 수정
                $a_member_secession    ="<a href='#' style='display:none'>"   ;   // 회원 탈퇴
                $a_member_infor_search ="<a href='#' onClick=\"openMemberInforSearch('$member_infor_search_mode', '$member_infor_search_succ_url', '$member_infor_search_popup_width', '$member_infor_search_popup_height', '$member_infor_search_scroll_yn' );return false;\">";// 회원 정보 찾기
            }

            echo "<meta http-equiv='Content-Type' content='text/html; charset=EUC-KR'>";
            include 'common/js/common_js.php'; // 공통 javascript
            include 'common/js/login_js.php' ; // 로그인 javascript

            $login_yn       = $memInfor['login_yn']; // 로그인 여부
            $admin_yn       = $memInfor['admin_yn']; // 어드민 여부
            $user_id        = $memInfor['user_id' ]; // 아이디
            $name           = $memInfor['name'    ]; // 이름
            $point          = $memInfor['point'   ]; // 이름
            $access         = $memInfor['access'  ]; // 접속 횟수

            function createLoginBox($login_skin_name='', $sucMode='', $succUrl='', $msg='') {

                global $package, $HTTP_COOKIE_VARS, $HTTP_GET_VARS, $HTTP_SERVER_VARS;
                global $show_admin_yn_s, $show_admin_yn_e, $hide_admin_yn_s, $hide_admin_yn_e;
                global $baseDir, $loginSkinDir, $memInfor, $_dboard_ver_str, $self_yn;
                global $id, $poll_id, $poll_exec, $a_params;
                @extract($HTTP_GET_VARS     ); // Get  방식의 Parameter 값
                @extract($HTTP_SERVER_VARS  ); // Server 변수

                if ($sucMode) {
                    $suc_mode = $sucMode;
                } else {
                    $suc_mode = $HTTP_GET_VARS ['suc_mode'];
                    if ( !$suc_mode ) $suc_mode = '1';
                }
                if ($succUrl) $succ_url = $succUrl;
                if ($msg    ) $message  = $msg    ;

                $login_yn       = $memInfor['login_yn']; // 로그인 여부
                $admin_yn       = $memInfor['admin_yn']; // 어드민 여부
                $user_id        = $memInfor['user_id' ]; // 아이디
                $name           = $memInfor['name'    ]; // 이름
                $point          = $memInfor['point'   ]; // 이름
                $access         = $memInfor['access'  ]; // 접속 횟수

                if ( $admin_yn != 'Y' ) { $show_admin_yn_s = "<!--"; $show_admin_yn_e = "-->";} // 관리자 여부
                if ( $admin_yn == 'Y' ) { $hide_admin_yn_s = "<!--"; $hide_admin_yn_e = "-->";} // 관리자 여부

                // 링크 설정
                appendParam ($a_params,'id',$id);
                appendParam ($a_params,'s',$s);
                appendParam ($a_params,'npop',$npop);
                appendParam ($a_params,'poll_id',$poll_id);
                appendParam ($a_params,'poll_exec',$poll_exec);

                if ( $login_skin_name ) {
                    $loginSkinDir= $baseDir . 'skin/login/' . $login_skin_name . '/';
                } else {
//                  $loginSkinDir= $baseDir . 'skin/login/doutlogin_' . $_dboard_ver_str . '/';
                    $loginSkinDir= $baseDir . 'skin/login/doutlogin_2_0/';
                }
                _css ($loginSkinDir );   // css 설정

                include "common/login_setup_default.inc"  ; // 기본 설정
                if ( file_exists($loginSkinDir ."setup.php" ) ) {
                    include $loginSkinDir ."setup.php"       ; // 스킨 관련 설정
                }

                if ( $login_yn == 'Y' ) {
                    $a_login ="<a href='#' style='display:none'>"                        ;  // 로그 인
//                  $a_logout="<a href='" . $baseDir . "logout_ok.php$a_params'>"        ;  // 로그 아웃
                    $a_logout="<a href='#' onClick=\"return logout();\">"        ;  // 로그 아웃
                    $a_member_register     ="<a href='#' style='display:none'>"         ;  // 회원 가입
                    $a_member_update       ="<a href='#' onClick=\"openMemberUpdate ('$member_update_mode', '$member_update_succ_url', '$member_update_popup_width', '$member_update_popup_height', '$member_update_scroll_yn' );return false;\">"   ;// 회원 수정
                    $a_member_secession    ="<a href='#' onClick=\"openMemberSecession('$member_secession_mode', '$member_secession_succ_url', '$member_secession_popup_width', '$member_secession_popup_height', '$member_secession_scroll_yn');return false;\">";// 회원 탈퇴
                    $a_member_infor_search ="<a href='#' style='display:none'>"   ;   // 회원 정보 찾기
                } else {
                    $a_login ="<a href='#' onClick=\"loginPopup ( '$member_login_popup_width', '$member_login_popup_height', '$member_login_mode', 'doutlogin_" . $_dboard_ver_str . "' );return false;\">"       ;  // 로그 인
                    $a_logout="<a href='#' style='display:none'>"                        ;  // 로그 아웃
                    $a_member_register     ="<a href='#' onClick=\"openMemberRegister ('$member_register_mode', '$member_register_succ_url', '$member_register_popup_width', '$member_register_popup_height', '$member_register_scroll_yn' );return false;\">" ;   // 회원 가입
                    $a_member_update       ="<a href='#' style='display:none'>"   ;   // 회원 수정
                    $a_member_secession    ="<a href='#' style='display:none'>"   ;   // 회원 탈퇴
                    $a_member_infor_search ="<a href='#' onClick=\"openMemberInforSearch('$member_infor_search_mode', '$member_infor_search_succ_url', '$member_infor_search_popup_width', '$member_infor_search_popup_height', '$member_infor_search_scroll_yn' );return false;\">";// 회원 정보 찾기
                }

                $a_cancle = "<a href='javascript:history.back();'>";

                $save_id  = $HTTP_COOKIE_VARS["_d_save_id"   ]; // 자동 로그인 여부

                if ( $login_yn == 'Y' ) {
                echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'><FORM name='logoutForm' METHOD=POST onSubmit=\"return logout(this);\"></TABLE>\n";
                    if ( $lg == 'Y' ) {
                        $message  = getUrlParamValue($QUERY_STRING, 'message' );
                        $succ_url = getUrlParamValue($QUERY_STRING, 'succ_url');
                        echo ( "\n<SCRIPT LANGUAGE='javascript'>\n ");
                        echo ( "    document.writeln ( \"<input name='suc_mode' type='hidden' value='\" + '" . $suc_mode . "' + \"'>\");\n");
                        echo ( "    document.writeln ( \"<input name='message'  type='hidden' value='\" + decodeURI( '" . $message . "') + \"'>\");\n");
                        echo ( "    document.writeln ( \"<input name='succ_url' type='hidden' value='\" + decodeURI( '" . $succ_url. "') + \"'>\");\n");
                        echo ( "\n</SCRIPT>\n ");
                    } else {
                        $message = urldecode($message );
                        $succ_url= urldecode($succ_url);
                    }
                // popupMode : '1' : 로그아웃화면
                //             '2' : 메시지화면
                //             '3' : 지정URL로 이동
                //             '4' : 팝업닫기
                    if ( $suc_mode == '1' ) { // 로그아웃화면
//                      echo $suc_mode . ' / 로그아웃화면';
                        include $loginSkinDir ."logout.php"          ; // 아웃 로그아웃 스킨
                    } else if ( $suc_mode == '2' ) { // 메시지화면
//                      echo $suc_mode . ' / 메시지화면';
                        if ( $lg == 'Y' ) {
                            include $loginSkinDir ."logout.php"          ; // 아웃 로그아웃 스킨
                        } else {
//                          echo $succ_url;
                            MessageC('M', "javascript:comfirmClick(\"" . $succ_url ."\");:확인", $message, $loginSkinDir);    // 회원 성공
                        }
//                        echo '흠냠 :' . $message . '<BR>';
                    } else if ( $suc_mode == '3' ) { // 지정URL로
//                      echo $suc_mode . ' / 지정URL로 이동';
                        include $loginSkinDir ."logout.php"          ; // 아웃 로그아웃 스킨
                    } else if ( $suc_mode == '4' ) { // 팝업닫기
//                      echo $suc_mode . ' / 팝업닫기';
                        include $loginSkinDir ."logout.php"          ; // 아웃 로그아웃 스킨
                    }
                    echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'></FORM></TABLE>";
                } else {
                    if ( $self_yn ) {
                        $message = getUrlParamValue( $QUERY_STRING , 'message' );
                        $succ_url= getUrlParamValue( $QUERY_STRING , 'succ_url');
                    }

                    echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'><FORM METHOD=POST onSubmit=\"return loginFormSubmit(this);\"><input name='suc_mode' type='hidden' value='$suc_mode'><input name='message' type='hidden' value='$message'><input name='succ_url' type='hidden' value='$succ_url'><input name='login_skin_name' type='hidden' value='$login_skin_name'></TABLE>\n";
                    if ( $save_id == 'Y' ) {
                        $user_id = $HTTP_COOKIE_VARS["_d_user_id"   ]; // 사용자 아이디
                    } else {
                        $user_id = ''; // 사용자 아이디
                    }
                    include $loginSkinDir ."login.php"               ; // 로그인   스킨
                    echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'></FORM></TABLE>";

                    if ( $save_id == 'Y' ) {
                        echo ( "<SCRIPT LANGUAGE='JavaScript'>\n");
                        echo ( "<!--\n");
                        echo (" if ( typeof(getObject ('save_id')) == 'object' ) { \n");
                        echo ("     getObject ('save_id').checked=true; \n");
                        echo (" }\n");
                        echo ( "//-->\n");
                        echo ( "</SCRIPT>\n");
                    }
                }
            }
            $_dboard_login_inc = true; // 디보드 패키지 내에서 아웃 로그인 공통 관련 인클루드 실행 여부
        }

    if ( $self_yn ) {
        createLoginBox($login_skin_name);
    }
}
?>