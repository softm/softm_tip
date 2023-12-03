<?
if ( function_exists('head') ) {
    if ( $poll_exec == 'poll_result' && !preg_match( "/(".$_SERVER['HTTP_HOST'].")((.)*(\/)+)+(poll_result.php)/", $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ) ) {
       /* 총 설문수        */
        $sql = "select count(no) from $tb_poll_item where p_no = '" . $poll_id . "'";
    //  logs ( '$sql : '. $sql . '<BR>' , true);
        $poll_tot = simpleSQLQuery($sql);

        if ( $poll_tot == 0 ) {
            if ( file_exists($skinDir ."poll_0_data.php") ) {
                include $skinDir ."poll_0_data.php"  ; // 조회된 설문이 없음
            }
        } else {
            if ( file_exists($skinDir ."poll_result_header.php") ) {
                include $skinDir ."poll_result_header.php"  ; // 설문 결과 헤더
            }
            if ( file_exists($skinDir ."poll_result_main_header.php") ) {
                include $skinDir ."poll_result_main_header.php"; // 설문 결과 그래프 Main 헤더 ( 순환 부분 )
            }
            require $libDir . "/list_poll_result.php"; // 설문 조사 조회
            // 인클루드 poll_result_main.php
            if ( file_exists($skinDir ."poll_result_main_footer.php") ) {
                include $skinDir ."poll_result_main_footer.php"; // 설문 결과 그래프 Main 풋터 ( 순환 부분 )
            }

            if ( file_exists($skinDir ."poll_result_footer.php") ) {
                include $skinDir ."poll_result_footer.php"; // 설문 결과 풋터 스킨
            }
        }

    } else {
        Message('S', '0003');     // 페이지 접근이 거부 되었습니다.
    }
}
?>