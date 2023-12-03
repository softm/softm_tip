<?
if ( function_exists('_head') ) {
    if ( $branch == 'exec' && !ereg( "(".$HTTP_SERVER_VARS['HTTP_HOST'].")((.)*(/)+)+(admin_board_exec.php)", $HTTP_SERVER_VARS['HTTP_HOST'] . $HTTP_SERVER_VARS['PHP_SELF'] ) && $REQUEST_METHOD == 'POST' ) {

        include 'common/file.inc'         ; // 파일
        include 'common/message_table.inc'; // 메시지

        if ( $gubun == 'insert' ) {

            $idCheck = simpleSQLQuery("select COUNT(no) from $tb_bbs_infor where bbs_id = '$bbs_id'");
            if ( $idCheck ) {
                Message('P', '0004');
            }
            $newNo = simpleSQLQuery("select MAX(no) + 1 from $tb_bbs_infor");
            if ( !$newNo ) $newNo = 1;
            // no, bbs_id, skin_no, skin_name, reg_date
            // no, bbs_id, skin_no, skin_name, table_width_unit, table_width,
            // how_many, more_many, page_many, title_limit, max_capacity, display_list,
            // display_write, display_view, header, footer, reg_date, upd_date,

            // 게시판 정보
            $sql  = "insert into $tb_bbs_infor ( no, bbs_id, skin_no, skin_name, grant_character_image, reg_date ) values ";
            $sql .= "($newNo, '$bbs_id', 0, 'dboard_2_0', '0111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111', '" . getYearToSecond() . "');";
            simpleSQLExecute($sql);

            /* 게시물 추출 정보     */
            $sql  = "insert into $tb_bbs_abstract ( no, bbs_id, skin_no, skin_name, reg_date ) values ";
            $sql .= "($newNo, '$bbs_id', 0, 'dnotice_list_2_0', " . getYearToSecond() . ");";
            simpleSQLExecute($sql);

            // 게시판 권한 정보
            // ( no, member_level, grant_list, grant_view, grant_write )

            $stmt = multiRowSQLQuery("select member_level from $tb_member_kind;");

            while ( $row = multiRowFetch  ($stmt) ) {
                $memberLevel = $row['member_level'];
                $sql  = "insert into $tb_bbs_grant ( no, bbs_id, member_level, grant_list, grant_view, grant_write, grant_answer, grant_comment, grant_down ) ";
                if ( $memberLevel == 0 || $memberLevel == 1 || $memberLevel == 99 ) { // [ 기본 회원 종류 ] 비회원, 일반회원, 관리자
                    $sql .= "values ($newNo , '$bbs_id', $memberLevel, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y');";
                } else {
                    /* ---- 목록권한 읽기권한 쓰기권한 답글권한 의견글권한 다운권한 ---- */
                    $sql .= "values ($newNo , '$bbs_id', $memberLevel, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y');";
                }
    //          logs ( '$sql : '. $sql . '<BR>' , true);
                simpleSQLExecute($sql);

                if ( $memberLevel > 0 ) { // 비회원이 아니면.
                    // 참고
                    // $pointInfor = array("","게시물 작성", "의견글 작성", "파일 업로드", "다운로드", "답글작성");
                    for ( $i=1; $i <= 5;$i++) {
                        /* 포인트 정보     */
                        $sql  = "insert into $tb_point_infor ( ";
                        $sql .= " no, bbs_id, member_level, use_st, point, etc, reg_date";
                        $sql .= " ) values ( ";
                        $sql .= "'" . $i                . "',";
                        $sql .= "'" . $bbs_id           . "',";
                        $sql .= "'" . $memberLevel      . "',";
                        $sql .= "'1'                        ,"; // 사용 : 1, 미사용 : 2
                        $sql .= " 1                         ,"; // 포인트
                        $sql .= "''                         ,";
                        $sql .= "'" . getYearToSecond() . "'" ;
                        $sql .= ");";
                        simpleSQLExecute($sql);
                    }
                }
            }

            // 테이블 생성
            include ( "schema.sql"               ); // 스키마
            if ( !isTable($tb_bbs_data   . '_' .$bbs_id) ) { /* 게시판 */
                simpleSQLExecute($tb_bbs_data_schm);
                // 인덱스 생성
    /*
                simpleSQLExecute($tb_bbs_data_idx0);
                simpleSQLExecute($tb_bbs_data_idx1);
                simpleSQLExecute($tb_bbs_data_idx2);
                simpleSQLExecute($tb_bbs_data_idx3);
                simpleSQLExecute($tb_bbs_data_idx4);
                simpleSQLExecute($tb_bbs_data_idx5);
                simpleSQLExecute($tb_bbs_data_idx6);
                simpleSQLExecute($tb_bbs_data_idx7);
    */
            }
            if ( !isTable($tb_bbs_comment . '_' .$bbs_id) ) simpleSQLExecute($tb_bbs_comment_schm   );  /* 게시판 간단 답변     */
            if ( !isTable($tb_bbs_category. '_' .$bbs_id) ) simpleSQLExecute($tb_bbs_category_schm  );  /* 카테고리 정보        */

            f_writeFile ("data/html/_dboard_header_"  . $bbs_id . ".php", '');
            f_writeFile ("data/html/_dboard_footer_"  . $bbs_id . ".php", '');
            f_writeFile ("data/html/_dnotice_header_" . $bbs_id . ".php", '');
            f_writeFile ("data/html/_dnotice_footer_" . $bbs_id . ".php", '');

            $filePath = "data/file/" . $bbs_id;
            if ( !@is_dir( $filePath ) ) {
                @mkdir($filePath,0707);
                @chmod($filePath,0707);
            }

            $filesData  = "<?\n";
            $filesData .= '$baseDir = "../";' . "\n";
            $filesData .= '$id = \'' . $bbs_id . '\';' . "\n";
            $filesData .= 'include $baseDir . "dboard.php";' . "\n";
            $filesData .= "?>";
            $fp = @fopen ( 'files/' . $bbs_id . '.php', 'w');
            fwrite ( $fp, $filesData,strlen($filesData) );

            redirectPage("admin_board.php"); // 게시판 관리 (조회) 이동

        } else if ( $gubun == 'delete' ) {
    //      logs ('$chk_no 길이 : ' . sizeof( $chk_no ));
            for ( $i=1; $i <= sizeof($chk_no)-1;$i++) {
                $key    = explode ( '$$', $chk_no [$i] );
                $no     = $key[0];
                $bbs_id = $key[1];
                // 게시판 정보 테이블 삭제
                $sql  = "delete from $tb_bbs_infor where no = $no and bbs_id = '$bbs_id';";
                simpleSQLExecute($sql);

                // 게시물 추출 정보 테이블 삭제
                $sql  = "delete from $tb_bbs_abstract where no = $no and bbs_id = '$bbs_id';";
                simpleSQLExecute($sql);

    //          logs ("1. $sql <BR>" , true);
                // 게시판 권한 테이블 삭제
                $sql  = "delete from $tb_bbs_grant where no = $no;";
                simpleSQLExecute($sql);

    //          logs ("2. $sql <BR>" , true);
                // 게시판 자료 테이블 삭제
                $sql  = "drop table $tb_bbs_data"    . '_' . $bbs_id . ";";
                if ( isTable($tb_bbs_data   . '_' .$bbs_id) ) simpleSQLExecute($sql);
    //          logs ("3. $sql <BR>" , true);
                // 게시판 간단 답변 테이블 삭제
                $sql  = "drop table $tb_bbs_comment" . '_' . $bbs_id . ";";
                if ( isTable($tb_bbs_comment. '_' .$bbs_id) ) simpleSQLExecute($sql);

                // 카테고리 테이블 삭제
                $sql  = "drop table $tb_bbs_category"    . '_' . $bbs_id . ";";
                if ( isTable($tb_bbs_category   . '_' .$bbs_id) ) simpleSQLExecute($sql);

                // 포인트 정보 테이블 삭제
                $sql  = "delete from $tb_point_infor where bbs_id = '$bbs_id';";
                simpleSQLExecute($sql);

    //          logs ("4. $sql <BR>" , true);
                f_unlink("data/html/_dboard_header_"  . $bbs_id . ".php");
                f_unlink("data/html/_dboard_footer_"  . $bbs_id . ".php");
                f_unlink("data/html/_dnotice_header_" . $bbs_id . ".php");
                f_unlink("data/html/_dnotice_footer_" . $bbs_id . ".php");
                f_unlink("files/" . $bbs_id . ".php");

                if ( $bbs_id ) {
                    $filePath = "data/file/" . $bbs_id;
                    if ( @is_dir ($filePath) ) {
                        f_rmDir($filePath);
                    }
                }
                $tot--;
            }

            $params['branch']  = 'list'              ;    // form parameter 생성

            if ( $tot < $s ) {
                $how_many = $HTTP_COOKIE_VARS["board_many"]; // 쿠키 읽어 오기
                $s = $s - $how_many;
                if ( $s < 1 ) { $s = 1; }
            }

            $params['s'                     ]  = $s                  ;
            $params['tot'                   ]  = $tot                ;
            $params['sort'                  ]  = $sort               ;
            $params['desc'                  ]  = $desc               ;
            formMove    ('moveForm','admin_board.php', $params);

        } else if ( $gubun == 'update' ) {
            if ( !$use_category      ) $use_category        = 'N';
            if ( !$use_default_login ) $use_default_login   = 'N';
            // 게시판 정보 테이블 삭제
            $sql  = "update $tb_bbs_infor set ";
            $sql .= " skin_name         = '$skin_name'       ,";
            $sql .= " design_method     = '$design_method',";
            $sql .= " use_default_login = '$use_default_login',";
            if ( $login_skin_name ) {
                $sql .= " login_skin_name   = '$login_skin_name' ,";
            }
            $sql .= " use_category      = '$use_category'    ,";
            $sql .= " table_width       =  $table_width      ,";
            $sql .= " table_width_unit  = '$table_width_unit',";
            $sql .= " how_many          =  $how_many         ,";
            $sql .= " more_many         =  $more_many        ,";
            $sql .= " page_many         =  $page_many        ,";
            $sql .= " title_limit       =  $title_limit      ,";
            $sql .= " max_capacity      =  $max_capacity     ,";
            $sql .= " mail_send_method  =  $mail_send_method ,";
            $sql .= " display_list      = '$display_list'    ,";
            $sql .= " display_write     = '$display_write'   ,";
            $sql .= " display_view      = '$display_view'    ,";

    /*
            if ( !escapeYN () ) { // magic_quotes_gpc Off
                $header = addslashes($header);
                $footer = addslashes($footer);
            }
            $sql .= " header            = '". $header    . "',";
            $sql .= " footer            = '". $footer    . "',";
    */
            if ( escapeYN () ) { // magic_quotes_gpc Off
                $header = stripslashes($header);
                $footer = stripslashes($footer);
                $include_php = stripslashes($include_php);
            } else {
                $operator_id = addslashes($operator_id);
            }

            $sql .= " base_path         = '". $base_path    . "',";
            $sql .= " operator_id       = '". $operator_id  . "',";
            $sql .= " upd_date          = '" . getYearToSecond() . "' ";
            $sql .= " where no = $no;";
    //      logs ("1. $sql <BR>", true);
            simpleSQLExecute($sql);

            f_writeFile("data/html/_dboard_header_" . $bbs_id . ".php", $header);
            f_writeFile("data/html/_dboard_footer_" . $bbs_id . ".php", $footer);
            f_writeFile("files/" . $bbs_id . ".php", $include_php);

    //      redirectPage("admin_board.php?no=$no&branch=setup"); // 게시판 관리 (조회) 이동

            $params['no'    ] = $no    ;
            $params['branch'] = 'setup';
            $params['s'                     ]  = $s     ;
            $params['tot'                   ]  = $tot   ;
            $params['sort'                  ]  = $sort  ;
            $params['desc'                  ]  = $desc  ;
            formMove('test','admin_board.php', $params);

        } else if ( $gubun == 'copy_prop' ) {
            $where = '';
            $updateCnt=0;

            for ( $i=1; $i <= sizeof($chk_no)-1;$i++) {
                $key    = explode ( '$$', $chk_no [$i] );
                $no     = $key[0];
                $bbs_id = $key[1];
                if ( $_dboard_s_id != $bbs_id ) {
                    if ( $updateCnt == 0 ) {
                        $where .= " bbs_id = '" . $bbs_id ."'";
                    } else {
                        $where .= " or bbs_id = '" . $bbs_id ."'";
                    }

                    if ( $detail_pro == '1' || $detail_pro == '2' ) { // 세부설정
                        simpleSQLExecute("delete from $tb_bbs_category" . '_' . $bbs_id);
                        simpleSQLExecute("insert into $tb_bbs_category" . '_' . $bbs_id . " select * from $tb_bbs_category" . '_' . $_dboard_s_id);
                    }

                    if ( $detail_pro == '1' || $detail_pro == '3' ) { // 상/하단 파일
                        @copy ( "data/html/_dboard_header_"  . $_dboard_s_id . ".php", "data/html/_dboard_header_"  . $bbs_id . ".php");
                        @copy ( "data/html/_dboard_footer_"  . $_dboard_s_id . ".php", "data/html/_dboard_footer_"  . $bbs_id . ".php");
                    }

                    if ( $detail_pro == '1' || $detail_pro == '4' ) { // 권한설정
                        $stmt_kind = multiRowSQLQuery("select member_level from $tb_member_kind;");
                        while ( $row_kind = multiRowFetch  ($stmt_kind) ) {
                            $memberLevel = $row_kind['member_level'];
                            if ( $memberLevel > 0 ) { // 비회원이 아니면.
                                // 참고
                                // $pointInfor = array("","게시물 작성", "의견글 작성", "파일 업로드", "다운로드", "답글작성");
                                for ( $j=1; $j <= 5;$j++) {
                                    $chkSql  = "select count(no) from $tb_point_infor ";
                                    $chkSql .= " where  no           = '" . $j             . "'";
                                    $chkSql .= " and    bbs_id       = '" . $bbs_id        . "'";
                                    $chkSql .= " and    member_level = '" . $memberLevel   . "'";
                                    $existChk = simpleSQLQuery($chkSql);
                                    if ( !$existChk ) {
                                        /* 포인트 정보     */
                                        $sql  = "insert into $tb_point_infor ( ";
                                        $sql .= " no, bbs_id, member_level, use_st, point, etc, reg_date ) ";
                                        $sql .= " select no, '" . $bbs_id . "', member_level, use_st, point, etc, '" . getYearToSecond() . "'";
                                        $sql .= " from $tb_point_infor ";
                                        $sql .= " where  no           = '" . $j             . "'";
                                        $sql .= " and    bbs_id       = '" . $_dboard_s_id  . "'";
                                        $sql .= " and    member_level = '" . $memberLevel   . "'";
                                        simpleSQLExecute($sql);
                                    } else {
                                        $sql  = " select use_st, point, etc";
                                        $sql .= " from $tb_point_infor ";
                                        $sql .= " where  no           = '" . $j             . "'";
                                        $sql .= " and    bbs_id       = '" . $_dboard_s_id  . "'";
                                        $sql .= " and    member_level = '" . $memberLevel   . "'";
                                        $row_point = singleRowSQLQuery($sql);

                                        $sql  = "update $tb_point_infor set ";
                                        $sql .= "use_st = '" . $row_point[use_st] . "',";
                                        $sql .= "point  = '" . $row_point[point ] . "',";
                                        $sql .= "etc    = '" . $row_point[etc   ] . "' ";
                                        $sql .= " where  no           = '" . $j             . "'";
                                        $sql .= " and    bbs_id       = '" . $bbs_id        . "'";
                                        $sql .= " and    member_level = '" . $memberLevel   . "'";
                                        simpleSQLExecute($sql);
                                    }
                                }
                            }
                        }
                    }

                    $updateCnt++;
                }
            }

            if ( $detail_pro == '1' || $detail_pro == '4' ) { // 권한설정
                $stmt = multiRowSQLQuery("select * from $tb_bbs_grant where bbs_id = '$_dboard_s_id'");
                while ( $row = multiRowFetch  ($stmt) ) {
                    $member_level          = $row['member_level'         ];
                    $list_grant            = $row['grant_list'           ];
                    $view_grant            = $row['grant_view'           ];
                    $write_grant           = $row['grant_write'          ];
                    $answer_grant          = $row['grant_answer'         ];
                    $comment_grant         = $row['grant_comment'        ];
                    $down_grant            = $row['grant_down'           ];

                    $sql  = "update $tb_bbs_grant set";
                    $sql .= " grant_list    = '" . $list_grant    . "',";
                    $sql .= " grant_view    = '" . $view_grant    . "',";
                    $sql .= " grant_write   = '" . $write_grant   . "',";
                    $sql .= " grant_answer  = '" . $answer_grant  . "',";
                    $sql .= " grant_comment = '" . $comment_grant . "',";
                    $sql .= " grant_down    = '" . $down_grant    . "' ";
                    $sql .= 'where (' . $where . " ) and member_level = '$member_level';";
                    simpleSQLExecute($sql);
                }
            }

            if ( $detail_pro == '1' || $detail_pro == '2' ) { // 세부설정
                $row = singleRowSQLQuery("select * from $tb_bbs_infor where bbs_id = '$_dboard_s_id'");
                $skin_name          = $row['skin_name'       ];
                $use_category       = $row['use_category'    ];
                $table_width        = $row['table_width'     ];
                $table_width_unit   = $row['table_width_unit'];
                $how_many           = $row['how_many'        ];
                $more_many          = $row['more_many'       ];
                $page_many          = $row['page_many'       ];
                $title_limit        = $row['title_limit'     ];
                $max_capacity       = $row['max_capacity'    ];
                $mail_send_method   = $row['mail_send_method'];
                $display_list       = $row['display_list'    ];
                $display_write      = $row['display_write'   ];
                $display_view       = $row['display_view'    ];
                $grant_character_image = $row['grant_character_image'    ];

                $header             = $row['header'          ];
                $footer             = $row['footer'          ];
                $base_path          = $row['base_path'       ];
                $operator_id        = $row['operator_id'     ];

                // 게시판 정보 테이블 삭제
                $sql  = "update $tb_bbs_infor set ";
                $sql .= " skin_name         = '$skin_name'       ,";
                $sql .= " use_category      = '$use_category'    ,";
                $sql .= " table_width       =  $table_width      ,";
                $sql .= " table_width_unit  = '$table_width_unit',";
                $sql .= " how_many          =  $how_many         ,";
                $sql .= " more_many         =  $more_many        ,";
                $sql .= " page_many         =  $page_many        ,";
                $sql .= " title_limit       =  $title_limit      ,";
                $sql .= " max_capacity      =  $max_capacity     ,";
                $sql .= " mail_send_method  =  $mail_send_method ,";
                $sql .= " display_list      = '$display_list'    ,";
                $sql .= " display_write     = '$display_write'   ,";
                $sql .= " display_view      = '$display_view'    ,";
                $operator_id = addslashes($operator_id);
                $sql .= " base_path         = '". $base_path    . "',";
                $sql .= " operator_id       = '". $operator_id  . "',";
                $sql .= " grant_character_image = '". $grant_character_image  . "',";
                $sql .= " upd_date          = " . getYearToSecond() . " ";

                $sql .= 'where (' . $where . " );";
                simpleSQLExecute($sql);
            }
            $params['s'                     ]  = $s     ;
            $params['tot'                   ]  = $tot   ;
            $params['sort'                  ]  = $sort  ;
            $params['desc'                  ]  = $desc  ;
            formMove('test','admin_board.php', $params);
        }
        else if ( $gubun == 'operator_update' ) {
              // 게시판 정보 테이블 삭제
            $sql  = "update $tb_bbs_infor set ";

            if ( !escapeYN () ) { // magic_quotes_gpc Off
                $operator_id = addslashes($operator_id);
            }

            $sql .= " operator_id       = '". $operator_id  . "',";
            $sql .= " upd_date          = " . getYearToSecond() . " ";
            $sql .= " where no = $no;";
            simpleSQLExecute($sql);
            $params['no'    ] = $no         ;
            $params['branch'] = 'setup'     ;
            $params['s'                     ]  = $s     ;
            $params['tot'                   ]  = $tot   ;
            $params['sort'                  ]  = $sort  ;
            $params['desc'                  ]  = $desc  ;
            formMove('test','admin_board.php', $params);
        }
        else if ( $gubun == 'abstract' ) {
            if ( !$use_category ) $use_category = 'N';

            // 게시판 정보 테이블 삭제
            $sql  = "update $tb_bbs_abstract set ";
            $sql .= " cat_no        = '$cat_no'       ,";
            $sql .= " use_category  = '$use_category' ,";
            $sql .= " skin_name     = '$skin_name'    ,";
            $sql .= " start_pos     =  $start_pos     ,";
            $sql .= " end_pos       =  $end_pos       ,";
            $sql .= " content_limit =  $content_limit ,";
            $sql .= " title_limit   =  $title_limit   ,";
            $sql .= " display_list  = '$display_list' ,";
            $sql .= " display_mode  = '$display_mode' ,";
            $sql .= " base_path     = '$base_path'     ";
    /*
            if ( !escapeYN () ) { // magic_quotes_gpc Off
                $header = addslashes($header);
                $footer = addslashes($footer);
            }
            $sql .= " header            = '". $header . "',";
            $sql .= " footer            = '". $footer . "' ";
    */
            if ( escapeYN () ) { // magic_quotes_gpc Off
                $header = stripslashes($header);
                $footer = stripslashes($footer);
            }

            $sql .= " where no = $no;";
            f_writeFile("data/html/_dnotice_header_" . $bbs_id . ".php", $header);
            f_writeFile("data/html/_dnotice_footer_" . $bbs_id . ".php", $footer);
            // logs ("1. $sql <BR>", true);
            simpleSQLExecute($sql);
            $params['no'    ] = $no       ;
            $params['branch'] = 'abstract';
            $params['s'                     ]  = $s     ;
            $params['tot'                   ]  = $tot   ;
            $params['sort'                  ]  = $sort  ;
            $params['desc'                  ]  = $desc  ;
            formMove('test','admin_board.php', $params);

        } else if ( $gubun == 'grant_update' ) {
            $bbs_data = singleRowSQLQuery("select bbs_id, grant_character_image from $tb_bbs_infor where no = '$no';");
            $grantCharStr   = $bbs_data['grant_character_image'];
    //      $grantCharStr = '0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000001';

            for ( $i=1; $i <= sizeof($update_yn)-1;$i++) {
                $key    = explode ( '$', $grant[$i] );
                if ( $update_yn[$i] == 'Y' ) {

                    $list_grant             = $key[0];
                    $view_grant             = $key[1];
                    $write_grant            = $key[2];
                    $answer_grant           = $key[3];
                    $comment_grant          = $key[4];
                    $down_grant             = $key[5];
                    $character_image_grant  = $key[6];

                    $sql  = "update $tb_bbs_grant set";
                    $sql .= " grant_list            = '" . $list_grant              . "',";
                    $sql .= " grant_view            = '" . $view_grant              . "',";
                    $sql .= " grant_write           = '" . $write_grant             . "',";
                    $sql .= " grant_answer          = '" . $answer_grant            . "',";
                    $sql .= " grant_comment         = '" . $comment_grant           . "',";
                    $sql .= " grant_down            = '" . $down_grant              . "' ";
                    $sql .= " where no = '$no'";
                    $sql .= " and member_level = '" . $member_level [$i] . "';";
                    simpleSQLExecute($sql);
                    $grantCharStr[$member_level [$i]] = $character_image_grant;
                }

            }

            $grantCharStr[99] = 1; // 권한 에러때문에 추가 한것임 버전업후 삭제할 부분임

            $sql  = "update $tb_bbs_infor set ";
            $sql .= " grant_character_image         = '$grantCharStr' ";
            $sql .= " where no = '$no';";
            simpleSQLExecute($sql);

    //        echo $grantCharStr;
    //        exit;
            $params['no'    ] = $no    ;
            $params['branch'] = 'grant';
            $params['s'                     ]  = $s     ;
            $params['tot'                   ]  = $tot   ;
            $params['sort'                  ]  = $sort  ;
            $params['desc'                  ]  = $desc  ;
            formMove('test','admin_board.php', $params);
        }

        else { // Parameter 조작의 경우
            redirectPage("admin_board.php"); // 게시판 관리 (조회) 이동
        }
    }
}
?>