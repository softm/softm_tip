<?
if ( $HTTP_POST_VARS['host_nm'] && $HTTP_POST_VARS['db_nm'] && $HTTP_POST_VARS['id'] && $HTTP_POST_VARS['driver'] ) {
    set_time_limit ( 0 );
    error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE ( Notice는 제외한 모든에러를 리포팅해라~ )
    include 'common/db_connect.inc'   ; // Data Base 연결 클래스

    include 'common/board_lib.inc'    ; // 게시판 라이브러리
    include 'common/poll_lib.inc'     ; // 설문 라이브러리
    include 'common/event_lib.inc'    ; // 이벤트 라이브러리
    include 'common/member_lib.inc'   ; // 멤버 라이브러리

    include 'common/message.inc'      ; // 에러 페이지 처리
	include 'common/message_table.inc'; // 메시지

    // 데이터베이스에 접속합니다.
    $db = new DBConnection($HTTP_POST_VARS['host_nm'],$HTTP_POST_VARS['db_nm'], $HTTP_POST_VARS['id'], $HTTP_POST_VARS['password'], $HTTP_POST_VARS['driver']);
    $rtn = false;
    if ( $HTTP_POST_VARS['driver'] == "MYSQL" ) {
        $rtn = $db->mysqlConnect2();
    }
    if ( !$rtn ) {
        $err = new Message ("D", mysql_errno(),mysql_error(),"");
        include "message.php";
    } else {
        /// 디비 연결이 되면 디렉토리 권한을 바꿔 줍니다.
        @mkdir("./data"           ,0707);
        @chmod("./data"           ,0707);
        @mkdir("./data/file"      ,0707);
        @chmod("./data/file"      ,0707);
        @mkdir("./data/session"   ,0707);
        @chmod("./data/session"   ,0707);
        @mkdir("./data/poll"      ,0707);
        @chmod("./data/poll"      ,0707);
        @mkdir("./data/html"      ,0707);
        @chmod("./data/html"      ,0707);
        @mkdir("./data/member"    ,0707);
        @chmod("./data/member"    ,0707);
        @mkdir("./data/member/character"  ,0707);
        @chmod("./data/member/character"  ,0707);
        @mkdir("./data/member/picture"    ,0707);
        @chmod("./data/member/picture"    ,0707);
        @mkdir("./data/event"     ,0707);
        @chmod("./data/event"     ,0707);
        @mkdir("./data/tmp"       ,0707);
        @chmod("./data/tmp"       ,0707);
        @mkdir("./files"     ,0707);
        @chmod("./files"     ,0707);

        include ( "common/lib.inc"          ); // 공통 라이브러리

		//simpleSQLExecute("set utf8 collate utf8_general_ci;");
		//simpleSQLExecute("set euckr;");
        $rtn = unWritableDirError (); // 설치 디렉토리 권한

        if ( $rtn && !$config ) {
    /*
            echo " host_nm : $host_nm  <BR>";
            echo " db_nm   : $db_nm    <BR>";
            echo " id      : $id       <BR>";
            echo " password: $password <BR>";
            echo " driver  : $driver   <BR>";
    */

            $baseD  = baseDir  ();  // 웹 서비스 기반 경로
            $setupD = setUpDir ();  // 실제 설치 경로

            session_save_path("data/session");
            session_set_cookie_params(0, '/');
        //  session_cache_limiter('nocache, must_revalidate'); // 캐쉬 하지 말아라
            @session_cache_limiter('');
            $_s_setup_ok = '1';
            session_register("_s_setup_ok");
            $_SESSION['_s_setup_ok'] = $_s_setup_ok;  // 4.10 세션 처리.

            /* 데이터베이스 설정 정보 수집 */
            $setupInfor  = "<?\n";
            $setupInfor .= $driver   . "\n"; // 드라이버
            $setupInfor .= $host_nm  . "\n"; // host 명
            $setupInfor .= $db_nm    . "\n"; // db 명
            $setupInfor .= $id       . "\n"; // 사용자 아이디
            $setupInfor .= $password . "\n"; // 사용자 비밀번호
            $setupInfor .= $baseD    . "\n"; // 기반 디렉토리
            $setupInfor .= $setupD   . "\n"; // 설치 루트
            $setupInfor .= 'dlogin_standard' . "\n"; // 설치 루트
            $setupInfor .= "?>";

            head("DB세팅화면_SQLDB세팅");
            _css();
            //$fp = @fopen ( "config.php", "w");
			$fp = true;
            if (!$fp) {
				echo $setupD;
                $errMsg = "<B>설치 디렉토리 권한</B>을 <B><font color='red'>707</font></B>로 설정해 주세요.<BR>|* ------------- <B>설치 경로 </B> ------------- *|<BR><B>". $setupD ."</B> <BR>|* _____________________________________ *|";
                $err = new Message ("U","0006", $errMsg,"");
                include "message.php";
            } else {
                //fwrite ( $fp, $setupInfor,strlen($setupInfor) );
                @chmod("config.php"     ,0707);
				include 'common/message.inc'      ; // 에러 페이지 처리

                include ( "schema.sql"      ); // 스키마
                // 테이블 존재 검사 후 테이블 생성
                if ( !isTable($tb_bbs_infor     , $db_nm, $driver) ) { simpleSQLExecute($tb_bbs_infor_schm    , $driver);   /* 게시판 정보          */ }
                if ( !isTable($tb_bbs_abstract  , $db_nm, $driver) ) { simpleSQLExecute($tb_bbs_abstract_schm , $driver);   /* 게시물 추출 정보     */ }
                if ( !isTable($tb_bbs_skin      , $db_nm, $driver) ) { simpleSQLExecute($tb_bbs_skin_schm     , $driver);   /* 게시판 스킨 정보     */ }
                if ( !isTable($tb_bbs_grant     , $db_nm, $driver) ) { simpleSQLExecute($tb_bbs_grant_schm    , $driver);   /* 게시판 사용자별 권한 */ }
                if ( !isTable($tb_member        , $db_nm, $driver) ) { simpleSQLExecute($tb_member_schm       , $driver);   /* 회원 정보            */ }
                if ( !isTable($tb_member_kind   , $db_nm, $driver) ) { simpleSQLExecute($tb_member_kind_schm  , $driver);   /* 회원 종류 정보       */ }
                if ( !isTable($tb_member_config , $db_nm, $driver) ) { simpleSQLExecute($tb_member_config_schm, $driver);   /* 회원 가입 폼 설정    */ }
                if ( !isTable($tb_dic_member_statistic , $db_nm, $driver) ) { simpleSQLExecute($tb_dic_member_statistic_schm , $driver);   /* 회원 통계   */ }

                if ( !isTable($tb_poll_master   , $db_nm, $driver) ) { simpleSQLExecute($tb_poll_master_schm  , $driver);   /* 설문 조사 정보       */ }
                if ( !isTable($tb_poll_item     , $db_nm, $driver) ) { simpleSQLExecute($tb_poll_item_schm    , $driver);   /* 설문 조사 항목       */ }
                if ( !isTable($tb_poll_skin     , $db_nm, $driver) ) { simpleSQLExecute($tb_poll_skin_schm    , $driver);   /* 설문 조사 스킨       */ }
                if ( !isTable($tb_poll_grant    , $db_nm, $driver) ) { simpleSQLExecute($tb_poll_grant_schm   , $driver);   /* 설문 조사 사용 권한  */ }
                if ( !isTable($tb_event         , $db_nm, $driver) ) { simpleSQLExecute($tb_event_schm        , $driver);   /* 이벤트 정보          */ }

                if ( !isTable($tb_event_grant       , $db_nm, $driver) ) { simpleSQLExecute($tb_event_grant_schm        , $driver);   /* 이벤트 권한          */ }
                if ( !isTable($tb_event_item        , $db_nm, $driver) ) { simpleSQLExecute($tb_event_item_schm         , $driver);   /* 이벤트 항목          */ }
                if ( !isTable($tb_point_infor       , $db_nm, $driver) ) { simpleSQLExecute($tb_point_infor_schm        , $driver);   /* 게시판 포인트 정보   */ }
                if ( !isTable($tb_poll_point_infor  , $db_nm, $driver) ) { simpleSQLExecute($tb_poll_point_infor_schm   , $driver);   /* 설문   포인트 정보   */ }

                if ( !isTable($tb_event_result_master, $db_nm, $driver)) { simpleSQLExecute($tb_event_result_master_schm, $driver);   /* 이벤트 결과 메인     */ }
                if ( !isTable($tb_event_result_detail, $db_nm, $driver)) { simpleSQLExecute($tb_event_result_detail_schm, $driver);   /* 이벤트 결과 상세     */ }
                if ( !isTable($tb_login_abstract     , $db_nm, $driver)) { simpleSQLExecute($tb_login_abstract_schm     , $driver);   /* 로그인 추출          */ }

                // 비회원
                $existChk = simpleSQLQuery("select count(member_level) from $tb_member_config where member_level = 0 ;", $driver );
                if ( !$existChk ) {
                    $sql  = "insert into $tb_member_config (member_level, agreement, agreement_content, name, sex, e_mail, home, jumin, tel, address, news_yn, point_yn, picture_image, character_image) values ";
                    $sql .= "(0,'Y','\-가입 약관\-','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y');";
                  //logs ( '$sql :  / ' . $existChk . ' / ' . $sql . '<BR>' , true);
                    simpleSQLExecute($sql,$driver);
                }

                // 회원
                $existChk = simpleSQLQuery("select count(member_level) from $tb_member_config where member_level = 1 ;", $driver );
                if ( !$existChk ) {
                    $sql  = "insert into $tb_member_config (member_level, agreement, agreement_content, name, sex, e_mail, home, jumin, tel, address, news_yn, point_yn, picture_image, character_image) values ";
                    $sql .= "(1,'Y','\-가입 약관\-','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y');";
        //          logs ( '$sql :  / ' . $existChk . ' / ' . $sql . '<BR>' , true);
                    simpleSQLExecute($sql,$driver);
                }

                // 관리자
                $existChk = simpleSQLQuery("select count(member_level) from $tb_member_config where member_level = 99;", $driver );
                if ( !$existChk ) {
                    $sql  = "insert into $tb_member_config (member_level, agreement, agreement_content, name, sex, e_mail, home, jumin, tel, address, news_yn, point_yn, picture_image, character_image) values ";
                    $sql .= "(99,'N','\-가입 약관\-','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y');";
        //          logs ( '$sql :  / ' . $existChk . ' / ' . $sql . '<BR>' , true);
                    simpleSQLExecute($sql,$driver);
                }
                // 비회원
                $existChk = simpleSQLQuery("select count(member_level) from $tb_member_kind where member_level = 0;", $driver );
                if ( !$existChk ) {
                    // 비회원
                    $sql  = "insert into $tb_member_kind ( member_level, member_nm, etc, reg_date ) values (0 , '비회원'  , '회원가입을 하지 않은 사용자 그룹 입니다.','". getYearToSecond() ."');";
                    simpleSQLExecute($sql, $driver);
                }
                // 회원
                $existChk = simpleSQLQuery("select count(member_level) from $tb_member_kind where member_level = 1;", $driver );
                if ( !$existChk ) {
                    // 회원
                    $sql  = "insert into $tb_member_kind ( member_level, member_nm, etc, reg_date ) values (1 , '일반회원', '회원 가입시 기본 회원 그룹 입니다.','". getYearToSecond() ."');";
                    simpleSQLExecute($sql, $driver);
                }
                // 관리자
                $existChk = simpleSQLQuery("select count(member_level) from $tb_member_kind where member_level = 99;", $driver );
                if ( !$existChk ) {
                    // 관리자
                    $sql  = "insert into $tb_member_kind ( member_level, member_nm, etc, reg_date ) values (99, '관리자'  , '관리자 회원 그룹 입니다.','". getYearToSecond() ."');";
                    simpleSQLExecute($sql, $driver);
                }

                $existCnt = simpleSQLQuery("select count(*) from $tb_dic_member_statistic;", $driver );
                $existCnt = (int) $existCnt;

                if ( $existCnt == 0  ) {
                    simpleSQLExecute("insert into $tb_dic_member_statistic ( cnt ) values ( 0 );", $driver ); /* 총 회원수 초기화 */
                }

                if ( isTable($tb_post          , $db_nm, $driver) ) {
        //            simpleSQLExecute("drop table $tb_post;", $driver); /* 우편 번호 테이블 삭제 */
                }

                if ( !isTable($tb_post          , $db_nm, $driver) ) {
                    simpleSQLExecute($tb_post_schm         , $driver);   /* 우편 번호            */
        //          logs ( '$tb_post_schm :  / '. $tb_post_schm . '<BR>' , true);
        //          $sql = "LOAD DATA INFILE '" . incCurrentDir() . "post.dat' INTO TABLE esi_post FIELDS TERMINATED BY '^';";
        //          logs ( '$sql :  / '. $sql . '<BR>' , true);
        //          simpleSQLExecute($sql, $driver);
        //          logs ( '$sql :  / '. $sql . '<BR>' , true);

                    $postFile = @file("./post.dat");
        //          echo incCurrentDir() . "post.dat";
        //          $cnt = 1;
                    while ( $post = each($postFile) ) {
            //            $cnt++;
            //            if ( $cnt > 50) break;

                        $postData = explode ('^', $post[1]);
        //135-773^서울^강남구^개포4동^시영아파트^(1∼25동)^1
        //121-803^전라북도서울사무소^02-715-6366^234-2^서울 마포구
                        if ( $postData[6] == 1 ) {
                            $sql = 'insert into ' . $tb_post . " values ( '$postData[0]', '$postData[1]', '$postData[2]', '$postData[3]', '$postData[4]', '$postData[5]', '$postData[6]' );";
                        } else {
        // 556-855^초도출장소^061-690-2637^초도리 300^전남 여수시　
                            $sql = 'insert into ' . $tb_post . " values ( '$postData[0]', '', '$postData[4]', '$postData[1]', '$postData[2]', '$postData[3]', '2' );";
                        }
            //          logs ( '$sql :  / ' . $sql . '<BR>' , true);
                        simpleSQLExecute($sql, $driver);
                    }

                    // 인덱스 생성
        //          simpleSQLExecute($tb_post_idx0, $driver);
        //          simpleSQLExecute($tb_post_idx1, $driver);
        //          simpleSQLExecute($tb_post_idx2, $driver);
                }
                closeDBConnection ($driver); // 데이터베이스와의 연결 설정을 해제 합니다.
                redirectPage ("setup2.php"); // 페이지 이동
            }
        } else {
            @session_destroy ();
            // redirectPage ("setup.php"); // 페이지 이동
            exit;
        }
    }

} // if END
else {
    @session_destroy ();
    echo "\n<meta http-equiv=\"refresh\" content=\"0; url=setup.php\">";
}
?>