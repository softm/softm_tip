<?
if ( function_exists('_head') ) {
    if ( $branch == 'exec' && ereg($HTTP_HOST,$HTTP_REFERER) && ereg( "(admin_event.php)", $HTTP_REFERER) && $REQUEST_METHOD == 'POST' ) {

        include ( 'common/file.inc'         ); // 파일

        if ( $gubun == 'insert' ) {

            $newNo = simpleSQLQuery("select MAX(no) + 1 from $tb_event");
            if ( !$newNo ) $newNo = 1;
            $sql .= " = '$login_skin_name',";
            // 이벤트 정보
            $sql  = "insert into $tb_event ( no, title, login_skin_name, display_mode, start_date, end_date, window_width, window_height, left_pos, top_pos, scroll_yn, use_top, reg_date ) values ";
            $sql .= "($newNo, '$title', 'dlogin_standard', '1', '" . getYearToSecond() . "','" . getYearToSecond() . "', 800, 600, 0, 0, 'Y', 'Y','". getYearToSecond() ."');";
            simpleSQLExecute($sql);
    //      logs ( '$sql : '. $sql . '<BR>' , true);

            // 이벤트 권한 정보
            // ( no, member_level, grant_list, grant_view, grant_write )
            $stmt = multiRowSQLQuery("select member_level from $tb_member_kind;");

            while ( $row = multiRowFetch  ($stmt) ) {
                $memberLevel = $row['member_level'];
                if ( $memberLevel != 0 ) { // 비회원이 아니면
                    $sql  = "insert into $tb_event_grant ( no, member_level, grant_join, join_point ) ";
                    $sql .= "values ($newNo , $memberLevel, 'Y', '1');";
    //              logs ( '$sql : '. $sql . '<BR>' , true);
                    simpleSQLExecute($sql);
                }
            }

            $filePath = "data/event/" . $newNo;
            if ( !@is_dir( $filePath ) ) {
                @mkdir($filePath,0707);
                @chmod($filePath,0707);
            }

            f_writeFile ("data/event/$newNo/_dboard_event.php", '');

            redirectPage("admin_event.php"); // 이벤트 관리 (조회) 이동

        } else if ( $gubun == 'delete' ) {
    //      logs ('$chk_no 길이 : ' . sizeof( $chk_no ));
            for ( $i=1; $i <= sizeof($chk_no)-1;$i++) {
                $event_id = $chk_no [$i];

                // 이벤트 권한 테이블 삭제
                $sql  = "delete from $tb_event_grant where no = '$event_id';";
                simpleSQLExecute($sql);

                // 이벤트 정보 테이블 삭제
                $sql  = "delete from $tb_event where no = '$event_id';";
                simpleSQLExecute($sql);

                // 이벤트 권한 테이블 삭제
                $sql  = "delete from $tb_event_item where no = '$event_id';";
                simpleSQLExecute($sql);

                f_unlink("data/event/$event_id/_dboard_event.php");

                $sql  = "delete from $tb_event_result_master where no = '$event_id';";
                simpleSQLExecute($sql);

                $sql  = "delete from $tb_event_result_detail where no = '$event_id';";
                simpleSQLExecute($sql);

                if ( $event_id ) {
                    $filePath = "data/event/" . $event_id;
                    if ( @is_dir ($filePath) ) {
                        f_rmDir($filePath);
                    }
                }
                $tot--;
            }

            $params['branch']  = 'list'              ;    // form parameter 생성

            if ( $tot < $s ) {
                $how_many = $HTTP_COOKIE_VARS["event_list_many"]; // 쿠키 읽어 오기
                $s = $s - $how_many;
                if ( $s < 1 ) { $s = 1; }
            }

            $params['s'                     ]  = $s                  ;
            $params['tot'                   ]  = $tot                ;
            $params['sort'                  ]  = $sort               ;
            $params['desc'                  ]  = $desc               ;
            formMove    ('moveForm','admin_event.php', $params);

        } else if ( $gubun == 'update' ) {

            $start_date = $start_date . $start_year . $start_month . $start_day . $start_hour . $start_min . $start_sec;
            $end_date   = $end_date   . $end_year   . $end_month   . $end_day   . $end_hour   . $end_min   . $end_sec  ;
            if ( !$scroll_yn ) { $scroll_yn = 'N'; }
            if ( !$use_default_login ) $use_default_login   = 'N';

            // 이벤트 정보 테이블 삭제
            $sql  = "update $tb_event set ";
            $sql .= " title          = '$title'        ,";
            $sql .= " use_default_login = '$use_default_login',";
            if ( $login_skin_name ) {
                $sql .= " login_skin_name   = '$login_skin_name' ,";
            }
            $sql .= " display_mode   = '$display_mode' ,";
            $sql .= " title_limit    = '$title_limit'  ,";
            $sql .= " suc_url        = '$suc_url'      ,";
            $sql .= " use_top        = '$use_top'      ,";
            $sql .= " start_date     = '$start_date'   ,";
            $sql .= " end_date       = '$end_date'     ,";
            $sql .= " window_width   = '$window_width' ,";
            $sql .= " window_height  = '$window_height',";
            $sql .= " left_pos       = '$left_pos'     ,";
            $sql .= " top_pos        = '$top_pos'      ,";
            $sql .= " scroll_yn      = '$scroll_yn'    ,";
            $sql .= " base_path      = '$base_path'     ";

            if ( escapeYN () ) { // magic_quotes_gpc Off
                $header = stripslashes($header);
            }
            $sql .= " where no = $event_id;";
    //      logs ("1. $sql <BR>", true);
            simpleSQLExecute($sql);

            $filePath = "data/event/" . $event_id;
            if ( !@is_dir( $filePath ) ) {
                @mkdir($filePath,0707);
                @chmod($filePath,0707);
            }
            f_writeFile ("data/event/$event_id/_dboard_event.php", $header);

            $params['event_id'    ] = $event_id    ;
            $params['branch'] = 'setup';
            $params['s'                     ]  = $s                  ;
            $params['tot'                   ]  = $tot                ;
            $params['sort'                  ]  = $sort               ;
            $params['desc'                  ]  = $desc               ;
            formMove    ('moveForm','admin_event.php', $params);

        } else if ( $gubun == 'result_write' ) {
            for ( $i=1; $i <= sizeof($g_no)-1;$i++) {
                    $sql  = "update $tb_event_result_detail set ";
                    if ( !escapeYN () ) { // magic_quotes_gpc Off
                        $sql .= " choice_data       = '" . addslashes($choice_data [$i]) . "'";
                    } else {
                        $sql .= " choice_data       = '" .            $choice_data [$i]  . "'";
                    }
                    $sql .= " where no      = '" . $event_id     . "'";
                    $sql .= " and   user_id = '" . $user_id      . "'";
                    $sql .= " and   g_no    = '" . $g_no    [$i] . "'";
                    $sql .= " and   key_seq = '" . $key_seq [$i] . "'";
    //              echo $sql;
                    simpleSQLExecute($sql);
            }

            $pre_prize_point = simpleSQLQuery("select prize_point from $tb_event_result_master where no = '$event_id' and user_id = '$user_id';");

            if ( $prize_yn == 'Y' ) {
                    $set_prize_point = $prize_point - $pre_prize_point;
                    $sign = '+';
                    if ( $set_prize_point < 0 ) {
                        $sign = '-';
                        $set_prize_point = abs( $set_prize_point );
                    }

                    if ( $set_prize_point >= 0 ) {
                        $sql = "update $tb_member set point = point $sign $set_prize_point where user_id = '$user_id';";
                        simpleSQLExecute($sql);
                        $sql = "update $tb_event_result_master set prize_yn = 'Y', prize_point = prize_point $sign $set_prize_point where no = '$event_id' and user_id = '$user_id';";
                        simpleSQLExecute($sql);
                    }
            } else {

                $set_prize_point = abs($pre_prize_point - $prize_point);

                $sql = "update $tb_member set point = point - $pre_prize_point where user_id = '$user_id';";
                simpleSQLExecute($sql);
                echo $sql;
                $sql = "update $tb_event_result_master set prize_yn = 'N', prize_point = 0 where no = '$event_id' and user_id = '$user_id';";
                simpleSQLExecute($sql);
                echo $sql;
            }
            $params['event_id'    ] = $event_id    ;
            $params['user_id'     ] = $user_id    ;
            $params['branch'] = 'result_write';
            formMove('test','admin_event.php', $params);// 게시물 추출 화면으로 이동
        } else if ( $gubun == 'result_delete' ) {
            $inUser = "";
            for ( $i=1; $i <= sizeof($chk_no)-1;$i++) {
                $inUser .= " '$chk_no[$i]'";
                if ( $i < sizeof($chk_no) - 1 ) { $inUser .= " ,"; }
            }
            $sql  = "delete from $tb_event_result_master where no = '$event_id' and user_id in ( $inUser );";
            simpleSQLExecute($sql);

            $sql  = "delete from $tb_event_result_detail where no = '$event_id' and user_id in ( $inUser );";
            simpleSQLExecute($sql);

            $params['event_id'    ] = $event_id    ;
            $params['branch'] = 'result';
            formMove('test','admin_event.php', $params);// 게시물 추출 화면으로 이동
        }
        else { // Parameter 조작의 경우
            redirectPage("admin_event.php"); // 이벤트 관리 (조회) 이동
        }
    }
}
?>