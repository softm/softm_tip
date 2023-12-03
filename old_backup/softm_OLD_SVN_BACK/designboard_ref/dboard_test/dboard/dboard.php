<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
$IJTSEC = ( $_GET["baseDir"] || $_POST["baseDir"] || $_GET["libDir"] || $_POST["libDir"] ) ? false : true;
if ( $IJTSEC ) {
	// dboard.php�� �ٸ��������� include�Ǿ����� ����
	if (!defined("DBOARD_INCLUDE") ) {
		if ( preg_match( "/(".$_SERVER['HTTP_HOST'].")((.)*(\/)+)+(dboard.php)/", $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ) ) {
			define("DBOARD_INCLUDE","OFF");
		} else {
			define("DBOARD_INCLUDE","ON");
		}
	}
    include_once  'common/lib.inc'         ;   // ���� ���̺귯��
    include_once  'common/message.inc'     ;   // ���� ������ ó��
    include_once  'common/_service.inc'    ;   // ���� ȭ�� ����
    include_once  'common/board_lib.inc'   ;   // �Խ��� ���̺귯��
    include_once  'common/member_lib.inc'  ;   // ��� ���̺귯��
    include_once  'common/db_connect.inc'  ;   // Data Base ���� Ŭ����
    include_once  'common/file.inc'        ;   // ���� �ý��� ����
    include_once  'common/page_tab.inc'    ;   // ������ ��

    $_sessionStart  = getMicroSecond    (); // ���� ���� �ð�

    if ( !$db ) $db = initDBConnection  (); // db connect

    $bbsInfor = getBbsInfor ($id); // �Խ��� ����

    if ( $bbsInfor ) {
        $memInfor = getMemInfor ();                                           // ȸ�� ����
        $bbsGrant = getBbsGrant ($bbsInfor['no'],$memInfor['member_level'] ); // ���� ����

        $exec     = ( !$exec ) ? 'list' : $exec;      // ȸ�� ó�� ���� ����
        $design_method = $bbsInfor['design_method'] ; // ������ ���

        // ȭ�� Ÿ��Ʋ ����
        if      ( $exec == 'list'   ) { $_title = '����Ʈ - ' . $_dboard_ver; $msgNo = '0005';}
        else if ( $exec == 'view'   ) { $_title = '�б� - '   . $_dboard_ver; $msgNo = '0006';}
        else if ( $exec == 'insert' ) { $_title = '���� - '   . $_dboard_ver; $msgNo = '0007';}
        else if ( $exec == 'update' ) { $_title = '���� - '   . $_dboard_ver; $msgNo = '0008';}
        else if ( $exec == 'answer' ) { $_title = '�亯 - '   . $_dboard_ver; $msgNo = '0009';}

        head(DBOARD_DIC_TITLE."-".$_title); // Header ���
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
        $search_condition = 'search_cond'; // �˻� ���� name ����
        $search_word      = 'search'     ; // �˻� ��   name ����

        boardFormCreate(); // �� ����

        include 'common/board_top.php'   ; // top
        include 'common/board_main.php'  ; // main
        include 'common/board_bottom.php'; // bottom
        footer();
        if(!$_dboard_board_included) $_dboard_board_included = true; // �Խ��� �ѹ� �̻� �ε��� ����(true)
    } else {
        $_title = 'Designboard';
        head(DBOARD_TITLE."-".$_title); // Header ���
        css($baseDir);
        Message('S', '0004'); // �Խ����� �������� �ʽ��ϴ�.
        footer();
    }

    if ( $db ) closeDBConnection (); // db disconnect

    $_sessionEnd = getMicroSecond();
}
?>
