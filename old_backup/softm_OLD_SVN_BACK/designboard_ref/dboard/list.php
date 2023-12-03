<?
if ( function_exists('_head') ) {
    // echo ( "유알엘 체쿠: " . $HTTP_SERVER_VARS['HTTP_HOST'] . $HTTP_SERVER_VARS['PHP_SELF'] . '<BR>' );
    if ( $exec == 'list' && !ereg( "(".$HTTP_SERVER_VARS['HTTP_HOST'].")((.)*(/)+)+(list.php)", $HTTP_SERVER_VARS['HTTP_HOST'] . $HTTP_SERVER_VARS['PHP_SELF'] ) ) {
        // 게시판 정보
        $how_many  = $bbsInfor['how_many' ]; // 첫 페이지     글수
        $more_many = $bbsInfor['more_many']; // 첫 페이지이후 글수
        $page_many = $bbsInfor['page_many']; // 페이지 표시 수
        $displayList = $bbsInfor['display_list']; // 메뉴표시 선택(리스트)
        $displayView = $bbsInfor['display_view']; // 리스트 출력  의견달기

        $hide_no_s       = ""; $hide_no_e       = "";$hide_name_s     = ""; $hide_name_e     = "";
        $hide_file1_s    = ""; $hide_file1_e    = "";$hide_file2_s    = ""; $hide_file2_e    = "";
        $hide_hit_s      = ""; $hide_hit_e      = "";
        $hide_down_hit1_s= ""; $hide_down_hit1_e= "";$hide_down_hit2_s= ""; $hide_down_hit2_e= "";
        $hide_reg_date_s = ""; $hide_reg_date_e = "";$hide_search_s   = ""; $hide_search_e   = "";
        $hide_character_s= ""; $hide_character_e= "";

        /* ---------------------------------------------------------- */
        if ( !$displayList[0] ) { $hide_no_s       = "<!--"; $hide_no_e       = "-->";} // 번호
        if ( !$displayList[1] ) { $hide_name_s     = "<!--"; $hide_name_e     = "-->";} // 이름
        if ( !$displayList[2] ) { $hide_file1_s    = "<!--"; $hide_file1_e    = "-->";} // 파일1
        if ( !$displayList[2] ) { $hide_file2_s    = "<!--"; $hide_file2_e    = "-->";} // 파일2
        if ( !$displayList[3] ) { $hide_hit_s      = "<!--"; $hide_hit_e      = "-->";} // 조회
        if ( !$displayList[4] ) { $hide_down_hit1_s= "<!--"; $hide_down_hit1_e= "-->";} // 다운수1
        if ( !$displayList[4] ) { $hide_down_hit2_s= "<!--"; $hide_down_hit2_e= "-->";} // 다운수2
        if ( !$displayList[5] ) { $hide_reg_date_s = "<!--"; $hide_reg_date_e = "-->";} // 날짜
        if ( !$displayList[6] ) { $hide_search_s   = "&nbsp;<!--"; $hide_search_e   = "-->";} // 검색
    //  if ( !$displayList[7] ) { $hide_new_s      = "<!--"; $hide_new_e      = "-->";} // 새글
    //  if ( !$displayList[8] ) { $hide_plus_s     = "<!--"; $hide_plus_e     = "-->";} // 당일 의견글 + 표시
        if ( !$displayList[9] ) { $hide_character_s= "<!--"; $hide_character_e= "-->";} // 회원 아이콘

        $grantCharStr = $bbsInfor['grant_character_image']; // 회원 아이콘 권한
        include $skinDir ."list_header.php"  ; // 리스트 Header ( 리스트 화면에서 상단에 한번만 출력되는 부분 )

        // 게시판 설정
        $s = ( !$s ) ? 1 : $s;
        if ( $s >= $how_many + 1 ) $cur_many = $more_many; else $cur_many = $how_many;

        /* 총 자료수        */
        $sql = "select count(*) from $tb_bbs_data" . "_" . $id;
        $where = "";
        if ( $search ) {
            $where  .= " where use_st != 0 ";
            $where  .= " and ";
            if ( $search_cond ) {
                $where  .= $search_cond . " like '%" . $search . "%'";
            } else {
                $where  .= " ( name     like '%" . $search . "%'";
                $where  .= " or    title    like '%" . $search . "%'";
                $where  .= " or    content  like '%" . $search . "%')";
            }
            if ( $search_cat_no ) $where  .= " and cat_no = '" . $search_cat_no . "'";
        } else {
            if ( $search_cat_no ) $where  .= " where cat_no = '" . $search_cat_no . "'";
        }
        $sql .= $where;

        if ( !$tot ) $tot = simpleSQLQuery($sql);

        if ( $p_exec == "delete" && $tot > 0 ) $tot = $tot - 1;

        if ( $s > $tot ) {
            if ( $p_exec == "delete" ) { $s = $s - $how_many; if ( $s < 0 ) $s = 1; }
            else { $s = 1; }
        }

        $a_pre_list  = _prevPageTab ( $s, $tot, $how_many, $more_many, $page_many, $HTTP_SERVER_VARS['PHP_SELF']); // 이전 페이지
        $a_next_list = _nextPageTab ( $s, $tot, $how_many, $more_many, $page_many, $HTTP_SERVER_VARS['PHP_SELF']); // 이후 페이지

        include $libDir . "/list.php"; // 리스트 조회

        if ( $tot == 0 ) {
            if ( file_exists($skinDir ."list_0_data.php" ) ) {
                include $skinDir ."list_0_data.php"  ; // 조회된 자료 없음
            }
        }
        include $skinDir ."list_footer.php"  ; // 리스트 Footer ( 리스트 화면에서 하단에 한번만 출력되는 부분 )

        if ( $displayList[6] ) echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" . "objectSelected( document.searchForm.".$search_condition.", '". $$search_condition ."' );\n</SCRIPT>\n" );

        if ( $list_image_display_mode == '1' ) { // 자동 크기 조정
            echo ( "\n<SCRIPT LANGUAGE='javascript'>\n var list_image_display_mode= '$list_image_display_mode';\n</SCRIPT>\n" );
        }
    } else {
        MessageC ('S', '0003'); // 페이지 접근이 거부 되었습니다.
    }
}
?>