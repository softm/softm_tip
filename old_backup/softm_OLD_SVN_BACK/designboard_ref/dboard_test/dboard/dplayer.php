<?
error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE ( Notice�� ������ ��翡���� �������ض�~ )
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
$IJTSEC = ( $_GET["baseDir"] || $_POST["baseDir"] || $_GET["libDir"] || $_POST["libDir"] ) ? false : true;
if ( $IJTSEC ) {
	// dplayer.php�� �ٸ��������� include�Ǿ����� ����
	if (!defined("DPLAYER_INCLUDE") ) {
		if ( preg_match( "/(".$_SERVER['HTTP_HOST'].")((.)*(\/)+)+(dplayer.php)/", $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ) ) {
			define("DPLAYER_INCLUDE","OFF");
		} else {
			define("DPLAYER_INCLUDE","ON");
		}
	}

    include_once $baseDir.'common/board_lib.inc';  // �Խ��� ���̺귯��
    include_once $baseDir.'common/member_lib.inc'; // ��� ���̺귯��
    include_once $baseDir.'common/lib.inc';        // ���� ���̺귯��
    include_once $baseDir.'common/message.inc';    // ���� ������ ó��
    include_once $baseDir.'common/db_connect.inc'; // Data Base ���� Ŭ����
    include_once $baseDir.'common/_service.inc';   // ���� ȭ�� ����
    include_once $baseDir.'common/file.inc';       // ���� �ý��� ����

    $memInfor = getMemInfor (); // ȸ��  ����
    $_dboard_poll_result_alert = false;
    if(!$_dboard_player_included) { // �ѹ��� ��Ŭ��� �ǰ� ó��

        // �÷��̾� ����
        // $gubun : '1' ::> ���� createPollȣ��
        //        : '2' ::> ���� createPollȣ��
        function createPlayer($gubun="BBS_ONE_PLAY", $display_method="C", $id, $play_no='' ) {
            global $package, $db, $sysInfor, $baseDir, $user_id, $tb_bbs_infor, $tb_bbs_grant, $tb_bbs_data, $_dboard_form_included, $_dboard_player_included;
            global $exec, $s, $tot, $how_many, $more_many, $page_many, $page_tab;
            global $memInfor, $_dboard_ver_str, $a_params, $_dboard_poll_result_alert, $grantCharStr;
//            global $_ENV, $_GET, $_POST, $_SERVER, $_SESSION, $_SESSION;
            global $_SERVER, $_GET, $_SESSION , $_SESSION;
			$package = 'player'; // �÷��̾�
            @extract($_GET   ); // Get  ����� Parameter ��
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
				if ( $_GET['skin_name'] || !$skin_name ) {
					$_skinName  = $bbsInfor['skin_name'];
				} else {
					$_skinName  = $skin_name;
				}
				$skinDir  = $baseDir . 'skin/board/' . $_skinName . '/'   ;


				css ($skinDir );   // css ����

				echo ( "\n<script type='text/javascript'>\n" );
				echo ( "    var driver  = '".$sysInfor['driver']."';\n");
				echo ( "    var baseDir = '".$baseDir           ."';\n");
				echo ( "    var fpWin   = null;");
				echo ( "\n</SCRIPT>\n" );

				if ( $exec == "player_display" ) {
					include $baseDir."dplayer_main.php"      ; // �÷��̾� ������ ���� ������ �ʱ�ȭ
					echo "\n<script type='text/javascript'>\n";
					echo "<!--\n";
				//  ECHO "alert ( 'dplayer.php1 \\n tmp_cart:   " . $_SESSION['tmp_cart'    ] . "\\n media_cart: " . $_SESSION['media_cart'  ] . "');";
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
				//  ECHO "alert ( 'dplayer.php2 \\n tmp_cart:   " . $_SESSION['tmp_cart'    ] . "\\n media_cart: " . $_SESSION['media_cart'  ] . "');";
					include $baseDir."common/lib/" . $sysInfor["driver"] . '/'  . "play_album_retrive.php"; // ���õ� �ٹ� ���� ��ȸ
					echo "//-->\n";
					echo "</SCRIPT>\n";
				} else if ( $exec == "get_item" ) {
					echo "\n<script type='text/javascript'>\n";
					echo "<!--\n";
					include $baseDir."common/lib/" . $sysInfor["driver"] . '/' . "play_one_row_retrive.php"; // ���õ� �ٹ� ���� ��ȸ
					echo "//-->\n";
					echo "</SCRIPT>\n";
				}
			}
			closeDBConnection (); // �����ͺ��̽� ���� ���� ����
		}
        $_dboard_player_included = true;
	}

	if ( DPLAYER_INCLUDE == DBOARD_INCLUDE_OFF ) {
		createPlayer($gubun, $display_method, $id );
    }
}
?>