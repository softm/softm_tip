<?
$IJTSEC = ( $HTTP_GET_VARS["baseDir"] || $HTTP_POST_VARS["baseDir"] || $HTTP_GET_VARS["libDir"] || $HTTP_POST_VARS["libDir"] ) ? false : true;
if ( $IJTSEC ) {
    include 'common/lib.inc'         ;   // ���� ���̺귯��
    include 'common/message.inc'     ;   // ���� ������ ó��
    include 'common/_service.inc'    ;   // ���� ȭ�� ����
    include 'common/board_lib.inc'   ;   // �Խ��� ���̺귯��
    include 'common/member_lib.inc'  ;   // ��� ���̺귯��
    include 'common/db_connect.inc'  ;   // Data Base ���� Ŭ����
    include 'common/file.inc'        ;   // ���� �ý��� ����
    include 'common/page_tab.inc'    ;   // ������ ��

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

        _head($_title); // print html header

        if(!$_dboard_board_included) {
            echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" );
            echo ( " var id   = '".$id   ."';\n" );
            echo ( " var no   = '".$no   ."';\n" );
            echo ( " var s    = '".$s    ."';\n" );
            echo ( " var npop = '".$npop ."';\n" );
            echo ( " var exec = '".$exec ."';\n" );
            echo ( " var search_cat_no = '".$search_cat_no ."';\n" );
            echo ( "</SCRIPT>\n" );
        }

        $search_condition = 'search_cond'; // �˻� ���� name ����
        $search_word      = 'search'     ; // �˻� ��   name ����

        boardFormCreate(); // �� ����

        include 'common/board_top.php'   ; // top
        include 'common/board_main.php'  ; // main
        include 'common/board_bottom.php'; // bottom
        _footer(); // print html footer
        if(!$_dboard_board_included) $_dboard_board_included = true; // �Խ��� �ѹ� �̻� �ε��� ����(true)
    } else {
        $_title = 'Designboard';
        head($_title); // Header ���
        _css($baseDir);
        MessageC ('S', '0004'); // �Խ����� �������� �ʽ��ϴ�.
    }

    if ( $db ) closeDBConnection (); // db disconnect

    $_sessionEnd = getMicroSecond();
    logs ( "\n<!--���� �ð� : " . $_sessionStart . "\n", true);
    logs ( "\n���� �ð� : " . $_sessionEnd   . "\n", true);
    logs ( "\n���� �ð� : " . sprintf("%0.3f",$_sessionEnd - $_sessionStart) . "\n-->", true);
}
?>
