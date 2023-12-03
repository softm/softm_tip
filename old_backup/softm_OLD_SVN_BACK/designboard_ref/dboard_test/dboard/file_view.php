<?
/*------- 조회 데이터가 존재 하지 않아 에러가 발생할 수 있읍니다.--------------*/
// 주의 사항 다운로드시에는 header정보를 변경함으로 header를 설정하기 전에.
// 표준 입출력 장치로 정보가 보여지게 되는 Process는 에러를 발생시킵니다.
// 그럼으로 header를 이용하여 Rediection을 시킴니다.
        if ( !$_GET['no'] ) { 
            echo 'FILE VIEW PAGE';
            exit;
        } else if ( $_GET['no'] ) {
            $no = $_GET['no'];
            $page_gubun = $_GET['page_gubun'];
//          header("location:download_ok.php?id=$id&no=$no");
//	        redirectPage("download_ok.php?id=$id&no=$no");
            include ( 'common/lib.inc'          ); // 공통 라이브러리
            include ( 'common/db_connect.inc'   ); // Data Base 연결 클래스
            include ( 'common/_service.inc'     ); // 서비스 화면 관련
            include ( 'common/message.inc'      ); // 에러 페이지 처리

            include 'common/board_lib.inc'    ; // 게시판 라이브러리

            $db = initDBConnection ();             // 데이터베이스 접속

            $memInfor = getMemInfor     (                              ); // 회원   정보
            $admin_yn = $memInfor['admin_yn'];
            $user_id  = $memInfor['user_id' ];

            $bbsGrant = getBbsGrantByID ($id,$memInfor['member_level'] ); // 권한   정보
            $bbsInfor = getBbsInfor ($id                               ); // 게시판 정보
            $_skinName = ''; // 스킨명
            if ( $_GET['skin_name'] || !$skin_name ) {
                $_skinName  = $bbsInfor['skin_name'];
            } else {
                $_skinName  = $skin_name;
            }
            $skinDir  = 'skin/board/' . $_skinName . '/'   ;
            $msgNo = '';

            if      ( $page_gubun == 'list' ) { $msgNo = 'S0061'; }
            else if ( $page_gubun == 'view' ) { $msgNo = 'S0062'; }

            if ( ( $msgNo && $page_gubun = 'list' && $bbsGrant['grant_list'] == 'Y' ) ||
                 ( $msgNo && $page_gubun = 'view' && $bbsGrant['grant_view'] == 'Y' ) ) {

                // no, user_id, f_path1, f_name1, f_ext1, f_size1, f_date1, f_path2, f_name2, f_ext2, f_size2, f_date2, use_st
                $sql = "select * from $tb_bbs_data" . "_" . $id . " where no = '".$no."'";
                $data = singleRowSQLQuery($sql);

                $sql  = "update $tb_bbs_data" . "_" . $id;

                if ( $gubun == '1' ) {
                    $f_path   = $data["f_path1"  ];  // 파일 경로1
                    $f_name   = $data["f_name1"  ];  // 파일 명1
                    $f_ext    = $data["f_ext1"   ];  // 확장자 명1
                    $f_date   = $data["f_date1"  ];  // 저장 파일명1
                    $w_user_id= $data["user_id"  ];  // 작성자 아이디
                    $use_st   = $data["use_st"   ];  // 글 상태

                    $down_hit1_cotent_chk   = $_SESSION['down_hit1_cotent_chk'];
                    $down_hit1_cotent_stats = preg_match("/%${id}_${no}/", $down_hit1_cotent_chk);
//                  echo ' $down_hit1_cotent_chk  : ' . $down_hit1_cotent_chk   . '<BR>';
//                  echo ' $down_hit1_cotent_stats: ' . $down_hit1_cotent_stats . '<BR>';
                    $sql .= " set   down_hit1 = down_hit1 + 1";
                } else if ( $gubun == '2' ) {
                    $f_path   = $data["f_path2"  ];  // 파일 경로2
                    $f_name   = $data["f_name2"  ];  // 파일 명2
                    $f_ext    = $data["f_ext2"   ];  // 확장자 명2
                    $f_date   = $data["f_date2"  ];  // 저장 파일명2
                    $w_user_id= $data["user_id"  ];  // 작성자 아이디
                    $use_st   = $data["use_st"   ];  // 글 상태

                    $down_hit2_cotent_chk   = $_SESSION['down_hit2_cotent_chk'];
                    $down_hit2_cotent_stats = preg_match("/%${id}_${no}/", $down_hit2_cotent_chk);
                    $sql .= " set   down_hit2 = down_hit2 + 1";
                }
                $sql .= " where no  = '$no';";

                $file_grant = 'N';
                if ( ( $use_st == '1' && $user_id == $w_user_id ) || $use_st != '1' || $admin_yn == 'Y' ) {
                    // 비공개글을 쓴 사용자, 비공개글이 아닌 글, 관리자 다운 가능합니다.
                    $file_grant = 'Y';
                }

                if ( $file_grant == 'Y' ) {
                    if ( $gubun == '1' && !$down_hit1_cotent_stats ) {
                        $down_hit1_cotent_chk = '%' . $id . '_' . $no . $down_hit1_cotent_chk;
                        if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0이하
                            @session_register('down_hit1_cotent_chk');
                        } else {
                            $_SESSION['down_hit1_cotent_chk'] = $down_hit1_cotent_chk;  // 4.10 세션 처리.
                        }
                        simpleSQLExecute($sql);
                    }

                    if ( $gubun == '2' && !$down_hit2_cotent_stats ) {
                        $down_hit2_cotent_chk = '%' . $id . '_' . $no . $down_hit2_cotent_chk;
                        if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0이하
                            @session_register('down_hit2_cotent_chk');
                        } else {
                            $_SESSION['down_hit2_cotent_chk'] = $down_hit2_cotent_chk;  // 4.10 세션 처리.
                        }
                        simpleSQLExecute($sql);
                    }

                    if ( $data['no'] ) {    
						$file    = $baseDir . "data/file/" . $id. "/$f_date.$f_ext";
                        $REAL_FILE = "$f_name.$f_ext"       ;
                        $imgInfor = getimagesize($file);
/*
                        logs ( '0 : '. $imgInfor[0] . '<BR>' , true);
                        logs ( '1 : '. $imgInfor[1] . '<BR>' , true);
                        logs ( '2 : '. $imgInfor[2] . '<BR>' , true);
                        logs ( '3 : '. $imgInfor[3] . '<BR>' , true);
                        logs ( '4 : '. $imgInfor[4] . '<BR>'. "\n" , true);
*/
                        // 1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, 7 = TIFF(intel byte order), 
                        // 8 = TIFF (motorola byte order, 9 = JPC, 10 = JP2, 11 = JPX.
                        $window_width = '';
                        $window_height= '';
                        if ( $mode == 'img' ) {
                            if ( $display_mode == '1' && ( ( $imgInfor[2] > 0 && $imgInfor[2] < 4 ) || $imgInfor[2] == 6 ) ) {
                                $window_width  = $imgInfor[0] + 12; // 가로
                                $window_height = $imgInfor[1] + 32; // 세로
                            } else if ( $display_mode == '2' ) {
                                $window_width  = $img_w + 12;
                                $window_height = $img_h + 32;
                            } else if ( $display_mode == '3' ) {
                                $img_w = $img_w + 12;
                                $img_h = $img_h + 32;
                                $window_width  = $popup_w; // 가로
                                $window_height = $popup_h; // 세로
                            }
                            if ( (int) $plus_w ) { $window_width  =  $window_width  + (int) $plus_w; }
                            if ( (int) $plus_h ) { $window_height =  $window_height + (int) $plus_h; }
                        } else if ( $mode == 'media' ) {
                            $window_width  = $media_w; // 가로
                            $window_height = $media_h; // 세로
                        }
                        if ( @is_file("$file") ) {
//                          include $skinDir . "file_view.php";

                            echo ( "<script type='text/javascript'>\n");
                            echo ( "<!--\n");
                            echo ( "    var window_width  = '$window_width';\n");
                            echo ( "    var window_height = '$window_height';\n");
                            echo ( "    var winPro        = '';\n");
//                          echo ( "   parent.fpWin.close();\n");
                            echo ( "   winPro       = 'toolbar=no,menubar=no,resizable=yes,scrollbars=no,top=0,left=0'\n");
                            echo ( "   if ( window_width > screen.width ) {\n");
                            echo ( "       window_width = screen.width;\n");
                            echo ( "       winPro       = 'toolbar=no,menubar=no,resizable=yes,scrollbars=yes,top=0,left=0'\n");
                            echo ( "   }\n");
                            echo ( "   if ( window_height > screen.height ) {\n");
                            echo ( "       window_height = screen.height;\n");
                            echo ( "       winPro       = 'toolbar=no,menubar=no,resizable=yes,scrollbars=yes,top=0,left=0'\n");
                            echo ( "   }\n");
                            echo ( "   var fpWin = window.open('about:blank','".$no . '_' . $id . "', winPro + ',width=' + window_width + ',height=' + window_height );\n");

//                          echo ( "    var obj = getObject( 'test' );\n");
//                          echo ( "    alert ( getObject( 'test' ) );\n");
//                          echo ( "    alert ( obj.innerHTML );\n");
// window.document.body.innerHTML 
                            $fp = '';
                            if ( $mode == 'img' ) {
                                $fp = fopen ($skinDir . "popup_image.php", "r");
                            } else if ( $mode == 'media' ) {
                                $fp = fopen ($skinDir . "popup_media.php", "r");
                            }
                            echo ( "    fpWin.document.open();\n");
                            while (!feof ($fp)) {
                                $content = fgets ($fp,1024);
                                $content = str_replace("\n", "", $content);
                                $content = str_replace("\r", "", $content);
                                $content = str_replace('<?=$f_name?' . '>', $f_name, $content);
                                if ( $mode == 'img' ) {
                                    if ( $display_mode == '2' ) {
                                        $t_size  = ( $img_w ) ? " width='"  . $img_w . "'" : ' ';
                                        $t_size .= ( $img_h ) ? " height='" . $img_h . "'" : ' ';
                                        $content = str_replace('<?=$f_preview?' . '>', "<img  name='_dboard_display_obj' src='$file' $t_size border=0>", $content);
                                    } else if ( $display_mode == '3') {
                                        $t_size  = ( $img_w ) ? " width='"  . $img_w . "'" : ' ';
                                        $t_size .= ( $img_h ) ? " height='" . $img_h . "'" : ' ';
                                        $content = str_replace('<?=$f_preview?' . '>', "<img src='$file' border=0 $t_size>", $content);
                                    } else {
                                        $content = str_replace('<?=$f_preview?' . '>', "<img src='$file' border=0>", $content);
                                    }
                                } else if ( $mode == 'media' ) {

                                    $t_media  = ( $show       == 'Y' ) ? " hidden=false"   : ' hidden=true'    ;
                                    $t_media .= ( $auto_start == 'Y' ) ? " autostart=true" : ' autostart=false';

                                    if ( $loop == 'Y' ) { // 무한 루프
                                        $t_media .= " loop=-1";
                                    } else if ( $loop == 'N' ) { // 한번 재생
                                        $t_media .= " loop";
                                    } else {                               // 순환 횟수 지정
                                        $t_media .= " loop=" . $loop;
                                    }

                                    $t_media .= ( $media_player_w            ) ? " width="  . $media_player_w : ' ';
                                    if ( strpos("[wav, mp3, mp2]", strtolower ($f_ext) ) == false ) { // 음악 파일은 높이 조정안함
                                        $t_media .= ( $media_player_h           ) ? " height=" . $media_player_h: ' ';
                                    }

                                    $content = str_replace('<?=$f_preview?' . '>', '<embed name=\"_dboard_display_obj\" src=\"' . $file . '\" ' . $t_media . '></embed>', $content);
                                }
                                echo ( "    fpWin.document.writeln(\"$content\");\n");
                            }
//                          echo ( "    fpWin.document.write(\"$content\");\n");
//                          echo ( "    fpWin.document.write(obj.innerHTML);\n");

                            echo ( "    fpWin.document.close();\n");
                            echo ( "    fpWin.resizeTo(window_width, window_height);\n");
                            echo ( "    fpWin.focus();\n");
							echo ( "    self.document.location.replace ('about:blank');\n");
//                          echo ( "    alert (parseInt(width) + ' ' + parseInt(height) );\n");
//                          echo ( "    alert (parent.fpWin.width + ' ' + parent.fpWin.height);\n");
//                          echo ( "    alert ( obj.innerHTML );\n");
                            echo ( "//-->\n");
                            echo ( "</SCRIPT>\n");

                        } else {
							include 'common/message_table.inc'; // 메시지 테이블
                            echo "해당 파일이나 경로가 존재하지 않습니다.";
                            echo ( "<script type='text/javascript'>\n");
                            echo ( "<!--\n");
                            echo ( "    alert ('". $errMsgTable['S0066'] ."');\n"); // 파일 접근 권한이 없음
							echo ( "    self.document.location.replace ('about:blank');\n");
                            echo ( "//-->\n");
                            echo ( "</SCRIPT>\n");
                        }
                    }
                } else {
					include 'common/message_table.inc'; // 메시지 테이블
                    echo ( "<script type='text/javascript'>\n");
                    echo ( "<!--\n");
                    echo ( "    alert ('". $errMsgTable[$msgNo] ."');\n"); // 다운로드 권한 없음. ( 비밀글 )
					echo ( "    self.document.location.replace ('about:blank');\n");
                    echo ( "//-->\n");
                    echo ( "</SCRIPT>\n");
                }
                closeDBConnection (); // 데이터베이스 연결 설정 해제
            } else {
				include 'common/message_table.inc'; // 메시지 테이블
                echo ( "<script type='text/javascript'>\n");
                echo ( "<!--\n");
                echo ( "    alert ('". $errMsgTable['S0061'] ."');\n"); // 파일 접근 권한이 없음
				echo ( "    self.document.location.replace ('about:blank');\n");
                echo ( "//-->\n");
                echo ( "</SCRIPT>\n");
            }
        }
?>