<?
if ( function_exists('head') ) {
    if ( $poll_exec == 'poll_result' && !preg_match( "/(".$_SERVER['HTTP_HOST'].")((.)*(\/)+)+(poll_result.php)/", $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ) ) {
       /* �� ������        */
        $sql = "select count(no) from $tb_poll_item where p_no = '" . $poll_id . "'";
    //  logs ( '$sql : '. $sql . '<BR>' , true);
        $poll_tot = simpleSQLQuery($sql);

        if ( $poll_tot == 0 ) {
            if ( file_exists($skinDir ."poll_0_data.php") ) {
                include $skinDir ."poll_0_data.php"  ; // ��ȸ�� ������ ����
            }
        } else {
            if ( file_exists($skinDir ."poll_result_header.php") ) {
                include $skinDir ."poll_result_header.php"  ; // ���� ��� ���
            }
            if ( file_exists($skinDir ."poll_result_main_header.php") ) {
                include $skinDir ."poll_result_main_header.php"; // ���� ��� �׷��� Main ��� ( ��ȯ �κ� )
            }
            require $libDir . "/list_poll_result.php"; // ���� ���� ��ȸ
            // ��Ŭ��� poll_result_main.php
            if ( file_exists($skinDir ."poll_result_main_footer.php") ) {
                include $skinDir ."poll_result_main_footer.php"; // ���� ��� �׷��� Main ǲ�� ( ��ȯ �κ� )
            }

            if ( file_exists($skinDir ."poll_result_footer.php") ) {
                include $skinDir ."poll_result_footer.php"; // ���� ��� ǲ�� ��Ų
            }
        }

    } else {
        Message('S', '0003');     // ������ ������ �ź� �Ǿ����ϴ�.
    }
}
?>