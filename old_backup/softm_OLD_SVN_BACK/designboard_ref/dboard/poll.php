<?
if ( function_exists('_head') ) {
// echo ( "유알엘 체쿠: " . $HTTP_SERVER_VARS['HTTP_HOST'] . $HTTP_SERVER_VARS['PHP_SELF'] . '<BR>' );
    if ( $poll_exec == 'poll' && !ereg( "(".$HTTP_SERVER_VARS['HTTP_HOST'].")((.)*(/)+)+(poll.php)", $HTTP_SERVER_VARS['HTTP_HOST'] . $HTTP_SERVER_VARS['PHP_SELF'] ) ) {
        if ( file_exists($skinDir ."poll_header.php" ) ) {
            include $skinDir ."poll_header.php"  ; // 설문 조사 Header ( 설문 조사 화면에서 상단에 한번만 출력되는 부분 )
        }

        include $libDir . "list_poll.php"; // 설문 조사 조회

       /* 총 설문수        */
        $sql = "select count(no) from $tb_poll_item where p_no = '" . $poll_id . "'";
    //  logs ( '$sql : '. $sql . '<BR>' , true);
        $poll_item_tot = simpleSQLQuery($sql);

        if ( $poll_item_tot == 0 ) {
            include $skinDir ."poll_0_data.php"  ; // 조회된 설문이 없음
        }
        if ( file_exists($skinDir ."poll_footer.php" ) ) {
            include $skinDir ."poll_footer.php"  ; // 설문 조사 Footer ( 설문 조사 화면에서 하단에 한번만 출력되는 부분 )
        }
    } else {
        head($_title);             // Header 출력
        MessageC ('S', '0003');     // 페이지 접근이 거부 되었습니다.
    }
}
?>