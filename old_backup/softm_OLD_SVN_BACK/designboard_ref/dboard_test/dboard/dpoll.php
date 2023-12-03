<?
error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE ( Notice�� ������ ��翡���� �������ض�~ )
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
$IJTSEC = ( $_GET["baseDir"] || $_POST["baseDir"] || $_GET["libDir"] || $_POST["libDir"] ) ? false : true;

if ( $IJTSEC ) {
	// dpoll.php�� �ٸ��������� include�Ǿ����� ����
	if (!defined("DPOLL_INCLUDE") ) {
		if ( preg_match( "/(".$_SERVER['HTTP_HOST'].")((.)*(\/)+)+(dpoll.php)/", $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ) ) {
			define("DPOLL_INCLUDE","OFF");
			define("DBOARD_INCLUDE","OFF");
		} else {
			define("DPOLL_INCLUDE","ON");
		}
	}

    include_once $baseDir.'common/poll_lib.inc'  ; // ���� ���̺귯��
    include_once $baseDir.'common/member_lib.inc'; // ��� ���̺귯��
    include_once $baseDir.'common/lib.inc'       ; // ���� ���̺귯��
    include_once $baseDir.'common/message.inc'   ; // ���� ������ ó��
    include_once $baseDir.'common/db_connect.inc'; // Data Base ���� Ŭ����
    include_once $baseDir.'common/_service.inc'  ; // ���� ȭ�� ����
    $package = 'poll';   // ����
    $memInfor = getMemInfor (); // ȸ��  ����

    $_dboard_poll_result_alert = false;

    if(!$_dboard_poll_included) { // �ѹ��� ��Ŭ��� �ǰ� ó��

        $a_params = '';
        // ���� ���縦 ���� �մϴ�.
        // $gubun : '1' ::> ���� createPollȣ��
        //        : '2' ::> ���� createPollȣ��
        function createPoll($poll_id, $poll_exec='poll', $gubun='1') {

    $_sessionStart = getMicroSecond(); // ���� ���� �ð�
            global $package, $db, $sysInfor, $baseDir, $user_id, $tb_poll_master, $tb_poll_item, $tb_poll_comment, $tb_member, $tb_bbs_data, $tb_bbs_comment, $_dboard_form_included, $_dpoll_form_included;
            global $s, $tot, $how_many, $more_many, $page_many, $page_tab;
            global $memInfor, $_dboard_ver_str, $a_params, $_dboard_poll_result_alert, $grantCharStr;
            global $_ENV, $_GET, $_POST, $_SERVER;

            $package = 'poll'; // ����
            if ( !$db ) $db = initDBConnection (); // �����ͺ��̽� ����

            // ���� �ض� �� �и� ���������
            $user_id        = $memInfor['user_id'     ]; // ���̵�
            $login_yn       = $memInfor['login_yn'    ]; // �α��� ����
            $admin_yn       = $memInfor['admin_yn'    ]; // ���� ����
            $memberlevel    = $memInfor['member_level']; // ȸ�� ���

            // ���� �б�
            $pollInfor = getPollInfor($poll_id               ); // ����  ����
            $pollGrant = getPollGrant($poll_id, $memberlevel ); // ����  ����

            $tmp_poll_id    = $poll_id  ;
            $tmp_poll_exec  = $poll_exec;
            @extract($_ENV   ); // ȯ�� ����
            @extract($_GET   ); // Get  ����� Parameter ��
            @extract($_POST  ); // Post ����� Parameter ��
            @extract($_SERVER); // Server ����
            $poll_id    = $tmp_poll_id  ;
            $poll_exec  = $tmp_poll_exec;

            global $notice_popup_width, $notice_popup_height;
            global $_dboard_ver;

            if ( $p_poll_exec == 'poll_result' && $p_poll_id == $poll_id ) $poll_exec = 'poll_result';
			// ��â�� ��츸 �߻�
            if ( $p_poll_exec == 'poll_result_alert_change' ) $poll_exec = 'poll_result';
            if ( $pollInfor )  { // �Խ��� ���� ����

                $poll_exec = ( !$poll_exec ) ? "poll" : $poll_exec;   // ȸ�� ó�� ���� ����

                /* ----- ȭ�� Ÿ��Ʋ ���� --------------------------- */
                if      ( $poll_exec == 'poll'          ) $_title = '���� ���� - ' . $_dboard_ver; $msgNo = '0045';
                if      ( $poll_exec == 'poll_result'   ) $_title = '���� ��� - ' . $_dboard_ver; $msgNo = '0046';

				head ($_title);

                $_pSkinName = ''; // ��Ų��

                if ( !$poll_skin_name ) {
                    $_pSkinName = $pollInfor['skin_name'];
                } else {
                    $_pSkinName = $poll_skin_name;
                }

                $poll_skin_name = $pollInfor['skin_name'];
                $skinDir = $baseDir . 'skin/poll/' . $poll_skin_name . '/';
                $libDir  = $baseDir . "common/lib/" . $sysInfor["driver"] . '/';

				$mailSendMethod = '1'; // ������
				$start_date   = $pollInfor['start_date'  ]; // ���� ������
				$end_date     = $pollInfor['end_date'    ]; // ���� ������
				$compare_date = (int) $end_date;
				$sysDate      = getYearToSecond();
				$sysDate      = substr($sysDate, 0 ,10);
				$sysDate      = (int) $sysDate;

                if ( ( $compare_date - $sysDate ) < 0 && $admin_yn == 'N' ) {
                    Message('S', '0049',"", $skinDir);
                } else {

                    $total_hit = $pollInfor['total_hit'   ]; // �� �������� �����ο���
                    $reg_date  = $pollInfor['reg_date'    ]; // ���� ���� ����

                    // ���� ����
                    if ( $poll_exec == 'poll'               ) $grant = $pollGrant['grant_poll'       ];
                    if ( $poll_exec == 'poll_exec'          ) $grant = $pollGrant['grant_poll'       ];
                    if ( $poll_exec == 'poll_result'        ) $grant = $pollGrant['grant_poll_result'];
                    if ( $poll_exec == 'insert_comment_exec') $grant = $pollGrant['grant_write'];
                    if ( $poll_exec == 'delete_comment'     ) $grant = $pollGrant['grant_write'];
                    if ( $poll_exec == 'delete_comment_exec') $grant = $pollGrant['grant_write'];

                    if ( $admin_yn == 'Y' ) $grant = 'Y';

                    appendParam ($a_params,'poll_id',$poll_id);
                    appendParam ($a_params,'poll_exec',$poll_exec);
                    appendParam ($a_params,'s',$s);

                    if ( $lg != 'Y' && $login_yn == 'N' && $grant == 'N' ) {
                        Message('S', $msgNo,"",$skinDir);
                    } else {
                        // ���� ���� (���� ������)
                        if ( $login_yn == 'Y' && $grant == 'N' ) {
                            Message('S', $msgNo,"", $skinDir);
                        } else {

							css ($skinDir ); // css ����

							pollFormCreate(); // �� ����

							include $baseDir .'common/poll_setup_default.inc'; // �⺻ ����
							include $baseDir .'common/login_setup_default.inc'; // �α��� �⺻ ����

							if ( file_exists($skinDir ."setup.php" ) ) {
								include $skinDir ."setup.php"       ; // ��Ų ���� ����
							}

							include_once $baseDir.'common/js/common_js.php'; // ���� javascript
							include_once $baseDir.'common/js/poll_js.php'; // �������� javascript
							include_once $baseDir.'common/js/member_infor_js.php'; // ȸ�� ���� ���� ����

							$title_limit  = $pollInfor['title_limit' ]; // ���� ���� (��)
							$title        = $pollInfor['title'       ]; // ���� ����

							if ( $title_limit != 0 ) {
								$title = curString($title, $title_limit, $title_cut_tag); // Ÿ��Ʋ ���� ���߱�
							}

							$start_year   = substr($start_date, 0 ,4);
							$start_month  = substr($start_date, 4 ,2);
							$start_day    = substr($start_date, 6 ,2);
							$start_hour   = substr($start_date, 8 ,2);

							$end_year     = substr($end_date  , 0 ,4);
							$end_month    = substr($end_date  , 4 ,2);
							$end_day      = substr($end_date  , 6 ,2);
							$end_hour     = substr($end_date  , 8 ,2);

							$opiniony_yn  = $pollInfor['opinion_yn'  ]; // �ǰ� ���
							$display_mode = $pollInfor['display_mode']; // ���ȭ�� ������� ( ����â : 1 , ��â : 2 )

                            if ( $admin_yn != 'Y' ) { $show_admin_yn_s = "<!--"; $show_admin_yn_e = "-->";} // ������ ����
                            if ( $admin_yn == 'Y' ) { $hide_admin_yn_s = "<!--"; $hide_admin_yn_e = "-->";} // ������ ����

                            if ( $admin_yn != 'Y' && $login_yn == 'Y' ) { $hide_name_s     = "<!--"; $hide_name_e     = "-->";} // �α��ν� �̸�
                                                                                                                                // �Է�â �� ���̺�
                            if ( $login_yn == 'Y'                     ) { $hide_password_s = "<!--"; $hide_password_e = "-->";} // �α��ν� �н�����

                            $grantCharStr = $pollInfor['grant_character_image']; // ȸ�� ������ ����
                            $cur_page = getReqPageName ();
// ��ũ ����
                            $a_logout="<a href='" . $baseDir . "logout_ok.php$a_params'>"        ;  // �α� �ƿ�
                            $a_login ="<a href='" . $cur_page . "$a_params&lg=Y'>"       ;  // �α� ��
                            $a_logout="<a href='" . $cur_page . "$a_params&exec=logout'>";  // �α� �ƿ�
                            $a_login ="<a href='" . $cur_page . "$a_params&lg=Y'>"       ;  // �α� ��
                            $a_poll  ="<a href='" . $cur_page . "$a_params'>"            ;  // ���� ����

                            if ( $pollGrant['grant_poll_result'] == 'Y' ) {
                                $a_poll_result  ="<a href='#' onClick=\"pollResult('$display_mode', '$baseDir', '$poll_id', $poll_result_popup_width, $poll_result_popup_height);return false;\">";      // ���� ���
                            } else {
                                $a_poll_result = "<a href='#' style='display:none'>";
                            }

                            $a_delete_comment = ''; // view_comment.php ���� �̿�

                            $a_cancle = "<a href='javascript:history.back();'>";

                            if ( $poll_exec == 'poll' ) { // ���� ����

                                echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'><FORM METHOD=POST ACTION='' onSubmit=\"pollExec(this, '$display_mode','$poll_id', $poll_result_popup_width, $poll_result_popup_height);return false;\"></TABLE>\n";
                                include $baseDir."poll.php"; // ����Ʈ ������
                                echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'></FORM></TABLE>";

                            } else if ( $poll_exec == 'poll_exec' ) { // ���� ����
                                include $baseDir."common/lib/" . $sysInfor["driver"] . '/' . "poll_exec.php"; // ���� ���� ����
                                if ( $_GET[error] == 1 ) {
                                    Message('S', '0048',"javascript:self.close();:Ȯ��", $skinDir);   // �̹� ��ǥ �ϼ̽��ϴ�.
                                }
                            }
                            else if ( $poll_exec == 'poll_result' ) { // ���� ���� ���

                                // name ������ ������ �̸����� ���ǹǷ� �� ���� [�α��� �̸�]
                                $name = $memInfor['name'];
                                if ( strpos($poll_exec, '_exec') == false && preg_match( '/('.$_SERVER['HTTP_HOST'].')((.)*(\/)+)+(dpoll.php)/', $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] )) {
                                    include $baseDir.'data/html/_dpoll_header_' . $poll_id . '.php';
                                }

                                $package = 'poll'; // ����

                                $skinDir = $baseDir . 'skin/poll/' . $poll_skin_name . '/';
                                include $baseDir .'poll_result.php'; // �б� ������

                                if ( strpos($poll_exec, '_exec') == false && preg_match( '/('.$_SERVER['HTTP_HOST'].')((.)*(\/)+)+(dpoll.php)/', $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] )) {
                                    include $baseDir . 'data/html/_dpoll_footer_' . $poll_id . '.php';
                                }
                            }
                            else if ( $poll_exec == 'insert_comment_exec' ) { // �ǰ� �ޱ� �Է� ����
                                include $baseDir."common/lib/" . $sysInfor["driver"] . '/' . 'write_comment_exec.php'; // �Է� ����
                            }
                            else if ( $poll_exec == 'delete_comment' ) {       // �ǰ� �ޱ� ���� [��й�ȣ �䱸]
                                $title = '���� �Ͻðڽ��ϱ�?';
                                include $baseDir .'ask_password.php'; // �н����� �䱸
                            }
                            else if ( $poll_exec == 'delete_comment_exec' ) {  // �ǰ� �ޱ� ���� ����
                               include $baseDir."common/lib/" . $sysInfor["driver"] . '/' . 'write_comment_exec.php'; // �Է� ����
                            }

                            if ( !$_dboard_poll_result_alert && ( $p_poll_exec == 'poll_result_alert_only' || $p_poll_exec == 'poll_result_alert_change' ) ) { // ��ǥ ó���� �˸�����
                                $_dboard_poll_result_alert = true;
                                echo ( "\n<script type='text/javascript'>\n" );
                                echo ( "    window.document.body.onload = aa;\n");
                                echo ( "    function aa() {\n");
                                echo ( "        alert('��ǥ�Ϸ�.');\n");
                                echo ( "    }\n");
                                echo ( "\n</SCRIPT>\n" );
                            }
                        }
                    }
                }
    $_sessionEnd = getMicroSecond();
			footer ();
            } // if END
            else { // ���� ���� ���� ����
                if ( DPOLL_INCLUDE == DBOARD_INCLUDE_OFF ) {
				    head ($_title);
                    css (); // css ����
                }
                Message('S', '0041'); // ���� ���簡 ���� ���� �ʽ��ϴ�.
                if ( DPOLL_INCLUDE == DBOARD_INCLUDE_OFF ) {
			        footer ();
                }
            } // else END
        }

        // ���� ���縦 ���� �մϴ�.
        function createRecentPoll ( $poll_exec='poll' ) {
            global $db;
            $db = initDBConnection (); // �����ͺ��̽� ����

            $poll_id  = getRecentPollNo ();
            $poll_day = getYearToDay();
            createPoll($poll_id, $poll_exec,'' , $poll_day . '00', $poll_day . '24' );
        }
        $_dboard_poll_included = true;
    }

    if ( DPOLL_INCLUDE == DBOARD_INCLUDE_OFF ) {
        createPoll($poll_id, $poll_exec);
    }
}
?>