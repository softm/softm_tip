<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
$IJTSEC = ( $_GET["baseDir"] || $_POST["baseDir"] || $_GET["libDir"] || $_POST["libDir"] ) ? false : true;
if ( $IJTSEC ) {
	// dlogin.php�� �ٸ��������� include�Ǿ����� ����
	if (!defined("DLOGIN_INCLUDE") ) {
		if ( preg_match( "/(".$_SERVER['HTTP_HOST'].")((.)*(\/)+)+(dlogin.php)/", $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ) ) {
			define("DLOGIN_INCLUDE","OFF");
		} else {
			define("DLOGIN_INCLUDE","ON");
		}
	}
    include_once $baseDir.'common/lib.inc'       ; // ���� ���̺귯��
    include_once $baseDir.'common/member_lib.inc'; // ��� ���̺귯��
    include_once $baseDir.'common/message.inc'   ; // ���� ������ ó��
    include_once $baseDir.'common/db_connect.inc'; // Data Base ���� Ŭ����
    include_once $baseDir.'common/_service.inc'  ; // ���� ȭ�� ����

    $package = 'outlogin';   // �ƿ� �α���

    /* ----- ���� �б� ---------------------------------- */
    $memInfor  = getMemInfor ( ); // ȸ��  ����
    $login_yn  = $memInfor['login_yn']; // �α��� ����

        $libDir = $baseDir."common/lib/" . $sysInfor["driver"] . '/';

        if(!$_dboard_login_inc) {
            // ��ũ ����
            appendParam ($a_params,'id',$id);
            appendParam ($a_params,'s',$s);
            appendParam ($a_params,'npop',$npop);
            appendParam ($a_params,'poll_id',$poll_id);
            appendParam ($a_params,'poll_exec',$poll_exec);

            $loginSkinDir= $baseDir.'skin/login/doutlogin_' . $_dboard_ver_str . '/';

            include "common/login_setup_default.inc"  ; // �⺻ ����
            if ( file_exists($loginSkinDir."setup.php" ) ) {
                include $loginSkinDir."setup.php"       ; // ��Ų ���� ����
            }

            if ( $login_yn == 'Y'  ) {
                $a_login ="<a href='#' style='display:none'>"                        ;  // �α� ��
                $a_logout="<a href='" . $baseDir."logout_ok.php$a_params'>"        ;  // �α� �ƿ�
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

            $login_yn       = $memInfor['login_yn']; // �α��� ����
            $admin_yn       = $memInfor['admin_yn']; // ���� ����
            $user_id        = $memInfor['user_id' ]; // ���̵�
            $name           = $memInfor['name'    ]; // �̸�
            $point          = $memInfor['point'   ]; // �̸�
            $access         = $memInfor['access'  ]; // ���� Ƚ��

            function createLoginBox($login_skin_name='', $sucMode='', $succUrl='', $msg='') {

                global $package, $_COOKIE, $_GET, $_SERVER;
                global $show_admin_yn_s, $show_admin_yn_e, $hide_admin_yn_s, $hide_admin_yn_e;
                global $baseDir, $loginSkinDir, $memInfor, $_dboard_ver_str;
                global $id, $poll_id, $poll_exec, $a_params;
                @extract($_GET     ); // Get  ����� Parameter ��
                @extract($_SERVER  ); // Server ����

                if ($sucMode) {
                    $suc_mode = $sucMode;
                } else {
                    $suc_mode = $_GET ['suc_mode'];
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

                include_once $baseDir.'common/js/common_js.php'; // ���� javascript
                include_once $baseDir.'common/js/login_js.php' ; // �α��� javascript
                include_once $baseDir.'common/extra_script.inc' ; // �ܺ� ���� javascript

                // ��ũ ����
                appendParam ($a_params,'id',$id);
                appendParam ($a_params,'s',$s);
                appendParam ($a_params,'npop',$npop);
                appendParam ($a_params,'poll_id',$poll_id);
                appendParam ($a_params,'poll_exec',$poll_exec);

                if ( $login_skin_name ) {
                    $loginSkinDir= $baseDir.'skin/login/' . $login_skin_name . '/';
                } else {
//                  $loginSkinDir= $baseDir.'skin/login/doutlogin_' . $_dboard_ver_str . '/';
                    $loginSkinDir= $baseDir.'skin/login/doutlogin_2_0/';
                }
                css ($loginSkinDir );   // css ����

                include $baseDir."common/login_setup_default.inc"  ; // �⺻ ����
                if ( file_exists($loginSkinDir ."setup.php" ) ) {
                    include $loginSkinDir ."setup.php"       ; // ��Ų ���� ����
                } else {
                    Message('S', '1001'); // ��Ų����
                }

                if ( $login_yn == 'Y' ) {
                    $a_login ="<a href='#' style='display:none'>"                        ;  // �α� ��
//                  $a_logout="<a href='" . $baseDir."logout_ok.php$a_params'>"        ;  // �α� �ƿ�
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

                $save_id  = $_COOKIE["_d_save_id"   ]; // �ڵ� �α��� ����

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
                          echo $succ_url;
                            Message('M', "javascript:comfirmClick(\"" . $succ_url ."\");:Ȯ��", $message, $loginSkinDir);    // ȸ�� ����
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
                	if ( DBOARD_INCLUDE == DBOARD_INCLUDE_OFF ) {
                        $message = getUrlParamValue( $QUERY_STRING , 'message' );
                        $succ_url= getUrlParamValue( $QUERY_STRING , 'succ_url');
                    }

                    echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'><FORM METHOD=POST onSubmit=\"return loginFormSubmit(this);\"><input name='suc_mode' type='hidden' value='$suc_mode'><input name='message' type='hidden' value='$message'><input name='succ_url' type='hidden' value='$succ_url'><input name='login_skin_name' type='hidden' value='$login_skin_name'></TABLE>\n";
                    if ( $save_id == 'Y' ) {
                        $user_id = $_COOKIE["_d_user_id"   ]; // ����� ���̵�
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

    if ( DLOGIN_INCLUDE == DBOARD_INCLUDE_OFF ) {
        createLoginBox($login_skin_name);
    }
}
?>