<?
if ( function_exists('head') ) {
    $p_exec = getUrlParamValue($HTTP_REFERER, 'exec');
    $s      = getUrlParamValue($HTTP_REFERER, 's'   );
// set_time_limit ( 0 );

//  if ( $id && $grant == 'Y' && ( $exec == 'insert_exec' && $p_exec == 'insert' ) || ( $exec == 'update_exec' && $p_exec== 'update' ) || ( $exec == 'answer_exec' && $p_exec== 'answer' ) &&
    if ( $id && $grant == 'Y' && ( $exec == 'insert_exec' ) || ( $exec == 'update_exec' ) || ( $exec == 'answer_exec' ) &&
         preg_match("/${HTTP_HOST}/", $HTTP_REFERER) && $REQUEST_METHOD == 'POST' )
    {
        if ( $bbsInfor )  { // 게시판 정보 존재
            $ip      = $REMOTE_ADDR                  ; // 아이피 주소
            $html_yn = ( !$html_yn ) ? "N" : $html_yn; // html 사용 여부
            $use_st  = ( !$open_yn ) ? '2'    : '1'  ; // 글 공개 여부
            $use_st  = ( !$ann_yn  ) ? $use_st: '0'  ; // 공지 사항
            $mail_yn = ( !$mail_yn ) ? "N" : $mail_yn; // 답변시 메일 발송 여부
            $cat_no  = ( !$cat_no  ) ? "1" : $cat_no ; // 카테고리 번호

            if ( $login_yn == 'N' && !$password ) {
                MessageExit('S', '0013',"", $skinDir); // 게시판 입력 스킨 구성에서 password 필드가 빠져서 작성됨
                                                    // 로그인을 안했을 경우에는 반드시 비밀번호가 입력되어야 합니다.
            }

            $title   = $_POST ['title'];
            $name    = $_POST ['name' ];

            $name    = preg_replace("(　|ㅤ)","",$name   ); // 유사공백1, 유사공백2
            $title   = str_replace("(　|ㅤ)","",$title   );
            $content = str_replace("(　|ㅤ)","",$content );

/*
            if ( $html_yn != 'N' ) {
				$doc = new DOMDocument(1.0,'utf-8');
// 				$doc = new DOMDocument();
// 				$content = iconv("euc-kr", "utf-8" , $content );
//             		$doc->loadHTML('<html><head><meta http-equiv="content-type" content="text/html; charset=euck-kr"><title>Test</title></head><body>'.$content.'</body></html>');
            		$doc->loadHTML($content);
//            		$doc->loadHTML('<?xml encoding="euc-kr">'.$content.'');
//              	$content = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $doc->saveHTML()));
// 					$doc->encoding = "euc-kr";
// 					$doc->preserveWhiteSpace = false;
// 					$doc->formatOutput = true;
            		$content = $doc->saveHTML();
            		$content = iconv("utf-8", "euc-kr" , $content );
            }
*/
//             echo '<textarea>' . $content . '</textarea>';

            // magic_quotes_gpc Off
            if ( !escapeYN () ) {
            	$name    = addslashes($name   );
            	$title   = addslashes($title  );
            	$content = addslashes($content);
            	$link1   = addslashes($link1  );
            	$link2   = addslashes($link2  );
            }

            if ( !$title   ) MessageExit("S", "0054","", $skinDir); // 제목 입력이 올바르지 않습니다.
            if ( !trim($content) ) MessageExit("S", "0064","", $skinDir); // 내용 입력이 올바르지 않습니다.

            include ( $baseDir . 'common/file_upload.inc'         ); // 파일 업로드

            if ( $file1_delete != 'Y' ) {
				$httpUrl1 = $baseDir . "data/file/" . $id. '/';
                if ( !@is_dir( $baseDir . $httpUrl1 ) ) {
                    @mkdir($baseDir . $httpUrl1,0707);
                    @chmod($baseDir . $httpUrl1,0707);
                }
            }

            if ( $file2_delete != 'Y' ) {
				$httpUrl2 = $baseDir . "data/file/" . $id. '/';
                if ( !@is_dir( $baseDir . $httpUrl2 ) ) {
                    @mkdir($baseDir . $httpUrl2,0707);
                    @chmod($baseDir . $httpUrl2,0707);
                }
            }

            $upFile  = FileUpload ( ); // 업로드 인스턴스 생성

            $save_file1_name  = date("Y").date("m").date("d").date("H").date("i").date("s");
            $save_file1_name .= substr(microtime(),2,4);
            $upFile->addUploadFile ($_FILES['file1'], $baseDir . "data/file/" . $id . '/', $save_file1_name . "." . getFileExtraName($_FILES['file1'][name]) , "inc^php3^php4^php^bat^sh^phtml^shtml^htm^html^asp^", $bbsInfor['max_capacity']);

            $save_file2_name  = date("Y").date("m").date("d").date("H").date("i").date("s");
            $save_file2_name .= substr(microtime(),2,4);
            $upFile->addUploadFile ($_FILES['file2'], $baseDir . "data/file/" . $id . '/', $save_file2_name . "." . getFileExtraName($_FILES['file2'][name]) , "inc^php3^php4^php^bat^sh^phtml^shtml^htm^html^asp^", $bbsInfor['max_capacity']);

            $upFile->Upload(); // 업로드 시작

            if ( $exec == 'insert_exec' ) {
                    $newNo = simpleSQLQuery("select MAX(no) from $tb_bbs_data" . "_" . $id);
                    if ( !$newNo ) { $newNo = 0; }   // 게시물 번호 생성

                    // 이후 글 번호
                    $sql = "select no from $tb_bbs_data" . "_" . $id . " where pre_no = 0 and no <= $newNo;";
                    $nextNo = simpleSQLQuery($sql);

                    $preNo= 0;
                    if ( !$nextNo ) { $nextNo = 0; }
                    $newNo = $newNo + 1;

                    if ( $use_st == '0' ) {
                        $notCnt = simpleSQLQuery("select COUNT(*) from $tb_bbs_data" . "_" . $id . ' where use_st = 0;');
                        // 2147483648 기준 공지 3648개 가능
                        $g_no = 2147480000 + $notCnt;
                    } else { $g_no = $newNo; }

                    // magic_quotes_gpc Off
                    if ( !escapeYN () ) {
                        $f_name1 = addslashes($upFile->name[0]);
                        $f_name2 = addslashes($upFile->name[1]);
                    } else {
                        $f_name1  = $upFile->name[0];
                        $f_name2  = $upFile->name[1];
                    }

                    if ( $upFile->size[0] <= 0 ) { $httpUrl1 = ''; } // 처음   자료
                    if ( $upFile->size[1] <= 0 ) { $httpUrl2 = ''; } // 두번째 자료
                    $reg_date  = getYearToMicro();

                    $sql  = "insert into $tb_bbs_data" . "_" . $id;
                    $sql .= "(";
                    $sql .= "no         , cat_no     ,g_no         ,depth       , ";
                    $sql .= "o_seq      , pre_no     , next_no     ,";
                    $sql .= "member_level,";
                    $sql .= "user_id    , name       ,password     , title      ,";
                    $sql .= "content    , e_mail     ,home         ,             ";
                    $sql .= "f_path1    , f_name1    ,f_ext1       , f_size1    ,";
                    $sql .= "f_date1    ,";
                    $sql .= "f_path2    , f_name2    ,f_ext2       , f_size2    ,";
                    $sql .= "f_date2    ,";
                    $sql .= "link1      , link2      ,";
                    $sql .= "reg_date   , html_yn    ,mail_yn      , use_st     ,";
                    $sql .= "recom_hit  , hit        ,total_comment, ip          ";
                    $sql .= ") values (";
                    $sql .= "$newNo     , $cat_no   , -" . "$g_no     , 0           ,";
                    $sql .= "0          , $preNo    , $nextNo    ,";
                    $sql .= "'" . $memInfor['member_level'] . "',";
                    $sql .= "'$user_id' , '$name'   , PASSWORD('$password'), '$title'   ,";
                    $sql .= "'$content' , '$e_mail' , '$home', ";
                    $sql .= "'$httpUrl1', '$f_name1' ,'". $upFile->ext[0] . "', '" . (!$upFile->size[0]?0:$upFile->size[0]). "'   ,";
                    $sql .= "'".$upFile->real_nm[0] ."' , ";
                    $sql .= "'$httpUrl2', '$f_name2' ,'". $upFile->ext[1] . "', '" . (!$upFile->size[1]?0:$upFile->size[1]). "'   ,";
                    $sql .= "'".$upFile->real_nm[1] ."' , ";
                    $sql .= "'$link1'   , '$link2'   ,";
                    $sql .= " '$reg_date', '$html_yn', '$mail_yn'    , '$use_st' ,";
                    $sql .= "0, 0, 0, '$ip'";
                    $sql .= ");";

                    // logs ( '$sql : '. $sql . '<BR>' , true);
                    simpleSQLExecute($sql);

                    // if ( $use_st != 0 ) { // 공지 사항이 아니면
                        $sql  = "update $tb_bbs_data" . "_" . $id;
                        $sql .= " set pre_no = $newNo where no = $nextNo;";
                        simpleSQLExecute($sql);
                    // }
                    $point=0;
                    $point       = getPointGrant ($id, $memInfor['member_level'], 1); // 게시물 작성 포인트
                    $uploadPoint = getPointGrant ($id, $memInfor['member_level'], 3); // 파일 업로드 포인트

                    if ( $f_name1 ) { $point += $uploadPoint; }
                    if ( $f_name2 ) { $point += $uploadPoint; }

                    setPointGrant ($user_id, $point); // 포인트 추가

                    $retunPage = getUrlPath ($HTTP_REFERER) . getReqPageName ($HTTP_REFERER);
                    $retunPage .= '?id='   . $id    ;

                    // 입력 처리후 이동 페이지
                    // '1' : list
                    // '2' : view
                    // '3' : insert
                    if ( $write_move_page == '1' )        { // 목록
                        $retunPage .= '&exec=' . 'list' ;
                    } else if ( $write_move_page == '2' ) { // 보기
                        $retunPage .= '&no=' . $newNo . '&exec=' . 'view' ;
                    } else if ( $write_move_page == '3' ) { // 입력
                        $retunPage .= '&exec=' . 'insert' ;
                    }
                    $retunPage .= '&s='    . $s     ;

                    $sercurity_cotent_chk = $_SESSION['sercurity_cotent_chk'];
                    if ( $use_st == 1 ) {
                        $sercurity_cotent_chk = '%' . $id .'_' . $newNo . $sercurity_cotent_chk;
                        if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0이하
                            @session_register('sercurity_cotent_chk');
                        } else {
                            $_SESSION['sercurity_cotent_chk'] = $sercurity_cotent_chk;  // 4.10 세션 처리.
                        }
                    }
            } else if ( $exec == 'update_exec' ) {

				$sql = "select * from $tb_bbs_data" . "_" . $id . " where no = ".$no;

                $data = singleRowSQLQuery($sql);
                $g_no = $data['g_no'];
                if ( $data['no'] ) {
                    $f_path1  = $data["f_path1" ];              // 파일 경로1
                    $f_name1  = addslashes($data["f_name1" ]);  // 파일 명1
                    $f_ext1   = $data["f_ext1"  ];              // 확장자 명1
                    $f_size1  = $data["f_size1" ];              // 파일 크기1
                    $f_date1  = $data["f_date1" ];              // 저장 파일명1

                    $f_path2  = $data["f_path2" ];              // 파일 경로2
                    $f_name2  = addslashes($data["f_name2" ]);  // 파일 명2
                    $f_ext2   = $data["f_ext2"  ];              // 확장자 명2
                    $f_size2  = $data["f_size2" ];              // 파일 크기2
                    $f_date2  = $data["f_date2" ];              // 저장 파일명2

                    $w_user_id= $data["user_id" ];              // 작성자 아이디
					$bf_use_st= $data["use_st"  ];				// 글의 상태

					$file1    = $baseDir . "data/file/" . $id. "/$f_date1.$f_ext1";
					$file2    = $baseDir . "data/file/" . $id. "/$f_date2.$f_ext2";

                    if ( $file1_delete == 'Y' ) {
                        if ( is_file("$file1") ) {
                            unlink ( "$file1" ) or MessageExit("S", "0023","", $skinDir); // 파일 삭제중 에러.
                        }

                        $f_path1   = "";  // 파일 경로1
                        $f_name1   = "";  // 파일 명1
                        $f_ext1    = "";  // 확장자 명1
                        $f_size1   = "";  // 파일 크기1
                        $f_date1   = "";  // 저장 파일명1

                    } else {
                        if ( $upFile->size[0] > 0 ) {
                            if ( @is_file("$file1") ) {
                                unlink ( "$file1" ) or MessageExit("S", "0023","", $skinDir); // 파일 삭제중 에러.
                            }
                            $f_path1  = $upFile->path[0]   ;   // 파일 경로
                            $f_name1  = $upFile->name[0]   ;   // 파일 명
                            $f_ext1   = $upFile->ext[0]    ;   // 확장자 명
                            $f_size1  = $upFile->size[0]   ;   // 파일 크기
                            $f_date1  = $upFile->real_nm[0];   // 저장 파일명
                        }
                    }
                    if ( $file2_delete == 'Y' ) {
                        if ( @is_file("$file2") ) {
                            unlink ( "$file2" ) or MessageExit("S", "0023","", $skinDir); // 파일 삭제중 에러.
                        }
                        $f_path2   = "";  // 파일 경로2
                        $f_name2   = "";  // 파일 명2
                        $f_ext2    = "";  // 확장자 명2
                        $f_size2   = "";  // 파일 크기2
                        $f_date2   = "";  // 저장 파일명2

                    } else {
                        if ( $upFile->size[1] > 0 ) {
                            if ( @is_file("$file2") ) {
                                unlink ( "$file2" ) or MessageExit("S", "0023","", $skinDir); // 파일 삭제중 에러.
                            }
                            $f_path2  = $upFile->path[1]   ;   // 파일 경로
                            $f_name2  = $upFile->name[1]   ;   // 파일 명
                            $f_ext2   = $upFile->ext[1]    ;   // 확장자 명
                            $f_size2  = $upFile->size[1]   ;   // 파일 크기
                            $f_date2  = $upFile->real_nm[1];   // 저장 파일명
                        }
                    }

					$point = 0;
					$uploadPoint = getPointGrant ($id, $memInfor['member_level'], 3); // 파일 업로드 포인트

					setPointGrant ($user_id, $point); // 포인트 감산

                    $sql  = "update $tb_bbs_data" . "_" . $id;
                    $sql .= " set ";
                    if ( $cat_no ) $sql .= "cat_no   = '$cat_no'  ,";
                    $sql .= "name     = '$name'    ,";
//                  $sql .= "member_level = '" . $memInfor['member_level'] . "',"; // 회원레벨 3.01 이후 버전 추가

                    if ( $use_st == '0' ) {
                        $notCnt = simpleSQLQuery("select COUNT(*) from $tb_bbs_data" . "_" . $id . ' where use_st = 0 and no != '.$no);
                        // 2147483648 기준 공지 3648개 가능
                        $g_no = 2147480000 + $notCnt;
                        $g_no = '-' . 2147480000 + $notCnt;
                    }

					if ( $bf_use_st == '0' && $use_st != '0' ) $g_no = '-' . $no;

					$sql .= "g_no   = " . "$g_no   ,";

                    if ( $title   ) $sql .= "title    = '$title'   ,";
                    if ( $content ) $sql .= "content  = '$content' ,";
                    if ( $e_mail  ) $sql .= "e_mail   = '$e_mail'  ,";
                    if ( $home    ) $sql .= "home     = '$home'    ,";

                    if ( $upFile->name[0] || $file1_delete == 'Y' ) {
                        $sql .= "f_path1   = '$f_path1'  ,";
                        $sql .= "f_name1   = '$f_name1'  ,";
                        $sql .= "f_ext1    = '$f_ext1'   ,";
                        $sql .= "f_size1   = '$f_size1'  ,";
                        $sql .= "f_date1   = '$f_date1'  ,";
//                      $sql .= "down_hit1 = 0           ,";
                    }

                    if ( $upFile->name[1] || $file2_delete == 'Y' ) {
                        $sql .= "f_path2   = '$f_path2'  ,";
                        $sql .= "f_name2   = '$f_name2'  ,";
                        $sql .= "f_ext2    = '$f_ext2'   ,";
                        $sql .= "f_size2   = '$f_size2'  ,";
                        $sql .= "f_date2   = '$f_date2'  ,";
//                      $sql .= "down_hit2 = 0           ,";
                    }

                    $sql .= "link1    = '$link1'   ,";
                    $sql .= "link2    = '$link2'   ,";
                    $sql .= "html_yn  = '$html_yn' ,";
                    $sql .= "mail_yn  = '$mail_yn' ,";
                    // 일반글 -> 공지글로 [ 어드민만 실행 ]
                    if ( $use_st == '0' ) {
                        if ( $admin_yn == 'Y' ) {
                            $sql .= "use_st   = '0'  ,";
                            $sql .= "depth    = '0'  ,";
                            $sql .= "o_seq    = '0'  ,";
                        }
                    } else {
                        $sql .= "use_st   = '$use_st'  ,";
                    }
                    $sql .= "ip       = '$ip'       ";
                    $sql .= "where no =  $no;";

                    $existChk = false;
                    $msgNo    = "";

                    if ( $admin_yn == 'Y' ) {
                        $existChk = true;
                    } else if ( $w_user_id && $login_yn == 'Y' ) { // 회원   글
                        if ( $w_user_id == $user_id ) $existChk = true;
                        else $msgNo = "0016"; // 수정 사용자 틀림
                    } else if ( !$w_user_id )                    { // 비회원 글
                        $password = sql_password($password);
                        if ( $data["password" ] == $password ) $existChk = true;
                        else $msgNo = "0015"; // 수정 비밀번호 틀림
                    }

                    if ( $existChk ) {
                        simpleSQLExecute($sql);
                        if ( $use_st == '0' && $data["depth"  ] > 0 && $admin_yn == 'Y') {
                            $sql  = "update $tb_bbs_data" . "_" . $id;
                            $sql .= " set depth = depth -1, o_seq = o_seq -1";
                            $sql .= " where  no = '".$data["next_no"  ]."'";
                            $sql .= " and    depth > '".$data["depth"  ]."'";
                            simpleSQLExecute($sql);
                        }
                    }
                    else             MessageExit('S', $msgNo,"", $skinDir);

                    $sercurity_cotent_chk = $_SESSION['sercurity_cotent_chk'];
                    $sercurity_stats = preg_match("/%${id}_${no}/", $sercurity_cotent_chk);
                    if ( $use_st == 1 && !$sercurity_stats ) {
                        $sercurity_cotent_chk = '%' . $id .'_' . $no . $sercurity_cotent_chk;
                        if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0이하
                            @session_register('sercurity_cotent_chk');
                        } else {
                            $_SESSION['sercurity_cotent_chk'] = $sercurity_cotent_chk;  // 4.10 세션 처리.
                        }
                    }

                    $retunPage = getUrlPath ($HTTP_REFERER) . getReqPageName ($HTTP_REFERER);

        //          $retunPage .= '&exec=' . 'list' ;
                    // 입력 처리후 이동 페이지
                    // '1' : list
                    // '2' : view
                    // '3' : insert
                    if ( $write_move_page == '1' )        { // 목록
                        $retunPage .= '?id=' . $id    ;
                        $retunPage .= '&s='  . $s .  '&exec=' . 'list' ;
                    } else if ( $write_move_page == '2' ) { // 보기
                        $retunPage .= '?id=' . $id                     ;
                        $retunPage .= '&no=' . $no . '&exec=' . 'view' ;
                    } else if ( $write_move_page == '3' ) { // 입력
                        $retunPage .= '?id=' . $id                     ;
                        $retunPage .= '&s='  . $s .  '&exec=' . 'insert' ;
                    } else {
                        $retunPage .= '&s='  . $s;
                    }
                } else {
                    MessageExit('S', '0015',"", $skinDir); // 수정할 게시물 없음
                }

            } else if ( $exec == 'answer_exec' ) {
                $sql = "select g_no, depth, o_seq, next_no, e_mail, name, mail_yn from $tb_bbs_data" . "_" . $id . " where no = $no;";
                $data = simpleSQLExecute($sql);
                if  ( !$data ) {
                    MessageExit('S', '0020',"", $skinDir); // 답변 글정보 오류
                }
                $data = singleRowSQLQuery($sql);
                $g_no  = $data['g_no'   ];
                $depth = $data['depth'  ];
                $o_seq = $data['o_seq'  ];
                $nextNo= $data['next_no']; // 이후 글 번호
                $preNo = $no             ; // 이전 글 번호

                $to_mail_yn = $data    ['mail_yn']; // 답변시 메일 받기
                $to_mail    = $data    ['e_mail' ]; // 받는 사람 이메일 주소
                $to_name    = $data    ['name'   ]; // 받는 사람 이름

                $newNo = simpleSQLQuery("select MAX(no) from $tb_bbs_data" . "_" . $id);
                if ( !$newNo ) { $newNo = 0; }   // 게시물 번호 생성
                $newNo = $newNo + 1;

                $sql  = "update $tb_bbs_data" . "_" . $id;
                $sql .= " set   pre_no = $newNo  ";
                $sql .= " where pre_no  = $no";
                simpleSQLExecute($sql);

                $sql  = "update $tb_bbs_data" . "_" . $id;
                $sql .= " set next_no = $newNo";
                $sql .= " where no = $no;";
                simpleSQLExecute($sql);

                $sql  = "update $tb_bbs_data" . "_" . $id;
                $sql .= " set   o_seq = o_seq + 1  ";
                $sql .= " where g_no  = $g_no";
                $sql .= " and   o_seq > $o_seq;";
                simpleSQLExecute($sql);

                // 정렬 순서, 답변 레벨을 1씩 증가 시킴니다.
                $o_seq   = $o_seq + 1;
                $depth   = $depth + 1;

                if ( !escapeYN () ) { // magic_quotes_gpc Off
                    $f_name1 = addslashes($upFile->name[0]);
                    $f_name2 = addslashes($upFile->name[1]);
                } else {
                    $f_name1  = $upFile->name[0];
                    $f_name2  = $upFile->name[1];
                }

                if ( $upFile->size[0] <= 0 ) { $httpUrl1 = ''; }
                if ( $upFile->size[1] <= 0 ) { $httpUrl2 = ''; }

                $sql  = "insert into $tb_bbs_data" . "_" . $id;
                $sql .= "(";
                $sql .= "no         , cat_no     ,g_no         ,depth       , ";
                $sql .= "o_seq      , pre_no     , next_no     ,";
                $sql .= "member_level,";
                $sql .= "user_id    , name       ,password     , title      ,";
                $sql .= "content    , e_mail     ,home         ,             ";
                $sql .= "f_path1    , f_name1    ,f_ext1       , f_size1    ,";
                $sql .= "f_date1    ,";
                $sql .= "f_path2    , f_name2    ,f_ext2       , f_size2    ,";
                $sql .= "f_date2    ,";
                $sql .= "reg_date   , html_yn    ,mail_yn      , use_st     ,";
                $sql .= "recom_hit  , hit        ,total_comment,ip          ";
                $sql .= ") values (";
                $sql .= "$newNo     , $cat_no    , $g_no      , $depth       ,";
                $sql .= "$o_seq     , $preNo     , $nextNo    ,";
                $sql .= "'" . $memInfor['member_level'] . "',";
                $sql .= "'$user_id' , '$name'   , PASSWORD('$password'), '$title'   ,";
                $sql .= "'$content' , '$e_mail' , '$home', ";
                $sql .= "'$httpUrl1', '$f_name1' ,'". $upFile->ext[0] . "', '" . (!$upFile->size[0]?0:$upFile->size[0]). "'   ,";
                $sql .= "'".$upFile->real_nm[0] ."' , ";
                $sql .= "'$httpUrl2', '$f_name2' ,'". $upFile->ext[1] . "', '" . (!$upFile->size[1]?0:$upFile->size[1]). "'   ,";
                $sql .= "'".$upFile->real_nm[1] ."' , ";
                $sql .= "'". getYearToMicro()."' , '$html_yn', '$mail_yn'    , '$use_st' ,";
                $sql .= "0, 0, 0, '$ip'";
                $sql .= ");";
                simpleSQLExecute($sql);

                $displayWrite = ''; // 쓰기 표시 항목
                if ( $_GET['display_write'] || !$display_write ) {
                    $displayWrite = $bbsInfor['display_write'];
                } else {
                    if ( !is_numeric ( $display_write) ) {
                        $displayWrite = $bbsInfor['display_write'];
                    } else {
                        $displayWrite = $display_write;
                    }
                }

                if ( $displayWrite[5] && $to_mail_yn == 'Y' ) {
                    $from_mail  = $e_mail;
                    $from_name  = $name  ;

                    include ( $baseDir . 'common/mail.inc'      ); // 메일 관련

                    if ( !$from_name ) $from_name = '행복을 찾는 사람..' ; // 보내는 사람 이름
                    if ( !$to_name   ) $to_name   = '행복한 사람들에게..'; // 받는   사람 이름

                    $content = stripslashes($content); // 입력하면서 애드했던 슬래쉬빼기
                    $title   = stripslashes($title  ); // 입력하면서 애드했던 슬래쉬빼기

                    if ( $html_yn == 'B' ) {    // HTML <BR> 지원
                        $content = nl2br ( $content );   /* 내용 */
                    } else if ( $html_yn != 'Y' ) {     // HTML 지원 안함
                        $content = str_replace("  ", "&nbsp;&nbsp;", $content );
                        $content = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$content );
                        $content = str_replace("<","&lt;",$content);
                        $content = nl2br ( $content );   /* 내용 */
                    }

                    if ( check_email ( $to_mail ) ) {
                        $from_mail = $from_name . ' ' . "<$from_mail>";
                        $to_mail   = $to_name   . ' ' . "<$to_mail>"  ;
                        @mail_sender( $from_mail, $to_mail, $title, $content ); // 메일 발송
                    }
                }

                $point=0;
                $point       = getPointGrant ($id, $memInfor['member_level'], 5); // 답글 작성 포인트
                $uploadPoint = getPointGrant ($id, $memInfor['member_level'], 3); // 파일 업로드 포인트

                if ( $f_name1 ) { $point += $uploadPoint; }
                if ( $f_name2 ) { $point += $uploadPoint; }

                setPointGrant ($user_id, $point); // 포인트 추가

                $sercurity_cotent_chk = $_SESSION['sercurity_cotent_chk'];
                if ( $use_st == 1 ) {
                    $sercurity_cotent_chk = $id .'_' . $newNo . '%' . $sercurity_cotent_chk;

                    if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0이하
                        @session_register('sercurity_cotent_chk');
                    } else {
                        $_SESSION['sercurity_cotent_chk'] = $sercurity_cotent_chk;  // 4.10 세션 처리.
                    }
                }

                $retunPage  = getUrlPath ($HTTP_REFERER) . getReqPageName ($HTTP_REFERER);

                // 입력 처리후 이동 페이지
                // '1' : list
                // '2' : view
                // '3' : insert
                if ( $write_move_page == '1' )        { // 목록
                    $retunPage .= '?id='   . $id    ;
                    $retunPage .= '&exec=' . 'list' ;
                } else if ( $write_move_page == '2' ) { // 보기
                    $retunPage .= '?id='   . $id    ;
                    $retunPage .= '&no=' . $newNo . '&exec=' . 'view' ;
                } else if ( $write_move_page == '3' ) { // 입력
                    $retunPage .= '?id='   . $id    ;
                    $retunPage .= '&exec=' . 'insert' ;
                }
                $retunPage .= '&s='    . $s     ;
            }

            if ( $poll_id   ) $retunPage .= "&poll_id=$poll_id"    ;
            if ( $poll_exec ) $retunPage .= "&poll_exec=$poll_exec";

            $retunPage .= '&npop=' . $npop;
            redirectPage($retunPage);
        } // if END

    }
}
?>