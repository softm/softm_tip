<?
if ( function_exists('head') ) {
    if ( $branch == 'exec' && preg_match("/${HTTP_HOST}/",$HTTP_REFERER) && ( preg_match( "/(admin_member.php)/", $HTTP_REFERER) || preg_match( "/(admin_member_formsetup.php)$/", $HTTP_REFERER) ) && $REQUEST_METHOD == 'POST' ) {
        include 'common/board_lib.inc';  // 게시판 라이브러리
        include 'common/poll_lib.inc'  ; // 설문 라이브러리
        include 'common/event_lib.inc' ; // 이벤트 라이브러리

        if ( $gubun == 'insert' ) {

        } else if ( $gubun == 'delete' ) {
            $inUser = "";
            $cnt = sizeof($chk_no)-1;
            $delCnt = 0;
            for ( $i=1; $i <= $cnt;$i++) {
                $inUser .= " '$chk_no[$i]'";

                $f1         = $chk_no[$i] . "_p.gif";
                $f2         = $chk_no[$i] . "_c.gif";
                if ( @is_file("data/member/picture/"  . $f1) ) { @unlink ( "data/member/picture/"  . $f1 ); }
                if ( @is_file("data/member/character/". $f2) ) { @unlink ( "data/member/character/". $f2 ); }
                if ( $i < $cnt ) { $inUser .= " ,"; }
                $tot--;
                $delCnt++;
            }

            $sql  = "delete from $tb_member where user_id in ( $inUser );";
            simpleSQLExecute($sql);

            $params['branch']  = 'list'              ;    // form parameter 생성

            if ( $tot < $s ) {
                $how_many = $_COOKIE["member_many"]; // 쿠키 읽어 오기
                $s = $s - $how_many;
                if ( $s < 1 ) { $s = 1; }
            }

            $sql  = "update $tb_dic_member_statistic set cnt = cnt - $delCnt;";
            simpleSQLExecute($sql); // 총 회원수 갱신

            $params['s'                     ]  = $s                  ;
            $params['tot'                   ]  = $tot                ;
            $params['sort'                  ]  = $sort               ;
            $params['desc'                  ]  = $desc               ;
            $params['search_gb'             ]  = $search_gb          ;
            $params['search'                ]  = $search             ;
            $params['search_member_level'   ]  = $search_member_level;

            formMove    ('moveForm','admin_member.php', $params);
        } else if ( $gubun == 'update' ) {
            $user_id_open         = ( !$user_id_open         ) ? "N" : $user_id_open        ;
            $member_level_open    = ( !$member_level_open    ) ? "N" : $member_level_open   ;
            $name_open            = ( !$name_open            ) ? "N" : $name_open           ;
            $nick_name_open       = ( !$nick_name_open       ) ? "N" : $nick_name_open      ;
            $sex_open             = ( !$sex_open             ) ? "N" : $sex_open            ;
            $e_mail_open          = ( !$e_mail_open          ) ? "N" : $e_mail_open         ;
            $home_open            = ( !$home_open            ) ? "N" : $home_open           ;
            $birth_open           = ( !$birth_open           ) ? "N" : $birth_open          ;
            $age_open             = ( !$age_open             ) ? "N" : $age_open            ;
            $tel_open             = ( !$tel_open             ) ? "N" : $tel_open            ;
            $address_open         = ( !$address_open         ) ? "N" : $address_open        ;
            $post_no_open         = ( !$post_no_open         ) ? "N" : $post_no_open        ;
            $point_open           = ( !$point_open           ) ? "N" : $point_open          ;
            $access_open          = ( !$access_open          ) ? "N" : $access_open         ;
            $picture_image_open   = ( !$picture_image_open   ) ? "N" : $picture_image_open  ;
            $character_image_open = ( !$character_image_open ) ? "N" : $character_image_open;

            $news_yn = ( !$news_yn ) ? "N" : $news_yn;
            $post_no = $post_cd1 . '-' . $post_cd2;
            $address = $address . '$$' . $detail_address;
            if ( $member_st == '9' ) {
                $sql  = "delete from $tb_member where user_id = '$user_id'";
                simpleSQLExecute($sql);

                $f1         = $user_id . "_p.gif";
                $f2         = $user_id . "_c.gif";
                if ( @is_file("data/member/picture/"  . $f1) ) { @unlink ( "data/member/picture/"  . $f1 ); }
                if ( @is_file("data/member/character/". $f2) ) { @unlink ( "data/member/character/". $f2 ); }
            } else {
                include ( "common/file.inc"         ); // 파일
                include ( "common/file_upload.inc"  ); // 파일 업로드
                // 회원 정보 수정
                $sql  = "update $tb_member set ";
        //      $sql .= " user_id     = '$user_id'    ,";
                $sql .= " member_level=  $member_level,";
                if ( $password_change == 'Y' ) $sql .= " password    =  PASSWORD('$password')  ,";
                $sql .= " name        = '$name'       ,";
                $sql .= " nick_name   = '$nick_name'  ,";
                $sql .= " sex         = ".($sex?$sex:'null')."        ,";
                $sql .= " e_mail      = '$e_mail'     ,";
                $sql .= " home        = '$home'       ,";
                $sql .= " birth       = '$birth'      ,";
                $sql .= " age         = '$age'        ,";
        //      $sql .= " jumin_1     =  PASSWORD('$jumin_1')    ,";
        //      $sql .= " jumin_2     =  PASSWORD('$jumin_2')    ,";
                $sql .= " tel         = '$tel'        ,";
                $sql .= " address     = '$address'    ,";
                $sql .= " post_no     = '$post_no'    ,";
                $sql .= " member_st   =  $member_st   ,";
                $sql .= " news_yn     = '$news_yn'    ,";
        
                $sql .= " point       = '$point'      ,";
                $upFile  = FileUpload ( ); // 업로드 인스턴스 생성
                $f1         = $user_id . "_p.gif";

                if ( $delete_picture_image != 'Y' ) {
                    $fileExt = strtolower ( getFileExtraName($_FILES['picture_image']['name'] ) );
                    if ( $fileExt == 'gif' || $fileExt == 'jpg' || $fileExt == 'bmp' ) {
                        if ( @is_file("data/member/picture/". $f1) ) { @unlink ( "data/member/picture/". $f1 ); }
                        $upFile->addUploadFile ($_FILES['picture_image'], "data/member/picture/", $f1, "html^txt^", 99999999999999);
                    }
                } else {
                    if ( @is_file("data/member/picture/". $f1) ) { @unlink ( "data/member/picture/". $f1 ); }
                }

                $f2         = '';
                $character_open = simpleSQLQuery("select character_image_open from $tb_member where user_id = '$user_id';");
                $f2_open         = $user_id . "_c.gif";
                $f2_close        = $user_id . "_c_close.gif";
                if ( $character_image_open == 'Y' ) { $f2 = $f2_open ; }
                else                                { $f2 = $f2_close; }

                if ( $delete_character_image != 'Y' ) {
                    $fileExt = strtolower ( getFileExtraName($_FILES['character_image']['name'] ) );
                    if ( $fileExt == 'gif' || $fileExt == 'jpg' || $fileExt == 'bmp' ) {
                        if ( $character_open == 'Y' ) { // 이전 상태가 공개이면.
                            @unlink ("data/member/character/". $f2_open );
                        } else { // 이전 상태가 비공개이면.
                            @unlink ("data/member/character/". $f2_close);
                        }
                        $upFile->addUploadFile ($_FILES['character_image'], "data/member/character/", $f2, "html^txt^", 99999999999999);
                    } else {
                        if ( $character_open == 'Y' && $character_image_open == 'N' ) { // 이전 상태가 공개이면.
                            @rename ( "data/member/character/". $f2_open , "data/member/character/". $f2_close );
                        } else if ( $character_open == 'N' && $character_image_open == 'Y' ) {
                            @rename ( "data/member/character/". $f2_close, "data/member/character/". $f2_open  );
                        }
                    }
                } else {
                    if ( @is_file("data/member/character/". $f2) ) { @unlink ( "data/member/character/". $f2 ); }
                }

                $upFile->Upload(); // 업로드 시작

                $sql .= " user_id_open             = '$user_id_open'            ,";
                $sql .= " member_level_open        = '$member_level_open'       ,";
                $sql .= " name_open                = '$name_open'               ,";
                $sql .= " nick_name_open           = '$nick_name_open'          ,";
                $sql .= " sex_open                 = '$sex_open'                ,";
                $sql .= " e_mail_open              = '$e_mail_open'             ,";
                $sql .= " home_open                = '$home_open'               ,";
                $sql .= " birth_open               = '$birth_open'              ,";
                $sql .= " age_open                 = '$age_open'                ,";
                $sql .= " tel_open                 = '$tel_open'                ,";
                $sql .= " address_open             = '$address_open'            ,";
                $sql .= " post_no_open             = '$post_no_open'            ,";
                $sql .= " point_open               = '$point_open'              ,";
                $sql .= " access_open              = '$access_open'             ,";
                $sql .= " picture_image_open       = '$picture_image_open'      ,";
                $sql .= " character_image_open     = '$character_image_open'    ,";
                $sql .= " hint          = " .($hint?$hint:'null'). "   ,";
                $sql .= " answer        = '$answer' ,";
                $sql .= " acc_date    = '" . getYearToSecond() . "'";
        //      $sql .= " reg_date    = '" . getYearToSecond() . "' ";
                $sql .= " where user_id = '$user_id';";
                //logs ("$sql <BR>",true);
                simpleSQLExecute($sql);

                $sql  = "select * from $tb_member where user_id = '" . $memInfor['user_id'] . "';";
                $result = singleRowSQLQuery($sql);
                if ( $result['user_id'] ) { // 수정하려는 아이디가 현재 로그인한 관리자 계정과 동일할 경우
                    $_s_memInfor['login_yn'    ] = 'Y';
                    $_s_memInfor['admin_yn'    ] = 'Y';
                    $_s_memInfor['user_id'     ] = $result['user_id'     ];
                    $_s_memInfor['member_level'] = $result['member_level'];
                    $_s_memInfor['name'        ] = $result['name'        ];
                    $_s_memInfor['e_mail'      ] = $result['e_mail'      ];
                    $_s_memInfor['member_st'   ] = $result['member_st'   ];
                    $_s_memInfor['reg_date'    ] = $result['reg_date'    ];
                    $_s_memInfor['news_yn'     ] = $result['news_yn'     ];
                    $_s_memInfor['point'       ] = $result['point'       ];
                    if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0이하
                        @session_register("_s_memInfor");
                    } else {
                        $_SESSION['_s_memInfor'] = $_s_memInfor;  // 4.10 세션 처리.
                    }
                }
            }

            if ( $member_st == '9' ) {
                $params['branch']  = 'list'              ;    // form parameter 생성
                $tot--;
                if ( $tot < $s ) {
                    $how_many = $_COOKIE["member_many"]; // 쿠키 읽어 오기
                    $s = $s - $how_many;
                    if ( $s < 1 ) { $s = 1; }
                }
            } else {
                $params['branch']  = 'write' ;    // form parameter 생성
                $params['user_id'] = $user_id;    // form parameter 생성
            }

            $params['s'                     ]  = $s                  ;
            $params['tot'                   ]  = $tot                ;
            $params['sort'                  ]  = $sort               ;
            $params['desc'                  ]  = $desc               ;
            $params['search_gb'             ]  = $search_gb          ;
            $params['search'                ]  = $search             ;
            $params['search_member_level'   ]  = $search_member_level;

            formMove    ('moveForm','admin_member.php', $params);

        } else if ( $gubun == 'member_kind_update' ) {
            $inUser = '';
            $cnt = sizeof($chk_no)-1;
            for ( $i=1; $i <= $cnt;$i++) {
                if ( $chk_no[$i] ) $inUser .= " '$chk_no[$i]',";
            }
            if ( $inUser ) {
                $inUser = substr($inUser, 0,-1);
                $sql  = "update $tb_member set ";
                $sql .= " member_level=  $update_member_level,";
                $sql .= " acc_date    = '" . getYearToSecond() . "'";
                $sql .= " where user_id in ( $inUser );";
                simpleSQLExecute($sql);
            }
            redirectPage("admin_member.php"); // 게시판 관리 (조회) 이동
        } else if ( $gubun == 'formsetup' ) {
    //      logs ( '$gubun : ' . $gubun, true );
            $name    = ( !$name    ) ? "N" : $name   ;
            $nick_name= ( !$nick_name) ? "N" : $nick_name;
            $e_mail  = ( !$e_mail  ) ? "N" : $e_mail ;
            $home    = ( !$home    ) ? "N" : $home   ;
            $jumin   = ( !$jumin   ) ? "N" : $jumin  ;
            $birth   = ( !$birth   ) ? "N" : $birth  ;
            $age     = ( !$age     ) ? "N" : $age    ;
            $tel     = ( !$tel     ) ? "N" : $tel    ;
            $address = ( !$address ) ? "N" : $address;
            $news_yn = ( !$news_yn ) ? "N" : $news_yn;

            $news_point      = ( !$news_point      ) ? "0" : $news_point     ;
            $point_yn        = ( !$point_yn        ) ? "N" : $point_yn       ;
            $point           = ( !$point           ) ? "0" : $point          ;
            $picture_image   = ( !$picture_image   ) ? "N" : $picture_image  ;
            $character_image = ( !$character_image ) ? "N" : $character_image;

            $existChk = simpleSQLQuery("select count(member_level) from $tb_member_config where member_level = $member_level;");
            if ( $existChk ) {
                $sql  = "update $tb_member_config set ";
                $sql .= " agreement    = '$agreement',";
                if ( !escapeYN () ) { // magic_quotes_gpc Off
                    $agreement_content = addslashes($agreement_content);
                }
                $sql .= " agreement_content = '" . $agreement_content . "',";
                $sql .= " name              = '$name'           ,";
                $sql .= " nick_name         = '$nick_name'      ,";
                $sql .= " sex               = '$sex'            ,";
                $sql .= " e_mail            = '$e_mail'         ,";
                $sql .= " home              = '$home'           ,";
                $sql .= " jumin             = '$jumin'          ,";
                $sql .= " birth             = '$birth'          ,";
                $sql .= " age               = '$age'            ,";
                $sql .= " tel               = '$tel'            ,";
                $sql .= " address           = '$address'        ,";
                $sql .= " news_yn           = '$news_yn'        ,";
                $sql .= " news_point        = '$news_point'     ,";
                $sql .= " point_yn          = '$point_yn'       ,";
                $sql .= " point             = '$point'          ,";
                $sql .= " hint              = '$hint'           ,";
                $sql .= " picture_image     = '$picture_image'  ,";
                $sql .= " character_image   = '$character_image' ";
    //          $sql .= " where member_level = '$member_level'";
    //          logs ( '$sql : ' . $sql, true );
                simpleSQLExecute($sql);
            } else {
                $sql  = "insert into $tb_member_config (member_level, agreement, agreement_content, name, e_mail, home, jumin, tel, address, news_yn) values ";
                $sql .= "(";
                $sql .= "'$member_level',";
                $sql .= "'$agreement',";
                if ( !escapeYN () ) { // magic_quotes_gpc Off
                    $agreement_content = addslashes($agreement_content);
                }
                    $sql .= "'" . $agreement_content . "',";
                $sql .= "'$name'        ,";
                $sql .= "'$e_mail'      ,";
                $sql .= "'$home'        ,";
                $sql .= "'$jumin'       ,";
                $sql .= "'$tel'         ,";
                $sql .= "'$address'     ,";
                $sql .= "'$news_yn'      ";
                $sql .= ");";
    //          logs ( '$sql : ' . $sql, true );
                simpleSQLExecute($sql);
            }
    //        $params['branch'] = 'formsetup';     // form parameter 생성
    //        formMove    ('moveForm','admin_member.php', $params);
            redirectPage("admin_member.php?branch=formsetup"); // 멤버 종류 관리 (조회) 이동
    //      redirectPage("admin_member_formsetup.php"); // 회원 가입 폼 설정

        } else if ( $gubun == 'kind_insert' ) {
            $newLevel = simpleSQLQuery("select MAX(member_level) + 1 from $tb_member_kind WHERE member_level between 2 and 98;");
            if ( !$newLevel ) $newLevel = 2;
            $sql  = "insert into $tb_member_kind ( member_level, member_nm, etc, reg_date ) values ";

            $sql .= "($newLevel, '$member_nm', '','". getYearToSecond() ."');";
            simpleSQLExecute($sql);

            $stmt = multiRowSQLQuery("select no, bbs_id from $tb_bbs_infor;");

            while ( $row = multiRowFetch  ($stmt) ) {
                $bbs_no = $row['no'];
                $bbs_id = $row['bbs_id'];
                $sql  = "insert into $tb_bbs_grant ( no, bbs_id, member_level, grant_list, grant_view, grant_write, grant_answer, grant_comment, grant_down ) values ($bbs_no, '$bbs_id', $newLevel, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y' );";
    //          logs ( '$sql : '. $sql . '<BR>' , true);
                simpleSQLExecute($sql);
                // 참고
                // $pointInfor = array("","게시물 작성", "의견글 작성", "파일 업로드", "다운로드", "답글작성");
                for ( $i=1; $i <= 5;$i++) {
                    /* 포인트 정보     */
                    $sql  = "insert into $tb_point_infor ( ";
                    $sql .= " no, bbs_id, member_level, use_st, point, etc, reg_date";
                    $sql .= " ) values ( ";
                    $sql .= "'" . $i                . "',";
                    $sql .= "'" . $bbs_id           . "',";
                    $sql .= "'" . $newLevel         . "',";
                    $sql .= "'1'                        ,"; // 사용 : 1, 미사용 : 2
                    $sql .= " 1                         ,"; // 포인트
                    $sql .= "''                         ,";
                    $sql .= "'" . getYearToSecond() . "'" ;
                    $sql .= ");";
                    simpleSQLExecute($sql);
                }
            }
            $stmt = multiRowSQLQuery("select no poll_id from $tb_poll_master;");

            while ( $row = multiRowFetch  ($stmt) ) {
                $poll_id = $row['poll_id'];

                // 참고
                // $pointInfor = array("","설문투표", "의견글");
                for ( $i=1; $i <= 2;$i++) {
                    /* 포인트 정보     */
                    $sql  = "insert into $tb_poll_point_infor ( ";
                    $sql .= " no, poll_no, member_level, use_st, point, etc, reg_date";
                    $sql .= " ) values ( ";
                    $sql .= "'" . $i                . "',";
                    $sql .= "'" . $poll_id          . "',";
                    $sql .= "'" . $newLevel         . "',";
                    $sql .= "'1'                        ,"; // 사용 : 1, 미사용 : 2
                    $sql .= " 1                         ,"; // 포인트
                    $sql .= "''                         ,";
                    $sql .= "'" . getYearToSecond() . "'" ;
                    $sql .= ");";
                    simpleSQLExecute($sql);
                }
            }


            $stmt = multiRowSQLQuery("select no event_id from $tb_event;");
            while ( $row = multiRowFetch  ($stmt) ) {
                $event_id = $row['event_id'];
                $sql  = "insert into $tb_event_grant ( no, member_level, grant_join, join_point ) values ( $event_id, $newLevel, 'Y', '1' );";
    //          logs ( '$sql : '. $sql . '<BR>' , true);
                simpleSQLExecute($sql);
            }

            redirectPage("admin_member.php?branch=kind"); // 멤버 종류 관리 (조회) 이동
        } else if ( $gubun == 'kind_delete' ) {

            $inLevel = "";
            $cnt = sizeof($chk_no)-1;
            for ( $i=1; $i <= $cnt;$i++) {
                if ( $chk_no [$i] != 99 && $chk_no [$i] != 1 && $chk_no [$i] != 0 ) {
                    $inLevel .= " $chk_no[$i] ";
                    if ( $i < $cnt ) { $inLevel .= " ,"; }
                }
            }

            if ( substr($inLevel, -1) == ',' ) {
                $inLevel = substr($inLevel, 0, strlen ( $inLevel ) -1 );
            }

            $sql  = "delete from $tb_member_kind where member_level in ( $inLevel );";
            simpleSQLExecute($sql);

            $sql  = "delete from $tb_bbs_grant   where member_level in ( $inLevel );";
            simpleSQLExecute($sql);

            // 포인트 정보 테이블 삭제
            $sql  = "delete from $tb_point_infor where member_level in ( $inLevel );";
            simpleSQLExecute($sql);

            // 설문 포인트 정보 테이블 삭제
            $sql  = "delete from $tb_poll_point_infor where member_level in ( $inLevel );";
            simpleSQLExecute($sql);

            // 이벤트 권한 테이블 삭제
            $sql  = "delete from $tb_event_grant   where member_level in ( $inLevel );";
            simpleSQLExecute($sql);

            $params['branch'] = 'kind';
            formMove('test','admin_member.php', $params);// 멤버 종류 관리 (조회) 이동
    //      redirectPage("admin_member.php?branch=kind"); // 멤버 종류 관리 (조회) 이동
        } else if ( $gubun == 'kind_update' ) {
            $cnt = sizeof($member_level)-1;
            for ( $i=1; $i <= $cnt;$i++) {
                if ( $update_yn[$i] == 'Y' ) {
                    $sql  = "update $tb_member_kind set ";
                    $sql .= " member_nm = '" . $member_nm [$i]   . "',";
                    if ( !escapeYN () ) { // magic_quotes_gpc Off
                        $sql .= " etc       = '" . addslashes($etc [$i]) . "',";
                    } else {
                        $sql .= " etc       = '" .            $etc [$i]  . "',";
                    }
                    $sql .= " point     = '" . $point [$i]       . "',";
                    $sql .= " reg_date  = '" . getYearToSecond() . "' ";
                    $sql .= " where member_level = '" . $member_level [$i] . "';";
                    simpleSQLExecute($sql);
                }
            }
            $params['branch'] = 'kind';
            formMove('test','admin_member.php', $params);// 멤버 종류 관리 (조회) 이동
        }
        else { // Parameter 조작의 경우
    //      logs ( '$gubun : ' . $gubun, true );
            redirectPage("admin_member.php"); // 게시판 관리 (조회) 이동
        }
    }
}
?>