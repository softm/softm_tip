<?
if ( function_exists('head') ) {
    if ( file_exists($skinDir ."poll_result_main.php") ) {
        $sql  = "select * from $tb_poll_item where p_no = '" . $poll_id . "' order by no;";

        $stmt = multiRowSQLQuery ($sql);

        while ( $data = multiRowFetch  ($stmt) ) {
        /* ----- �� ���� ------------------------------------ */
            $poll_no= $data['no'  ];   ;   /* ���� �׸� ��ȣ */
            $p_no   = $data['p_no'];   ;   /* ���� ���� ��ȣ */
            $item   = $data['item'];   ;   /* ���� �׸�      */
            $hit    = $data['hit' ];   ;   /* ��ǥ ��        */

            $item = curString($item, $item_limit, $item_cut_tag); // Ÿ��Ʋ ���� ���߱�
            if ( $hit > 0 ) {
                $percent = $hit / $total_hit * 100;
                $percent = round( $percent, 1 ) . '%';
            } else {
                $percent = '0%';
            }
            include $skinDir ."poll_result_main.php"; // ���� ��� �׷��� Main ��Ų ( ��ȯ �κ� )
        }
    } else {
        Message('S', '0044',"");
    }
}
?>