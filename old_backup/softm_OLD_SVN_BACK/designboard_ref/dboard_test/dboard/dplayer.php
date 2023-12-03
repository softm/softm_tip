<?
error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE ( Notice는 제외한 모든에러를 리포팅해라~ )
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
$IJTSEC = ( $_GET["baseDir"] || $_POST["baseDir"] || $_GET["libDir"] || $_POST["libDir"] ) ? false : true;
if ( $IJTSEC ) {
	// dplayer.php가 다른페이지에 include되었는지 여부
	if (!defined("DPLAYER_INCLUDE") ) {
		if ( preg_match( "/(".$_SERVER['HTTP_HOST'].")((.)*(\/)+)+(dplayer.php)/", $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ) ) {
			define("DPLAYER_INCLUDE","OFF");
		} else {
			define("DPLAYER_INCLUDE","ON");
		}
	}

    include_once $baseDir.'common/board_lib.inc';  // 게시판 라이브러리
    include_once $baseDir.'common/member_lib.inc'; // 멤버 라이브러리
    include_once $baseDir.'common/lib.inc';        // 공통 라이브러리
    include_once $baseDir.'common/message.inc';    // 에러 페이지 처리
    include_once $baseDir.'common/db_connect.inc'; // Data Base 연결 클래스
    include_once $baseDir.'common/_service.inc';   // 서비스 화면 관련
    include_once $baseDir.'common/file.inc';       // 파일 시스템 관련

    $memInfor = getMemInfor (); // 회원  정보
    $_dboard_poll_result_alert = false;
    if(!$_dboard_player_included) { // 한번만 인클루드 되게 처리

        // 플레이어 생성
        // $gubun : '1' ::> 직접 createPoll호출
        //        : '2' ::> 직접 createPoll호출
        function createPlayer($gubun="BBS_ONE_PLAY", $display_method="C", $id, $play_no='' ) {
            global $package, $db, $sysInfor, $baseDir, $user_id, $tb_bbs_infor, $tb_bbs_grant, $tb_bbs_data, $_dboard_form_included, $_dboard_player_included;
            global $exec, $s, $tot, $how_many, $more_many, $page_many, $page_tab;
            global $memInfor, $_dboard_ver_str, $a_params, $_dboard_poll_result_alert, $grantCharStr;
//            global $_ENV, $_GET, $_POST, $_SERVER, $_SESSION, $_SESSION;
            global $_SERVER, $_GET, $_SESSION , $_SESSION;
			$package = 'player'; // 플레이어
            @extract($_GET   ); // Get  방식의 Parameter 값
            if ( !$db ) $db = initDBConnection (); // 데이터베이스 접속

			// 단계의 변이 ::> $exec
			// player_display --> get_item
			$exec = ( !$exec ) ? "player_display" : $exec;    // 회면 처리 변수 설정

			$bbsInfor = getBbsInfor ($id                                       ); // 게시판 정보
// echo '여기탄다.';
			$bbsGrant = getBbsGrant ($bbsInfor['no'],$memInfor['member_level'] ); // 권한   정보

			if ( $bbsInfor )  { // 게시판 정보 존재

				$user_id   = $memInfor['user_id' ]; // 아이디

				// ----------------------------- ------------------ --------------------------- //
				$_skinName = ''; // 스킨명
				if ( $_GET['skin_name'] || !$skin_name ) {
					$_skinName  = $bbsInfor['skin_name'];
				} else {
					$_skinName  = $skin_name;
				}
				$skinDir  = $baseDir . 'skin/board/' . $_skinName . '/'   ;


				css ($skinDir );   // css 설정

				echo ( "\n<script type='text/javascript'>\n" );
				echo ( "    var driver  = '".$sysInfor['driver']."';\n");
				echo ( "    var baseDir = '".$baseDir           ."';\n");
				echo ( "    var fpWin   = null;");
				echo ( "\n</SCRIPT>\n" );

				if ( $exec == "player_display" ) {
					include $baseDir."dplayer_main.php"      ; // 플레이어 동작을 위한 페이지 초기화
					echo "\n<script type='text/javascript'>\n";
					echo "<!--\n";
				//  ECHO "alert ( 'dplayer.php1 \\n tmp_cart:   " . $_SESSION['tmp_cart'    ] . "\\n media_cart: " . $_SESSION['media_cart'  ] . "');";
					//  S_playMode      = 'S'       ; // 전곡순서  : 'S', 전곡랜덤 : 'R', 현재곡   : 'O'
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
							echo "S_type       = '$display_method';\n";// 플레이어 팝업 : 'P', 프레임 : 'F', 현재 페이지 : 'C'
							echo "S_listMode   = '2';\n";// 재생 목록 현재 페이지 출력 : '1', 팝업 출력 : '2'
							echo "S_lyricsMode = '2';\n";// 가사      현재 페이지 출력 : '1'. 팝업 출력 : '2'
						}
					}
					echo "S_autoplay = 'Y';\n";
				//  ECHO "alert ( 'dplayer.php2 \\n tmp_cart:   " . $_SESSION['tmp_cart'    ] . "\\n media_cart: " . $_SESSION['media_cart'  ] . "');";
					include $baseDir."common/lib/" . $sysInfor["driver"] . '/'  . "play_album_retrive.php"; // 선택된 앨범 정보 조회
					echo "//-->\n";
					echo "</SCRIPT>\n";
				} else if ( $exec == "get_item" ) {
					echo "\n<script type='text/javascript'>\n";
					echo "<!--\n";
					include $baseDir."common/lib/" . $sysInfor["driver"] . '/' . "play_one_row_retrive.php"; // 선택된 앨범 정보 조회
					echo "//-->\n";
					echo "</SCRIPT>\n";
				}
			}
			closeDBConnection (); // 데이터베이스 연결 설정 해제
		}
        $_dboard_player_included = true;
	}

	if ( DPLAYER_INCLUDE == DBOARD_INCLUDE_OFF ) {
		createPlayer($gubun, $display_method, $id );
    }
}
?>