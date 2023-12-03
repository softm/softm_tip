<?
if ( function_exists('head') ) {
    $p_no = getUrlParamValue($HTTP_REFERER, 'p_no'     );
    if      ( $package == 'board' ) { $tmp_id = $id      ; }
    else if ( $package == 'poll'  ) { $tmp_id = $poll_id ; $exec = $poll_exec;}

    if ( $tmp_id && $grant == 'Y' && ( $exec == 'insert_comment_exec' || $exec == 'delete_comment_exec' ) && preg_match("/${HTTP_HOST}/",$HTTP_REFERER) && $REQUEST_METHOD == 'POST' ) {
        $comment_table = ( $package == 'board' ) ?  $tb_bbs_comment : $tb_poll_comment;
        $INFOR         = ( $package == 'board' ) ?  $bbsInfor       : $pollInfor      ;

        if ( $INFOR )  { // 정보 존재
            $retunPage = getUrlPath ($HTTP_REFERER) . getReqPageName ($HTTP_REFERER);

            if ( $login_yn == 'N' && !$password ) {
                MessageExit('S', '0014',"",$skinDir);  // 의견글 스킨 구성에서 password 필드가 빠져서 작성됨
                                                    // 로그인을 안했을 경우에는 반드시 비밀번호가 입력되어야 합니다.
            }

            if ( $exec == 'insert_comment_exec' ) {
                if ( $package == 'board' ) {
                    $sql = "select MAX(no) from $comment_table" . "_" . $tmp_id. " where p_no = '". $no ."'";
                } else if ( $package == 'poll' ) {
                    $sql = "select MAX(no) from $comment_table" . "_" . $tmp_id;
                    $no = $tmp_id;
                }
                $newNo = simpleSQLQuery($sql);
                if ( !$newNo ) { $newNo = 0; }   // 게시물 번호 생성
                $newNo = $newNo + 1;

                $ip      = $REMOTE_ADDR        ; // 아이피 주소
                $name    = $_POST ['name' ];
                // magic_quotes_gpc Off
                if ( !escapeYN () ) {
                    $name    = addslashes($name   );
                    $memo    = addslashes($memo   );
                }

                $sql  = "insert into $comment_table" . "_" . $tmp_id;
                $sql .= "(";
                $sql .= "no, p_no, user_id, name, password, memo, ip, reg_date ";
                $sql .= ") values (";
                $sql .= "$newNo, $no, '$user_id', '$name', PASSWORD('$password'), '$memo', '$ip', '" . getYearToMicro() . "'";
                $sql .= ");";
//              logs ( '$sql : '. $sql . '<BR>' , true);
                simpleSQLExecute($sql);
                $point=0;
                if ( $package == 'board' ) {
                    $sql  = "update $tb_bbs_data" . "_" . $tmp_id . " set ";
                    $sql .= "total_comment = total_comment + 1 , ";
                    $sql .= "comment_date  = '" . getYearToSecond () . "'";
                    $sql .= "where no = $no;";
                    simpleSQLExecute($sql);

                    $point       = getPointGrant ($id, $memInfor['member_level'], 2); // 의견글 작성 포인트
                } else if ( $package == 'poll' ) {
					$point       = getPollPointGrant ($poll_id, $memInfor['member_level'], 2); // 의견글 작성 포인트
                }
				setPointGrant ($user_id, $point); // 포인트 추가

                if ( $package == 'board' ) {
                    if ( file_exists($skinDir ."view_main.php" ) ) {
                        $retunPage .= '?id='   . $tmp_id;
                        $retunPage .= '&no='   . $no    ;
                        $retunPage .= '&s='    . $s     ;
                        $retunPage .= '&npop=' . $npop  ;
                        $retunPage .= '&exec=view'      ;
                    } else {
                        $retunPage .= '?id='   . $tmp_id;
                        $retunPage .= '&s='    . $s     ;
                        $retunPage .= '&npop=' . $npop  ;
                        $retunPage .= '&exec=' . 'list' ;
                    }
                    if ( $poll_id   ) $retunPage .= "&poll_id=$poll_id"    ;
                    if ( $poll_exec ) $retunPage .= "&poll_exec=$poll_exec";
                    redirectPage($retunPage);
                } else if ( $package == 'poll' ) {
                    $params['id']      = $id    ;
                    $params['poll_id'] = $tmp_id;
                    $params['poll_no'] = $no    ;
                    $params['poll_exec'] = 'poll_result';     // form parameter 생성

                    formMove    ('moveForm',$retunPage, $params);
/*
                    $retunPage .= '?poll_id='   . $id    ;
                    $retunPage .= '&poll_no='   . $no    ;
                    $retunPage .= '&poll_exec=poll_result';
*/
                }
            } else if ( $exec == 'delete_comment_exec' ) {

                if ( $grant == 'Y' ) {
                    if ( $package == 'board' ) {
                       $sql  = "select user_id from $comment_table" . "_" . $tmp_id . " where p_no = '$p_no' and no ='$no'";
                    } else if ( $package == 'poll' ) {
                        $sql  = "select user_id from $comment_table" . "_" . $tmp_id . " where no ='$poll_no'";
                    }

                    $c_user_id = simpleSQLQuery($sql);

                    if ( $c_user_id && $login_yn == 'Y' ) { // 회원   글

                        if ( $package == 'board' ) {
                            $sql1  = "select COUNT(no) from $comment_table" . "_" . $tmp_id . " where p_no = '$p_no' and no ='$no'";
                            if ( $admin_yn != 'Y' ) { $sql1 .= " and user_id = '$user_id'";              } // 관리자의 경우
                        } else if ( $package == 'poll' ) {
                            $sql1  = "select COUNT(no) from $comment_table" . "_" . $tmp_id . " where no ='$poll_no'";
                            if ( $admin_yn != 'Y' ) { $sql1 .= " and user_id = '$user_id'";              } // 관리자의 경우
                        }

                        $existChk = simpleSQLQuery($sql1);
                    } else if ( !$c_user_id )             { // 비회원 글
                        if ( $package == 'board' ) {
                            $sql1  = "select COUNT(no) from $comment_table" . "_" . $tmp_id . " where p_no = '$p_no' and no ='$no'";
                            if ( $admin_yn != 'Y' ) { $sql1 .= " and password = PASSWORD('$password');"; } // 관리자의 경우
                        } else if ( $package == 'poll' ) {
                            $sql1  = "select COUNT(no) from $comment_table" . "_" . $tmp_id . " where no ='$poll_no'";
                            if ( $admin_yn != 'Y' ) { $sql1 .= " and password = PASSWORD('$password');"; } // 관리자의 경우
                        }
                        $existChk = simpleSQLQuery($sql1);
                    }

                    if ( $existChk ) {
                        if ( $package == 'board' ) {
                            $sql = "delete from $comment_table" . "_" . $tmp_id . " where p_no = '$p_no' and no ='$no';";
                        } else if ( $package == 'poll' ) {
                            $sql = "delete from $comment_table" . "_" . $tmp_id . " where no ='$poll_no';";
                        }
                        simpleSQLExecute($sql);

						$point = 0;
                        if ( $package == 'board' ) {
                            // 의견글 수 감소
                            $sql  = "update $tb_bbs_data" . "_" . $id . " set ";
                            $sql .= " total_comment = total_comment - 1";
                            $sql .= " where no = $p_no;";
                            simpleSQLExecute($sql);
							$point -= getPointGrant ($id, $memInfor['member_level'], 2); // 의견글 작성 포인트
						} else if ( $package == 'poll' ) {
							$point -= getPollPointGrant ($poll_id, $memInfor['member_level'], 2); // 의견글 작성 포인트
						}
						setPointGrant ($user_id, $point); // 포인트 추가
                    } else {
                        MessageExit('S', '0019',"",$skinDir); // 삭제 오류
                    }

                    if ( $package == 'board' ) {
                        if ( file_exists($skinDir ."view_main.php" ) ) {
                            $retunPage .= '?id='        . $tmp_id;
                            $retunPage .= '&no='        . $p_no  ;
                            $retunPage .= '&npop='      . $npop  ;
                            $retunPage .= '&exec=view'           ;
                        } else {
                            $retunPage .= '?id='   . $tmp_id;
                            $retunPage .= '&s='    . $s     ;
                            $retunPage .= '&npop=' . $npop  ;
                            $retunPage .= '&exec=' . 'list' ;
                        }
                        if ( $poll_id   ) $retunPage .= "&poll_id=$poll_id"    ;
                        if ( $poll_exec ) $retunPage .= "&poll_exec=$poll_exec";
                        redirectPage($retunPage);
                    } else if ( $package == 'poll' ) {
                        $params['id']      = $id    ;
                        $params['poll_id'] = $tmp_id;
                        $params['poll_no'] = $no    ;
                        $params['poll_exec'] = 'poll_result';     // form parameter 생성
                        formMove    ('moveForm',$retunPage, $params);
/*
                        $retunPage .= '?poll_id='   . $id    ;
                        $retunPage .= '&poll_exec=poll_result';
*/
                    }
                }
            }
            closeDBConnection (); // 데이터베이스 연결 설정 해제
        } // if END
    }
}
?>