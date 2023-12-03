<?
error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE ( Notice�� ������ ��翡���� �������ض�~ )
$IJTSEC = ( $HTTP_GET_VARS["baseDir"] || $HTTP_POST_VARS["baseDir"] || $HTTP_GET_VARS["libDir"] || $HTTP_POST_VARS["libDir"] ) ? false : true;
if ( $IJTSEC ) {
    include 'common/board_lib.inc';  // �Խ��� ���̺귯��
    include 'common/member_lib.inc'; // ��� ���̺귯��
    include 'common/lib.inc';        // ���� ���̺귯��
    include 'common/message.inc';    // ���� ������ ó��
    include 'common/db_connect.inc'; // Data Base ���� Ŭ����
    include 'common/_service.inc';   // ���� ȭ�� ����
    include 'common/file.inc';       // ���� �ý��� ����
    $memInfor = getMemInfor (); // ȸ��  ����
    $self_yn  = ereg( "(".$HTTP_SERVER_VARS['HTTP_HOST'].")((.)*(/)+)+(dplayer.php)", $HTTP_SERVER_VARS['HTTP_HOST'] . $HTTP_SERVER_VARS['PHP_SELF'] ) ;
    $_dboard_poll_result_alert = false;
    if(!$_dboard_player_included) { // �ѹ��� ��Ŭ��� �ǰ� ó��

        // �÷��̾� ����
        // $gubun : '1' ::> ���� createPollȣ��
        //        : '2' ::> ���� createPollȣ��
        function createPlayer($gubun="BBS_ONE_PLAY", $display_method="C", $id, $play_no='' ) {
            global $package, $db, $sysInfor, $baseDir, $self_yn, $user_id, $tb_bbs_infor, $tb_bbs_grant, $tb_bbs_data, $_dboard_form_included, $_dboard_player_included;
            global $exec, $s, $tot, $how_many, $more_many, $page_many, $page_tab;
            global $memInfor, $_dboard_ver_str, $a_params, $_dboard_poll_result_alert, $grantCharStr;
//            global $HTTP_ENV_VARS, $HTTP_GET_VARS, $HTTP_POST_VARS, $HTTP_SERVER_VARS, $HTTP_SESSION_VARS, $_SESSION;
            global $HTTP_SERVER_VARS, $HTTP_GET_VARS, $HTTP_SESSION_VARS , $_SESSION;
			$package = 'player'; // �÷��̾�
            @extract($HTTP_GET_VARS   ); // Get  ����� Parameter ��
            if ( !$db ) $db = initDBConnection (); // �����ͺ��̽� ����

			// �ܰ��� ���� ::> $exec 
			// player_display --> get_item
			$exec = ( !$exec ) ? "player_display" : $exec;    // ȸ�� ó�� ���� ����

			$bbsInfor = getBbsInfor ($id                                       ); // �Խ��� ����
// echo '����ź��.';
			$bbsGrant = getBbsGrant ($bbsInfor['no'],$memInfor['member_level'] ); // ����   ����

			if ( $bbsInfor )  { // �Խ��� ���� ����

				$user_id   = $memInfor['user_id' ]; // ���̵�

				// ----------------------------- ------------------ --------------------------- //
				$_skinName = ''; // ��Ų��
				if ( $HTTP_GET_VARS['skin_name'] || !$skin_name ) {
					$_skinName  = $bbsInfor['skin_name'];
				} else {
					$_skinName  = $skin_name;
				}
				$skinDir  = $baseDir . 'skin/board/' . $_skinName . '/'   ;


				_css ($skinDir );   // css ����

				echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" );
				echo ( "    var driver  = '".$sysInfor['driver']."';\n");
				echo ( "    var baseDir = '".$baseDir           ."';\n");
				echo ( "    var fpWin   = null;");
				echo ( "\n</SCRIPT>\n" );

				if ( $exec == "player_display" ) {
					include "dplayer_main.php"      ; // �÷��̾� ������ ���� ������ �ʱ�ȭ
					echo "\n<SCRIPT LANGUAGE='JavaScript'>\n";
					echo "<!--\n";
				//  ECHO "alert ( 'dplayer.php1 \\n tmp_cart:   " . $HTTP_SESSION_VARS['tmp_cart'    ] . "\\n media_cart: " . $HTTP_SESSION_VARS['media_cart'  ] . "');";
					//  S_playMode      = 'S'       ; // �������  : 'S', ����� : 'R', �����   : 'O'
					if ( $gubun == 'CART_PLAY' ) {
						echo "S_playMode = 'S';\n";
					} else if ( $gubun == 'ALL_PLAY' ) {
						echo "S_playMode = 'S';\n";
					} else if ( $gubun == 'RANDOM_PLAY' ) {
						echo "S_playMode = 'R';\n";
					} else {
						if ( $gubun == 'BBS_ONE_PLAY' ) {
							if ( $display_method == 'N' ) {
								echo "S_display = 'N';\n";
							}
							echo "S_playMode   = 'S';\n";
							echo "S_type       = '$display_method';\n";// �÷��̾� �˾� : 'P', ������ : 'F', ���� ������ : 'C'
							echo "S_listMode   = '2';\n";// ��� ��� ���� ������ ��� : '1', �˾� ��� : '2'
							echo "S_lyricsMode = '2';\n";// ����      ���� ������ ��� : '1'. �˾� ��� : '2'
						}
					}
					echo "S_autoplay = 'Y';\n";
				//  ECHO "alert ( 'dplayer.php2 \\n tmp_cart:   " . $HTTP_SESSION_VARS['tmp_cart'    ] . "\\n media_cart: " . $HTTP_SESSION_VARS['media_cart'  ] . "');";
					include "common/lib/" . $sysInfor["driver"] . '/'  . "play_album_retrive.php"; // ���õ� �ٹ� ���� ��ȸ
					echo "//-->\n";
					echo "</SCRIPT>\n";
				} else if ( $exec == "get_item" ) {
					echo "\n<SCRIPT LANGUAGE='JavaScript'>\n";
					echo "<!--\n";
					include "common/lib/" . $sysInfor["driver"] . '/' . "play_one_row_retrive.php"; // ���õ� �ٹ� ���� ��ȸ
					echo "//-->\n";
					echo "</SCRIPT>\n";
				}
			}
			closeDBConnection (); // �����ͺ��̽� ���� ���� ����
		}
        $_dboard_player_included = true;
	}

    if ( $self_yn ) {
		createPlayer($gubun, $display_method, $id );
    }
}
?>