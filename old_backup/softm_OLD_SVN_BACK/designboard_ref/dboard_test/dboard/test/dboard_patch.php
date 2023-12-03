<?
include_once ( 'common/lib.inc'          ); // 공통 라이브러리
include_once ( 'common/message.inc'      ); // 에러 페이지 처리
include_once ( 'common/db_connect.inc'   ); // Data Base 연결 클래스
include_once ( 'common/_service.inc'     ); // 서비스 화면 관련
include_once ( 'common/file.inc'         ); // 파일 시스템 관련
include_once ( 'common/lib/var/table.inc'); // 테이블 정보 설정

function fieldCheck($tableName,$fieldName) {
    global $db;
    $exist = true;
    if ( isTable($tableName) ) {
        $stmt = multiRowSQLQuery("show fields from $tableName;");
        while ( $row = multiRowFetch  ($stmt) ) {
            $field   = $row['Field'   ];
            if ( strtolower ($field) == $fieldName ) {
                $exist = true ;
                break;
            } else {
                $exist = false;
            }
        }
    }
    return $exist;
}

function indexCheck($tableName,$fieldName) {
    global $db;
    $exist = true;
    if ( isTable($tableName) ) {
        $stmt = multiRowSQLQuery("show index from $tableName;");
        while ( $row = multiRowFetch  ($stmt) ) {
            $field   = $row['Key_name'   ];
            if ( strtolower ($field) == $fieldName ) {
                $exist = true ;
                break;
            } else {
                $exist = false;
            }
        }
    }
    return $exist;
}

if ( $config ) {
    $memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음
    if ( $memInfor['member_level'] == 99 ) {
        if ( $execute_yn == 'Y' ) {
            set_time_limit ( 0 );
            $boardMemberLevelUpdate = false; // 게시판 회원 레벨 반영

            // 데이터베이스에 접속합니다.
            $db = initDBConnection (); // 데이터베이스에 접속합니다.

/* 1.01 이하 ------------------------------------------------ 시작 */
			if ( (float) $_dboard_ver_str <= 1.01 ) {
				// bbs_id
				$exist = fieldCheck($tb_bbs_grant,'bbs_id');
				if ( !$exist ) {
					echo '<font color="red">게시판 권한 필드 정보가 (게시판 아이디) 추가되었습니다.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_bbs_grant . " add (bbs_id VARCHAR (40) NOT NULL);");   /* 게시판 아이디*/
				}
				// grant_answer
				$exist = fieldCheck($tb_bbs_grant,'grant_answer');
				if ( !$exist ) {
					echo '<font color="red">게시판 권한 필드 정보가 (답변 권한) 추가되었습니다.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_bbs_grant . " add (grant_answer CHAR (1));");   /* 답변제한     */
				}

				// grant_comment
				$exist = fieldCheck($tb_bbs_grant,'grant_comment');
				if ( !$exist ) {
					echo '<font color="red">게시판 권한 필드 정보가 (의견글 권한) 추가되었습니다.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_bbs_grant . " add (grant_comment CHAR (1));");   /* 의견글제한     */
				}

				// grant_down
				$exist = fieldCheck($tb_bbs_grant,'grant_down');
				if ( !$exist ) {
					echo '<font color="red">게시판 권한 필드 정보가 (다운 권한) 추가되었습니다.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_bbs_grant . " add (grant_down CHAR (1));");   /* 다운제한     */
				}

				// operator_id
				$exist = fieldCheck($tb_bbs_infor,'operator_id');
				if ( !$exist ) {
					echo '<font color="red">게시판 정보가 (운영자아이디) 추가 되었습니다.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_bbs_infor . " add (operator_id VARCHAR (255));");   /* 카테고리 정보 */
				}
			}
/* 1.01 이하 ------------------------------------------------ 끝 */

/* 2.09 이하 ------------------------------------------------ 시작 */
			if ( (float) $_dboard_ver_str <= 2.09 ) {
				// use_category
				$exist = fieldCheck($tb_bbs_infor,'use_category');
				if ( !$exist ) {
					echo '<font color="red">게시판 정보(카테고리) 변경되었습니다.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_bbs_infor . " add (use_category CHAR (1) DEFAULT 'N');");   /* 카테고리 정보 */
				}

				// cat_no
				$exist = fieldCheck($tb_bbs_abstract,'cat_no');
				if ( !$exist ) {
					echo '<font color="red">게시판 추출 정보가(카테고리) 변경되었습니다.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_bbs_abstract . " add (use_category CHAR(1) DEFAULT 'N');");   /* 카테고리 사용 여부 */
					simpleSQLExecute('alter table ' . $tb_bbs_abstract . " add (cat_no       INT (4) DEFAULT '0');");   /* 카테고리 번호      */
				}

				// 회원 가입 항목 데이터 정보 home
				$exist = fieldCheck($tb_member, 'home');
				if ( !$exist ) {
					echo '<font color="red">회원 관련 정보 변경되었습니다.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (home VARCHAR (255) );");   /* 카테고리 정보 */
				}

				// 회원 가입폼 데이터 정보 home
				$exist = fieldCheck($tb_member_config, 'home');

				if ( !$exist ) {
					echo '<font color="red">회원 가입폼 정보 변경되었습니다.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_config . " add (home CHAR (1) NOT NULL);");   /* 카테고리 정보 */
				}
			}
/* 2.09 이하 ------------------------------------------------ 끝 */

/* 3.01 이하 ------------------------------------------------ 시작 */
			if ( (float) $_dboard_ver_str <= 3.01 ) {
				// 게시판 포인트 정보 테이블
				$tb_point_infor  = 'kyh_point_infor'  ; /* 포인트 정보          */
				if ( !isTable($tb_point_infor) ) {
					echo '<font color="red">게시판 포인트 정보 테이블이 생성되었습니다.</font><BR>';
					/* 게시판 포인트 정보 */
					$tb_point_infor_schm  = "CREATE  TABLE  $tb_point_infor (";
					$tb_point_infor_schm .= "    no              INT     (10 )       NOT NULL    , /* 포인트 번호  */";
					$tb_point_infor_schm .= "    bbs_id          VARCHAR (40 )       NOT NULL    , /* 게시판 아이디*/";
					$tb_point_infor_schm .= "    member_level    INT     (2  )       NOT NULL    , /* 회원 레벨    */";
					$tb_point_infor_schm .= "    use_st          INT     (1  )       NOT NULL    , /* 사용 상태    */";
					$tb_point_infor_schm .= "    point           INT     (10 )       DEFAULT '0' , /* 포인트 점수  */";
					$tb_point_infor_schm .= "    etc             VARCHAR (255)                   , /* 비고         */";
					$tb_point_infor_schm .= "    reg_date        CHAR    (14 )       NOT NULL    , /* 생성 일자    */";
					$tb_point_infor_schm .= "    primary key (no, bbs_id, member_level)          ,";
					$tb_point_infor_schm .= "  KEY idx_point_infor (use_st) /* 인덱스 생성 */";
					$tb_point_infor_schm .= ") ;";
					simpleSQLExecute($tb_point_infor_schm);   /* 포인트 정보 */
				}
				// 설문 포인트 정보 테이블
				$tb_poll_point_infor  = 'kyh_poll_point_infor'  ; /* 포인트 정보          */
				if ( !isTable($tb_poll_point_infor) ) {
					echo '<font color="red">설문 포인트 정보 테이블이 생성되었습니다.</font><BR>';
					/* 설문 포인트 정보 */
					$tb_poll_point_infor_schm  = "CREATE  TABLE  $tb_poll_point_infor (";
					$tb_poll_point_infor_schm .= "    no              INT     (10 )       NOT NULL    , /* 포인트 번호  */";
					$tb_poll_point_infor_schm .= "    poll_no         INT     (10 )       NOT NULL    , /* 설문 번호    */";
					$tb_poll_point_infor_schm .= "    member_level    INT     (2  )       NOT NULL    , /* 회원 레벨    */";
					$tb_poll_point_infor_schm .= "    use_st          INT     (1  )       NOT NULL    , /* 사용 상태    */";
					$tb_poll_point_infor_schm .= "    point           INT     (10 )       DEFAULT '0' , /* 포인트 점수  */";
					$tb_poll_point_infor_schm .= "    etc             VARCHAR (255)                   , /* 비고         */";
					$tb_poll_point_infor_schm .= "    reg_date        CHAR    (14 )       NOT NULL    , /* 생성 일자    */";
					$tb_poll_point_infor_schm .= "    primary key (no, poll_no, member_level)          ,";
					$tb_poll_point_infor_schm .= "  KEY idx_poll_point_infor (use_st) /* 인덱스 생성 */";
					$tb_poll_point_infor_schm .= ") ;";
					simpleSQLExecute($tb_poll_point_infor_schm);   /* 포인트 정보 */
				}
				if ( !is_dir ( "./data/member" ) ) {
					@mkdir("./data/member"    ,0707);
					@chmod("./data/member"    ,0707);
					echo '<font color="red">회원 데이터 디렉토리가 생성 되었습니다.[ /data/member ]</font><BR>';

				}

				if ( !is_dir ( "./data/member/picture" ) ) {
					@mkdir("./data/member/picture"    ,0707);
					@chmod("./data/member/picture"    ,0707);
					echo '<font color="red">회원 사진 디렉토리가 생성 되었습니다.[ /data/member/picture ]</font><BR>';
				}

				if ( !is_dir ( "./data/member/character" ) ) {
					@mkdir("./data/member/character"    ,0707);
					@chmod("./data/member/character"    ,0707);
					echo '<font color="red">회원 캐릭터 디렉토리가 생성 되었습니다.[ /data/member/character ]</font><BR>';
				}

				$exist = fieldCheck($tb_bbs_infor, 'grant_character_image');
				if ( !$exist ) {
					echo '<font color="red">게시판 정보가 추가 되었습니다.[ grant_character_image ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_bbs_infor . " add ( grant_character_image VARCHAR (255) DEFAULT '0111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111' );");   /* 회원 아이콘 */
				}

				$exist = fieldCheck($tb_member, 'point');
				if ( !$exist ) {
					echo '<font color="red">회원 관련 정보 변경되었습니다. [ point ] </font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (point               INT     (11)    DEFAULT '0');");   /* 포인트 점수 */
				}

				$exist = fieldCheck($tb_member, 'user_id_open');
				if ( !$exist ) {
					echo '<font color="red">회원 관련 정보 변경되었습니다.[ user_id_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (user_id_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* 아이디  공개 : 'Y' , 공개안함 : 'N' */
				}

				$exist = fieldCheck($tb_member, 'member_level_open');
				if ( !$exist ) {
					echo '<font color="red">회원 관련 정보 변경되었습니다.[ member_level_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (member_level_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* 회원 종류  공개 : 'Y' , 공개안함 : 'N' */
				}

				$exist = fieldCheck($tb_member, 'name_open');
				if ( !$exist ) {
					echo '<font color="red">회원 관련 정보 변경되었습니다.[ name_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (name_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* 이름       공개 : 'Y' , 공개안함 : 'N' */
				}

				$exist = fieldCheck($tb_member, 'sex_open');
				if ( !$exist ) {
					echo '<font color="red">회원 관련 정보 변경되었습니다.[ sex_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (sex_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* 성별       공개 : 'Y' , 공개안함 : 'N' */
				}

				$exist = fieldCheck($tb_member, 'e_mail_open');
				if ( !$exist ) {
					echo '<font color="red">회원 관련 정보 변경되었습니다.[ e_mail_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (e_mail_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* 이메일     공개 : 'Y' , 공개안함 : 'N' */
				}

				$exist = fieldCheck($tb_member, 'home_open');
				if ( !$exist ) {
					echo '<font color="red">회원 관련 정보 변경되었습니다.[ home_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (home_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* 홈페이지   공개 : 'Y' , 공개안함 : 'N' */
				}

				$exist = fieldCheck($tb_member, 'tel_open');
				if ( !$exist ) {
					echo '<font color="red">회원 관련 정보 변경되었습니다.[ tel_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (tel_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* 전화번호   공개 : 'Y' , 공개안함 : 'N' */
				}

				$exist = fieldCheck($tb_member, 'address_open');
				if ( !$exist ) {
					echo '<font color="red">회원 관련 정보 변경되었습니다.[ address_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (address_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* 주소       공개 : 'Y' , 공개안함 : 'N' */
				}

				$exist = fieldCheck($tb_member, 'post_no_open');
				if ( !$exist ) {
					echo '<font color="red">회원 관련 정보 변경되었습니다.[ post_no_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (post_no_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* 우편번호   공개 : 'Y' , 공개안함 : 'N' */
				}

				$exist = fieldCheck($tb_member, 'point_open');
				if ( !$exist ) {
					echo '<font color="red">회원 관련 정보 변경되었습니다.[ point_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (point_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* 포인트     공개 : 'Y' , 공개안함 : 'N' */
				}

				$exist = fieldCheck($tb_member, 'picture_image_open');
				if ( !$exist ) {
					echo '<font color="red">회원 관련 정보 변경되었습니다.[ picture_image_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (picture_image_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* 사진   공개     : 'Y' , 공개안함 : 'N' */
				}

				$exist = fieldCheck($tb_member, 'character_image_open');
				if ( !$exist ) {
					echo '<font color="red">회원 관련 정보 변경되었습니다.[ character_image_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (character_image_open    CHAR    (1 )    DEFAULT 'Y' NOT NULL );");   /* 아이콘 공개  : 'Y' , 공개안함 : 'N' */
				}

				$exist = fieldCheck($tb_member_kind, 'point');
				if ( !$exist ) {
					echo '<font color="red">회원 종류 정보 변경되었습니다. [ point ] </font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_kind . " add (point               INT     (10)       DEFAULT 1 );");   /* 포인트 점수 */
				}

				$exist = fieldCheck($tb_member_config, 'news_point');
				if ( !$exist ) {
					echo '<font color="red">회원 가입폼 정보 변경되었습니다. [ news_point ] </font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_config . " add (news_point        INT     (10)    DEFAULT 500 );");   /* 뉴스레터 수신 포인터 점수 */
				}


				$exist = fieldCheck($tb_member_config, 'point_yn');
				if ( !$exist ) {
					echo '<font color="red">회원 가입폼 정보 변경되었습니다. [ point_yn ] </font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_config . " add (point_yn               CHAR    (1)     NOT NULL DEFAULT 'Y');");   /* 포인터 표시 */
				}

				$exist = fieldCheck($tb_member_config, 'point');
				if ( !$exist ) {
					echo '<font color="red">회원 가입폼 정보 변경되었습니다. [ point ] </font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_config . " add (point               INT     (10)    DEFAULT 1000 );");   /* 포인터 점수 */
				}

				$exist = fieldCheck($tb_member_config, 'picture_image');
				if ( !$exist ) {
					echo '<font color="red">회원 가입폼 정보 변경되었습니다.[ picture_image ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_config . " add (picture_image           CHAR    (1)     NOT NULL DEFAULT 'Y');");   /* 사진 표시 */
				}

				$exist = fieldCheck($tb_member_config, 'character_image');
				if ( !$exist ) {
					echo '<font color="red">회원 가입폼 정보 변경되었습니다.[ character_image ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_config . " add (character_image         CHAR    (1)     NOT NULL DEFAULT 'Y');");   /* 캐릭터 표시 */
				}

				// 설문 정보 테이블 수정 및 생성
				$sql = "select no, title from $tb_poll_master;";
				$stmt = multiRowSQLQuery($sql);
				while ( $row = multiRowFetch  ($stmt) ) {
					$stmt_kind = multiRowSQLQuery("select member_level, member_nm from $tb_member_kind;");
					while ( $row_kind = multiRowFetch  ($stmt_kind) ) {
						$memberLevel = $row_kind['member_level'];
						$memberNm    = $row_kind['member_nm'   ];
						$exist = simpleSQLQuery("select count(no) from $tb_poll_grant where no = " . $row['no'] . " and member_level = '$memberLevel'");
						if ( !$exist ) {
							$sql  = "insert into $tb_poll_grant ( no, member_level, grant_poll, grant_poll_result, grant_write ) ";
							if ( $memberLevel == 0 || $memberLevel == 1 || $memberLevel == 99 ) { // [ 기본 회원 종류 ] 비회원, 일반회원, 관리자
								$sql .= "values (" . $row['no'] . " , $memberLevel, 'Y', 'Y', 'Y' );";
							} else {
								/* ---- 목록권한 읽기권한 쓰기권한 답글권한 의견글권한 다운권한 ---- */
								$sql .= "values (" . $row['no'] . " , $memberLevel, 'Y', 'Y', 'Y' );";
							}
							simpleSQLExecute($sql);
						}
						if ( $memberLevel > 0 ) { // 비회원이 아니면.
							// 참고
							// $pointInfor = array("","설문투표", "의견글");
							$existChk = true;
							for ( $i=1; $i <= 2;$i++) {
								$chkSql  = "select count(no) from $tb_poll_point_infor ";
								$chkSql .= " where  no           = '" . $i             . "'";
								$chkSql .= " and    poll_no      = '" . $row['no']     . "'";
								$chkSql .= " and    member_level = '" . $memberLevel   . "'";
								$existChk = simpleSQLQuery($chkSql);
								if ( !$existChk ) {
									/* 포인트 정보     */
									$sql  = "insert into $tb_poll_point_infor ( ";
									$sql .= " no, poll_no, member_level, use_st, point, etc, reg_date";
									$sql .= " ) values ( ";
									$sql .= "'" . $i                . "',";
									$sql .= "'" . $row['no']        . "',";
									$sql .= "'" . $memberLevel      . "',";
									$sql .= "'1'                        ,"; // 사용 : 1, 미사용 : 2
									$sql .= " 1                         ,"; // 포인트
									$sql .= "''                         ,";
									$sql .= "'" . getYearToSecond() . "'" ;
									$sql .= ");";
									simpleSQLExecute($sql);
								}
							}
							if ( !$existChk ) {
								echo '<font color="black">' . $row['title'] .' 설문 ' . $memberNm . ' 포인트 정보가 생성되었습니다..</font><BR>';
							}
						}
					}
				}

				$exist = fieldCheck($tb_poll_master, 'use_top');
				if ( !$exist ) {
					echo '<font color="red">설문 조사 정보변경되었습니다.[ use_top ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_poll_master . " add (use_top             CHAR    (1)     DEFAULT 'Y');");   /* 항상 최근 설문으로 설정 */
				}

				$exist = fieldCheck($tb_poll_master, 'poll_process');
				if ( !$exist ) {
					echo '<font color="red">설문 조사 정보변경되었습니다.[ poll_process ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_poll_master . " add (poll_process	     CHAR	 (1  )	 DEFAULT '1');");   /* 투표후 처리 페이지 : '1' : 결과페이지, '2' : 현재페이지유지, '3' : url입력 */
				}

				$exist = fieldCheck($tb_poll_master, 'suc_url');
				if ( !$exist ) {
					echo '<font color="red">설문 조사 정보변경되었습니다.[ suc_url ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_poll_master . " add (suc_url             VARCHAR (255));");   /* 성공 이동 페이지 */
				}

				if ( (float) $_dboard_ver_str <= 3.01 ) {
					$exist = fieldCheck($tb_poll_master, 'display_mode');
					if ( $exist ) {
						echo '<font color="red">설문 조사 정보변경되었습니다.[ display_mode ]</font><BR>';
						simpleSQLExecute('alter table ' . $tb_poll_master . " modify display_mode        CHAR    (1  )   DEFAULT '2';");   /* 성공 이동 페이지 */
					}
				}

				$exist = fieldCheck($tb_poll_master, 'grant_character_image');
				if ( !$exist ) {
					echo '<font color="red">설문 조사 정보변경되었습니다.[ grant_character_image ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_poll_master . " add ( grant_character_image VARCHAR (255) DEFAULT '0111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111' );");   /* 회원 아이콘 */
				}

				// 이벤트 정보 테이블 수정 및 생성
				$tb_event      = 'kyh_event'        ;
				$tb_event_item = 'kyh_event_item'   ; /* 이벤트 항목          */
				$exist = fieldCheck($tb_event,'display_mode');
				if ( !$exist ) {
					echo '<font color="red">이벤트 정보 필드가 추가 되었습니다. [ display_mode ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_event . " add (display_mode    CHAR    (1  )       DEFAULT '1' );");   /* 이벤트 표시형식    */
				}

				$exist = fieldCheck($tb_event,'use_top');
				if ( !$exist ) {
					echo '<font color="red">이벤트 정보 필드가 추가 되었습니다. [ use_top ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_event . " add (use_top         CHAR    (1  )       DEFAULT 'N' );");   /* 항상 최근 이벤트로 설정 */
				}

				$exist = fieldCheck($tb_event,'scroll_yn');
				if ( !$exist ) {
					echo '<font color="red">이벤트 정보 필드가 추가 되었습니다. [ scroll_yn ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_event . " add (scroll_yn       CHAR    (1  )       DEFAULT 'Y' );");   /* 팝업 스크롤 여부 */
				}

			}
/* 3.01 이하 ------------------------------------------------ 끝 */

/* 3.22 이하 ------------------------------------------------ 시작 */
			if ( (float) $_dboard_ver_str <= 3.22 ) {
				// 이벤트 정보
				if ( !is_dir ( "./data/event" ) ) {
					@mkdir("./data/event"    ,0707);
					@chmod("./data/event"    ,0707);
					echo '<font color="red">이벤트 데이터 디렉토리가 생성 되었습니다.[ /data/event ]</font><BR>';
				}

				// 게시판 정보 title_limit [ 3.22 이하 버전 사용자 ]
				$exist = fieldCheck($tb_event,'title_limit');
				if ( !$exist ) {
					echo '<font color="red">이벤트 정보가 추가되었습니다.[ title_limit ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_event . " add (title_limit          INT     (3  )       DEFAULT 30);");
				}

				// 게시판 정보 suc_url [ 3.22 이하 버전 사용자 ]
				$exist = fieldCheck($tb_event,'suc_url');
				if ( !$exist ) {
					echo '<font color="red">이벤트 정보가 추가되었습니다.[ suc_url ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_event . " add (suc_url              VARCHAR (255));");
				}

				// 게시판 정보 scroll_yn [ 3.22 이하 버전 사용자 ]
				$exist = fieldCheck($tb_event,'scroll_yn');
				if ( !$exist ) {
					echo '<font color="red">이벤트 정보가 추가되었습니다.[ scroll_yn ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_event . " add (scroll_yn            CHAR    (1  )       DEFAULT 'Y');");
				}

				// 게시판 정보 base_path [ 3.22 이하 버전 사용자 ]
				$exist = fieldCheck($tb_event,'base_path');
				if ( !$exist ) {
					echo '<font color="red">이벤트 정보가 추가되었습니다.[ base_path ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_event . " add (base_path            VARCHAR (255));");
				}

				// 게시판 정보 login_skin_name [ 3.22 이하 버전 사용자 ]
				$exist = fieldCheck($tb_event,'login_skin_name');
				if ( !$exist ) {
					echo '<font color="red">이벤트 정보가 추가되었습니다.[ login_skin_name ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_event . " add (login_skin_name      VARCHAR (40 )       NOT NULL);");
				}

				// 게시판 정보 use_default_login [ 3.22 이하 버전 사용자 ]
				$exist = fieldCheck($tb_event,'use_default_login');
				if ( !$exist ) {
					echo '<font color="red">이벤트 정보가 추가되었습니다.[ use_default_login ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_event . " add (use_default_login    CHAR    (1  )       DEFAULT 'Y');");
				}

				// 게시판 정보 reg_date [ 3.22 이하 버전 사용자 ]
				$exist = fieldCheck($tb_event,'reg_date');
				if ( !$exist ) {
					echo '<font color="red">이벤트 정보가 추가되었습니다.[ reg_date ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_event . " add (reg_date             CHAR    (14 )       NOT NULL);");
				}

				// 이벤트 항목 정보 o_seq
				$exist = fieldCheck($tb_event_item, 'o_seq'  );
				if ( !$exist ) {
					echo '<font color="red">이벤트 항목 정보 변경되었습니다. [ o_seq ] </font><BR>';
					simpleSQLExecute('alter table ' . $tb_event_item . " add (o_seq           INT     (4  ));");   /* 정렬 순서 */
				}
				// 이벤트 항목 정보 seq
				$exist = fieldCheck($tb_event_item, 'seq'  );
				if ( !$exist ) {
					echo '<font color="red">이벤트 항목 정보 변경되었습니다. [ seq ] </font><BR>';
					simpleSQLExecute('alter table ' . $tb_event_item . " add (seq             INT     (4  )       NOT NULL);");   /* 순번 */
				}
				if ( (float) $_dboard_ver_str <= 3.22 ) {
					if ( isTable($tb_event_item) ) {
						echo '<font color="red">이벤트 항목 테이블 정보 변경되었습니다. [ KEY 삭제 ] </font><BR>';
						simpleSQLExecute('alter table ' . $tb_event_item . " drop PRIMARY KEY;");   /* 정렬 순서 */
						echo '<font color="red">이벤트 항목 테이블 정보 변경되었습니다. [ KEY 생성 : no, g_no, seq ] </font><BR>';
						simpleSQLExecute('alter table ' . $tb_event_item . " add  PRIMARY KEY (no,g_no,seq);");   /* 정렬 순서 */
					}
				}
				if ( !isTable($tb_event) ) {
					echo '<font color="red">이벤트 정보 테이블이 생성되었습니다.</font><BR>';
					/* 이벤트 정보 */
					$tb_event_schm  = "CREATE  TABLE  $tb_event (";
					$tb_event_schm .= "    no                   INT     (10 )       NOT NULL    , /* 이벤트 번호             */";
					$tb_event_schm .= "    title                VARCHAR (255)       NOT NULL    , /* 이벤트 제목             */";
					$tb_event_schm .= "    display_mode         CHAR    (1  )       DEFAULT '1' , /* 이벤트 표시형식         */";
					$tb_event_schm .= "    title_limit          INT     (3  )       DEFAULT 30  , /* 제목글자제한 (자)       */";
					$tb_event_schm .= "    suc_url              VARCHAR (255)                   , /* 성공 이동 페이지        */";
					$tb_event_schm .= "    use_top              CHAR    (1  )       DEFAULT 'N' , /* 항상 최근 이벤트로 설정 */";
					$tb_event_schm .= "    start_date           CHAR    (14 )                   , /* 이벤트 시작일           */";
					$tb_event_schm .= "    end_date             CHAR    (14 )                   , /* 이벤트 종료일           */";
					$tb_event_schm .= "    window_width         INT     (4  )                   , /* 이벤트 창 높이          */";
					$tb_event_schm .= "    window_height        INT     (4  )                   , /* 이벤트 창 넓이          */";
					$tb_event_schm .= "    left_pos             INT     (4  )                   , /* 이벤트 창 X 좌표        */";
					$tb_event_schm .= "    top_pos              INT     (4  )                   , /* 이벤트 창 Y 좌표        */";
					$tb_event_schm .= "    scroll_yn            CHAR    (1  )       DEFAULT 'Y' , /* 팝업 스크롤 여부        */";
					$tb_event_schm .= "    base_path            VARCHAR (255)                   , /* 기반 디렉토리           */";
					$tb_event_schm .= "    login_skin_name      VARCHAR (40 )       NOT NULL    , /* 로그인 스킨 명          */";
					$tb_event_schm .= "    use_default_login    CHAR    (1  )       DEFAULT 'Y' , /* 기본 로그인 사용여부    */";
					$tb_event_schm .= "    reg_date             CHAR    (14 )       NOT NULL    , /* 이벤트 생성 일자        */";
					$tb_event_schm .= "    primary key (no)";
					$tb_event_schm .= ") ;";
					simpleSQLExecute($tb_event_schm);   /* 이벤트 정보 */
				}

				$tb_event_grant  = 'kyh_event_grant'  ; /* 이벤트 권한          */
				if ( !isTable($tb_event_grant) ) {
					echo '<font color="red">이벤트 권한 테이블이 생성되었습니다.</font><BR>';
					/* 이벤트 권한 */
						$tb_event_grant_schm  = "CREATE  TABLE  $tb_event_grant (";
						$tb_event_grant_schm .= "    no              INT     (10 )       NOT NULL    , /* 이벤트 번호    */";
						$tb_event_grant_schm .= "    member_level    INT     (2  )       NOT NULL    , /* 회원 레벨      */";
						$tb_event_grant_schm .= "    grant_join      CHAR    (1  )                   , /* 참가           */";
						$tb_event_grant_schm .= "    join_point      INT     (10 )                   , /* 포인트 점수    */";
						$tb_event_grant_schm .= "    primary key (no ,member_level)";
						$tb_event_grant_schm .= ") ;";
					simpleSQLExecute($tb_event_grant_schm);   /* 이벤트 권한 */
				}

				if ( !isTable($tb_event_item) ) {
					echo '<font color="red">이벤트 항목 테이블이 생성되었습니다.</font><BR>';
					/* 이벤트 항목 */
					$tb_event_item_schm  = "CREATE  TABLE  $tb_event_item(";
					$tb_event_item_schm .= "    no              INT     (10 )       NOT NULL    , /* 이벤트 번호        */";
					$tb_event_item_schm .= "    g_no            INT     (4  )       NOT NULL    , /* 이벤트 그룹 번호   */";
					$tb_event_item_schm .= "    seq             INT     (4  )       NOT NULL    , /* 항목 순번          */";
					$tb_event_item_schm .= "    o_seq           INT     (4  )                   , /* 정렬 순서          */";
					$tb_event_item_schm .= "    item            CHAR    (1  )                   , /* 항목명 구분        */";
					$tb_event_item_schm .= "    item_name       VARCHAR (255)                   , /* 항목 명            */";
					$tb_event_item_schm .= "    primary key (no, g_no, seq)";
					$tb_event_item_schm .= ") ;";
					simpleSQLExecute($tb_event_item_schm);   /* 이벤트 항목 */
				}

				$tb_event_result_master = "kyh_event_result_master"; /* 이벤트 결과 메인 */
				if ( !isTable($tb_event_result_master) ) {
					echo '<font color="red">이벤트 결과 메인 테이블이 생성되었습니다.</font><BR>';
					/* 이벤트 결과 메인 */
					$tb_event_result_master_schm  = "CREATE  TABLE  $tb_event_result_master(";
					$tb_event_result_master_schm .= "    no              INT     (10 )       NOT NULL    , /* 이벤트 번호    */";
					$tb_event_result_master_schm .= "    user_id         VARCHAR (20 )       NOT NULL    , /* 사용자 ID      */";
					$tb_event_result_master_schm .= "    prize_yn        CHAR    (1  )                   , /* 당첨 여부      */";
					$tb_event_result_master_schm .= "    prize_point     INT     (10 )                   , /* 당첨 포인트    */";
					$tb_event_result_master_schm .= "    join_date       CHAR    (14 )       NOT NULL    , /* 참가 일자      */";
					$tb_event_result_master_schm .= "    primary key (no ,user_id )";
					$tb_event_result_master_schm .= ") ;";
					simpleSQLExecute($tb_event_result_master_schm);   /* 이벤트 결과 메인 */
				}

				$tb_event_result_detail = "kyh_event_result_detail"; /* 이벤트 결과 상세 */
				if ( !isTable($tb_event_result_detail) ) {
					echo '<font color="red">이벤트 결과 상세 테이블이 생성되었습니다.</font><BR>';
					/* 이벤트 결과 상세 */
					$tb_event_result_detail_schm  = "CREATE  TABLE  $tb_event_result_detail(";
					$tb_event_result_detail_schm .= "    no              INT     (10 )       NOT NULL    , /* 이벤트 번호       */";
					$tb_event_result_detail_schm .= "    user_id         VARCHAR (20 )       NOT NULL    , /* 사용자 ID         */";
					$tb_event_result_detail_schm .= "    g_no            INT     (4  )       NOT NULL    , /* 이벤트 그룹 번호  */";
					$tb_event_result_detail_schm .= "    key_seq         INT     (4  )       NOT NULL    , /* 순번              */";
					$tb_event_result_detail_schm .= "    choice_data     TEXT                            , /* 선택된 값         */";
					$tb_event_result_detail_schm .= "    primary key (no, user_id, g_no, key_seq)";
					$tb_event_result_detail_schm .= ") ;";
					simpleSQLExecute($tb_event_result_detail_schm);   /* 이벤트 결과 메인 */
				}

				$tb_login_abstract = "kyh_login_abstract"; /* 로그인 추출 */
				if ( !isTable($tb_login_abstract) ) {
					echo '<font color="red">로그인 추출 테이블이 생성되었습니다.</font><BR>';
					/* 로그인 추출 */
					$tb_login_abstract_schm  = "CREATE  TABLE  $tb_login_abstract (";
					$tb_login_abstract_schm .= "    skin_no          INT     (10)                    , /* 스킨 번호         */";
					$tb_login_abstract_schm .= "    skin_name        VARCHAR (40)    NOT NULL        , /* 스킨 명           */";
					$tb_login_abstract_schm .= "    display_mode     CHAR    (1)     DEFAULT '1'     , /* 화면 형식         */";
					$tb_login_abstract_schm .= "    window_width     INT     (4  )                   , /* 팝업 창 높이      */";
					$tb_login_abstract_schm .= "    window_height    INT     (4  )                   , /* 팝업 창 넓이      */";
					$tb_login_abstract_schm .= "    left_pos         INT     (4  )                   , /* 팝업 창 X 좌표    */";
					$tb_login_abstract_schm .= "    top_pos          INT     (4  )                   , /* 팝업 창 Y 좌표    */";
					$tb_login_abstract_schm .= "    scroll_yn        CHAR    (1)     DEFAULT 'Y'     , /* 팝업 스크롤 여부  */";
					$tb_login_abstract_schm .= "    suc_mode         CHAR    (1)     DEFAULT '1'     , /* 성공 실행 형태    */";
					$tb_login_abstract_schm .= "    suc_url          VARCHAR (255)                   , /* 성공 이동 페이지  */";
					$tb_login_abstract_schm .= "    message          VARCHAR (255)                   , /* 알림상자 메세지   */";
					$tb_login_abstract_schm .= "    base_path        VARCHAR (255)                   , /* 기반 디렉토리     */";
					$tb_login_abstract_schm .= "    upd_date         CHAR    (14)    NOT NULL          /* 생성 일자         */";
					$tb_login_abstract_schm .= ") ;";
					simpleSQLExecute($tb_login_abstract_schm);   /* 로그인 추출 */
					$sql  = "insert into $tb_login_abstract ( skin_no, skin_name, display_mode, window_width, window_height, left_pos, top_pos, scroll_yn, suc_mode, suc_url, message, base_path, upd_date ) values ( ";
					$sql .= "'0', 'dlogin_standard', '1', '800', '600', '0', '0', 'Y', '1', '', '', '', '' );";
					simpleSQLExecute($sql);   /* 로그인 추출 입력 */
				}

				if ( @is_dir ( 'skin/out_login' ) ) {
					@rename ( 'skin/out_login', 'skin/login' );
					echo '<font color="red">로그인 스킨 디렉토리명이 변경되었습니다. out_login ==> login</font><BR>';
				}

				if ( @is_file ( 'doutlogin.php' ) ) {
					@rename ( 'doutlogin.php', 'dlogin.php' );
					echo '<font color="red">로그인 프로그램명이 변경되었습니다. doutlogin.php ==> dlogin.php</font><BR>';
				}

				if ( @is_file ( 'common/outlogin_setup_default.inc' ) ) {
					@rename ( 'common/outlogin_setup_default.inc', 'common/login_setup_default.inc' );
					echo '<font color="red">로그인 셋업 프로그램명이 변경되었습니다. outlogin_setup_default.inc ==> login_setup_default.inc</font><BR>';
				}

				$f=@file($baseDir . "config.php");
				$driver     = trim(str_replace("\n","",$f[1]));
				$host_nm    = trim(str_replace("\n","",$f[2]));
				$db_nm      = trim(str_replace("\n","",$f[3]));
				$id         = trim(str_replace("\n","",$f[4]));
				$password   = trim(str_replace("\n","",$f[5]));
				$base_dir   = trim(str_replace("\n","",$f[6]));
				$setup_dir  = trim(str_replace("\n","",$f[7]));
				$login_skin = 'dlogin_standard';
				if ( $f[8] == "?>" ) {
					echo '<font color="red">구성 설정이 추가되었습니다. config.php <<== dlogin_standard</font><BR>';
					/* 데이터베이스 설정 정보 수집 */
					$setupInfor  = "<?\n";
					$setupInfor .= $driver      . "\n"; // 드라이버
					$setupInfor .= $host_nm     . "\n"; // host 명
					$setupInfor .= $db_nm       . "\n"; // db 명
					$setupInfor .= $id          . "\n"; // 사용자 아이디
					$setupInfor .= $password    . "\n"; // 사용자 비밀번호
					$setupInfor .= $base_dir    . "\n"; // 기반 디렉토리
					$setupInfor .= $setup_dir   . "\n"; // 설치 루트
					$setupInfor .= $login_skin  . "\n"; // 내부 스킨
					$setupInfor .= "?>";
					$fp = @fopen ( "config.php", "w") Or MessageExit('U', '0006',"");
					fwrite ( $fp, $setupInfor,strlen($setupInfor) );
					@chmod("config.php"     ,0707);
				}

				// 게시판 정보 login_skin_name [ 3.22 이하 버전 사용자 ]
				$exist = fieldCheck($tb_bbs_infor,'login_skin_name');
				if ( !$exist ) {
					echo '<font color="red">게시판 정보가 (로그인스킨) 추가되었습니다.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_bbs_infor . " add (login_skin_name VARCHAR (40)    NOT NULL );");   /* 로그인 스킨 정보 */
				}

				// 게시판 정보 use_default_login [ 3.22 이하 버전 사용자 ]
				$exist = fieldCheck($tb_bbs_infor,'use_default_login');
				if ( !$exist ) {
					echo '<font color="red">게시판 정보가 (기본 로그인 사용) 추가되었습니다.</font><BR>';
					simpleSQLExecute('alter table ' . $tb_bbs_infor . " add (use_default_login CHAR    (1)     DEFAULT 'Y' );");   /* 기본 로그인 사용여부 */
				}

			}
/* 3.22 이하 ------------------------------------------------ 끝 */

/* 3.38 이하 ------------------------------------------------ 시작 */
			if ( (float) $_dboard_ver_str <= 3.38 ) {
				$exist = fieldCheck($tb_member, 'birth');
				if ( !$exist ) {
					echo '<font color="red">회원 정보가 변경되었습니다.[ birth ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (birth                VARCHAR (14));");   /* 생년월일   */
				}

				$exist = fieldCheck($tb_member, 'age');
				if ( !$exist ) {
					echo '<font color="red">회원 정보가 변경되었습니다.[ age ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (age                  INT     (3 ));");   /* 나이       */
				}

				$exist = fieldCheck($tb_member, 'birth_open');
				if ( !$exist ) {
					echo '<font color="red">회원 정보가 변경되었습니다.[ birth_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (birth_open           CHAR    (1 )    DEFAULT 'N' NOT NULL);");   /* 생년월일   공개 : 'Y' , 공개안함 : 'N' */
				}

				$exist = fieldCheck($tb_member, 'age_open');
				if ( !$exist ) {
					echo '<font color="red">회원 정보가 변경되었습니다.[ age_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (age_open           CHAR    (1 )    DEFAULT 'N' NOT NULL);");   /* 나이       공개 : 'Y' , 공개안함 : 'N' */
				}

				$exist = fieldCheck($tb_member_config, 'birth');
				if ( !$exist ) {
					echo '<font color="red">회원 가입폼 정보가 변경되었습니다.[ birth ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_config . " add (birth               CHAR    (1)     DEFAULT 'Y' NOT NULL);");   /* 생년월일 표시      */
				}

				$exist = fieldCheck($tb_member_config, 'age');
				if ( !$exist ) {
					echo '<font color="red">회원 가입폼 정보가 변경되었습니다.[ age ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_config . " add (age               CHAR    (1)     DEFAULT 'Y' NOT NULL);");   /* 나이     표시      */
				}

				$exist = fieldCheck($tb_member_config, 'hint');
				if ( !$exist ) {
					echo '<font color="red">회원 가입폼 정보가 변경되었습니다.[ hint ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_config . " add (hint                CHAR    (1)     DEFAULT  'Y');");   /* 힌트 표시 */
				}

				$exist = fieldCheck($tb_member, 'access');
				if ( !$exist ) {
					echo '<font color="red">회원 정보가 변경되었습니다.[ access ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (access               INT     (10)    DEFAULT 0);");   /* 접속 횟수 */
				}

				$exist = fieldCheck($tb_member, 'access_open');
				if ( !$exist ) {
					echo '<font color="red">회원 정보가 변경되었습니다.[ access_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (access_open          CHAR    (1 )    DEFAULT 'Y' NOT NULL);");   /* 접속수     공개 : 'Y' , 공개안함 : 'N' */
				}

				$exist = fieldCheck($tb_member, 'hint');
				if ( !$exist ) {
					echo '<font color="red">회원 정보가 변경되었습니다.[ hint ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (hint                 INT     (3 ));");   /* 힌트        */
				}

				$exist = fieldCheck($tb_member, 'answer');
				if ( !$exist ) {
					echo '<font color="red">회원 정보가 변경되었습니다.[ answer ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (answer               VARCHAR (255));");   /* 답          */
				}
			}
/* 3.38 이하 ------------------------------------------------ 끝 */

/* 3.41 이하 ------------------------------------------------ 시작 */
			if ( (float) $_dboard_ver_str <= 3.41 ) {
				$tb_dic_member_statistic  = 'kyh_dic_member_statistic'  ; /* 회원 통계 */
					if ( !isTable($tb_dic_member_statistic) ) {
						echo '<font color="red">총 회원수 테이블이 생성되었습니다.</font><BR>';
                        $tb_dic_member_statistic_schm  = "CREATE TABLE $tb_dic_member_statistic ( ";
                        $tb_dic_member_statistic_schm .= "    cnt INT     (10) /* 총 회원수 */";
                        $tb_dic_member_statistic_schm .= ");";
						simpleSQLExecute($tb_dic_member_statistic_schm); /* 회원 통계 */
						simpleSQLExecute("insert into $tb_dic_member_statistic ( cnt ) values ( 0 );"); /* 총 회원수 초기화 */
					}

				if ( !is_dir ( "./data/tmp" ) ) {
					@mkdir("./data/tmp"    ,0707);
					@chmod("./data/tmp"    ,0707);
					echo '<font color="red">임시 디렉토리가 생성 되었습니다.[ /data/tmp ]</font><BR>';
				}

				$exist = fieldCheck($tb_member, 'nick_name');
				if ( !$exist ) {
					echo '<font color="red">회원 정보가 변경되었습니다.[ nick_name ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (nick_name  VARCHAR (20));");   /* 별명       */
				}

				$exist = fieldCheck($tb_member, 'nick_name_open');
				if ( !$exist ) {
					echo '<font color="red">회원 정보가 변경되었습니다.[ nick_name_open ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member . " add (nick_name_open          CHAR    (1 )    DEFAULT 'Y' NOT NULL);");   /* 별명   공개 : 'Y' , 공개안함 : 'N' */
				}

				$exist = fieldCheck($tb_member_config, 'nick_name');
				if ( !$exist ) {
					echo '<font color="red">회원 가입폼 정보가 변경되었습니다.[ nick_name ]</font><BR>';
					simpleSQLExecute('alter table ' . $tb_member_config . " add (nick_name          CHAR    (1)     DEFAULT 'Y' NOT NULL);");   /* 별명 표시      */
				}
            }
/* 3.41 이하 ------------------------------------------------ 끝 */

/* 게시판 정보 순환 루프 --------------------------------------------------------- 시작*/
			$sql = "select no, bbs_id from $tb_bbs_infor;";
			$stmt = multiRowSQLQuery($sql);
			while ( $row = multiRowFetch  ($stmt) ) {
	/* 1.01 이하 ------------------------------------------------ 시작 */
				if ( (float) $_dboard_ver_str <= 1.01 ) {
					// f_path1
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'f_path1');
					if ( !$exist ) {
						echo '<font color="red">게시판 정보가 (파일 실제 경로1) 추가 되었습니다.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (f_path1 VARCHAR (255));");   /* 파일 실제 경로1 */
					}
					// f_name1
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'f_name1');
					if ( !$exist ) {
						echo '<font color="red">게시판 정보가 (실제 파일 명1) 추가 되었습니다.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (f_name1 VARCHAR (255));");   /* 실제 파일 명1 */
					}
					// f_ext1
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'f_ext1');
					if ( !$exist ) {
						echo '<font color="red">게시판 정보가 (파일 확장자1) 추가 되었습니다.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (f_ext1 VARCHAR (10));");   /* 파일 확장자1     */
					}

					// f_size1
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'f_size1');
					if ( !$exist ) {
						echo '<font color="red">게시판 정보가 (파일 크기1) 추가 되었습니다.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (f_size1 VARCHAR (10));");   /* 파일 크기1      */
					}
					// f_date1
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'f_date1');
					if ( !$exist ) {
						echo '<font color="red">게시판 정보가 (저장 파일명1) 추가 되었습니다.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (f_date1 VARCHAR (10));");   /* 저장 파일명1    */
					}
					// f_path2
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'f_path2');
					if ( !$exist ) {
						echo '<font color="red">게시판 정보가 (파일 실제 경로2) 추가 되었습니다.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (f_path2 VARCHAR (255));");   /* 파일 실제 경로2 */
					}

					// f_name2
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'f_name2');
					if ( !$exist ) {
						echo '<font color="red">게시판 정보가 (실제 파일 명2) 추가 되었습니다.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (f_name2 VARCHAR (255));");   /* 실제 파일 명2 */
					}

					// f_ext2
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'f_ext2');
					if ( !$exist ) {
						echo '<font color="red">게시판 정보가 (파일 확장자2) 추가 되었습니다.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (f_ext2 VARCHAR (10));");   /* 파일 확장자2     */
					}

					// f_size2
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'f_size2');
					if ( !$exist ) {
						echo '<font color="red">게시판 정보가 (파일 크기2) 추가 되었습니다.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (f_size2 VARCHAR (10));");   /* 파일 크기2      */
					}

					// f_date2
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'f_date2');
					if ( !$exist ) {
						echo '<font color="red">게시판 정보가 (저장 파일명2) 추가 되었습니다.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (f_date2 VARCHAR (10));");   /* 저장 파일명2    */
					}

					// down_hit1
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'down_hit1');
					if ( !$exist ) {
						echo '<font color="red">게시판 정보가 (다운로드수1) 추가 되었습니다.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (down_hit1 INT (6) DEFAULT 0);");   /* 다운로드수1    */
					}

					// down_hit2 [ 1.01 이하 버전 사용자 ]
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'],'down_hit2');
					if ( !$exist ) {
						echo '<font color="red">게시판 정보가 (다운로드수2) 추가 되었습니다.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add (down_hit2 INT (6) DEFAULT 0);");   /* 다운로드수2    */
					}
				}
	/* 1.01 이하 ------------------------------------------------ 끝 */

	/* 2.09 이하 ------------------------------------------------ 시작 */
				if ( (float) $_dboard_ver_str <= 2.09 ) {
					// cat_no
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'], 'cat_no');
					if ( !$exist ) {
						echo '<font color="red">게시판 정보가 (카테고리) 추가 되었습니다.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add ( cat_no INT (4) );");   /* 카테고리 정보 */
					}

					if ( !isTable($tb_bbs_category . "_" . $row['bbs_id']) ) {
						echo '<font color="red">게시판 카테고리 테이블이 생성되었습니다.</font><BR>';
						$tb_bbs_category_schm  = "CREATE TABLE $tb_bbs_category" . "_" . $row['bbs_id'] . "(";
						$tb_bbs_category_schm .= "    no                   INT         (4 )        NOT NULL    , /* 카테고리 번호      */";
						$tb_bbs_category_schm .= "    o_seq                INT         (4)                     , /* 정렬 순서          */";
						$tb_bbs_category_schm .= "    name                 VARCHAR     (255)                   , /* 상단 파일 경로     */";
						$tb_bbs_category_schm .= "    etc                  VARCHAR     (255)                   , /* 비고               */";
						$tb_bbs_category_schm .= "    primary key (no )";
						$tb_bbs_category_schm .= ") ;";
						simpleSQLExecute($tb_bbs_category_schm);   /* 카테고리 정보 */
					}
				}
	/* 2.09 이하 ------------------------------------------------ 끝 */

	/* 3.01 이하 ------------------------------------------------ 시작 */
				if ( (float) $_dboard_ver_str <= 3.01 ) {
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'], 'member_level');
					if ( !$exist ) {
						$boardMemberLevelUpdate = false; // 한번이라도 들어가면 3.01 이하 버전
						echo $row['bbs_id'] . ' <font color="red">게시판 정보가 (회원레벨) 추가 되었습니다. [ member_level ] </font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add ( member_level        INT     (2)     NOT NULL default 0 );");   /* 회원 레벨          */
					} else {
						$boardMemberLevelUpdate = true ; // 한번이라도 들어가면 3.01 이하 버전
					}
					// 게시판 포인트 정보 테이블
					$stmt_kind = multiRowSQLQuery("select member_level, member_nm from $tb_member_kind;");
					while ( $row_kind = multiRowFetch  ($stmt_kind) ) {
						$memberLevel = $row_kind['member_level'];
						$memberNm    = $row_kind['member_nm'   ];
						$exist = simpleSQLQuery("select count(no) from $tb_bbs_grant where no = " . $row['no'] . " and member_level = '$memberLevel'");
						if ( !$exist ) {
							$sql  = "insert into $tb_bbs_grant ( no, bbs_id, member_level, grant_list, grant_view, grant_write, grant_answer, grant_comment, grant_down ) ";
							if ( $memberLevel == 0 || $memberLevel == 1 || $memberLevel == 99 ) { // [ 기본 회원 종류 ] 비회원, 일반회원, 관리자
								$sql .= "values (" . $row['no'] . ", '$bbs_id', $memberLevel, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y');";
							} else {
								/* ---- 목록권한 읽기권한 쓰기권한 답글권한 의견글권한 다운권한 ---- */
								$sql .= "values (" . $row['no'] . ", '$bbs_id', $memberLevel, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y');";
							}
							simpleSQLExecute($sql);
						}

						if ( $memberLevel > 0 ) { // 비회원이 아니면.
							// 참고
							// $pointInfor = array("","게시물 작성", "의견글 작성", "파일 업로드", "다운로드", "답글작성");
							$existChk = true;
							for ( $i=1; $i <= 5;$i++) {
								$chkSql  = "select count(no) from $tb_point_infor ";
								$chkSql .= " where  no           = '" . $i             . "'";
								$chkSql .= " and    bbs_id       = '" . $row['bbs_id'] . "'";
								$chkSql .= " and    member_level = '" . $memberLevel   . "'";
								$existChk = simpleSQLQuery($chkSql);
								if ( !$existChk ) {
									/* 포인트 정보     */
									$sql  = "insert into $tb_point_infor ( ";
									$sql .= " no, bbs_id, member_level, use_st, point, etc, reg_date";
									$sql .= " ) values ( ";
									$sql .= "'" . $i                . "',";
									$sql .= "'" . $row['bbs_id']    . "',";
									$sql .= "'" . $memberLevel      . "',";
									$sql .= "'1'                        ,"; // 사용 : 1, 미사용 : 2
									$sql .= " 1                         ,"; // 포인트
									$sql .= "''                         ,";
									$sql .= "'" . getYearToSecond() . "'" ;
									$sql .= ");";
									simpleSQLExecute($sql);
								}
							}
							if ( !$existChk ) {
								echo '<font color="black">' . $row['bbs_id'] .' 게시판 ' . $memberNm . ' 포인트 정보가 생성되었습니다..</font><BR>';
							}
						}
					}
					// 게시판데이터 테이블 회원 레벨 반영
					if ( !$boardMemberLevelUpdate ) {
						$sql = "select distinct user_id from $tb_bbs_data" . "_" . $row['bbs_id'];
						$bbs_data_stmt = multiRowSQLQuery($sql);
						while ( $bbs_data_row = multiRowFetch  ($bbs_data_stmt) ) {
							$sql_member = "select member_level from $tb_member where user_id = '" . $bbs_data_row['user_id'] . "'" ;
							$memberLevel = simpleSQLQuery($sql_member);
							if ( $bbs_data_row['user_id'] ) {
								$updateSql  = "update kyh_bbs_data_" . $row['bbs_id'];
								$updateSql .= " set member_level = '" . $memberLevel . "'";
								$updateSql .= " where user_id = '" . $bbs_data_row['user_id'] . "';";
								simpleSQLExecute($updateSql);
							}
						}
						echo '<font color="black">' . $row['bbs_id'] .' 게시판 회원 레벨이 갱신되었습니다.</font><BR>';
					}
				}
	/* 3.01 이하 ------------------------------------------------ 끝 */

	/* 3.38 이하 ------------------------------------------------ 시작 */
				if ( (float) $_dboard_ver_str <= 3.38 ) {
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'], 'link1');
					if ( !$exist ) {
						$boardMemberLevelUpdate = false; // 한번이라도 들어가면 3.38 이하 버전
						echo $row['bbs_id'] . ' <font color="red">게시판 정보가 (링크1) 추가 되었습니다. [ link1 ] </font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add ( link1               VARCHAR (255));");   /* 링크1 */
					}
					$exist = fieldCheck($tb_bbs_data . '_' . $row['bbs_id'], 'link2');
					if ( !$exist ) {
						$boardMemberLevelUpdate = false;
						echo $row['bbs_id'] . ' <font color="red">게시판 정보가 (링크1) 추가 되었습니다. [ link2 ] </font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_data . '_' . $row['bbs_id'] . " add ( link2               VARCHAR (255));");   /* 링크2 */
					}
					$exist = simpleSQLQuery("select count(*) from " . $tb_bbs_data . '_' . $row['bbs_id'] . " where g_no > 0;");
					if ( $exist ) {
						simpleSQLExecute('update ' . $tb_bbs_data . '_' . $row['bbs_id'] . " set g_no = concat('-',g_no) where g_no > 0;");
						echo $row['bbs_id'] . ' <font color="red">게시판 정보가 갱신 되었습니다. [ g_no ] </font><BR>';
					}
					$exist = simpleSQLQuery("select count(*) from " . $tb_bbs_data . '_' . $row['bbs_id'] . " where use_st = 0 and g_no > -2147480000;");
					if ( $exist ) {
						simpleSQLExecute('update ' . $tb_bbs_data . '_' . $row['bbs_id'] . " set g_no = -2147480000 where use_st = 0;");
						echo $row['bbs_id'] . ' <font color="red">게시판 정보가 갱신 되었습니다. [ use_st ] </font><BR>';
					}
                    $exist = indexCheck($tb_bbs_data . '_' . $row['bbs_id'], 'idx_bbsd_0');
                    if ( $exist ) {
                        simpleSQLExecute("drop index idx_bbsd_0 on " . $tb_bbs_data . '_' . $row['bbs_id'] . ";" );
                        echo $row['bbs_id'] . ' <font color="red">게시판 구조 갱신 되었습니다. [ drop idx_bbsd_0 ] </font><BR>';
                    }
                    $exist = indexCheck($tb_bbs_data . '_' . $row['bbs_id'], 'idx_bbsd_2');
                    if ( $exist ) {
                        simpleSQLExecute("drop index idx_bbsd_2 on " . $tb_bbs_data . '_' . $row['bbs_id'] . ";" );
                        echo $row['bbs_id'] . ' <font color="red">게시판 구조 갱신 되었습니다. [ drop idx_bbsd_2 ] </font><BR>';
                    }
                    $exist = indexCheck($tb_bbs_data . '_' . $row['bbs_id'], 'idx_bbsd_0');
                    if ( !$exist ) {
                        simpleSQLExecute("create index idx_bbsd_0 on " . $tb_bbs_data . '_' . $row['bbs_id'] . "(g_no, o_seq);" );
                        echo $row['bbs_id'] . ' <font color="red">게시판 구조 갱신 되었습니다. [ create idx_bbsd_0 ] </font><BR>';
                    }
                    $exist = indexCheck($tb_bbs_data . '_' . $row['bbs_id'], 'idx_bbsd_2');
                    if ( !$exist ) {
                        simpleSQLExecute("create index idx_bbsd_2 on " . $tb_bbs_data . '_' . $row['bbs_id'] . "(cat_no);" );
                        echo $row['bbs_id'] . ' <font color="red">게시판 구조 갱신 되었습니다. [ create idx_bbsd_2 ] </font><BR>';
                    }
                }
	/* 3.38 이하 ------------------------------------------------ 끝 */

	/* 3.40 이하 ------------------------------------------------ 시작 */
				if ( (float) $_dboard_ver_str <= 3.40 ) {
					@mkdir("./files"     ,0707);
					@chmod("./files"     ,0707);
					if ( !@is_file ('files/' . $row['bbs_id'] . '.php') ) {
						$filesData  = "<?\n";
						$filesData .= '$baseDir = "../";' . "\n";
						$filesData .= '$id = \'' . $row['bbs_id'] . '\';' . "\n";
						$filesData .= 'include $baseDir . "dboard.php"' . "\n";
						$filesData .= "?>";
						$fp = @fopen ( 'files/' . $row['bbs_id'] . '.php', 'w');
						fwrite ( $fp, $filesData,strlen($filesData) );
						@chmod('files/' . $row['bbs_id'] . '.php',0707);

						echo '<font color="red">files/' . $row['bbs_id'] . '.php' . ' 파일이 생성 되었습니다.</font><BR>';
					}
					// design_method
					$exist = fieldCheck($tb_bbs_infor,'design_method');
					if ( !$exist ) {
						echo '<font color="red">게시판 정보가 (디자인 방식) 추가 되었습니다.</font><BR>';
						simpleSQLExecute('alter table ' . $tb_bbs_infor . " add (design_method            CHAR    (1)     DEFAULT '1');");   /* 디자인 방식 */
					}
				}
	/* 3.40 이하 ------------------------------------------------ 끝 */
            }
/* 게시판 정보 순환 루프 --------------------------------------------------------- 시작*/

            echo '<BR><B><font color="black">완료되었습니다.</font></B><BR><BR>';
            echo '<B><font color="red"><font color="black">dboard_patch.php</font> 파일을 꼭 삭제해주세요.</font></B>';
            closeDBConnection (); // 데이터베이스 연결 설정 해제
        } else {
            echo "<FORM METHOD=POST ACTION='' onSubmit='return setupForm_Sumbit();'>
            <input type='hidden' name='execute_yn' value='Y'>
            <input type='submit' value='누적 패치 시작'>
            </FORM>
            <img id='progress_bar' style='visibility:hidden;position:absolute;left:0px;top:0px;z-index:1' src='images/install_progress.gif'>
            <script type='text/javascript'>
            <!--
            var doubleTrans = false; // 두번 폼이 전송되지 않도록 처리.

                function setupForm_Sumbit() {
                    if ( doubleTrans ) return false;
                    else doubleTrans = true;
                    return true;
                }
            //-->
            </SCRIPT>
            ";
        }
    } else {
        echo '<a href="admin.php?succ_url=category_install.php">관리자로 로그인하신후 실행해주세요.</a>';
    }
}
?>