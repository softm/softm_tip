<?
if ( function_exists('_head') ) {
    // echo ( "���˿� ü��: " . $HTTP_SERVER_VARS['HTTP_HOST'] . $HTTP_SERVER_VARS['PHP_SELF'] . '<BR>' );
    if ( $exec == 'list' && !ereg( "(".$HTTP_SERVER_VARS['HTTP_HOST'].")((.)*(/)+)+(list.php)", $HTTP_SERVER_VARS['HTTP_HOST'] . $HTTP_SERVER_VARS['PHP_SELF'] ) ) {
        // �Խ��� ����
        $how_many  = $bbsInfor['how_many' ]; // ù ������     �ۼ�
        $more_many = $bbsInfor['more_many']; // ù ���������� �ۼ�
        $page_many = $bbsInfor['page_many']; // ������ ǥ�� ��
        $displayList = $bbsInfor['display_list']; // �޴�ǥ�� ����(����Ʈ)
        $displayView = $bbsInfor['display_view']; // ����Ʈ ���  �ǰߴޱ�

        $hide_no_s       = ""; $hide_no_e       = "";$hide_name_s     = ""; $hide_name_e     = "";
        $hide_file1_s    = ""; $hide_file1_e    = "";$hide_file2_s    = ""; $hide_file2_e    = "";
        $hide_hit_s      = ""; $hide_hit_e      = "";
        $hide_down_hit1_s= ""; $hide_down_hit1_e= "";$hide_down_hit2_s= ""; $hide_down_hit2_e= "";
        $hide_reg_date_s = ""; $hide_reg_date_e = "";$hide_search_s   = ""; $hide_search_e   = "";
        $hide_character_s= ""; $hide_character_e= "";

        /* ---------------------------------------------------------- */
        if ( !$displayList[0] ) { $hide_no_s       = "<!--"; $hide_no_e       = "-->";} // ��ȣ
        if ( !$displayList[1] ) { $hide_name_s     = "<!--"; $hide_name_e     = "-->";} // �̸�
        if ( !$displayList[2] ) { $hide_file1_s    = "<!--"; $hide_file1_e    = "-->";} // ����1
        if ( !$displayList[2] ) { $hide_file2_s    = "<!--"; $hide_file2_e    = "-->";} // ����2
        if ( !$displayList[3] ) { $hide_hit_s      = "<!--"; $hide_hit_e      = "-->";} // ��ȸ
        if ( !$displayList[4] ) { $hide_down_hit1_s= "<!--"; $hide_down_hit1_e= "-->";} // �ٿ��1
        if ( !$displayList[4] ) { $hide_down_hit2_s= "<!--"; $hide_down_hit2_e= "-->";} // �ٿ��2
        if ( !$displayList[5] ) { $hide_reg_date_s = "<!--"; $hide_reg_date_e = "-->";} // ��¥
        if ( !$displayList[6] ) { $hide_search_s   = "&nbsp;<!--"; $hide_search_e   = "-->";} // �˻�
    //  if ( !$displayList[7] ) { $hide_new_s      = "<!--"; $hide_new_e      = "-->";} // ����
    //  if ( !$displayList[8] ) { $hide_plus_s     = "<!--"; $hide_plus_e     = "-->";} // ���� �ǰ߱� + ǥ��
        if ( !$displayList[9] ) { $hide_character_s= "<!--"; $hide_character_e= "-->";} // ȸ�� ������

        $grantCharStr = $bbsInfor['grant_character_image']; // ȸ�� ������ ����
        include $skinDir ."list_header.php"  ; // ����Ʈ Header ( ����Ʈ ȭ�鿡�� ��ܿ� �ѹ��� ��µǴ� �κ� )

        // �Խ��� ����
        $s = ( !$s ) ? 1 : $s;
        if ( $s >= $how_many + 1 ) $cur_many = $more_many; else $cur_many = $how_many;

        /* �� �ڷ��        */
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

        $a_pre_list  = _prevPageTab ( $s, $tot, $how_many, $more_many, $page_many, $HTTP_SERVER_VARS['PHP_SELF']); // ���� ������
        $a_next_list = _nextPageTab ( $s, $tot, $how_many, $more_many, $page_many, $HTTP_SERVER_VARS['PHP_SELF']); // ���� ������

        include $libDir . "/list.php"; // ����Ʈ ��ȸ

        if ( $tot == 0 ) {
            if ( file_exists($skinDir ."list_0_data.php" ) ) {
                include $skinDir ."list_0_data.php"  ; // ��ȸ�� �ڷ� ����
            }
        }
        include $skinDir ."list_footer.php"  ; // ����Ʈ Footer ( ����Ʈ ȭ�鿡�� �ϴܿ� �ѹ��� ��µǴ� �κ� )

        if ( $displayList[6] ) echo ( "\n<SCRIPT LANGUAGE='javascript'>\n" . "objectSelected( document.searchForm.".$search_condition.", '". $$search_condition ."' );\n</SCRIPT>\n" );

        if ( $list_image_display_mode == '1' ) { // �ڵ� ũ�� ����
            echo ( "\n<SCRIPT LANGUAGE='javascript'>\n var list_image_display_mode= '$list_image_display_mode';\n</SCRIPT>\n" );
        }
    } else {
        MessageC ('S', '0003'); // ������ ������ �ź� �Ǿ����ϴ�.
    }
}
?>