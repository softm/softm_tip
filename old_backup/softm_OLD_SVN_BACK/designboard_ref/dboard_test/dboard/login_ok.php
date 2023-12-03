<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
include 'common/lib.inc'       ; // 공통 라이브러리
include 'common/member_lib.inc'; // 멤버 라이브러리
include 'common/message.inc'   ; // 에러 페이지 처리
include 'common/db_connect.inc'; // Data Base 연결 클래스
include 'common/member.inc'    ; // 회원 클래스 처리
if (!$config) {
    MessageHead('P', '0002', 'MOVE:setup.php:설정 페이지');
}

if ( preg_match( "/((admin){1}(\_)?){1}(setup|poll|member|board|event)?.php/", $HTTP_REFERER) ) {
    $retunPage ="admin_setup.php";
    $pageLevel = 99; // 관리자      페이지에서 접근
} else {
    $retunPage = getUrlPath ($HTTP_REFERER) . getReqPageName ($HTTP_REFERER);
    $pageLevel = 1;  // 일반 사용자 페이지에서 접근
}
head($_title);
css();
body();
if ( preg_match("/${HTTP_HOST}/",$HTTP_REFERER) && $REQUEST_METHOD == 'POST' && $pageLevel > 0 ) {
    // 데이터베이스에 접속합니다.
    $db = initDBConnection ();
//     ini_set("display_errors", 1);
//    echo strlen($password);
    $loginCorrect = false;
    $mb_db_password = simpleSQLQuery("select password from $tb_member where user_id = '" . addslashes($user_id) . "';");
	$isPatched = true;
    if ( simpleSQLQuery("SELECT VERSION()") >= 4.1 ) {
        $mb_old_password = @sql_old_password($password);
        if( strlen($mb_db_password) == 16 && $mb_old_password == $mb_db_password ) {
            $new_password = sql_password($password);
            $loginCorrect = true;
            $columnType = getColumnType($tb_member, 'password');
            if ( $columnType == 'varchar(41)' ) {
                simpleSQLExecute("update {$tb_member} set password = PASSWORD('".addslashes($password)."') where user_id = '" . addslashes($user_id) . "'");
            } else {
            	$isPatched = false;
            }
            //echo PATCH_VERSION . " / " . $mb_db_password . " / " . $mb_old_password . " / " . sql_password($password);
        }
    }

    if ( !$loginCorrect ) {
    	$sql  = "select count(user_id) from $tb_member where user_id = '" . addslashes($user_id) . "' and password = PASSWORD('" . addslashes($password) . "');";
    	$loginCorrect = simpleSQLQuery($sql);
    }
    $login_skin_name = getUrlParamValue($HTTP_REFERER, 'login_skin_name');
    $referer_yn = 'N'; // 리퍼러에 $login_skin_name이 존재
    if ( $login_skin_name ) {
        $referer_yn = 'Y';
        $loginSkinDir= 'skin/login/' . $login_skin_name . '/';
    } else {
        $login_skin_name = $_POST ['login_skin_name'];
        if ( $login_skin_name ) {
            $loginSkinDir= 'skin/login/' . $login_skin_name . '/';
        } else {
            $loginSkinDir= '';
        }
    }
    if ( $loginCorrect ) {
        $sql  = "select * from $tb_member where user_id = '" . addslashes($user_id) . "';";
        $result = singleRowSQLQuery($sql);

        if ( $pageLevel <= $result['member_level'] ) { // 관리자 페이지를 통한 로그인
        	// go admin_setup.php - patched
        	if ( !$isPatched && $result['member_level'] == 99 ) {
        		$retunPage ="admin_setup.php";
        	}
            if ( $result['member_st'   ] == 1 ) { // 사용 상태
                $_s_memInfor['login_yn'    ] = 'Y';

                if ( $result['member_level'] == 99 ) {
                    include 'common/file.inc'; // 파일 처리
                    $filePath = "data/tmp";
                    if ( @is_dir ($filePath) ) f_rmAllFile($filePath); // 임시 파일 내용 삭제
                    $_s_memInfor['admin_yn'    ] = 'Y';
                } else {
                    $_s_memInfor['admin_yn'    ] = 'N';
                }

                $_s_memInfor['user_id'     ] = $result['user_id'     ];
                $_s_memInfor['member_level'] = $result['member_level'];
                $_s_memInfor['name'        ] = $result['name'        ];
                $_s_memInfor['e_mail'      ] = $result['e_mail'      ];
                $_s_memInfor['home'        ] = $result['home'        ];
                $_s_memInfor['member_st'   ] = $result['member_st'   ];
                $_s_memInfor['reg_date'    ] = $result['reg_date'    ];
                $_s_memInfor['news_yn'     ] = $result['news_yn'     ];
                $_s_memInfor['access'      ] = $result['access'      ] + 1;

                $_s_memInfor['table_no'        ] = $result['table_no'         ]; // 목표 사용 테이블 번호
                $_s_memInfor['last_mission_ym' ] = $result['last_mission_ym'  ]; // 마지막 평가한 년도
                $_s_memInfor['last_forward_ym' ] = $result['last_forward_ym'  ]; // 자기사명,인생,단기목표 마지막 이월 시간

                $id         = ( getUrlParamValue($HTTP_REFERER, 'id'        ) ) ? getUrlParamValue($HTTP_REFERER, 'id'          ) : $id         ;
                $poll_id    = ( getUrlParamValue($HTTP_REFERER, 'poll_id'   ) ) ? getUrlParamValue($HTTP_REFERER, 'poll_id'     ) : $poll_id    ;
                $event_id   = ( getUrlParamValue($HTTP_REFERER, 'event_id'  ) ) ? getUrlParamValue($HTTP_REFERER, 'event_id'    ) : $event_id   ;
                $exec       = ( getUrlParamValue($HTTP_REFERER, 'exec'      ) ) ? getUrlParamValue($HTTP_REFERER, 'exec'        ) : $exec       ;
                $poll_exec  = ( getUrlParamValue($HTTP_REFERER, 'poll_exec' ) ) ? getUrlParamValue($HTTP_REFERER, 'poll_exec'   ) : $poll_exec  ;
                $event_exec = ( getUrlParamValue($HTTP_REFERER, 'event_exec') ) ? getUrlParamValue($HTTP_REFERER, 'event_exec'  ) : $event_exec ;
                $npop       = ( getUrlParamValue($HTTP_REFERER, 'npop'      ) ) ? getUrlParamValue($HTTP_REFERER, 'npop'        ) : $npop       ;
                $no         = ( getUrlParamValue($HTTP_REFERER, 'no'        ) ) ? getUrlParamValue($HTTP_REFERER, 'no'          ) : $no         ;
                $s          = ( getUrlParamValue($HTTP_REFERER, 's'         ) ) ? getUrlParamValue($HTTP_REFERER, 's'           ) : $s          ;

                $query_str = '';
                appendParam ($query_str,'id',$id);
                appendParam ($query_str,'poll_id',$poll_id);
                appendParam ($query_str,'exec',$exec);
                appendParam ($query_str,'poll_exec',$poll_exec);
                appendParam ($query_str,'npop',$npop);
                appendParam ($query_str,'no',$no);
                appendParam ($query_str,'s',$s);
                if ( $login_skin_name && $referer_yn == 'Y' ) appendParam ($query_str,'login_skin_name',$login_skin_name);
                appendParam ($query_str,'event_id',$event_id);

                if ( $save_id == 'Y' ) {
                    if ( $save_id  ) { setcookie ("_d_save_id"  , $save_id  , time() + 604800,"/"); }
                    if ( $user_id  ) { setcookie ("_d_user_id"  , $user_id  , time() + 604800,"/"); }
//                  if ( $password ) { setcookie ("_d_password" , $password , time() + 604800,"/"); }
                } else {
                    setcookie ("_d_save_id" , "", time() - 3600,"/");
                    setcookie ("_d_user_id" , "", time() - 3600,"/");
//                  setcookie ("_d_password", "", time() - 3600,"/");
                }

                // 회원 종류별 로그인 포인트 조회
                $sql = "select point from $tb_member_kind where member_level = '" . $result['member_level'] . "'";
                $point = simpleSQLQuery($sql);

                $point       = (int) $point;
                $sign        = '+'; // 부호
                $_s_memInfor['point'] = $result['point'] + $point; // 포인트 기록
                if ( $point < 0 ) { $sign = '-'; $point = abs($point); }

                $sql  = "update $tb_member";
                $sql .= " set point = point $sign $point ,";
                $sql .= " access = access + 1,";
                $sql .= " acc_date  = '" . getYearToSecond() . "'";
                $sql .= " where user_id = '" . $user_id . "';";
                simpleSQLExecute($sql);

                if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0이하
                    @session_register("_s_memInfor");
                } else {
                    $_SESSION['_s_memInfor'] = $_s_memInfor;  // 4.10 세션 처리.
                }

                if ( $suc_mode && $suc_mode != '1' ) {
                    appendParam ($query_str,'suc_mode',$suc_mode);
                }

                echo ( "<script type='text/javascript'>\n");
                echo ( "<!--\n");
				echo ( "function getOnlyURL(_url) {\n");
				echo ( "	var url = _url;\n");
				echo ( "	var e = url.indexOf ( '?' );\n");
				echo ( "	if ( e > 0 ) url = url.substring(0,e);\n");
				echo ( "	return url;\n");
				echo ( "}\n");
                echo ( "    var opener_url = '';\n");
                echo ( "    var first = '';\n");
                echo ( "    if ( opener && typeof(opener     ) != 'undefined' && typeof(opener.document) == 'object' ) {\n");
                echo ( "        opener_url = getOnlyURL(opener.document.location.href);\n");
                echo ( "        if ( typeof(opener.id  ) != 'undefined' ) { if ( first ) { opener_url += '?id='   + opener.id     ; first = false; } else { opener_url += '&id='   + opener.id     ; } }\n");
                echo ( "        if ( typeof(opener.exec) != 'undefined' ) { if ( first ) { opener_url += '?exec=' + opener.exec   ; first = false; } else { opener_url += '&exec=' + opener.exec   ; } }\n");
                echo ( "        if ( typeof(opener.no  ) != 'undefined' ) { if ( first ) { opener_url += '?no='   + opener.no     ; first = false; } else { opener_url += '&no='   + opener.no     ; } }\n");
                echo ( "        if ( typeof(opener.s   ) != 'undefined' ) { if ( first ) { opener_url += '?s='    + opener.s      ; first = false; } else { opener_url += '&s='    + opener.s      ; } }\n");
                echo ( "        if ( typeof(opener.npop) != 'undefined' ) { if ( first ) { opener_url += '?npop=' + opener.npop   ; first = false; } else { opener_url += '&npop=' + opener.npop   ; } }\n");
                if ( $poll_id   ) echo "if ( first ) { opener_url += '?poll_id=$poll_id'   ; first = false; } else { opener_url += '&poll_id=$poll_id'   ; }";
                if ( $poll_exec ) echo "if ( first ) { opener_url += '?poll_exec=$poll_exec'   ; first = false; } else { opener_url += '&poll_exec=$poll_exec'   ; }";
                echo ( "        opener.document.location.replace(opener_url);\n");
                echo ( "    }\n");
                echo ( "//-->\n");
                echo ( "</SCRIPT>\n");

                if ( $suc_mode == '2' ) { // 메시지화면
                    appendParam ($query_str,'message',urlencode($message));
                    appendParam ($query_str,'succ_url',urlencode($succ_url));
                    $retunPage .= $query_str;
                    redirectPage($retunPage);
                } else if ( $suc_mode == '3' ) { // 지정URL로 이동
                    $succ_url= urldecode($succ_url);
                    redirectPage($succ_url);
                } else if ( $suc_mode == '4' ) { // 윈도우 닫기
                    $message = urldecode($message);
                    echo ( "<script type='text/javascript'>\n");
                    echo ( "<!--\n");
                    echo ( "    alert('" . $message . "');\n");
                    echo ( "    self.close();\n");
                    echo ( "//-->\n");
                    echo ( "</SCRIPT>\n");
                } else {
                    $retunPage .= $query_str;
                    redirectPage($retunPage );
                }

//              formMove('test',$retunPage, $params);
            } else if ( $result['member_st'   ] == 0 ) { // 사용 정지된 계정
                @session_unregister("_s_memInfor");
                $_s_memInfor= getMemInfor(); // 기본값으로 설정하기 위해 세션을 제거 한후 다시 읽어 들입니다.
                $_s_memInfor['login_yn'    ] = 'N';
                if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0
                    @session_register("_s_memInfor");
                } else {
                    $_SESSION['_s_memInfor'] = $_s_memInfor;  // 4.10 세션 처리.
                }
                head("디자인보드");          // Header 출력 ( 타이틀이 출력되는 경우는 에러가 발생한 경우)
                css ();
                Message("U", "0004", "",$loginSkinDir);
            } else if ( $result['member_st'   ] == 9 ) { // 사용 정지된 계정

            }
        } else { // 권한이 없는 사용자
            if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0이하
                @session_unregister("_s_memInfor");
            } else {
                unset($_SESSION['_s_memInfor']);
            }

            $_s_memInfor= getMemInfor(); // 기본값으로 설정하기 위해 세션을 제거 한후 다시 읽어 들입니다.
            if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0이하
                @session_register("_s_memInfor");
            } else {
                $_SESSION['_s_memInfor'] = $_s_memInfor;  // 4.10 세션 처리.
            }
            head("디자인보드");          // Header 출력 ( 타이틀이 출력되는 경우는 에러가 발생한 경우)
            css ();
            Message("U", "0005", "",$loginSkinDir);
        }

        closeDBConnection ();            // 데이터베이스 연결 설정 해제
    } else {
        if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0
            @session_unregister("_s_memInfor");
        } else {
            unset($_SESSION['_s_memInfor']);
        }
        $_s_memInfor= getMemInfor(); // 기본값으로 설정하기 위해 세션을 제거 한후 다시 읽어 들입니다.
        if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0
            @session_register("_s_memInfor");
        } else {
            $_SESSION['_s_memInfor'] = $_s_memInfor;  // 4.10 세션 처리.
        }
        head();          // Header 출력 ( 타이틀이 출력되는 경우는 에러가 발생한 경우)
        css ();
        Message("P", "0003", "",$loginSkinDir);
        //redirectPage("admin.php"      ); // 관리자 로그인 페이지로 이동
    }
} else {
//  redirectPage("admin.php"); // 관리 계정 셋팅화면 으로 이동
//  MessageExit("U", "0001", 1, "", "setup2.php");
}
?>
</head>
<body>
<?
footer(); // Footer 출력
?>