<?
if ( function_exists('head') ) {
    if ( file_exists($skinDir ."poll_result_main.php") ) {
        $sql  = "select * from $tb_poll_item where p_no = '" . $poll_id . "' order by no;";

        $stmt = multiRowSQLQuery ($sql);

        while ( $data = multiRowFetch  ($stmt) ) {
        /* ----- 값 설정 ------------------------------------ */
            $poll_no= $data['no'  ];   ;   /* 설문 항목 번호 */
            $p_no   = $data['p_no'];   ;   /* 상위 설문 번호 */
            $item   = $data['item'];   ;   /* 설문 항목      */
            $hit    = $data['hit' ];   ;   /* 득표 수        */

            $item = curString($item, $item_limit, $item_cut_tag); // 타이틀 길이 맞추기
            if ( $hit > 0 ) {
                $percent = $hit / $total_hit * 100;
                $percent = round( $percent, 1 ) . '%';
            } else {
                $percent = '0%';
            }
            include $skinDir ."poll_result_main.php"; // 설문 결과 그래프 Main 스킨 ( 순환 부분 )
        }
    } else {
        Message('S', '0044',"");
    }
}
?>