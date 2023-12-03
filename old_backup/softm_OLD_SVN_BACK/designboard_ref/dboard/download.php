<?
/*------- 조회 데이터가 존재 하지 않아 에러가 발생할 수 있읍니다.--------------*/
// 주의 사항 다운로드시에는 header정보를 변경함으로 header를 설정하기 전에.
// 표준 입출력 장치로 정보가 보여지게 되는 Process는 에러를 발생시킵니다.
// 그럼으로 header를 이용하여 Rediection을 시킴니다.
        if ( !$HTTP_GET_VARS['no'] ) { 
            echo 'DOWNLOAD PAGE';
            exit;
        } else if ( $HTTP_GET_VARS['no'] ) {
            $no = $HTTP_GET_VARS['no'];
//          header("location:download_ok.php?id=$id&no=$no");
//	        redirectPage("download_ok.php?id=$id&no=$no");
            include 'common/board_lib.inc' ; // 게시판 라이브러리

            include 'common/lib.inc'       ; // 공통 라이브러리
            include 'common/db_connect.inc'; // Data Base 연결 클래스
            include 'common/_service.inc'  ; // 서비스 화면 관련
            $db = initDBConnection ();             // 데이터베이스 접속

            $memInfor = getMemInfor     (                              ); // 회원   정보
            $admin_yn = $memInfor['admin_yn'];
            $user_id  = $memInfor['user_id' ];

            $bbsGrant = getBbsGrantByID ($id,$memInfor['member_level'] ); // 권한   정보

            if ( $bbsGrant['grant_down'] == 'Y' ) {

                $sql = "select no, user_id, f_path1, f_name1, f_ext1, f_size1, f_date1, f_path2, f_name2, f_ext2, f_size2, f_date2, use_st from $tb_bbs_data" . "_" . $id . " where no = '".$no."'";
                $data = singleRowSQLQuery($sql);

                $sql  = "update $tb_bbs_data" . "_" . $id;

                if ( $gubun == '1' ) {
                    $f_path   = $data["f_path1"  ];  // 파일 경로1
                    $f_name   = $data["f_name1"  ];  // 파일 명1
                    $f_ext    = $data["f_ext1"   ];  // 확장자 명1
                    $f_date   = $data["f_date1"  ];  // 저장 파일명1
                    $w_user_id= $data["user_id"  ];  // 작성자 아이디
                    $use_st   = $data["use_st"   ];  // 글 상태

                    $down_hit1_cotent_chk   = $HTTP_SESSION_VARS['down_hit1_cotent_chk'];
                    $down_hit1_cotent_stats = ereg('%' . $id . '_' . $no, $down_hit1_cotent_chk);
//                    echo ' $down_hit1_cotent_chk  : ' . $down_hit1_cotent_chk   . '<BR>';
//                    echo ' $down_hit1_cotent_stats: ' . $down_hit1_cotent_stats . '<BR>';
                    $sql .= " set   down_hit1 = down_hit1 + 1";
                } else if ( $gubun == '2' ) {
                    $f_path   = $data["f_path2"  ];  // 파일 경로2
                    $f_name   = $data["f_name2"  ];  // 파일 명2
                    $f_ext    = $data["f_ext2"   ];  // 확장자 명2
                    $f_date   = $data["f_date2"  ];  // 저장 파일명2
                    $w_user_id= $data["user_id"  ];  // 작성자 아이디
                    $use_st   = $data["use_st"   ];  // 글 상태

                    $down_hit2_cotent_chk   = $HTTP_SESSION_VARS['down_hit2_cotent_chk'];
                    $down_hit2_cotent_stats = ereg('%' . $id . '_' . $no, $down_hit2_cotent_chk);
                    $sql .= " set   down_hit2 = down_hit2 + 1";
                }
                $sql .= " where no  = '$no';";

                $down_grant = 'N';
                if ( ( $use_st == '1' && $user_id == $w_user_id ) || $use_st != '1' || $admin_yn == 'Y' ) {
                    // 비공개글을 쓴 사용자, 비공개글이 아닌 글, 관리자 다운 가능합니다.
                    $down_grant = 'Y';
                }

                if ( $down_grant == 'Y' ) {
                    if ( $gubun == '1' && !$down_hit1_cotent_stats ) {
                        $down_hit1_cotent_chk = '%' . $id . '_' . $no . $down_hit1_cotent_chk;
                        @session_register('down_hit1_cotent_chk');
						$_SESSION['down_hit1_cotent_chk'] = $down_hit1_cotent_chk;  // 4.10 세션 처리.
                        simpleSQLExecute($sql);
                    }

                    if ( $gubun == '2' && !$down_hit2_cotent_stats ) {
                        $down_hit2_cotent_chk = '%' . $id . '_' . $no . $down_hit2_cotent_chk;
                        @session_register('down_hit2_cotent_chk');
						$_SESSION['down_hit2_cotent_chk'] = $down_hit2_cotent_chk;  // 4.10 세션 처리.
                        simpleSQLExecute($sql);
                    }

                    if ( $data['no'] ) {    
						$file    = $baseDir . "data/file/" . $id. "/$f_date.$f_ext";
                        $REAL_FILE = "$f_name.$f_ext"       ;
                        if ( @is_file("$file") ) {
                            downHeader($file, $REAL_FILE);
                            $fp = fopen($file, "r"); 
                            if (!fpassthru($fp)) fclose($fp);
                            flush();
                            $point=0;
                            $point       = getPointGrant ($id, $memInfor['member_level'], 4); // 다운로드 포인트
                            setPointGrant ($user_id, $point); // 포인트 추가
                        } else {
                            include 'common/message_table.inc'; // 메시지 테이블
                            echo ( "<SCRIPT LANGUAGE='JavaScript'>\n");
                            echo ( "<!--\n");
                            echo ( "    alert ('". $errMsgTable['S0066'] . " ( " . $file . " )');\n"); // 파일이 존재하지 않음
							echo ( "    self.document.location.replace ('about:blank');\n");
                            echo ( "//-->\n");
                            echo ( "</SCRIPT>\n");
                        }
                    }
                } else {
					include 'common/message_table.inc'; // 메시지 테이블
                    echo ( "<SCRIPT LANGUAGE='JavaScript'>\n");
                    echo ( "<!--\n");
                    echo ( "    alert ('". $errMsgTable['S0060'] ."');\n"); // 다운로드 권한 없음. ( 비밀글 )
					echo ( "    self.document.location.replace ('about:blank');\n");
                    echo ( "//-->\n");
                    echo ( "</SCRIPT>\n");
                }
                if ( $db ) closeDBConnection (); // db disconnect
            } else {
				include 'common/message_table.inc'; // 메시지 테이블
                echo ( "<SCRIPT LANGUAGE='JavaScript'>\n");
                echo ( "<!--\n");
                echo ( "    alert ('". $errMsgTable['S0051'] ."');\n"); // 다운로드 권한 없음.
				echo ( "    self.document.location.replace ('about:blank');\n");
                echo ( "//-->\n");
                echo ( "</SCRIPT>\n");
            }
        }
?>