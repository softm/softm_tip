<?
if ( function_exists('_head') ) {
// echo ( "���˿� ü��: " . $HTTP_SERVER_VARS['HTTP_HOST'] . $HTTP_SERVER_VARS['PHP_SELF'] . '<BR>' );
    if ( $poll_exec == 'poll' && !ereg( "(".$HTTP_SERVER_VARS['HTTP_HOST'].")((.)*(/)+)+(poll.php)", $HTTP_SERVER_VARS['HTTP_HOST'] . $HTTP_SERVER_VARS['PHP_SELF'] ) ) {
        if ( file_exists($skinDir ."poll_header.php" ) ) {
            include $skinDir ."poll_header.php"  ; // ���� ���� Header ( ���� ���� ȭ�鿡�� ��ܿ� �ѹ��� ��µǴ� �κ� )
        }

        include $libDir . "list_poll.php"; // ���� ���� ��ȸ

       /* �� ������        */
        $sql = "select count(no) from $tb_poll_item where p_no = '" . $poll_id . "'";
    //  logs ( '$sql : '. $sql . '<BR>' , true);
        $poll_item_tot = simpleSQLQuery($sql);

        if ( $poll_item_tot == 0 ) {
            include $skinDir ."poll_0_data.php"  ; // ��ȸ�� ������ ����
        }
        if ( file_exists($skinDir ."poll_footer.php" ) ) {
            include $skinDir ."poll_footer.php"  ; // ���� ���� Footer ( ���� ���� ȭ�鿡�� �ϴܿ� �ѹ��� ��µǴ� �κ� )
        }
    } else {
        head($_title);             // Header ���
        MessageC ('S', '0003');     // ������ ������ �ź� �Ǿ����ϴ�.
    }
}
?>