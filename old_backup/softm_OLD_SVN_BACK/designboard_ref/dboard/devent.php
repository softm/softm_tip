<?
error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE ( Notice�� ������ ��翡���� �������ض�~ )
$IJTSEC = ( $HTTP_GET_VARS["baseDir"] || $HTTP_POST_VARS["baseDir"] || $HTTP_GET_VARS["libDir"] || $HTTP_POST_VARS["libDir"] ) ? false : true;
if ( $IJTSEC ) {
    include 'common/lib.inc'       ; // ���� ���̺귯��
    include 'common/event_lib.inc' ; // �̺�Ʈ ���̺귯��
    include 'common/member_lib.inc'; // ��� ���̺귯��
    include 'common/message.inc'   ; // ���� ������ ó��
    include 'common/db_connect.inc'; // Data Base ���� Ŭ����
    include 'common/_service.inc'  ; // ���� ȭ�� ����

    $package = 'event';   // �̺�Ʈ
    $a_event_join  = '';  // �̺�Ʈ ����
    $a_event_close = '';  // �̺�Ʈ â �ݱ�

    // ���� �б�
    $memInfor    = getMemInfor (); // ȸ��  ����
    $login_yn    = $memInfor['login_yn'    ]; // �α��� ����
    $user_id     = $memInfor['user_id'     ]; // ���̵�
    $admin_yn    = $memInfor['admin_yn'    ]; // ���� ����
    $memberlevel = $memInfor['member_level']; // ȸ�� ���
	include 'common/js/common_js.php'; // ���� javascript

    if(!$_dboard_event_included) { // �ѹ��� ��Ŭ��� �ǰ� ó��
		include 'common/js/event_js.php'; // �̺�Ʈ javascript
        $_dboard_event_inc_cnt = 1;
        echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'><FORM name='_dboard_eventForm' METHOD=POST ACTION='' onSubmit='return eventJoin(this,\"$event_id\");'><input type='hidden' name='event_id' value='$event_id'><input type='hidden' name='event_exec' value=''></FORM></TABLE>\n";
    }

    /* ----------------------- ���� �Ұ� ------------------------ */
    if(!$_dboard_event_included) { // �ѹ��� ��Ŭ��� �ǰ� ó��
        $_dboard_event_included = true;

	    eventFormCreate(); // �� ����

        echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" );
        echo ( "    var login_yn = \"" . $memInfor['login_yn'] . "\"\n");
        echo ( "\n</SCRIPT>\n" );

        // �̺�Ʈ ���� �޽��� ����
        function eventMsgMake() {
            global $login_yn, $grant, $_dboard_event_inc_cnt, $errMsgTable;
            if ( $_dboard_event_inc_cnt == 1 ) {
				include 'common/message_table.inc'; // �޽��� ���̺�
                echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" );
                if ( $login_yn == 'N' ) {
                    echo ( "    var message = '" . $errMsgTable['S0074'] . "';"); // �α����� �������ּ���.
                } else if ( $grant != 'Y' ) {
                    echo ( "    var message = '" . $errMsgTable['S0073'] . "';"); // �̺�Ʈ ���� ������ �����ϴ�.
                } else {
                    echo ( "    var message = '" . $errMsgTable['S0077'] . "';"); // �̺�Ʈ�� �����Ͻðڽ��ϱ�?
                }
                echo ( "\n</SCRIPT>\n" );
            }
        }

        // �̺�Ʈ ���� ���� �޽��� ����
        function eventJoinMsg() {
            global $event_join, $_dboard_event_inc_cnt, $errMsgTable;
            if ( $event_join == 'Y' && $_dboard_event_inc_cnt == 1 ) {
                echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" );
                echo ( "    alert ('" . $errMsgTable['S0075'] . "');");
                echo ( "\n</SCRIPT>\n" );
            }
        }

        // �̹� �̺�Ʈ�� ���������� �޽��� ����
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
                    echo ( "    message = '" . $errMsgTable['S0076'] . "';"); // �̺�Ʈ�� �̹� �����ϼ̽��ϴ�.
                    if ( $join_check == 'Y' ) {
                        echo ( "    alert ( message );");
                    }
                } else {
                    echo ( "    var alreadyJoin = 'N';");
                }
            echo ( "\n</SCRIPT>\n" );
            }
        }

        // �̺�Ʈ ���縦 ���� �մϴ�.
        function createEvent($event_id) {
            global $db, $package, $isconnected, $sysInfor, $baseDir, $_dboard_event_inc_cnt;
            global $login_yn, $user_id, $admin_yn, $memberlevel, $a_event_join, $a_event_close, $grant, $event_join, $join_check;

            global $HTTP_SERVER_VARS, $HTTP_GET_VARS, $HTTP_COOKIE_VARS;
            @extract($HTTP_SERVER_VARS); // Server ����
            $package = 'event';   // �̺�Ʈ

            $lg             = $HTTP_GET_VARS ['lg'        ];
            $event_join     = $HTTP_GET_VARS ['event_join'];
            $join_check     = $HTTP_GET_VARS ['join_check'];

            $db = initDBConnection ();             // �����ͺ��̽� ����

            $libDir     = $baseDir . "common/lib/" . $sysInfor["driver"] . '/';

            /* ------- �̺�Ʈ ���� -------------------------------------- */
            $eventInfor = getEventInfor($event_id               ); // �̺�Ʈ ����
            $eventGrant = getEventGrant($event_id, $memberlevel ); // ����   ����
            $grant      = $eventGrant['grant_join'];

            include $baseDir ."common/event_setup_default.inc"  ; // �⺻ ����

            $start_date   = $eventInfor['start_date'  ]; // �̺�Ʈ ������
            $start_year   = substr($start_date, 0 ,4);
            $start_month  = substr($start_date, 4 ,2);
            $start_day    = substr($start_date, 6 ,2);
            $start_hour   = substr($start_date, 8 ,2);
            $end_date     = $eventInfor['end_date'    ]; // �̺�Ʈ ������
            $end_year     = substr($end_date  , 0 ,4);
            $end_month    = substr($end_date  , 4 ,2);
            $end_day      = substr($end_date  , 6 ,2);
            $end_hour     = substr($end_date  , 8 ,2);

            if ( ( $compare_date - $sysDate ) < 0 && $admin_yn == 'N' ) {
                MessageC ('S', '0072',"", $skinDir); // �̺�Ʈ�� ���� �Ǿ����ϴ�.
            } else {
                if ( $eventInfor )  { // �Խ��� ���� ����

                    $grant = $eventGrant['grant_join'];
                    if      ( $admin_yn == 'Y' ) { $grant = 'Y'; }
                    
                    $a_cancle     = "<a href='javascript:history.back();'>";
                    $a_event_join = "<a href='#' onClick=\"eventJoin(document._dboard_eventForm[$_dboard_event_inc_cnt],'$event_id','$grant');return false;\">";  // �̺�Ʈ ����
                    $a_event_close= "<a href='#' onclick=\"closeEventPopup(1);return false;\">"; // �̺�Ʈ â �ݱ�

                    $display_mode = $eventInfor['display_mode']; // �̺�Ʈ ǥ������ ( '1' : �˾�, '2' : ����â, '3' : ��ũ )

                    if  ( $lg == 'Y' && $login_yn == 'N' ) {                  // �α���

                        $use_default_login = $eventInfor['use_default_login'];
                        $login_skin_name   = '';
                        if ( $use_default_login == 'Y' ) {
                            $login_skin_name   = $sysInfor['login_skin'];
                        } else {
                            $login_skin_name   = $eventInfor['login_skin_name'];
                        }
                        $loginSkinDir= $baseDir . 'skin/login/' . $login_skin_name . '/';

                        _css ($loginSkinDir );   // css ����

                        if ( file_exists($loginSkinDir ."setup.php" ) ) {
                            include $loginSkinDir ."setup.php"       ; // ��Ų ���� ����
                        }

                        include $baseDir ."common/login_setup_default.inc"  ; // �⺻ ����
                        if ( $login_yn == 'Y' ) {
                            $a_login ="<a href='#' style='display:none'>"                ;  // �α� ��
        //                  $a_logout="<a href='" . $baseDir . "logout_ok.php$a_params'>";  // �α� �ƿ�
                            $a_logout="<a href='#' onClick=\"return logout();\">"        ;  // �α� �ƿ�
                            $a_member_register     ="<a href='#' style='display:none'>"  ;  // ȸ�� ����
                            $a_member_update       ="<a href='#' onClick=\"openMemberUpdate ('$member_update_mode', '$member_update_succ_url', '$member_update_popup_width', '$member_update_popup_height', '$member_update_scroll_yn' );return false;\">"   ;// ȸ�� ����
                            $a_member_secession    ="<a href='#' onClick=\"openMemberSecession('$member_secession_mode', '$member_secession_succ_url', '$member_secession_popup_width', '$member_secession_popup_height', '$member_secession_scroll_yn');return false;\">";// ȸ�� Ż��
                            $a_member_infor_search ="<a href='#' style='display:none'>"   ;   // ȸ�� ���� ã��
                        } else {
                            $a_login ="<a href='#' onClick=\"loginPopup ( '$member_login_popup_width', '$member_login_popup_height', '$member_login_mode', 'doutlogin_" . $_dboard_ver_str . "' );return false;\">"       ;  // �α� ��
                            $a_logout="<a href='#' style='display:none'>"                ;  // �α� �ƿ�
                            $a_member_register     ="<a href='#' onClick=\"openMemberRegister ('$member_register_mode', '$member_register_succ_url', '$member_register_popup_width', '$member_register_popup_height', '$member_register_scroll_yn' );return false;\">" ;   // ȸ�� ����
                            $a_member_update       ="<a href='#' style='display:none'>"  ;   // ȸ�� ����
                            $a_member_secession    ="<a href='#' style='display:none'>"  ;   // ȸ�� Ż��
                            $a_member_infor_search ="<a href='#' onClick=\"openMemberInforSearch('$member_infor_search_mode', '$member_infor_search_succ_url', '$member_infor_search_popup_width', '$member_infor_search_popup_height', '$member_infor_search_scroll_yn' );return false;\">";// ȸ�� ���� ã��
                        }

                        echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'><FORM METHOD=POST onSubmit=\"return loginFormSubmit(this);\"><input name='suc_mode' type='hidden' value='$suc_mode'><input name='message' type='hidden' value='$message'><input name='succ_url' type='hidden' value='$succ_url'></TABLE>\n";
                        $save_id  = $HTTP_COOKIE_VARS["_d_save_id"   ]; // �ڵ� �α��� ����
                        if ( $save_id == 'Y' ) {
                            $user_id = $HTTP_COOKIE_VARS["_d_user_id"   ]; // ����� ���̵�
                        } else {
                            $user_id = ''; // ����� ���̵�
                        }
                        include $loginSkinDir ."login.php"               ; // �α���   ��Ų
                        echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'></FORM></TABLE>";
                    } else if ( $display_mode == '1' ) { // �˾�
                        $window_width   = $eventInfor['window_width' ];
                        $window_height  = $eventInfor['window_height'];
                        $left_pos       = $eventInfor['left_pos'     ];
                        $top_pos        = $eventInfor['top_pos'      ];

                        $popup_open     = $HTTP_COOKIE_VARS[popup_open   ]; // �˾� ����
                        echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" );
                        echo ( "    if ( getCookie('popup_open') != 'N') {\n");
                        $scoll_yn = ( $eventInfor['scroll_yn'] == 'Y' ) ? "yes" : "no";
                        echo ( "        var eventWin = window.open(\"" . $baseDir . "devent.php?event_id=" . $event_id . "&popup_yn=Y\",\"event\",\"location=no,toolbar=no,menubar=no,resizable=no,scrollbars=". $scoll_yn .",top=$top_pos,left=$left_pos,width=$window_width\,height=$window_height\");\n");
                        echo ( "        eventWin.focus();\n");
                        echo ( "    }\n");

                        echo ( "\n</SCRIPT>\n" );
                    } else if ( $display_mode == '2' ) { // ����â
                        eventMsgMake(); // �̺�Ʈ ���� �޽��� ����

                        echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'><FORM name='_dboard_eventForm' METHOD=POST ACTION='' onSubmit='return eventJoin(this, \"$event_id\", \"$grant\");'><input type='hidden' name='event_id' value='$event_id'><input type='hidden' name='event_exec' value=''></TABLE>\n";
                        include ( $baseDir . "data/event/" . $event_id . "/_dboard_event.php" );
                        echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'></FORM></TABLE>";
                        eventJoinMsg();   // �̺�Ʈ ���� �޽���
                        alreadyJoinMsg(); // �̹� �̺�Ʈ�� ���������� �޽���
                        $_dboard_event_inc_cnt++;
                    } else if ( $display_mode == '3' ) { // ��ũ

                    }
                } // if END
                else { // �̺�Ʈ ���� ���� ����
                    MessageC ('S', '0071');  // �̺�Ʈ�� �������� �ʽ��ϴ�.
                } // else END
            }

            closeDBConnection (); // �����ͺ��̽� ���� ���� ����
        }

        // �̺�Ʈ ���縦 ���� �մϴ�. [�˾��϶� ����]
        function createEventOpen($event_id, $event_exec='event') {
            global $db, $package, $isconnected, $sysInfor, $baseDir, $_dboard_event_inc_cnt;
            global $login_yn, $user_id, $admin_yn, $memberlevel, $a_event_join, $a_event_close, $grant, $event_join, $join_check;
            global $HTTP_SERVER_VARS, $HTTP_GET_VARS, $HTTP_COOKIE_VARS;
            @extract($HTTP_SERVER_VARS); // Server ����
            $package = 'event';   // �̺�Ʈ

            $lg             = $HTTP_GET_VARS ['lg'        ];
            $event_join     = $HTTP_GET_VARS ['event_join'];
            $join_check     = $HTTP_GET_VARS ['join_check'];

            $db = initDBConnection ();             // �����ͺ��̽� ����

            $libDir     = $baseDir . "common/lib/" . $sysInfor["driver"] . '/';

            /* ------- �̺�Ʈ ���� -------------------------------------- */
            $eventInfor = getEventInfor($event_id               ); // �̺�Ʈ ����
            $eventGrant = getEventGrant($event_id, $memberlevel ); // ����   ����
            $grant      = $eventGrant['grant_join'];

            include $baseDir ."common/event_setup_default.inc"  ; // �⺻ ����

            $start_date   = $eventInfor['start_date'  ]; // �̺�Ʈ ������
            $start_year   = substr($start_date, 0 ,4);
            $start_month  = substr($start_date, 4 ,2);
            $start_day    = substr($start_date, 6 ,2);
            $start_hour   = substr($start_date, 8 ,2);
            $end_date     = $eventInfor['end_date'    ]; // �̺�Ʈ ������
            $end_year     = substr($end_date  , 0 ,4);
            $end_month    = substr($end_date  , 4 ,2);
            $end_day      = substr($end_date  , 6 ,2);
            $end_hour     = substr($end_date  , 8 ,2);

            if ( ( $compare_date - $sysDate ) < 0 && $admin_yn == 'N' ) {
                MessageC ('S', '0072',"", $skinDir); // �̺�Ʈ�� ���� �Ǿ����ϴ�.
            } else {
                if ( $eventInfor )  { // �Խ��� ���� ����
                    $grant = $eventGrant['grant_join'];
                    if      ( $admin_yn == 'Y' ) { $grant = 'Y'; }

                    $a_cancle     = "<a href='javascript:history.back();'>";
                    $a_event_join = "<a href='#' onClick=\"eventJoin(document._dboard_eventForm[$_dboard_event_inc_cnt],'$event_id','$grant');return false;\">";  // �̺�Ʈ ����
                    $a_event_close= "<a href='#' onclick=\"closeEventPopup(1);return false;\">"; // �̺�Ʈ â �ݱ�

                    $display_mode = $eventInfor['display_mode']; // �̺�Ʈ ǥ������ ( '1' : �˾�, '2' : ����â, '3' : ��ũ )

                    if  ( $lg == 'Y' && $login_yn == 'N' ) {                  // �α���

                        $use_default_login = $eventInfor['use_default_login'];
                        $login_skin_name   = '';
                        if ( $use_default_login == 'Y' ) {
                            $login_skin_name   = $sysInfor['login_skin'];
                        } else {
                            $login_skin_name   = $eventInfor['login_skin_name'];
                        }
                        $loginSkinDir= $baseDir . 'skin/login/' . $login_skin_name . '/';

                        _css ($loginSkinDir );   // css ����

                        if ( file_exists($loginSkinDir ."setup.php" ) ) {
                            include $loginSkinDir ."setup.php"       ; // ��Ų ���� ����
                        }

                        include $baseDir ."common/login_setup_default.inc"  ; // �⺻ ����
                        if ( $login_yn == 'Y' ) {
                            $a_login ="<a href='#' style='display:none'>"                ;  // �α� ��
        //                  $a_logout="<a href='" . $baseDir . "logout_ok.php$a_params'>";  // �α� �ƿ�
                            $a_logout="<a href='#' onClick=\"return logout();\">"        ;  // �α� �ƿ�
                            $a_member_register     ="<a href='#' style='display:none'>"  ;  // ȸ�� ����
                            $a_member_update       ="<a href='#' onClick=\"openMemberUpdate ('$member_update_mode', '$member_update_succ_url', '$member_update_popup_width', '$member_update_popup_height', '$member_update_scroll_yn' );return false;\">"   ;// ȸ�� ����
                            $a_member_secession    ="<a href='#' onClick=\"openMemberSecession('$member_secession_mode', '$member_secession_succ_url', '$member_secession_popup_width', '$member_secession_popup_height', '$member_secession_scroll_yn');return false;\">";// ȸ�� Ż��
                            $a_member_infor_search ="<a href='#' style='display:none'>"   ;   // ȸ�� ���� ã��
                        } else {
                            $a_login ="<a href='#' onClick=\"loginPopup ( '$member_login_popup_width', '$member_login_popup_height', '$member_login_mode', 'doutlogin_" . $_dboard_ver_str . "' );return false;\">"       ;  // �α� ��
                            $a_logout="<a href='#' style='display:none'>"                ;  // �α� �ƿ�
                            $a_member_register     ="<a href='#' onClick=\"openMemberRegister ('$member_register_mode', '$member_register_succ_url', '$member_register_popup_width', '$member_register_popup_height', '$member_register_scroll_yn' );return false;\">" ;   // ȸ�� ����
                            $a_member_update       ="<a href='#' style='display:none'>"  ;   // ȸ�� ����
                            $a_member_secession    ="<a href='#' style='display:none'>"  ;   // ȸ�� Ż��
                            $a_member_infor_search ="<a href='#' onClick=\"openMemberInforSearch('$member_infor_search_mode', '$member_infor_search_succ_url', '$member_infor_search_popup_width', '$member_infor_search_popup_height', '$member_infor_search_scroll_yn' );return false;\">";// ȸ�� ���� ã��
                        }

                        echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'><FORM METHOD=POST onSubmit=\"return loginFormSubmit(this);\"><input name='suc_mode' type='hidden' value='$suc_mode'><input name='message' type='hidden' value='$message'><input name='succ_url' type='hidden' value='$succ_url'></TABLE>\n";
                        $save_id  = $HTTP_COOKIE_VARS["_d_save_id"   ]; // �ڵ� �α��� ����
                        if ( $save_id == 'Y' ) {
                            $user_id = $HTTP_COOKIE_VARS["_d_user_id"   ]; // ����� ���̵�
                        } else {
                            $user_id = ''; // ����� ���̵�
                        }
                        include $loginSkinDir ."login.php"               ; // �α���   ��Ų
                        echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'></FORM></TABLE>";
                    } else {
                        eventMsgMake(); // �̺�Ʈ ���� �޽��� ����
                        echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'><FORM name='_dboard_eventForm' METHOD=POST ACTION='' onSubmit='return eventJoin(this, \"$event_id\", \"$grant\");'><input type='hidden' name='event_id' value='$event_id'><input type='hidden' name='event_exec' value=''></TABLE>\n";
                        include ( $baseDir . "data/event/" . $event_id . "/_dboard_event.php" );
                        echo "\n<TABLE border='0' cellspacing='0' cellpadding='0' align='center'></FORM></TABLE>";
                        eventJoinMsg();   // �̺�Ʈ ���� �޽���
                        alreadyJoinMsg(); // �̹� �̺�Ʈ�� ���������� �޽���
                        $_dboard_event_inc_cnt++;
                    }
                } // if END
                else { // �̺�Ʈ ���� ���� ����
                    MessageC ('S', '0071');  // �̺�Ʈ�� �������� �ʽ��ϴ�.
                } // else END
            }

            closeDBConnection (); // �����ͺ��̽� ���� ���� ����
        }

        // �̺�Ʈ ���縦 ���� �մϴ�.
        function createRecentEvent ( $event_exec='poll' ) {
            global $db, $isconnected;
            $db = initDBConnection ();             // �����ͺ��̽� ����
            $event_id  = getRecentEventNo ();
            $event_day = getYearToDay();
            createEvent ($event_id);
            closeDBConnection (); // �����ͺ��̽� ���� ���� ����
        }
    }

    if ( ereg( "(".$HTTP_SERVER_VARS['HTTP_HOST'].")((.)*(/)+)+(devent.php)", $HTTP_SERVER_VARS['HTTP_HOST'] . $HTTP_SERVER_VARS['PHP_SELF'] ) ) {
        createEventOpen($event_id, $event_exec);
    }
}
?>