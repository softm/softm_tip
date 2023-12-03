<?
if ( function_exists('_head') ) {
    $p_exec = getUrlParamValue($HTTP_REFERER, 'exec');

    if ( $id && $grant == 'Y' && $exec == 'delete_exec' && $p_exec == 'delete' && 
         !ereg( "(".$HTTP_SERVER_VARS['HTTP_HOST'].")((.)*(/)+)+(delete_exec.php)", $HTTP_SERVER_VARS['HTTP_HOST'] . $HTTP_SERVER_VARS['PHP_SELF'] ) &&
         $REQUEST_METHOD == 'POST' && ereg($HTTP_HOST,$HTTP_REFERER) ) {

        if ( $bbsInfor ) { // 게시판 정보 존재

            if ( $login_yn == 'N' && !$password ) {
                Message ('S', '0013',""); // 게시판 입력 스킨 구성에서 password 필드가 빠져서 작성됨
                                          // 로그인을 안했을 경우에는 반드시 비밀번호가 입력되어야 합니다.
            }

            $sql  = "select no, g_no, o_seq, depth, pre_no, next_no, user_id, f_path1, f_ext1, f_date1, f_path2, f_ext2, f_date2 from $tb_bbs_data" . "_" . $id . " where no = $no;";

            $data = singleRowSQLQuery($sql);
            $w_user_id= $data["user_id"];  // 작성자 아이디
            $g_no     = $data['g_no'   ];
            $o_seq    = $data['o_seq'  ];
            $depth    = $data['depth'  ];
            $preNo    = $data['pre_no' ];
            $nextNo   = $data['next_no'];

            $f_path1  = $data["f_path1" ]; // 파일 경로1
            $f_ext1   = $data["f_ext1"  ]; // 확장자 명1
            $f_date1  = $data["f_date1" ]; // 저장 파일명1
            $f_name1  = $data["f_name1" ]; // 실제 파일명1

            $f_path2  = $data["f_path2" ]; // 파일 경로2
            $f_ext2   = $data["f_ext2"  ]; // 확장자 명2
            $f_date2  = $data["f_date2" ]; // 저장 파일명2
            $f_name2  = $data["f_name2" ]; // 실제 파일명2

            // $file1    = "$f_path1$f_date1.$f_ext1";
            // $file2    = "$f_path2$f_date2.$f_ext2";

			$file1    = $baseDir . "data/file/" . $id. "/$f_date1.$f_ext1";
			$file2    = $baseDir . "data/file/" . $id. "/$f_date2.$f_ext2";

            $ip       = $REMOTE_ADDR; // 아이피 주소

            if ( $w_user_id && $login_yn == 'Y' ) { // 회원   글
                $sql0  = "select COUNT(no) from $tb_bbs_data" . "_" . $id;

                $sql0 .= " where no = $no ";
                if ( $admin_yn != 'Y' ) { // 관리자 경우 조건 스킵
                    $sql0 .= " and user_id = '$user_id';";
                }
                $existChk = simpleSQLQuery($sql0);
            } else if ( !$w_user_id )             { // 비회원 글
                $sql0  = "select COUNT(no) from $tb_bbs_data" . "_" . $id; 
                $sql0 .= " where no = $no";
                if ( $admin_yn != 'Y' ) {
                    $sql0 .= " and password = PASSWORD('$password');";
                }
                $existChk = simpleSQLQuery($sql0);
            }

            if ( $existChk ) {
                $sql  = "select COUNT(no) from $tb_bbs_data" . "_" . $id; 
                $sql .= " where g_no = $g_no and o_seq = $o_seq + 1 and depth = $depth + 1;";
                $subChk= simpleSQLQuery($sql);
                if ( $subChk ) {                  // 삭제 자료가 답글이 존재하는 경우
                    $sql  = "update $tb_bbs_data" . "_" . $id;
                    $sql .= " set   ip     = '$ip',";
                    if ( $admin_yn == 'Y' ) {
                        $sql .= " use_st = 9    "; // 관리자에 의해 삭제
                    } else {
                        $sql .= " use_st = 8    "; // 사용자에 의해 삭제
                    }
                    $sql .= " where no  = $no";
                    simpleSQLExecute($sql);

                    $sql  = "update $tb_bbs_data" . "_" . $id;
                    $sql .= " set   pre_no = $preNo";
                    $sql .= " where no = $nextNo";
                    simpleSQLExecute($sql);

                    $sql  = "update $tb_bbs_data" . "_" . $id;
                    $sql .= " set   next_no = $nextNo";
                    $sql .= " where no = $preNo";
                    simpleSQLExecute($sql);

                } else {
                    $sql  = "delete from $tb_bbs_data" . "_" . $id . " where no = $no;";
                    simpleSQLExecute($sql);

                    $sql  = "update $tb_bbs_data" . "_" . $id;
                    $sql .= " set   pre_no = $preNo";
                    $sql .= " where no = $nextNo";
                    simpleSQLExecute($sql);

                    $sql  = "update $tb_bbs_data" . "_" . $id;
                    $sql .= " set   next_no = $nextNo";
                    $sql .= " where no = $preNo";
                    simpleSQLExecute($sql);

                    $sql  = "delete from $tb_bbs_comment" . "_" . $id;
                    $sql .= " where p_no = $no";
                    simpleSQLExecute($sql);

                    if ( @is_file("$file1") ) {
                        @unlink ( "$file1" ) or Message ("S", "0023","", $skinDir); // 파일 삭제중 에러.
                    }
                    if ( @is_file("$file2") ) {
                        @unlink ( "$file2" ) or Message ("S", "0023","", $skinDir); // 파일 삭제중 에러.
                    }
                }

                $point = 0;
				if ( $depth ) { // 답변글
					$point      -= getPointGrant ($id, $memInfor['member_level'], 5); // 답글 작성 포인트
					$uploadPoint = getPointGrant ($id, $memInfor['member_level'], 3); // 파일 업로드 포인트
					if ( $f_name1 ) $point -= $uploadPoint;
					if ( $f_name2 ) $point -= $uploadPoint;
				} else {
					$point      -= getPointGrant ($id, $memInfor['member_level'], 1); // 게시물 작성 포인트
					$uploadPoint = getPointGrant ($id, $memInfor['member_level'], 3); // 파일 업로드 포인트

					if ( $f_name1 ) $point -= $uploadPoint;
					if ( $f_name2 ) $point -= $uploadPoint;
				}
				setPointGrant ($user_id, $point); // 포인트 감산

            } else {
                if ( $login_yn == 'Y' )         { // 회원 오류
                    Message ('S', '0018',""); // 삭제 사용자 틀림
                } else if ( $login_yn == 'N' )  { // 비회원 오류
                    Message ('S', '0017',""); // 삭제 비밀번호 틀림
                }
            }

            $retunPage = getUrlPath ($HTTP_REFERER) . getReqPageName ($HTTP_REFERER);
            $retunPage .= '?id='   . $id    ;
    //      $retunPage .= '&exec=' . 'list' ;
            redirectPage($retunPage);
        }
    }
}
?>