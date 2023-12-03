<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
include 'common/member_lib.inc'; // 멤버 라이브러리
include 'common/lib.inc'          ; // 공통 라이브러리
include 'common/message.inc'      ; // 에러 페이지 처리
include 'common/message_table.inc'; // 메시지
include 'common/_service.inc'     ; // 서비스 화면 관련

if ( preg_match( "/admin_member.php/", $HTTP_REFERER) ) {
    $retunPage ="admin_member.php";
    $pageLevel = 99; // 관리자      페이지에서 접근
} else {
//. "?id=" . getUrlParamValue($HTTP_REFERER, 'id') . "&exec=" . getUrlParamValue($HTTP_REFERER, 'exec')
    $retunPage = getUrlPath ($HTTP_REFERER) . getReqPageName ($HTTP_REFERER);
    $pageLevel = 1;  // 일반 사용자 페이지에서 접근
}

if ( preg_match("/${HTTP_HOST}/",$HTTP_REFERER) && $REQUEST_METHOD == 'POST' ) {
    include ( 'common/db_connect.inc'   ); // Data Base 연결 클래스
    $db = initDBConnection (); // 데이터베이스에 접속합니다.

    /* ----- 정보 읽기 ---------------------------------- */
    $memInfor = getMemInfor     (   ); // 회원   정보
    $memForm  = getMemFormSetup (0  ); // 회원 폼 설정
    $login_yn = $memInfor['login_yn']; // 로그인 여부
    $admin_yn = $memInfor['admin_yn']; // 어드민 여부
    if ( $mexec == 'insert' || $gubun == 'dup_check' ) {
    	$exec = $mexec. "_exec";
    	define ("NOT_INCLUDE_HTML_HEAD", true);
        head('회원 가입');
    } else if ( $mexec == 'update' ) {
    	$exec = $mexec. "_exec";
    	define ("NOT_INCLUDE_HTML_HEAD", true);
        head('회원 정보 수정');
    } else if ( $mexec == 'secession' ) { // 회원 탈퇴
    	$exec = $mexec. "_exec";
    	define ("NOT_INCLUDE_HTML_HEAD", true);
		head('회원 탈퇴');
    } else if ( $gubun == 'dup_check' ) {
    	$exec = $gubun . "_exec";
    	define ("NOT_INCLUDE_HTML_HEAD", true);
    	head('회원 가입');
    }
    css();
?>
<style>
body { overflow:hidden }
</style>
<script type="text/javascript">
<!--
	function getOnlyURL(_url) {
		var url = _url;
		var e = url.indexOf ( '?' );
		if ( e > 0 ) url = url.substring(0,e);
		return url;
	}
	function getFileName(val)
	{
		var rtnStr = val;
		var s1 = 0, s2 = 0;
		var s  = 0;
		s1 = rtnStr.lastIndexOf("\\") + 1 ;
		s2 = rtnStr.lastIndexOf("/")  + 1 ;
		if ( s1 > 0 ) { s = s1; }
		if ( s2 > 0 ) { s = s2; }
		if ( s > 0 ) {
			rtnStr = rtnStr.substring( s );
		} else {
			rtnStr = "";
		}
		return rtnStr;
	}
//-->
</SCRIPT>
<?
    if ( $gubun == 'dup_check' ) {
        $idCheck = simpleSQLQuery("select COUNT(user_id ) from $tb_member where user_id = '$user_id'");
        if ( $idCheck ) {
            Message('P', '0005', 'CLOSE:중복된 아이디 입니다.', $skinDir    );    // 중복된 아이디
        } else {
            Message('P', '0006', 'CLOSE:사용가능한 아이디 입니다.', $skinDir);    // 사용   아이디
        }

    } else if ( $mexec == 'insert' ) {
        $idCheck = simpleSQLQuery("select COUNT(user_id ) from $tb_member where user_id  = '$user_id'");
        if ( $idCheck ) {
            Message('P', '0005', "", $skinDir);        // 중복된 아이디
        } else {
            $constraintChk = 0;
            $msgNo = '';
            if ( $memForm['jumin' ] == 'Y' ) {
                $jumin = $jumin_1 . $jumin_2;
                $constraintChk = simpleSQLQuery("select COUNT(user_id) from $tb_member where jumin = password('$jumin')");
                if ( $constraintChk && $memInfor['member_level'] != 99 ) { // 어드민이 아닌경우에만 검사
                    $msgNo = '0007';
                } else {
                    $constraintChk = 0;
                }
            } else {
                $constraintChk = simpleSQLQuery("select COUNT(user_id) from $tb_member where e_mail = '$e_mail'");
                if ( $constraintChk && $memForm['e_mail'] == 'Y' ) { // 어드민이 아닌경우에만 검사
                    $msgNo = '0018';
                } else {
                    $constraintChk = 0;
                }
            }

            if ( $constraintChk ) { // 어드민이 아닌경우에만 검사
                Message('P', $msgNo, "", $skinDir);    // 중복된 주민 번호
            } else {
                // 회원 정보
                $news_yn = ( !$news_yn ) ? "N" : $news_yn;
                if ( !$_GET['member_level'] ) {
                    $member_level = ( !$member_level ) ? 1 : $member_level; // 기본회원등급 [일반회원] 설정
                    $post_no = $post_cd1 . '-' . $post_cd2;
                    $address = $address . '$$' . $detail_address;
                    if ( !$user_id_open                 ) { $user_id_open         = 'N'; }
                    if ( !$member_level_open            ) { $member_level_open    = 'N'; }
                    if ( !$name_open                    ) { $name_open            = 'N'; }
                    if ( !$sex_open                     ) { $sex_open             = 'N'; }
                    if ( !$e_mail_open                  ) { $e_mail_open          = 'N'; }
                    if ( !$home_open                    ) { $home_open            = 'N'; }
                    if ( !$birth_open                   ) { $birth_open           = 'N'; }
                    if ( !$age_open                     ) { $age_open             = 'N'; }
                    if ( !$tel_open                     ) { $tel_open             = 'N'; }
                    if ( !$address_open                 ) { $address_open         = 'N'; }
                    if ( !$post_no_open                 ) { $post_no_open         = 'N'; }
                    if ( !$point_open                   ) { $point_open           = 'N'; }
                    if ( !$picture_image_open           ) { $picture_image_open   = 'N'; }
                    if ( !$character_image_open         ) { $character_image_open = 'N'; }

                    include ( "common/file.inc"         ); // 파일
                    include ( "common/file_upload.inc"  ); // 파일 업로드

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
                    $f2_open         = $user_id . "_c.gif";
                    $f2_close        = $user_id . "_c_close.gif";
                    if ( $character_image_open == 'Y' ) { $f2 = $f2_open ; }
                    else                                { $f2 = $f2_close; }

                    if ( $delete_character_image != 'Y' ) {
                        $fileExt = strtolower ( getFileExtraName($_FILES['character_image']['name'] ) );
                        if ( $fileExt == 'gif' || $fileExt == 'jpg' || $fileExt == 'bmp' ) {
                            $upFile->addUploadFile ($_FILES['character_image'], "data/member/character/", $f2, "html^txt^", 99999999999999);
                        }
                    }

                    $sql  = "update $tb_dic_member_statistic set cnt = cnt + 1;";
                    simpleSQLExecute($sql); // 총 회원수 갱신

                    $upFile->Upload(); // 업로드 시작
                    $point = $memForm['point']; // 가입 포인트
                    if ( $memForm['news_yn'] == 'Y' ) $point += $memForm['news_point']; // 뉴스레터 수신 포인트

					if ( $admin_yn == 'N' && $member_level == '99' ) $member_level = 1;
                    $sql  = "insert into $tb_member ( user_id, member_level, password, name, sex, e_mail, home, birth, age, jumin, news_yn, tel, post_no, hint, answer, ";
                    $sql .= " point, user_id_open, member_level_open, name_open, sex_open, e_mail_open, home_open, birth_open, age_open, tel_open, address_open, post_no_open, point_open, picture_image_open, character_image_open, ";
                    $sql .= " address, reg_date";
                    $sql .= " ) values ";
                    $sql .= "('$user_id', $member_level, PASSWORD('$password'), '$name', '$sex', '$e_mail', '$home', '$birth', '$age', PASSWORD('$jumin'), '$news_yn', '$tel', '$post_no', '$hint', '$answer', ";
                    $sql .= "'" . $point . "', '$user_id_open', '$member_level_open', '$name_open', '$sex_open', '$e_mail_open', '$home_open', '$birth_open', '$age_open', '$tel_open', '$address_open', '$post_no_open', '$point_open', '$picture_image_open', '$character_image_open',";
                    $sql .= " '$address', '" . getYearToSecond() . "'";
                    $sql .= " );";
                    simpleSQLExecute($sql);

                    if ( $login_yn == 'N' ) {
                        $_s_memInfor['login_yn'    ] = 'Y'          ;
                        $_s_memInfor['admin_yn'    ] = 'N'          ;
                        $_s_memInfor['user_id'     ] = $user_id     ;
                        $_s_memInfor['member_level'] = $member_level;
                        $_s_memInfor['name'        ] = $name        ;
                        $_s_memInfor['home'        ] = $home        ;
                        $_s_memInfor['e_mail'      ] = $e_mail      ;
                        $_s_memInfor['member_st'   ] = 1            ;
                        $_s_memInfor['reg_date'    ] = $reg_date    ;
                        $_s_memInfor['news_yn'     ] = $news_yn     ;

                        if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0이하
                            @session_register("_s_memInfor");
                        } else {
                            $_SESSION['_s_memInfor'] = $_s_memInfor;  // 4.10 세션 처리.
                        }
//                      echo '로그인 저장.';
                    }

//                    if ( $pageLevel == 99 ) {
//                        Message---unused('P', '0008', 'javascript:opener.document.location.replace("admin_member.php");opener.focus();self.close();:가입완료', $skinDir);    // 회원 가입 완료
//                    } else {
                        echo ( "\n<script type='text/javascript'>\n");
                        echo ( "function regEnd() {\n" );
                        echo ( "        var url = '?id=$id&exec=$exec&no=$no&npop=$npop';\n");
                        echo ( "    if ( typeof(opener) != 'undefined' ) {\n");
                            if ( $succ_url ) {
//                          echo ( "    alert ( 'start :' + getFileName('$succ_url') + ':end'); \n");
                            echo ( "    if ( getFileName ('$succ_url') == '' ) {\n");
                            echo ( "        url = '$succ_url' ;\n" );
                            echo ( "    } else {\n");
                            echo ( "        url = '$succ_url' + url;\n" );
                            echo ( "    }\n");
                            } else {
                                echo ( "        if (typeof(opener.document)=='object') { \n" );
                                    echo ( "        url = opener.document.location.href;\n" );
//                                  echo ( "        url = getOnlyURL(opener.document.location.href) + url;\n" );
                                    echo ( "        opener.document.location.replace( url );\n" );
                                echo ( "        }\n" );
                            }
                        echo ( "        opener.focus();\n" );
                        echo ( "        self.close();\n" );
                        echo ( "    } else { \n");
                            if ( $succ_url ) {
//                          echo ( "    alert ( 'start :' + getFileName('$succ_url') + ':end'); \n");
                            echo ( "    if ( getFileName ('$succ_url') == '' ) {\n");
                            echo ( "        url = '$succ_url' ;\n" );
                            echo ( "    } else {\n");
                            echo ( "        url = '$succ_url' + url;\n" );
                            echo ( "    }\n");
                            } else {
                                echo ( "        url = 'http://" . $HTTP_HOST . "';\n" );
                            }
                        echo ( "        document.location.replace( url );\n" );
                        echo ( "    }\n");
                        echo ( "}\n");
                        echo ( "</SCRIPT>\n" );
                        Message('P', '0008', "javascript:regEnd();:가입완료", $skinDir);    // 회원 가입 완료
//                    }
                }
            }
        }
    } else if ( $mexec == 'update' ) {
        head('회원 정보 수정');     // Header 출력
        $news_yn = ( !$news_yn ) ? "N" : $news_yn;
        $post_no = $post_cd1 . '-' . $post_cd2;
        $address = $address . '$$' . $detail_address;
        if ( !$user_id_open                 ) { $user_id_open         = 'N'; }
        if ( !$member_level_open            ) { $member_level_open    = 'N'; }
        if ( !$name_open                    ) { $name_open            = 'N'; }
        if ( !$sex_open                     ) { $sex_open             = 'N'; }
        if ( !$e_mail_open                  ) { $e_mail_open          = 'N'; }
        if ( !$home_open                    ) { $home_open            = 'N'; }
        if ( !$birth_open                   ) { $birth_open           = 'N'; }
        if ( !$age_open                     ) { $age_open             = 'N'; }
        if ( !$tel_open                     ) { $tel_open             = 'N'; }
        if ( !$address_open                 ) { $address_open         = 'N'; }
        if ( !$post_no_open                 ) { $post_no_open         = 'N'; }
        if ( !$point_open                   ) { $point_open           = 'N'; }
        if ( !$picture_image_open           ) { $picture_image_open   = 'N'; }
        if ( !$character_image_open         ) { $character_image_open = 'N'; }

        if ( !escapeYN () ) { // magic_quotes_gpc Off
            $answer = addslashes($answer);
        }

        include ( "common/file.inc"         ); // 파일
        include ( "common/file_upload.inc"  ); // 파일 업로드

        $upFile  = FileUpload ( ); // 업로드 인스턴스 생성
        $user_id = $memInfor['user_id'];
        $f1      = $user_id . "_p.gif";

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
        // 게시판 정보 테이블 삭제
        $sql  = "update $tb_member set ";
        $sql .= " user_id_open        =  '$user_id_open'        ,";

        if ( $admin_yn == 'Y' ) { $sql .= " member_level=  $member_level,"; }

        $sql .= " user_id_open      =  '$user_id_open'      ,";
        $sql .= " member_level_open =  '$member_level_open' ,";

        if ( $password_change     == 'Y' ) { $sql .= " password    =  PASSWORD('$password')   ,"; }
        if ( $memForm['name'    ] == 'Y' || $memForm['name'    ] == 'C') { $sql .= " name        = '$name'       ,"; $sql .= " name_open           =  '$name_open'           ,";}
        if ( $memForm['sex'     ] == 'Y' || $memForm['sex'     ] == 'C') { $sql .= " sex         = '$sex'        ,"; $sql .= " sex_open            =  '$sex_open'            ,";}
        if ( $memForm['e_mail'  ] == 'Y' || $memForm['e_mail'  ] == 'C') { $sql .= " e_mail      = '$e_mail'     ,"; $sql .= " e_mail_open         =  '$e_mail_open'         ,";}
        if ( $memForm['home'    ] == 'Y' || $memForm['home'    ] == 'C') { $sql .= " home        = '$home'       ,"; $sql .= " home_open           =  '$home_open'           ,";}
        if ( $memForm['birth'   ] == 'Y' || $memForm['birth'   ] == 'C') { $sql .= " birth       = '$birth'      ,"; $sql .= " birth_open          =  '$birth_open'          ,";}
        if ( $memForm['age'     ] == 'Y' || $memForm['age'     ] == 'C') { $sql .= " age         = '$age'        ,"; $sql .= " age_open            =  '$age_open'            ,";}
        if ( $memForm['tel'     ] == 'Y' || $memForm['tel'     ] == 'C') { $sql .= " tel         = '$tel'        ,"; $sql .= " tel_open            =  '$tel_open'            ,";}
        if ( $memForm['address' ] == 'Y' || $memForm['address' ] == 'C') { $sql .= " address     = '$address'    ,"; $sql .= " address_open        =  '$address_open'        ,";
                                                                           $sql .= " post_no     = '$post_no'    ,"; $sql .= " post_no_open        =  '$post_no_open'        ,";}
        if ( $memForm['news_yn' ] == 'Y' || $memForm['news_yn' ] == 'C') { $sql .= " news_yn     = '$news_yn'    ,"; }
        if ( $memForm['point_yn'] == 'Y' || $memForm['point_yn'] == 'C') {                                           $sql .= " point_open          =  '$point_open'          ,";}

        if ( $memForm['picture_image'  ] == 'Y' || $memForm['picture_image'  ] == 'C' ) { $sql .= " picture_image_open    =  '$picture_image_open'    ,";}
        if ( $memForm['character_image'] == 'Y' || $memForm['character_image'] == 'C' ) { $sql .= " character_image_open  =  '$character_image_open'  ,";}
        $sql .= " hint          = '$hint'   ,";
        $sql .= " answer        = '$answer' ,";
        $sql .= " acc_date      = '" . getYearToSecond() . "'";
        $sql .= " where user_id   = '" . $user_id . "'";
        $sql .= " and   member_st != 0;";  // 사용 정지가 아닌 회원만

//      logs ("$sql <BR>",true);
        simpleSQLExecute($sql);

        $sql  = "select * from $tb_member where user_id = '" . $memInfor['user_id'] . "';";
        $result = singleRowSQLQuery($sql);

        echo ( "<script type='text/javascript'>\n");
        echo ( "<!--\n");
        echo ( "    function windowClose() {\n");
        echo ( "        if ( typeof( opener ) == 'object' ) {\n");
        echo ( "            self.close();\n");
        echo ( "        } else {\n");
        echo ( "            history.back();\n");
        echo ( "        }\n");
        echo ( "    }\n");
        echo ( "//-->\n");
        echo ( "</SCRIPT>\n");

        echo ( "\n<script type='text/javascript'>\n");
        echo ( "function regEnd() {\n" );
        echo ( "        var url = '?id=$id&exec=$exec&no=$no&npop=$npop';\n");
        echo ( "    if ( typeof(opener) == 'object' && typeof(opener.document) == 'object' ) {\n");
            if ( $succ_url ) {
//          echo ( "    alert ( 'start :' + getFileName('$succ_url') + ':end'); \n");
            echo ( "    if ( getFileName ('$succ_url') == '' ) {\n");
            echo ( "        url = '$succ_url' ;\n" );
            echo ( "    } else {\n");
            echo ( "        url = '$succ_url' + url;\n" );
            echo ( "    }\n");
            } else {
                echo ( "        url = opener.document.location.href;\n" );
//              echo ( "        url = getOnlyURL(opener.document.location.href) + url;\n" );
            }
        echo ( "        opener.document.location.replace( url );\n" );
        echo ( "        opener.focus();\n" );
        echo ( "        self.close();\n" );
        echo ( "    } else { \n");
            if ( $succ_url ) {
//          echo ( "    alert ( 'start :' + getFileName('$succ_url') + ':end'); \n");
            echo ( "    if ( getFileName ('$succ_url') == '' ) {\n");
            echo ( "        url = '$succ_url' ;\n" );
            echo ( "    } else {\n");
            echo ( "        url = '$succ_url' + url;\n" );
            echo ( "    }\n");
            } else {
                echo ( "        url = 'http://" . $HTTP_HOST . "';\n" );
            }
        echo ( "        document.location.replace( url );\n" );
        echo ( "    }\n");
        echo ( "}\n");
        echo ( "</SCRIPT>\n" );

        if ( $result['member_st'] == 0 ) { // 사용 정지 상태
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
            Message('U', '0004',"javascript:windowClose();:확인", $skinDir); // 사용 정지된 회원

        } else { // 사용 상태

            $_s_memInfor['login_yn'    ] = 'Y';

            if ( $result['member_level'] == 99 ) {
                $_s_memInfor['admin_yn'    ] = 'Y';
            } else {
                $_s_memInfor['admin_yn'    ] = 'N';
            }

            setSessionMemberValue ('user_id'     ,$result['user_id'     ]);
            setSessionMemberValue ('member_level',$result['member_level']);
            setSessionMemberValue ('name'        ,$result['name'        ]);
            setSessionMemberValue ('e_mail'      ,$result['e_mail'      ]);
            setSessionMemberValue ('home'        ,$result['home'        ]);
            setSessionMemberValue ('member_st'   ,$result['member_st'   ]);
            setSessionMemberValue ('reg_date'    ,$result['reg_date'    ]);
            setSessionMemberValue ('news_yn'     ,$result['news_yn'     ]);
            // logs ( '$skinDir : '. $skinDir . '<BR>' , true);
            Message('P', '0013',"javascript:regEnd();:확인", $skinDir); // 회원 정보가 수정 되었습니다.
        }
    } else if ( $mexec == 'secession' ) { // 회원 탈퇴
        $user_id          = $memInfor['user_id' ]; // 아이디
        if ( $user_id ) {
            @session_destroy();
            echo ( "\n<script type='text/javascript'>\n");
            echo ( "function secessionEnd() {\n" );
            echo ( "        var url = '?id=$id&exec=$exec&no=$no&npop=$npop';\n");
            echo ( "    if ( typeof(opener     ) != 'undefined' ) {\n");
                if ( $succ_url ) {
//                          echo ( "    alert ( 'start :' + getFileName('$succ_url') + ':end'); \n");
                echo ( "    if ( getFileName ('$succ_url') == '' ) {\n");
                echo ( "        url = '$succ_url' ;\n" );
                echo ( "    } else {\n");
                echo ( "        url = '$succ_url' + url;\n" );
                echo ( "    }\n");
                echo ( "    opener.document.location.replace( url );\n" );
                }
            echo ( "        opener.focus();\n" );
            echo ( "        self.close();\n" );
            echo ( "    } else { \n");
                if ( $succ_url ) {
//                          echo ( "    alert ( 'start :' + getFileName('$succ_url') + ':end'); \n");
                echo ( "    if ( getFileName ('$succ_url') == '' ) {\n");
                echo ( "        url = '$succ_url' ;\n" );
                echo ( "    } else {\n");
                echo ( "        url = '$succ_url' + url;\n" );
                echo ( "    }\n");
                } else {
                    echo ( "        url = 'http://" . $HTTP_HOST . "';\n" );
                }
            echo ( "        document.location.replace( url );\n" );
            echo ( "    }\n");
            echo ( "}\n");
            echo ( "</SCRIPT>\n" );
/*
            $chg_user_id = '!@#$_' . $user_id;
            $sql  = "update $tb_member set ";
            $sql .= " member_st = '9',";
            $sql .= " jumin     = '' ,";
            $sql .= " user_id   = '$chg_user_id'";
            $sql .= " where user_id = '$user_id';"; // 회원 탈퇴
*/
            $sql  = "delete from $tb_member where user_id = '$user_id'";
            simpleSQLExecute($sql);

            $sql  = "update $tb_dic_member_statistic set cnt = cnt - 1;";
            simpleSQLExecute($sql); // 총 회원수 갱신

            $f1         = $user_id . "_p.gif";
            $f2         = $user_id . "_c.gif";
            if ( @is_file("data/member/picture/"  . $f1) ) { @unlink ( "data/member/picture/"  . $f1 ); }
            if ( @is_file("data/member/character/". $f2) ) { @unlink ( "data/member/character/". $f2 ); }

            Message('P', '0016', "javascript:secessionEnd();:탈퇴완료", $skinDir);    // 회원 탈퇴 완료
        }
    } else { // Parameter 조작의 경우
        Message('S', '0003', 'CLOSE:닫기', $skinDir);    // 페이지 접근이 거부 되었습니다.
    }

} else { // Parameter 조작의 경우
        Message('S', '0003', 'CLOSE:닫기', $skinDir);    // 페이지 접근이 거부 되었습니다.
}
?>
</head>
<body>
<?
closeDBConnection (); // 데이터베이스 연결 설정 해제
footer(); // Footer 출력
?>
