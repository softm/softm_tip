<?
if ( function_exists('_head') ) {
    if ( $branch == 'exec' && ereg($HTTP_HOST,$HTTP_REFERER) && ereg( "(admin_poll.php)$", $HTTP_REFERER) && $REQUEST_METHOD == 'POST' ) {
        include ( 'common/file.inc'         ); // ����

        if ( $gubun == 'insert' ) {

            $poll_id = simpleSQLQuery("select MAX(no) + 1 from $tb_poll_master");
            if ( !$poll_id ) $poll_id = 1;

            if ( !escapeYN () ) { // magic_quotes_gpc Off
                $title   = addslashes($title  );
            }

            // no, title, skin_no, skin_name
            // start_dt, end_dt, title_limit, opiniony_yn
            // �Խ��� ����
            $sql  = "insert into $tb_poll_master ( no, title, skin_no, skin_name, opinion_yn, grant_character_image, reg_date, start_date, end_date ) values ";
            $sql .= "($poll_id, '".$title."', 0, 'dpoll_2_0', 'Y', '0111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111', " . getYearToSecond() . ", " . getYearToSecond() . ", " . getDateAdd (getYearToMicro(), 'DAY', 7 ) . ");";

    //      logs ( $sql . "<BR>", false) ;
            simpleSQLExecute($sql);

            // ���� ���� ����
            // ( no, member_level, grant_list, grant_view, grant_write, grant_character_image )

            $stmt = multiRowSQLQuery("select member_level from $tb_member_kind;");

            while ( $row = multiRowFetch  ($stmt) ) {
                $memberLevel = $row['member_level'];
                $sql  = "insert into $tb_poll_grant ( no, member_level, grant_poll, grant_poll_result, grant_write ) ";
                if ( $memberLevel == 0 || $memberLevel == 1 || $memberLevel == 99 ) { // [ �⺻ ȸ�� ���� ] ��ȸ��, �Ϲ�ȸ��, ������
                    $sql .= "values ($poll_id , $memberLevel, 'Y', 'Y', 'Y' );";
                } else {
                    /* ---- ��ϱ��� �б���� ������� ��۱��� �ǰ߱۱��� �ٿ���� ---- */
                    $sql .= "values ($poll_id , $memberLevel, 'Y', 'Y', 'Y' );";
                }
    //          logs ( '$sql : '. $sql . '<BR>' , true);
                simpleSQLExecute($sql);

                if ( $memberLevel > 0 ) { // ��ȸ���� �ƴϸ�.
                    // ����
                    // $pointInfor = array("","������ǥ", "�ǰ߱�");
                    for ( $i=1; $i <= 2;$i++) {
                        /* ����Ʈ ����     */
                        $sql  = "insert into $tb_poll_point_infor ( ";
                        $sql .= " no, poll_no, member_level, use_st, point, etc, reg_date";
                        $sql .= " ) values ( ";
                        $sql .= "'" . $i                . "',";
                        $sql .= "'" . $poll_id          . "',";
                        $sql .= "'" . $memberLevel      . "',";
                        $sql .= "'1'                        ,"; // ��� : 1, �̻�� : 2
                        $sql .= " 1                         ,"; // ����Ʈ
                        $sql .= "''                         ,";
                        $sql .= "'" . getYearToSecond() . "'" ;
                        $sql .= ");";
                        simpleSQLExecute($sql);
                    }
                }
            }

            // ���̺� ����
            include ( "schema.sql"               ); // ��Ű��
            if ( !isTable($tb_poll_comment. '_' .$poll_id) ) simpleSQLExecute($tb_poll_comment_schm  );  /* ���� ���� ���� �亯  */

            f_writeFile("data/html/_dpoll_header_" . $poll_id . ".php", '');
            f_writeFile("data/html/_dpoll_footer_" . $poll_id . ".php", '');

            redirectPage("admin_poll.php"); // ���� ���� (��ȸ) �̵�

        } else if ( $gubun == 'delete' ) {
    //      logs ('$chk_no ���� : ' . sizeof( $chk_no ),true);
            for ( $i=1; $i <= sizeof($chk_no)-1;$i++) {
                // ���� ���� ���̺� ����
    //          echo "<BR>" . $chk_no [$i] . "<BR>";
                $poll_id = $chk_no [$i];
                $sql  = "delete from $tb_poll_master where no = $poll_id;";
    //          logs ("1. $sql <BR>", false);
                simpleSQLExecute($sql);

                // ���� ���� �׸� ���̺� ����
                $sql  = "delete from $tb_poll_item where p_no = $poll_id;";
    //          logs ("2. $sql <BR>", false);
                simpleSQLExecute($sql);

                // ���� ���� ���� ���̺� ����
                $sql  = "delete from $tb_poll_grant where no = $poll_id;";
    //          logs ("3. $sql <BR>", false);
                simpleSQLExecute($sql);

                // ����Ʈ ���� ���̺� ����
                $sql  = "delete from $tb_poll_point_infor where poll_no = '$poll_id';";
                simpleSQLExecute($sql);

                // ���� ���� ���� �亯 ���̺� ����
                $sql  = "drop table $tb_poll_comment" . '_' . $poll_id . ";";
    //          logs ("4. $sql <BR>", false);
                if ( isTable($tb_poll_comment. '_' . $poll_id) ) simpleSQLExecute($sql);
                f_unlink("data/html/_dpoll_header_" . $poll_id . ".php");
                f_unlink("data/html/_dpoll_footer_" . $poll_id . ".php");
            }

            $params['s'                     ]  = $s     ;
            $params['tot'                   ]  = $tot   ;
            $params['sort'                  ]  = $sort  ;
            $params['desc'                  ]  = $desc  ;
            formMove('test','admin_poll.php', $params);

        } else if ( $gubun == 'update' ) {

            if ( escapeYN () ) { // magic_quotes_gpc Off
                $header = stripslashes($header);
                $footer = stripslashes($footer);
            }

            f_writeFile("data/html/_dpoll_header_" . $poll_id . ".php", $header);
            f_writeFile("data/html/_dpoll_footer_" . $poll_id . ".php", $footer);

            $start_date = $start_date . $start_year . $start_month . $start_day . $start_hour . $start_min . $start_sec;
            $end_date   = $end_date   . $end_year   . $end_month   . $end_day   . $end_hour   . $end_min   . $end_sec  ;
            $opinion_yn = ( !$opinion_yn ) ? "N" : $opinion_yn;

            if ( !$use_top ) { $use_top = 'N'; }
            if ( !escapeYN () ) { // magic_quotes_gpc Off
                $title   = addslashes($title  );
    //          $header  = addslashes($header );
    //          $footer  = addslashes($footer );
            }

            // ���� ���� ����
            $sql  = "update $tb_poll_master set ";
            $sql .= " title        = '" . $title . "' ,";
    //      $sql .= " skin_no      =  $skin_no    ,";
            $sql .= " skin_name    = '$skin_name' ,";
            $sql .= " start_date   = '$start_date',";
            $sql .= " end_date     = '$end_date'  ,";
            $sql .= " title_limit  =  $title_limit,";
            $sql .= " display_mode =  $display_mode,";
            $sql .= " opinion_yn   = '$opinion_yn',";
    //      $sql .= " header       = '" . $header . "',";
    //      $sql .= " footer       = '" . $footer . "',";
            $sql .= " use_top      = '$use_top'     ,";
            $sql .= " poll_process = '$poll_process',";
            $sql .= " suc_url      = '$suc_url'     ,";
            $sql .= " base_path    = '$base_path' ,";
            $sql .= " reg_date     = '" . getYearToSecond() . "' ";
            $sql .= " where no = $poll_id;";
            logs ("$sql <BR>", false);
            simpleSQLExecute($sql);

            // ���� �׸� �Է� / ����
            $itemCd = '';
            for ( $i=1; $i<=10; $i++ ) {
                if ( $i < 10 ) { $itemCd = '0'. $i; } else { $itemCd = $i; }
                $sql = "select count(no) from $tb_poll_item where no = $i and p_no = $poll_id;";
    //          logs ('$sql : ' . "$sql <BR>", false);

                $existChk = simpleSQLQuery($sql);
    //          $item = str_replace("'", "\'", "$item");
                $item = $HTTP_POST_VARS["poll_item_$itemCd"];
                if ( !escapeYN () ) { // magic_quotes_gpc Off
                    $item = addslashes($item);
                }

    //          logs ( $item . '<BR>', false );
                if ( $existChk ) {
                    if ( $item ) {
                        $sql  = "update $tb_poll_item set";
        //              $sql .= " no    = '$no'   ,";
        //              $sql .= " p_no  = '$p_no' ,";
                        $sql .= " item  = '$item'  ";
        //              $sql .= " hit   = '$hit'   ";
                        $sql .= " where no = $i ";
                        $sql .= " and p_no = $poll_id;";
                        logs ("$sql <BR>", false);
                        simpleSQLExecute($sql);
                    } else {
                        $sql  = "delete from $tb_poll_item ";
                        $sql .= " where no = $i ";
                        $sql .= " and p_no = $poll_id;";
                        logs ("$sql <BR>", false);
                        simpleSQLExecute($sql);
                    }
                } else {
                    if ( $item ) {
                        $sql  = "insert into $tb_poll_item ( no, p_no, item, hit ) values ";
                        $sql .= "( $i, $poll_id, '$item', 0 );";
                        logs ("$sql <BR>", false);
                        simpleSQLExecute($sql);
                    }
                }
            }
            $params['poll_id'    ] = $poll_id;
            $params['branch'] = 'itemsetup'  ;
            $params['s'                     ]  = $s     ;
            $params['tot'                   ]  = $tot   ;
            $params['sort'                  ]  = $sort  ;
            $params['desc'                  ]  = $desc  ;
            formMove('test','admin_poll.php', $params);

    //      redirectPage("admin_poll.php"); // ���� ���� ���� (��ȸ) �̵�
        } else if ( $gubun == 'resultsetup' ) {
    //      echo '������ ���� ź��.' ;
            $sql  = "update $tb_poll_master set ";
            $sql .= " header = '" . addslashes($header) . "',";
            $sql .= " footer = '" . addslashes($footer) . "' ";
            $sql .= " where no = $poll_id;";
    //      logs ("$sql <BR>", false);
            simpleSQLExecute($sql);
            redirectPage("admin_poll.php"); // ���� ���� ���� (��ȸ) �̵�
        } else if ( $gubun == 'grant_update' ) {
            $poll_data = singleRowSQLQuery("select title, grant_character_image from $tb_poll_master where no = '$poll_id';");
            $grantCharStr   = $poll_data['grant_character_image'];

            for ( $i=1; $i <= sizeof($update_yn)-1;$i++) {
                if ( $update_yn[$i] == 'Y' ) {
                    $key    = explode ( '$', $grant[$i] );
                    $poll_grant             = $key[0];
                    $poll_result_grant      = $key[1];
                    $write_grant            = $key[2];
                    $character_image_grant  = $key[3];

                    $sql  = "update $tb_poll_grant set";
                    $sql .= " grant_poll            = '" . $poll_grant              . "',";
                    $sql .= " grant_poll_result     = '" . $poll_result_grant       . "',";
                    $sql .= " grant_write           = '" . $write_grant             . "' ";
                    $sql .= " where no = '$poll_id'";
                    $sql .= " and member_level = '" . $member_level [$i] . "';";
                    simpleSQLExecute($sql);
                    $grantCharStr[$member_level [$i]] = $character_image_grant;
                }
            }

            $sql  = "update $tb_poll_master set ";
            $sql .= " grant_character_image         = '$grantCharStr' ";
            $sql .= " where no = '$poll_id';";
            simpleSQLExecute($sql);

            $params['poll_id'] = $poll_id;
            $params['branch' ] = 'grant' ;
            $params['s'                     ]  = $s     ;
            $params['tot'                   ]  = $tot   ;
            $params['sort'                  ]  = $sort  ;
            $params['desc'                  ]  = $desc  ;
            formMove('test','admin_poll.php', $params);
        } else { // Parameter ������ ���
            redirectPage("admin_poll.php"); // ���� ���� ���� (��ȸ) �̵�
        }
    }
}
?>