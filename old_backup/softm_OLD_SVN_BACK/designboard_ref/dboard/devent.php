<?
error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE ( Notice는 제외한 모든에러를 리포팅해라~ )
$IJTSEC = ( $HTTP_GET_VARS["baseDir"] || $HTTP_POST_VARS["baseDir"] || $HTTP_GET_VARS["libDir"] || $HTTP_POST_VARS["libDir"] ) ? false : true;
if ( $IJTSEC ) {
    include 'common/lib.inc'       ; // 공통 라이브러리
    include 'common/event_lib.inc' ; // 이벤트 라이브러리
    include 'common/member_lib.inc'; // 멤버 라이브러리
    include 'common/message.inc'   ; // 에러 페이지 처리
    include 'common/db_connect.inc'; // Data Base 연결 클래스
    include 'common/_service.inc'  ; // 서비스 화면 관련

    $package = 'event';   // 이벤트
    $a_event_join  = '';  // 이벤트 참가
    $a_event_close = '';  // 이벤트 창 닫기

    // 정보 읽기
    $memInfor    = getMemInfor (); // 회원  정보
    $login_yn    = $memInfor['login_yn'    ]; // 로그인 여부
    $user_id     = $memInfor['user_id'     ]; // 아이디
    $admin_yn    = $memInfor['admin_yn'    ]; // 어드민 여부
    $memberlevel = $memInfor['member_level']; // 회원 등급
	include 'common/js/common_js.php'; // 공통 javascript

    if(!$_dboard_event_included) { // 한번만 인클루드 되게 처리
		include 'common/js/event_js.php'; // 이벤트 javascript
        $_dboard_event_inc_cnt = 1;
        echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'><FORM name='_dboard_eventForm' METHOD=POST ACTION='' onSubmit='return eventJoin(this,\"$event_id\");'><input type='hidden' name='event_id' value='$event_id'><input type='hidden' name='event_exec' value=''></FORM></TABLE>\n";
    }

    /* ----------------------- 삭제 불가 ------------------------ */
    if(!$_dboard_event_included) { // 한번만 인클루드 되게 처리
        $_dboard_event_included = true;

	    eventFormCreate(); // 폼 생성

        echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" );
        echo ( "    var login_yn = \"" . $memInfor['login_yn'] . "\"\n");
        echo ( "\n</SCRIPT>\n" );

        // 이벤트 정보 메시지 생성
        function eventMsgMake() {
            global $login_yn, $grant, $_dboard_event_inc_cnt, $errMsgTable;
            if ( $_dboard_event_inc_cnt == 1 ) {
				include 'common/message_table.inc'; // 메시지 테이블
                echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" );
                if ( $login_yn == 'N' ) {
                    echo ( "    var message = '" . $errMsgTable['S0074'] . "';"); // 로그인후 참가해주세요.
                } else if ( $grant != 'Y' ) {
                    echo ( "    var message = '" . $errMsgTable['S0073'] . "';"); // 이벤트 참가 권한이 없습니다.
                } else {
                    echo ( "    var message = '" . $errMsgTable['S0077'] . "';"); // 이벤트에 참가하시겠습니까?
                }
                echo ( "\n</SCRIPT>\n" );
            }
        }

        // 이벤트 참가 정보 메시지 생성
        function eventJoinMsg() {
            global $event_join, $_dboard_event_inc_cnt, $errMsgTable;
            if ( $event_join == 'Y' && $_dboard_event_inc_cnt == 1 ) {
                echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" );
                echo ( "    alert ('" . $errMsgTable['S0075'] . "');");
                echo ( "\n</SCRIPT>\n" );
            }
        }

        // 이미 이벤트에 참가했을때 메시지 생성
        function alreadyJoinMsg() {
            global $db, $tb_event_result_master, $event_id, $user_id, $_dboard_event_inc_cnt, $errMsgTable, $join_check;

            $chkSql  = "select count(no) from $tb_event_result_master ";
            $chkSql .= " where  no      = '" . $event_id    . "'";
            $chkSql .= " and    user_id = '" . $user_id     . "'";

            $existChk = simpleSQLQuery($chkSql);
            if ( $_dboard_event_inc_cnt == 1 ) {
            echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" );
                if ( $existChk ) {
                    echo ( "    var alreadyJoin = 'Y';");
                    echo ( "    message = '" . $errMsgTable['S0076'] . "';"); // 이벤트에 이미 참가하셨습니다.
                    if ( $join_check == 'Y' ) {
                        echo ( "    alert ( message );");
                    }
                } else {
                    echo ( "    var alreadyJoin = 'N';");
                }
            echo ( "\n</SCRIPT>\n" );
            }
        }

        // 이벤트 조사를 생성 합니다.
        function createEvent($event_id) {
            global $db, $package, $isconnected, $sysInfor, $baseDir, $_dboard_event_inc_cnt;
            global $login_yn, $user_id, $admin_yn, $memberlevel, $a_event_join, $a_event_close, $grant, $event_join, $join_check;

            global $HTTP_SERVER_VARS, $HTTP_GET_VARS, $HTTP_COOKIE_VARS;
            @extract($HTTP_SERVER_VARS); // Server 변수
            $package = 'event';   // 이벤트

            $lg             = $HTTP_GET_VARS ['lg'        ];
            $event_join     = $HTTP_GET_VARS ['event_join'];
            $join_check     = $HTTP_GET_VARS ['join_check'];

            $db = initDBConnection ();             // 데이터베이스 접속

            $libDir     = $baseDir . "common/lib/" . $sysInfor["driver"] . '/';

            /* ------- 이벤트 정보 -------------------------------------- */
            $eventInfor = getEventInfor($event_id               ); // 이벤트 정보
            $eventGrant = getEventGrant($event_id, $memberlevel ); // 권한   정보
            $grant      = $eventGrant['grant_join'];

            include $baseDir ."common/event_setup_default.inc"  ; // 기본 설정

            $start_date   = $eventInfor['start_date'  ]; // 이벤트 시작일
            $start_year   = substr($start_date, 0 ,4);
            $start_month  = substr($start_date, 4 ,2);
            $start_day    = substr($start_date, 6 ,2);
            $start_hour   = substr($start_date, 8 ,2);
            $end_date     = $eventInfor['end_date'    ]; // 이벤트 종료일
            $end_year     = substr($end_date  , 0 ,4);
            $end_month    = substr($end_date  , 4 ,2);
            $end_day      = substr($end_date  , 6 ,2);
            $end_hour     = substr($end_date  , 8 ,2);

            if ( ( $compare_date - $sysDate ) < 0 && $admin_yn == 'N' ) {
                MessageC ('S', '0072',"", $skinDir); // 이벤트가 종료 되었습니다.
            } else {
                if ( $eventInfor )  { // 게시판 정보 존재

                    $grant = $eventGrant['grant_join'];
                    if      ( $admin_yn == 'Y' ) { $grant = 'Y'; }
                    
                    $a_cancle     = "<a href='javascript:history.back();'>";
                    $a_event_join = "<a href='#' onClick=\"eventJoin(document._dboard_eventForm[$_dboard_event_inc_cnt],'$event_id','$grant');return false;\">";  // 이벤트 참가
                    $a_event_close= "<a href='#' onclick=\"closeEventPopup(1);return false;\">"; // 이벤트 창 닫기

                    $display_mode = $eventInfor['display_mode']; // 이벤트 표시형식 ( '1' : 팝업, '2' : 현재창, '3' : 링크 )

                    if  ( $lg == 'Y' && $login_yn == 'N' ) {                  // 로그인

                        $use_default_login = $eventInfor['use_default_login'];
                        $login_skin_name   = '';
                        if ( $use_default_login == 'Y' ) {
                            $login_skin_name   = $sysInfor['login_skin'];
                        } else {
                            $login_skin_name   = $eventInfor['login_skin_name'];
                        }
                        $loginSkinDir= $baseDir . 'skin/login/' . $login_skin_name . '/';

                        _css ($loginSkinDir );   // css 설정

                        if ( file_exists($loginSkinDir ."setup.php" ) ) {
                            include $loginSkinDir ."setup.php"       ; // 스킨 관련 설정
                        }

                        include $baseDir ."common/login_setup_default.inc"  ; // 기본 설정
                        if ( $login_yn == 'Y' ) {
                            $a_login ="<a href='#' style='display:none'>"                ;  // 로그 인
        //                  $a_logout="<a href='" . $baseDir . "logout_ok.php$a_params'>";  // 로그 아웃
                            $a_logout="<a href='#' onClick=\"return logout();\">"        ;  // 로그 아웃
                            $a_member_register     ="<a href='#' style='display:none'>"  ;  // 회원 가입
                            $a_member_update       ="<a href='#' onClick=\"openMemberUpdate ('$member_update_mode', '$member_update_succ_url', '$member_update_popup_width', '$member_update_popup_height', '$member_update_scroll_yn' );return false;\">"   ;// 회원 수정
                            $a_member_secession    ="<a href='#' onClick=\"openMemberSecession('$member_secession_mode', '$member_secession_succ_url', '$member_secession_popup_width', '$member_secession_popup_height', '$member_secession_scroll_yn');return false;\">";// 회원 탈퇴
                            $a_member_infor_search ="<a href='#' style='display:none'>"   ;   // 회원 정보 찾기
                        } else {
                            $a_login ="<a href='#' onClick=\"loginPopup ( '$member_login_popup_width', '$member_login_popup_height', '$member_login_mode', 'doutlogin_" . $_dboard_ver_str . "' );return false;\">"       ;  // 로그 인
                            $a_logout="<a href='#' style='display:none'>"                ;  // 로그 아웃
                            $a_member_register     ="<a href='#' onClick=\"openMemberRegister ('$member_register_mode', '$member_register_succ_url', '$member_register_popup_width', '$member_register_popup_height', '$member_register_scroll_yn' );return false;\">" ;   // 회원 가입
                            $a_member_update       ="<a href='#' style='display:none'>"  ;   // 회원 수정
                            $a_member_secession    ="<a href='#' style='display:none'>"  ;   // 회원 탈퇴
                            $a_member_infor_search ="<a href='#' onClick=\"openMemberInforSearch('$member_infor_search_mode', '$member_infor_search_succ_url', '$member_infor_search_popup_width', '$member_infor_search_popup_height', '$member_infor_search_scroll_yn' );return false;\">";// 회원 정보 찾기
                        }

                        echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'><FORM METHOD=POST onSubmit=\"return loginFormSubmit(this);\"><input name='suc_mode' type='hidden' value='$suc_mode'><input name='message' type='hidden' value='$message'><input name='succ_url' type='hidden' value='$succ_url'></TABLE>\n";
                        $save_id  = $HTTP_COOKIE_VARS["_d_save_id"   ]; // 자동 로그인 여부
                        if ( $save_id == 'Y' ) {
                            $user_id = $HTTP_COOKIE_VARS["_d_user_id"   ]; // 사용자 아이디
                        } else {
                            $user_id = ''; // 사용자 아이디
                        }
                        include $loginSkinDir ."login.php"               ; // 로그인   스킨
                        echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'></FORM></TABLE>";
                    } else if ( $display_mode == '1' ) { // 팝업
                        $window_width   = $eventInfor['window_width' ];
                        $window_height  = $eventInfor['window_height'];
                        $left_pos       = $eventInfor['left_pos'     ];
                        $top_pos        = $eventInfor['top_pos'      ];

                        $popup_open     = $HTTP_COOKIE_VARS[popup_open   ]; // 팝업 여부
                        echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" );
                        echo ( "    if ( getCookie('popup_open') != 'N') {\n");
                        $scoll_yn = ( $eventInfor['scroll_yn'] == 'Y' ) ? "yes" : "no";
                        echo ( "        var eventWin = window.open(\"" . $baseDir . "devent.php?event_id=" . $event_id . "&popup_yn=Y\",\"event\",\"location=no,toolbar=no,menubar=no,resizable=no,scrollbars=". $scoll_yn .",top=$top_pos,left=$left_pos,width=$window_width\,height=$window_height\");\n");
                        echo ( "        eventWin.focus();\n");
                        echo ( "    }\n");

                        echo ( "\n</SCRIPT>\n" );
                    } else if ( $display_mode == '2' ) { // 현재창
                        eventMsgMake(); // 이벤트 정보 메시지 생성

                        echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'><FORM name='_dboard_eventForm' METHOD=POST ACTION='' onSubmit='return eventJoin(this, \"$event_id\", \"$grant\");'><input type='hidden' name='event_id' value='$event_id'><input type='hidden' name='event_exec' value=''></TABLE>\n";
                        include ( $baseDir . "data/event/" . $event_id . "/_dboard_event.php" );
                        echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'></FORM></TABLE>";
                        eventJoinMsg();   // 이벤트 참가 메시지
                        alreadyJoinMsg(); // 이미 이벤트에 참가했을때 메시지
                        $_dboard_event_inc_cnt++;
                    } else if ( $display_mode == '3' ) { // 링크

                    }
                } // if END
                else { // 이벤트 조사 정보 없음
                    MessageC ('S', '0071');  // 이벤트가 존재하지 않습니다.
                } // else END
            }

            closeDBConnection (); // 데이터베이스 연결 설정 해제
        }

        // 이벤트 조사를 생성 합니다. [팝업일때 실행]
        function createEventOpen($event_id, $event_exec='event') {
            global $db, $package, $isconnected, $sysInfor, $baseDir, $_dboard_event_inc_cnt;
            global $login_yn, $user_id, $admin_yn, $memberlevel, $a_event_join, $a_event_close, $grant, $event_join, $join_check;
            global $HTTP_SERVER_VARS, $HTTP_GET_VARS, $HTTP_COOKIE_VARS;
            @extract($HTTP_SERVER_VARS); // Server 변수
            $package = 'event';   // 이벤트

            $lg             = $HTTP_GET_VARS ['lg'        ];
            $event_join     = $HTTP_GET_VARS ['event_join'];
            $join_check     = $HTTP_GET_VARS ['join_check'];

            $db = initDBConnection ();             // 데이터베이스 접속

            $libDir     = $baseDir . "common/lib/" . $sysInfor["driver"] . '/';

            /* ------- 이벤트 정보 -------------------------------------- */
            $eventInfor = getEventInfor($event_id               ); // 이벤트 정보
            $eventGrant = getEventGrant($event_id, $memberlevel ); // 권한   정보
            $grant      = $eventGrant['grant_join'];

            include $baseDir ."common/event_setup_default.inc"  ; // 기본 설정

            $start_date   = $eventInfor['start_date'  ]; // 이벤트 시작일
            $start_year   = substr($start_date, 0 ,4);
            $start_month  = substr($start_date, 4 ,2);
            $start_day    = substr($start_date, 6 ,2);
            $start_hour   = substr($start_date, 8 ,2);
            $end_date     = $eventInfor['end_date'    ]; // 이벤트 종료일
            $end_year     = substr($end_date  , 0 ,4);
            $end_month    = substr($end_date  , 4 ,2);
            $end_day      = substr($end_date  , 6 ,2);
            $end_hour     = substr($end_date  , 8 ,2);

            if ( ( $compare_date - $sysDate ) < 0 && $admin_yn == 'N' ) {
                MessageC ('S', '0072',"", $skinDir); // 이벤트가 종료 되었습니다.
            } else {
                if ( $eventInfor )  { // 게시판 정보 존재
                    $grant = $eventGrant['grant_join'];
                    if      ( $admin_yn == 'Y' ) { $grant = 'Y'; }

                    $a_cancle     = "<a href='javascript:history.back();'>";
                    $a_event_join = "<a href='#' onClick=\"eventJoin(document._dboard_eventForm[$_dboard_event_inc_cnt],'$event_id','$grant');return false;\">";  // 이벤트 참가
                    $a_event_close= "<a href='#' onclick=\"closeEventPopup(1);return false;\">"; // 이벤트 창 닫기

                    $display_mode = $eventInfor['display_mode']; // 이벤트 표시형식 ( '1' : 팝업, '2' : 현재창, '3' : 링크 )

                    if  ( $lg == 'Y' && $login_yn == 'N' ) {                  // 로그인

                        $use_default_login = $eventInfor['use_default_login'];
                        $login_skin_name   = '';
                        if ( $use_default_login == 'Y' ) {
                            $login_skin_name   = $sysInfor['login_skin'];
                        } else {
                            $login_skin_name   = $eventInfor['login_skin_name'];
                        }
                        $loginSkinDir= $baseDir . 'skin/login/' . $login_skin_name . '/';

                        _css ($loginSkinDir );   // css 설정

                        if ( file_exists($loginSkinDir ."setup.php" ) ) {
                            include $loginSkinDir ."setup.php"       ; // 스킨 관련 설정
                        }

                        include $baseDir ."common/login_setup_default.inc"  ; // 기본 설정
                        if ( $login_yn == 'Y' ) {
                            $a_login ="<a href='#' style='display:none'>"                ;  // 로그 인
        //                  $a_logout="<a href='" . $baseDir . "logout_ok.php$a_params'>";  // 로그 아웃
                            $a_logout="<a href='#' onClick=\"return logout();\">"        ;  // 로그 아웃
                            $a_member_register     ="<a href='#' style='display:none'>"  ;  // 회원 가입
                            $a_member_update       ="<a href='#' onClick=\"openMemberUpdate ('$member_update_mode', '$member_update_succ_url', '$member_update_popup_width', '$member_update_popup_height', '$member_update_scroll_yn' );return false;\">"   ;// 회원 수정
                            $a_member_secession    ="<a href='#' onClick=\"openMemberSecession('$member_secession_mode', '$member_secession_succ_url', '$member_secession_popup_width', '$member_secession_popup_height', '$member_secession_scroll_yn');return false;\">";// 회원 탈퇴
                            $a_member_infor_search ="<a href='#' style='display:none'>"   ;   // 회원 정보 찾기
                        } else {
                            $a_login ="<a href='#' onClick=\"loginPopup ( '$member_login_popup_width', '$member_login_popup_height', '$member_login_mode', 'doutlogin_" . $_dboard_ver_str . "' );return false;\">"       ;  // 로그 인
                            $a_logout="<a href='#' style='display:none'>"                ;  // 로그 아웃
                            $a_member_register     ="<a href='#' onClick=\"openMemberRegister ('$member_register_mode', '$member_register_succ_url', '$member_register_popup_width', '$member_register_popup_height', '$member_register_scroll_yn' );return false;\">" ;   // 회원 가입
                            $a_member_update       ="<a href='#' style='display:none'>"  ;   // 회원 수정
                            $a_member_secession    ="<a href='#' style='display:none'>"  ;   // 회원 탈퇴
                            $a_member_infor_search ="<a href='#' onClick=\"openMemberInforSearch('$member_infor_search_mode', '$member_infor_search_succ_url', '$member_infor_search_popup_width', '$member_infor_search_popup_height', '$member_infor_search_scroll_yn' );return false;\">";// 회원 정보 찾기
                        }

                        echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'><FORM METHOD=POST onSubmit=\"return loginFormSubmit(this);\"><input name='suc_mode' type='hidden' value='$suc_mode'><input name='message' type='hidden' value='$message'><input name='succ_url' type='hidden' value='$succ_url'></TABLE>\n";
                        $save_id  = $HTTP_COOKIE_VARS["_d_save_id"   ]; // 자동 로그인 여부
                        if ( $save_id == 'Y' ) {
                            $user_id = $HTTP_COOKIE_VARS["_d_user_id"   ]; // 사용자 아이디
                        } else {
                            $user_id = ''; // 사용자 아이디
                        }
                        include $loginSkinDir ."login.php"               ; // 로그인   스킨
                        echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'></FORM></TABLE>";
                    } else {
                        eventMsgMake(); // 이벤트 정보 메시지 생성
                        echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'><FORM name='_dboard_eventForm' METHOD=POST ACTION='' onSubmit='return eventJoin(this, \"$event_id\", \"$grant\");'><input type='hidden' name='event_id' value='$event_id'><input type='hidden' name='event_exec' value=''></TABLE>\n";
                        include ( $baseDir . "data/event/" . $event_id . "/_dboard_event.php" );
                        echo "\n<TABLE border='0' cellspacing='0' cellpadding='0' align='center'></FORM></TABLE>";
                        eventJoinMsg();   // 이벤트 참가 메시지
                        alreadyJoinMsg(); // 이미 이벤트에 참가했을때 메시지
                        $_dboard_event_inc_cnt++;
                    }
                } // if END
                else { // 이벤트 조사 정보 없음
                    MessageC ('S', '0071');  // 이벤트가 존재하지 않습니다.
                } // else END
            }

            closeDBConnection (); // 데이터베이스 연결 설정 해제
        }

        // 이벤트 조사를 생성 합니다.
        function createRecentEvent ( $event_exec='poll' ) {
            global $db, $isconnected;
            $db = initDBConnection ();             // 데이터베이스 접속
            $event_id  = getRecentEventNo ();
            $event_day = getYearToDay();
            createEvent ($event_id);
            closeDBConnection (); // 데이터베이스 연결 설정 해제
        }
    }

    if ( ereg( "(".$HTTP_SERVER_VARS['HTTP_HOST'].")((.)*(/)+)+(devent.php)", $HTTP_SERVER_VARS['HTTP_HOST'] . $HTTP_SERVER_VARS['PHP_SELF'] ) ) {
        createEventOpen($event_id, $event_exec);
    }
}
?>