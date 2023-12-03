<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
$IJTSEC = ( $_GET["baseDir"] || $_POST["baseDir"] || $_GET["libDir"] || $_POST["libDir"] ) ? false : true;
if ( $IJTSEC ) {
	// dboard.php가 다른페이지에 include되었는지 여부
	if (!defined("DBOARD_INCLUDE") ) {
		if ( preg_match( "/(".$_SERVER['HTTP_HOST'].")((.)*(\/)+)+(dboard.php)/", $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ) ) {
			define("DBOARD_INCLUDE","OFF");
		} else {
			define("DBOARD_INCLUDE","ON");
		}
	}
    include_once  'common/lib.inc'         ;   // 공통 라이브러리
    include_once  'common/message.inc'     ;   // 에러 페이지 처리
    include_once  'common/_service.inc'    ;   // 서비스 화면 관련
    include_once  'common/board_lib.inc'   ;   // 게시판 라이브러리
    include_once  'common/member_lib.inc'  ;   // 멤버 라이브러리
    include_once  'common/db_connect.inc'  ;   // Data Base 연결 클래스
    include_once  'common/file.inc'        ;   // 파일 시스템 관련
    include_once  'common/page_tab.inc'    ;   // 페이지 탭

    $_sessionStart  = getMicroSecond    (); // 실행 시작 시간

    if ( !$db ) $db = initDBConnection  (); // db connect

    $bbsInfor = getBbsInfor ($id); // 게시판 정보

    if ( $bbsInfor ) {
        $memInfor = getMemInfor ();                                           // 회원 정보
        $bbsGrant = getBbsGrant ($bbsInfor['no'],$memInfor['member_level'] ); // 권한 정보

        $exec     = ( !$exec ) ? 'list' : $exec;      // 회면 처리 변수 설정
        $design_method = $bbsInfor['design_method'] ; // 디자인 방식

        // 화면 타이틀 설정
        if      ( $exec == 'list'   ) { $_title = '리스트 - ' . $_dboard_ver; $msgNo = '0005';}
        else if ( $exec == 'view'   ) { $_title = '읽기 - '   . $_dboard_ver; $msgNo = '0006';}
        else if ( $exec == 'insert' ) { $_title = '쓰기 - '   . $_dboard_ver; $msgNo = '0007';}
        else if ( $exec == 'update' ) { $_title = '수정 - '   . $_dboard_ver; $msgNo = '0008';}
        else if ( $exec == 'answer' ) { $_title = '답변 - '   . $_dboard_ver; $msgNo = '0009';}

        head(DBOARD_DIC_TITLE."-".$_title); // Header 출력
        css($baseDir);

        if(!$_dboard_board_included) {
            echo ( "\n<script type='text/javascript'>\n" );
            echo ( " var id   = '".$id   ."';\n" );
            echo ( " var no   = '".$no   ."';\n" );
            echo ( " var s    = '".$s    ."';\n" );
            echo ( " var npop = '".$npop ."';\n" );
            echo ( " var exec = '".$exec ."';\n" );
            echo ( " var search_cat_no = '".$search_cat_no ."';\n" );
            echo ( "</SCRIPT>\n" );
        }
        if ( DBOARD_PAGE_DIRECT_ACCESS ) {
    		body();
        }
        $search_condition = 'search_cond'; // 검색 조건 name 설정
        $search_word      = 'search'     ; // 검색 어   name 설정

        boardFormCreate(); // 폼 생성

        include 'common/board_top.php'   ; // top
        include 'common/board_main.php'  ; // main
        include 'common/board_bottom.php'; // bottom
        footer();
        if(!$_dboard_board_included) $_dboard_board_included = true; // 게시판 한번 이상 로딩된 상태(true)
    } else {
        $_title = 'Designboard';
        head(DBOARD_TITLE."-".$_title); // Header 출력
        css($baseDir);
        Message('S', '0004'); // 게시판이 존재하지 않습니다.
        footer();
    }

    if ( $db ) closeDBConnection (); // db disconnect

    $_sessionEnd = getMicroSecond();
}
?>
