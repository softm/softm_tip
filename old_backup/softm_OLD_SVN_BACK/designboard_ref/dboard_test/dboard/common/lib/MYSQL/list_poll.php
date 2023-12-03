<?
if ( function_exists('head') ) {
    if ( file_exists($skinDir ."poll_main.php") ) {
        $sql  = "select * from $tb_poll_item where p_no = '" . $poll_id . "' order by no;";
        $stmt = multiRowSQLQuery ($sql);
        while ( $data = multiRowFetch  ($stmt) ) {
            $poll_no= $data['no'  ];
            $g_no   = $data['g_no'];
            $item   = $data['item'];
            $hit    = $data['hit' ];
            $item = curString($item, $item_limit, $item_cut_tag); // 타이틀 길이 맞추기
            include $skinDir ."poll_main.php"; // 설문 리스트 Main  스킨 ( 순환 부분 )
        }
    } else {
        Message('S', '0043',"");
    }
}
?>