<?
if ( function_exists('_head') ) {
    $p_exec = getUrlParamValue($HTTP_REFERER, 'exec');

    if ( $id && $grant == 'Y' && $exec == 'delete_exec' && $p_exec == 'delete' && 
         !ereg( "(".$HTTP_SERVER_VARS['HTTP_HOST'].")((.)*(/)+)+(delete_exec.php)", $HTTP_SERVER_VARS['HTTP_HOST'] . $HTTP_SERVER_VARS['PHP_SELF'] ) &&
         $REQUEST_METHOD == 'POST' && ereg($HTTP_HOST,$HTTP_REFERER) ) {

        if ( $bbsInfor ) { // �Խ��� ���� ����

            if ( $login_yn == 'N' && !$password ) {
                Message ('S', '0013',""); // �Խ��� �Է� ��Ų �������� password �ʵ尡 ������ �ۼ���
                                          // �α����� ������ ��쿡�� �ݵ�� ��й�ȣ�� �ԷµǾ�� �մϴ�.
            }

            $sql  = "select no, g_no, o_seq, depth, pre_no, next_no, user_id, f_path1, f_ext1, f_date1, f_path2, f_ext2, f_date2 from $tb_bbs_data" . "_" . $id . " where no = $no;";

            $data = singleRowSQLQuery($sql);
            $w_user_id= $data["user_id"];  // �ۼ��� ���̵�
            $g_no     = $data['g_no'   ];
            $o_seq    = $data['o_seq'  ];
            $depth    = $data['depth'  ];
            $preNo    = $data['pre_no' ];
            $nextNo   = $data['next_no'];

            $f_path1  = $data["f_path1" ]; // ���� ���1
            $f_ext1   = $data["f_ext1"  ]; // Ȯ���� ��1
            $f_date1  = $data["f_date1" ]; // ���� ���ϸ�1
            $f_name1  = $data["f_name1" ]; // ���� ���ϸ�1

            $f_path2  = $data["f_path2" ]; // ���� ���2
            $f_ext2   = $data["f_ext2"  ]; // Ȯ���� ��2
            $f_date2  = $data["f_date2" ]; // ���� ���ϸ�2
            $f_name2  = $data["f_name2" ]; // ���� ���ϸ�2

            // $file1    = "$f_path1$f_date1.$f_ext1";
            // $file2    = "$f_path2$f_date2.$f_ext2";

			$file1    = $baseDir . "data/file/" . $id. "/$f_date1.$f_ext1";
			$file2    = $baseDir . "data/file/" . $id. "/$f_date2.$f_ext2";

            $ip       = $REMOTE_ADDR; // ������ �ּ�

            if ( $w_user_id && $login_yn == 'Y' ) { // ȸ��   ��
                $sql0  = "select COUNT(no) from $tb_bbs_data" . "_" . $id;

                $sql0 .= " where no = $no ";
                if ( $admin_yn != 'Y' ) { // ������ ��� ���� ��ŵ
                    $sql0 .= " and user_id = '$user_id';";
                }
                $existChk = simpleSQLQuery($sql0);
            } else if ( !$w_user_id )             { // ��ȸ�� ��
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
                if ( $subChk ) {                  // ���� �ڷᰡ ����� �����ϴ� ���
                    $sql  = "update $tb_bbs_data" . "_" . $id;
                    $sql .= " set   ip     = '$ip',";
                    if ( $admin_yn == 'Y' ) {
                        $sql .= " use_st = 9    "; // �����ڿ� ���� ����
                    } else {
                        $sql .= " use_st = 8    "; // ����ڿ� ���� ����
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
                        @unlink ( "$file1" ) or Message ("S", "0023","", $skinDir); // ���� ������ ����.
                    }
                    if ( @is_file("$file2") ) {
                        @unlink ( "$file2" ) or Message ("S", "0023","", $skinDir); // ���� ������ ����.
                    }
                }

                $point = 0;
				if ( $depth ) { // �亯��
					$point      -= getPointGrant ($id, $memInfor['member_level'], 5); // ��� �ۼ� ����Ʈ
					$uploadPoint = getPointGrant ($id, $memInfor['member_level'], 3); // ���� ���ε� ����Ʈ
					if ( $f_name1 ) $point -= $uploadPoint;
					if ( $f_name2 ) $point -= $uploadPoint;
				} else {
					$point      -= getPointGrant ($id, $memInfor['member_level'], 1); // �Խù� �ۼ� ����Ʈ
					$uploadPoint = getPointGrant ($id, $memInfor['member_level'], 3); // ���� ���ε� ����Ʈ

					if ( $f_name1 ) $point -= $uploadPoint;
					if ( $f_name2 ) $point -= $uploadPoint;
				}
				setPointGrant ($user_id, $point); // ����Ʈ ����

            } else {
                if ( $login_yn == 'Y' )         { // ȸ�� ����
                    Message ('S', '0018',""); // ���� ����� Ʋ��
                } else if ( $login_yn == 'N' )  { // ��ȸ�� ����
                    Message ('S', '0017',""); // ���� ��й�ȣ Ʋ��
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