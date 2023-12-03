<?
$IJTSEC = ( $HTTP_GET_VARS["baseDir"] || $HTTP_POST_VARS["baseDir"] || $HTTP_GET_VARS["libDir"] || $HTTP_POST_VARS["libDir"] ) ? false : true;
if ( $IJTSEC ) {
    include 'common/lib.inc'       ; // ���� ���̺귯��
    include 'common/member_lib.inc'; // ��� ���̺귯��
    include 'common/message.inc'   ; // ���� ������ ó��
    include 'common/db_connect.inc'; // Data Base ���� Ŭ����
    include 'common/_service.inc'  ; // ���� ȭ�� ����

    $package = 'outlogin';   // �ƿ� �α���

    /* ----- ���� �б� ---------------------------------- */
    $memInfor  = getMemInfor ( ); // ȸ��  ����
    $login_yn  = $memInfor['login_yn']; // �α��� ����
    $self_yn   = ereg( "(".$HTTP_SERVER_VARS['HTTP_HOST'].")((.)*(/)+)+(dlogin.php)", $HTTP_SERVER_VARS['HTTP_HOST'] . $HTTP_SERVER_VARS['PHP_SELF'] ) ;

        $libDir = $baseDir . "common/lib/" . $sysInfor["driver"] . '/';

        if(!$_dboard_login_inc) {
            // ��ũ ����
            appendParam ($a_params,'id',$id);
            appendParam ($a_params,'s',$s);
            appendParam ($a_params,'npop',$npop);
            appendParam ($a_params,'poll_id',$poll_id);
            appendParam ($a_params,'poll_exec',$poll_exec);

            $loginSkinDir= $baseDir . 'skin/login/doutlogin_' . $_dboard_ver_str . '/';

            include "common/login_setup_default.inc"  ; // �⺻ ����
            if ( file_exists($loginSkinDir ."setup.php" ) ) {
                include $loginSkinDir ."setup.php"       ; // ��Ų ���� ����
            }

            if ( $login_yn == 'Y'  ) {
                $a_login ="<a href='#' style='display:none'>"                        ;  // �α� ��
                $a_logout="<a href='" . $baseDir . "logout_ok.php$a_params'>"        ;  // �α� �ƿ�
                $a_member_register     ="<a href='#' style='display:none'>"         ;  // ȸ�� ����
                $a_member_update       ="<a href='#' onClick=\"openMemberUpdate ('$member_update_mode', '$member_update_succ_url', '$member_update_popup_width', '$member_update_popup_height', '$member_update_scroll_yn' );return false;\">"   ;// ȸ�� ����
                $a_member_secession    ="<a href='#' onClick=\"openMemberSecession('$member_secession_mode', '$member_secession_succ_url', '$member_secession_popup_width', '$member_secession_popup_height', '$member_secession_scroll_yn');return false;\">";// ȸ�� Ż��
                $a_member_infor_search ="<a href='#' style='display:none'>"   ;   // ȸ�� ���� ã��
            } else {
                $a_login ="<a href='#' onClick=\"loginPopup ( '$member_login_popup_width', '$member_login_popup_height', '$member_login_mode', 'doutlogin_" . $_dboard_ver_str . "' );return false;\">"       ;  // �α� ��
                $a_logout="<a href='#' style='display:none'>"                        ;  // �α� �ƿ�
                $a_member_register     ="<a href='#' onClick=\"openMemberRegister ('$member_register_mode', '$member_register_succ_url', '$member_register_popup_width', '$member_register_popup_height', '$member_register_scroll_yn' );return false;\">" ;   // ȸ�� ����
                $a_member_update       ="<a href='#' style='display:none'>"   ;   // ȸ�� ����
                $a_member_secession    ="<a href='#' style='display:none'>"   ;   // ȸ�� Ż��
                $a_member_infor_search ="<a href='#' onClick=\"openMemberInforSearch('$member_infor_search_mode', '$member_infor_search_succ_url', '$member_infor_search_popup_width', '$member_infor_search_popup_height', '$member_infor_search_scroll_yn' );return false;\">";// ȸ�� ���� ã��
            }

            echo "<meta http-equiv='Content-Type' content='text/html; charset=EUC-KR'>";
            include 'common/js/common_js.php'; // ���� javascript
            include 'common/js/login_js.php' ; // �α��� javascript

            $login_yn       = $memInfor['login_yn']; // �α��� ����
            $admin_yn       = $memInfor['admin_yn']; // ���� ����
            $user_id        = $memInfor['user_id' ]; // ���̵�
            $name           = $memInfor['name'    ]; // �̸�
            $point          = $memInfor['point'   ]; // �̸�
            $access         = $memInfor['access'  ]; // ���� Ƚ��

            function createLoginBox($login_skin_name='', $sucMode='', $succUrl='', $msg='') {

                global $package, $HTTP_COOKIE_VARS, $HTTP_GET_VARS, $HTTP_SERVER_VARS;
                global $show_admin_yn_s, $show_admin_yn_e, $hide_admin_yn_s, $hide_admin_yn_e;
                global $baseDir, $loginSkinDir, $memInfor, $_dboard_ver_str, $self_yn;
                global $id, $poll_id, $poll_exec, $a_params;
                @extract($HTTP_GET_VARS     ); // Get  ����� Parameter ��
                @extract($HTTP_SERVER_VARS  ); // Server ����

                if ($sucMode) {
                    $suc_mode = $sucMode;
                } else {
                    $suc_mode = $HTTP_GET_VARS ['suc_mode'];
                    if ( !$suc_mode ) $suc_mode = '1';
                }
                if ($succUrl) $succ_url = $succUrl;
                if ($msg    ) $message  = $msg    ;

                $login_yn       = $memInfor['login_yn']; // �α��� ����
                $admin_yn       = $memInfor['admin_yn']; // ���� ����
                $user_id        = $memInfor['user_id' ]; // ���̵�
                $name           = $memInfor['name'    ]; // �̸�
                $point          = $memInfor['point'   ]; // �̸�
                $access         = $memInfor['access'  ]; // ���� Ƚ��

                if ( $admin_yn != 'Y' ) { $show_admin_yn_s = "<!--"; $show_admin_yn_e = "-->";} // ������ ����
                if ( $admin_yn == 'Y' ) { $hide_admin_yn_s = "<!--"; $hide_admin_yn_e = "-->";} // ������ ����

                // ��ũ ����
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
                _css ($loginSkinDir );   // css ����

                include "common/login_setup_default.inc"  ; // �⺻ ����
                if ( file_exists($loginSkinDir ."setup.php" ) ) {
                    include $loginSkinDir ."setup.php"       ; // ��Ų ���� ����
                }

                if ( $login_yn == 'Y' ) {
                    $a_login ="<a href='#' style='display:none'>"                        ;  // �α� ��
//                  $a_logout="<a href='" . $baseDir . "logout_ok.php$a_params'>"        ;  // �α� �ƿ�
                    $a_logout="<a href='#' onClick=\"return logout();\">"        ;  // �α� �ƿ�
                    $a_member_register     ="<a href='#' style='display:none'>"         ;  // ȸ�� ����
                    $a_member_update       ="<a href='#' onClick=\"openMemberUpdate ('$member_update_mode', '$member_update_succ_url', '$member_update_popup_width', '$member_update_popup_height', '$member_update_scroll_yn' );return false;\">"   ;// ȸ�� ����
                    $a_member_secession    ="<a href='#' onClick=\"openMemberSecession('$member_secession_mode', '$member_secession_succ_url', '$member_secession_popup_width', '$member_secession_popup_height', '$member_secession_scroll_yn');return false;\">";// ȸ�� Ż��
                    $a_member_infor_search ="<a href='#' style='display:none'>"   ;   // ȸ�� ���� ã��
                } else {
                    $a_login ="<a href='#' onClick=\"loginPopup ( '$member_login_popup_width', '$member_login_popup_height', '$member_login_mode', 'doutlogin_" . $_dboard_ver_str . "' );return false;\">"       ;  // �α� ��
                    $a_logout="<a href='#' style='display:none'>"                        ;  // �α� �ƿ�
                    $a_member_register     ="<a href='#' onClick=\"openMemberRegister ('$member_register_mode', '$member_register_succ_url', '$member_register_popup_width', '$member_register_popup_height', '$member_register_scroll_yn' );return false;\">" ;   // ȸ�� ����
                    $a_member_update       ="<a href='#' style='display:none'>"   ;   // ȸ�� ����
                    $a_member_secession    ="<a href='#' style='display:none'>"   ;   // ȸ�� Ż��
                    $a_member_infor_search ="<a href='#' onClick=\"openMemberInforSearch('$member_infor_search_mode', '$member_infor_search_succ_url', '$member_infor_search_popup_width', '$member_infor_search_popup_height', '$member_infor_search_scroll_yn' );return false;\">";// ȸ�� ���� ã��
                }

                $a_cancle = "<a href='javascript:history.back();'>";

                $save_id  = $HTTP_COOKIE_VARS["_d_save_id"   ]; // �ڵ� �α��� ����

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
                // popupMode : '1' : �α׾ƿ�ȭ��
                //             '2' : �޽���ȭ��
                //             '3' : ����URL�� �̵�
                //             '4' : �˾��ݱ�
                    if ( $suc_mode == '1' ) { // �α׾ƿ�ȭ��
//                      echo $suc_mode . ' / �α׾ƿ�ȭ��';
                        include $loginSkinDir ."logout.php"          ; // �ƿ� �α׾ƿ� ��Ų
                    } else if ( $suc_mode == '2' ) { // �޽���ȭ��
//                      echo $suc_mode . ' / �޽���ȭ��';
                        if ( $lg == 'Y' ) {
                            include $loginSkinDir ."logout.php"          ; // �ƿ� �α׾ƿ� ��Ų
                        } else {
//                          echo $succ_url;
                            MessageC('M', "javascript:comfirmClick(\"" . $succ_url ."\");:Ȯ��", $message, $loginSkinDir);    // ȸ�� ����
                        }
//                        echo '��� :' . $message . '<BR>';
                    } else if ( $suc_mode == '3' ) { // ����URL��
//                      echo $suc_mode . ' / ����URL�� �̵�';
                        include $loginSkinDir ."logout.php"          ; // �ƿ� �α׾ƿ� ��Ų
                    } else if ( $suc_mode == '4' ) { // �˾��ݱ�
//                      echo $suc_mode . ' / �˾��ݱ�';
                        include $loginSkinDir ."logout.php"          ; // �ƿ� �α׾ƿ� ��Ų
                    }
                    echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'></FORM></TABLE>";
                } else {
                    if ( $self_yn ) {
                        $message = getUrlParamValue( $QUERY_STRING , 'message' );
                        $succ_url= getUrlParamValue( $QUERY_STRING , 'succ_url');
                    }

                    echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'><FORM METHOD=POST onSubmit=\"return loginFormSubmit(this);\"><input name='suc_mode' type='hidden' value='$suc_mode'><input name='message' type='hidden' value='$message'><input name='succ_url' type='hidden' value='$succ_url'><input name='login_skin_name' type='hidden' value='$login_skin_name'></TABLE>\n";
                    if ( $save_id == 'Y' ) {
                        $user_id = $HTTP_COOKIE_VARS["_d_user_id"   ]; // ����� ���̵�
                    } else {
                        $user_id = ''; // ����� ���̵�
                    }
                    include $loginSkinDir ."login.php"               ; // �α���   ��Ų
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
            $_dboard_login_inc = true; // �𺸵� ��Ű�� ������ �ƿ� �α��� ���� ���� ��Ŭ��� ���� ����
        }

    if ( $self_yn ) {
        createLoginBox($login_skin_name);
    }
}
?>